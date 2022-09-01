<?php

namespace Deployer;

require 'recipe/laravel.php';
require 'recipe/rsync.php';

set('keep_releases', 5);

// Project repository
set('project_alias', 'dialog');
set('repository', 'git@adlg-test-task:bukin/adlg-test-task.git');
set('bin/php', function () {
    return '/usr/bin/php8.1';
});

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', [
    'storage/app/public/pages',
    'storage/app/public/temp',
    'storage/app/public/users',
    'storage/uploads',
    'vendor',
]);

// Hosts
set('default_stage', 'test');
inventory('hosts.yaml');

// Tasks
task('artisan:optimize', function () {});

task('deploy:vendors', function () {
    if (!commandExist('unzip')) {
        warning('To speed up composer installation setup "unzip" command with PHP zip extension.');
    }
    run('cd {{release_path}} && /usr/bin/php8.1 {{bin/composer}} install --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader --ignore-platform-reqs 2>&1');
});

// Deploy
desc('Prepare environment');
task('files:test_environment', function () {
    run('mv {{release_path}}/.env.test {{release_path}}/.env');
    run('rm {{release_path}}/.env.local');
    run("cd {{release_path}} && chmod +x artisan");
})->onStage('test');
after('deploy:shared', 'files:test_environment');

desc('Restart PHP-FPM service');
task('php-fpm:restart', function () {
    run('sudo systemctl restart php8.1-fpm.service');
});
after('deploy:symlink', 'php-fpm:restart');

before('deploy:symlink', 'deploy:public_disk');
before('deploy:symlink', 'artisan:migrate');

after('deploy:failed', 'deploy:unlock');
after('success', 'artisan:cache:clear');

// Rollback
task('rollback:full', [
    'rollback',
    'artisan:view:cache',
    'artisan:config:cache',
    'artisan:migrate:rollback',
    'php-fpm:restart',
    'artisan:cache:clear',
]);

task('rollback_tasks', [
    'artisan:view:cache',
    'artisan:config:cache',
    'artisan:route:cache-separate',
    'php-fpm:restart',
    'artisan:cache:clear',
]);
after('rollback', 'rollback_tasks');
