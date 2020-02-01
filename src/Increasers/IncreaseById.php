<?php

namespace Igrejanet\Firebird\Increasers;

/**
 * IncreaseById
 *
 * @author Matheus Lopes SAntos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package Igrejanet\Firebird\Increasers
 */
class IncreaseById
{
    /**
     * @var string
     */
    protected $sql;

    /**
     * @param string $keyName
     * @param string $tableName
     */
    public function __construct(string $keyName, string $tableName)
    {
        $this->sql = 'SELECT COALESCE(MAX('. $keyName .'), 0) + 1 as CODIGO FROM ' . $tableName;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->sql;
    }
}