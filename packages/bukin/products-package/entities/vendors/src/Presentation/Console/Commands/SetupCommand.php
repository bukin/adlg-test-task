<?php

namespace Bukin\ProductsPackage\Vendors\Presentation\Console\Commands;

use Bukin\ProductsPackage\Vendors\Infrastructure\Providers\ServiceProvider;
use InetStudio\AdminPanel\Base\Console\Commands\BaseSetupCommand;

class SetupCommand extends BaseSetupCommand
{
    protected $name = 'bukin:products-package:vendors:setup';

    protected $description = 'Setup vendors entity';

    protected function initCommands(): void
    {
        $this->calls = [
            [
                'type' => 'artisan',
                'description' => 'Publish migrations',
                'command' => 'vendor:publish',
                'params' => [
                    '--provider' => ServiceProvider::class,
                    '--tag' => 'migrations',
                ],
            ],
            [
                'type' => 'artisan',
                'description' => 'Migration',
                'command' => 'migrate',
            ],
        ];
    }
}
