<?php

namespace App\Console\Commands;

use Faker\Generator;
use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\DB;
use InetStudio\ACL\Roles\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\ACL\Users\Contracts\Services\Front\ItemsServiceContract as UsersServiceContract;

class CreateAdminUserWithApiTokenCommand extends Command
{
    protected $name = 'app:make:admin';

    protected $description = 'Create admin user with api token';

    public function __construct(
        protected ItemsServiceContract $rolesService,
        protected UsersServiceContract $usersService
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $adminRole = $this->rolesService->getModel()->where([['name', '=', 'admin']])->first();

        /** @var Generator $faker */
        $faker = Container::getInstance()->make(Generator::class);

        $user = $this->usersService->saveModel([
            'activated' => 1,
            'name' => $faker->userName(),
            'email' => $faker->email(),
            'password' => $faker->password(),
        ], 0);

        $token = $user->createToken('api');

        DB::table('role_user')->insert(
            ['user_id' => $user->id, 'role_id' => $adminRole->id, 'user_type' => get_class($user)]
        );

        $this->info('User API token: '.$token->plainTextToken);
    }
}
