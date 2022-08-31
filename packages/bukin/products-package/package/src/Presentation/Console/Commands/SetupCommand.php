<?php

namespace Bukin\ProductsPackage\Presentation\Console\Commands;

use InetStudio\AdminPanel\Base\Console\Commands\BaseSetupCommand;

class SetupCommand extends BaseSetupCommand
{
    protected $name = 'bukin:products-package:setup';

    protected $description = 'Setup products package';

    protected function initCommands(): void
    {
        $this->calls = [
            [
                'type' => 'artisan',
                'description' => '',
                'command' => 'bukin:products-package:products:setup',
            ],
            [
                'type' => 'artisan',
                'description' => '',
                'command' => 'bukin:products-package:vendors:setup',
            ],
        ];
    }
}
