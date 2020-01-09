<?php

namespace Tests;

use Faker\Factory;
use Illuminate\Pagination\Paginator;
use Tests\Models\User;
use Tests\Repositories\Users;

class UsersRepositoryTest extends Application
{
    public function testCreateUser()
    {
        $faker = Factory::create('pt_BR');

        $users = new Users($this->app);

        $users->create(['NAME' => $faker->name, 'EMAIL' => $faker->safeEmail]);

        $this->assertEquals(1, $users->count());
    }

    public function testFirst()
    {
        $users = new Users($this->app);

        $this->assertInstanceOf(User::class, $users->first());
    }

    public function testSimplePagination()
    {
        $faker = Factory::create('pt_BR');
        $users = new Users($this->app);

        for ($i = 0; $i < 10; $i++) {
            $users->create(['NAME' => $faker->name, 'EMAIL' => $faker->safeEmail]);
        }

        $pagination = $users->simplePaginate(5);

        $this->assertInstanceOf(Paginator::class, $pagination);
    }

    public function testFullPagination()
    {
        $users = new Users($this->app);
        $pagination = $users->paginate(5);

        var_dump($pagination);
    }
}