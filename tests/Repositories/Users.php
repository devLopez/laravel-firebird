<?php

namespace Tests\Repositories;

use Masterkey\Repository\AbstractRepository;
use Tests\Models\User;

class Users extends AbstractRepository
{
    public function model()
    {
        return User::class;
    }
}