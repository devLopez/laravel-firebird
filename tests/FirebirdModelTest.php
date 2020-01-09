<?php

namespace Tests;

use Igrejanet\Firebird\FirebirdModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Tests\Models\User;

class FirebirdModelTest extends Application
{
    public function testInstanceOfModel()
    {
        $user = new User();

        $this->assertInstanceOf(Model::class, $user);
        $this->assertInstanceOf(FirebirdModel::class, $user);
    }

    public function testAllMethod()
    {
        $user = User::all();

        $this->assertInstanceOf(Collection::class, $user);
    }

    public function testCreateMethod()
    {
        $user = User::create([
            'NAME' => 'Matheus Lopes Santos',
            'EMAIL' => 'email@email.com'
        ]);

        $this->assertTrue($user->exists);
    }
}