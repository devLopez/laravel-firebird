<?php

namespace Igrejanet\Firebird\Query;

use Firebird\Query\Grammars\FirebirdGrammar;
use Illuminate\Database\Query\Builder;

/**
 * FirebirdBuilder
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package Igrejanet\Firebird\Query
 */
class FirebirdBuilder extends Builder
{
    /**
     * Extendemos aqui o método getCountForPagination para que a paginação
     * possa funcionar corretamente com o firebird, visto que o laravel
     * busca o campo aggregate, da contagem, entretanto, o firebird retorna
     * este campo em UPPER CASE, fazendo assim lançar uma exception
     *
     * @param array $columns
     * @return int
     */
    public function getCountForPagination($columns = ['*'])
    {
        $results = $this->runPaginationCountQuery($columns);

        $isFirebird = $this->getGrammar() instanceof FirebirdGrammar;

        // Once we have run the pagination count query, we will get the resulting count and
        // take into account what type of query it was. When there is a group by we will
        // just return the count of the entire results set since that will be correct.
        if ( isset($this->groups) ) {
            return count($results);
        } elseif ( ! isset($results[0]) ) {
            return 0;
        } elseif ( is_object($results[0]) ) {

            if ( $isFirebird ) {
                return (int) $results[0]->AGGREGATE;
            }
            return (int) $results[0]->aggregate;
        }

        return (int) array_change_key_case((array) $results[0])['aggregate'];
    }
}