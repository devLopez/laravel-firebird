<?php

namespace Igrejanet\Firebird\Increasers;

/**
 * IncreaseByGenerator
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package Igrejanet\Firebird\Increasers
 */
class IncreaseByGenerator
{
    /**
     * @var string
     */
    protected $sql;

    /**
     * @param string $generator
     */
    public function __construct(string $generator)
    {
        $this->sql = 'SELECT GEN_ID('. $generator .', 1) AS CODIGO FROM RDB$DATABASE';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->sql;
    }
}