<?php

namespace Tests;

use Igrejanet\Firebird\FirebirdModel;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory;
use Tests\Models\Product;
use Tests\Models\User;

class FirebirdModelTest extends Application
{
    public function testInstanceOfModel()
    {
        $faker = Factory::create('pt_BR');

        $user = new User([
            'NAME' => $faker->name,
            'EMAIL' => $faker->safeEmail
        ]);

        $user->save();

        $this->assertInstanceOf(Model::class, $user);
        $this->assertInstanceOf(FirebirdModel::class, $user);
        $this->assertTrue($user->exists);
    }

    public function testInstanceOfProducts()
    {
        $faker = Factory::create('pt_BR');

        $product = new Product([
            'PRODUCT_NAME' => 'Água',
            'PRICE' => $faker->randomFloat(2, 1, 10)
        ]);

        $product->save();

        $this->assertInstanceOf(FirebirdModel::class, $product);
        $this->assertTrue($product->exists);
    }
}