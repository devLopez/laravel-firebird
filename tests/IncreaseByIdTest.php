<?php

namespace Tests;

use Igrejanet\Firebird\Increasers\IncreaseById;
use PHPUnit\Framework\TestCase;

class IncreaseByIdTest extends TestCase
{
    public function testIfSqlForIncreaserWillBeGenerated()
    {
        $sql = (string) (new IncreaseById('ID', 'USUARIOS'));

        $this->assertEquals('SELECT COALESCE(MAX(ID), 0) + 1 as CODIGO FROM USUARIOS', $sql);
    }
}