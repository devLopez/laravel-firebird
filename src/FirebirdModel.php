<?php

namespace Igrejanet\Firebird;

use Illuminate\Database\Eloquent\{Builder, Model};
use Igrejanet\Firebird\Query\FirebirdBuilder;
use RuntimeException;

/**
 * FirebirdModel
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package Igrejanet\Firebird
 */
class FirebirdModel extends Model
{
    /**
     * @var null|string
     */
    protected $generator = null;

    /**
     * @return int
     * @throws RuntimeException
     */
    public function increaseById()
    {
        $row = $this->getConnection()->selectOne('SELECT COALESCE(MAX('. $this->getKeyName() .'), 0) + 1 as CODIGO FROM ' . $this->table);

        if ( $row ) {
            return $row->CODIGO;
        }

        throw new RuntimeException('Ocorreu um erro ao gerar o nº do registro. Tente novamente');
    }

    /**
     * @return int
     * @throws RuntimeException
     */
    public function increaseByGenerator()
    {
        $row = $this->getConnection()->selectOne('SELECT GEN_ID('. $this->generator .', 1) AS CODIGO FROM RDB$DATABASE');

        if ( $row ) {
            return $row->CODIGO;
        }

        throw new RuntimeException('Ocorreu um erro ao gerar o nº do registro. Tente novamente');
    }

    /**
     * @return int
     */
    public function generateId()
    {
        if ( is_null($this->generator) ) {
            return $this->increaseById();
        }

        return $this->increaseByGenerator();
    }

    /**
     * @param Builder $query
     * @param array   $attributes
     */
    protected function insertAndSetId(Builder $query, $attributes)
    {
        $keyName = $this->getKeyName();

        $primaryKeyIsSetted = ( isset($attributes[$keyName]) && ! is_null($attributes[$keyName]) );

        if ( $primaryKeyIsSetted ) {
            $query->insert($attributes);
        } else {
            $id = $this->generateId();

            $attributes[$keyName] = $id;

            $query->insert($attributes);

            $this->setAttribute($keyName, $id);
        }
    }

    /**
     * @return FirebirdBuilder|\Illuminate\Database\Query\Builder
     */
    protected function newBaseQueryBuilder()
    {
        $connection = $this->getConnection();

        return new FirebirdBuilder(
            $connection,
            $connection->getQueryGrammar(),
            $connection->getPostProcessor()
        );
    }
}