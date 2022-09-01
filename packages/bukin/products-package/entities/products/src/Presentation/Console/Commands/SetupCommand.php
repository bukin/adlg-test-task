<?php

namespace Bukin\ProductsPackage\Products\Presentation\Console\Commands;

use Bukin\ProductsPackage\Products\Infrastructure\Providers\ServiceProvider;
use InetStudio\AdminPanel\Base\Console\Commands\BaseSetupCommand;

class SetupCommand extends BaseSetupCommand
{
    protected $name = 'bukin:products-package:products:setup';

    protected $description = 'Setup products entity';

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
