<?php

namespace Igrejanet\Firebird;

use Igrejanet\Firebird\Increasers\{IncreaseByGenerator, IncreaseById};
use Igrejanet\Firebird\Query\FirebirdBuilder;
use Illuminate\Database\Eloquent\{Builder, Model};
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

    public function runningFirebird() : bool
    {
        return $this->getConnection()->getDriverName() == 'firebird';
    }

    /**
     * @return int
     * @throws RuntimeException
     */
    public function increaseById()
    {
        $row = $this->getConnection()->selectOne(new IncreaseById($this->getKeyName(), $this->getTable()));

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
        $row = $this->getConnection()->selectOne(new IncreaseByGenerator($this->generator));

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
        if ( ! $this->runningFirebird() ) {
            parent::insertAndSetId($query, $attributes);
        } else {
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
