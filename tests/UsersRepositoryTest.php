<?php

namespace Tests;

use Faker\Factory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Masterkey\Repository\Criteria\Select;
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

    /**
     * @throws \RepositoryException
     */
    public function testFullPagination()
    {
        $users = new Users($this->app);
        $pagination = $users->paginate(5);

        $this->assertInstanceOf(LengthAwarePaginator::class, $pagination);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testDeleteUser()
    {
        $users = new Users($this->app);
        $id = $users->first()->getAttribute('ID');

        $users->delete($id);

        $users->find($id);
    }

    public function testMassInsert()
    {
        $faker = Factory::create('pt_BR');
        $users = new Users($this->app);

        $newData = [];

        for ($i = 0; $i < 10; $i++) {
            array_push($newData, ['NAME' => $faker->name, 'EMAIL' => $faker->safeEmail]);
        }

        $this->assertTrue($users->insert($newData));
    }

    public function testSelectCriteria()
    {
        $users = new Users($this->app);
        $user = $users->pushCriteria(new Select('NAME'))->first();

        $this->assertNull($user->EMAIL);
    }
}