<?php

namespace Tests;

use Igrejanet\Firebird\Increasers\IncreaseByGenerator;
use PHPUnit\Framework\TestCase;

class IncreaseByGeneratorTest extends TestCase
{
    public function testIncreaseByGenerator()
    {
        $sql = (string) (new IncreaseByGenerator('GEN_USERS'));

        $this->assertEquals('SELECT GEN_ID(GEN_USERS, 1) AS CODIGO FROM RDB$DATABASE', $sql);
    }
}