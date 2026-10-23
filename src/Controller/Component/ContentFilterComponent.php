<?php

/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

namespace App\Controller\Component;

use Cake\Controller\Component;

class ContentFilterComponent extends Component
{
    public $params = [];

    public function prepareParams($request)
    {
        if ($request->is('post')) {
            $params = $request->getData();
        } else {
            $params = $request->getQueryParams();
        }

        $this->params = is_array($params) ? $params : [];
    }

    /**
     * Aceita apenas nomes de colunas simples (letras, números e "_"),
     * pois são concatenados na consulta e não podem vir livres do usuário.
     */
    protected function isSafeIdentifier($name)
    {
        return is_string($name) && preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $name) === 1;
    }

    /**
     * Retorna o valor do parâmetro como texto, ou null se vazio/inválido.
     */
    protected function param($name)
    {
        if (!isset($this->params[$name]) || is_array($this->params[$name])) {
            return null;
        }

        $value = trim((string)$this->params[$name]);

        return $value === '' ? null : $value;
    }

    /*
    * Help for filter all parameters and requests for searching the contents
    */
    public function fields($request, $table)
    {
        //Prepare params
        $this->prepareParams($request);

        return [$table . '.id', $table . '.title', $table . '.created', $table . '.modified'];
    }

    /*
     * Help for filter all parameters and requests for searching the contacts
     *  $table = Table name
     *  $field = Field name of the table
     *  $detail = Type of comparison (like, specific)
     *
     * Retorna condições no formato de array do ORM, para que os valores
     * sejam enviados como parâmetros (evita SQL injection).
    */
    public function wheres($request, $table, $fieldList)
    {
        //Prepare params
        $this->prepareParams($request);

        $where = [];

        foreach ((array)$fieldList as $field) {

            if (!$this->isSafeIdentifier($field['content'])) {
                continue;
            }

            $value = $this->param($field['content']);
            if ($value === null) {
                continue;
            }

            $column = $table . '.' . $field['content'];

            if ($field['detail'] == 'like') {

                //Escapa os curingas do LIKE digitados pelo usuário
                $where[$column . ' LIKE'] = '%' . addcslashes($value, '%_\\') . '%';

            } elseif ($field['detail'] == 'specific') {

                $where[$column] = $value;

            }//elseif ($field['detail'] == 'specific')

        }//foreach ($fieldList as $field)

        return $where;
    }

    public function order($request, $table)
    {
        //Prepare params
        $this->prepareParams($request);

        $orderBy   = $this->param('orderBy');
        $orderType = strtoupper((string)$this->param('orderType')) === 'ASC' ? 'ASC' : 'DESC';

        if ($orderBy === 'rand') {
            return 'RAND()';
        }

        if ($orderBy === null || !$this->isSafeIdentifier($orderBy)) {
            $orderBy = 'id';
        }

        return $table . '.' . $orderBy . ' ' . $orderType;
    }

    /**
     * At this function, you could put all dependencies list to identify through $request params
     */
    public function contain($request, $table)
    {
        //Prepare params
        $this->prepareParams($request);

        $contain = [];

        if ($table == 'SaleGoals') {

            $contain[] = 'GoalsDetails';
            $contain[] = 'ProductGoals';

        } elseif ($table == 'SaleCommissions') {

            $contain[] = 'CommissionsDetails';

        }//elseif ($table == 'SaleCommissions')

        return $contain;
    }

    public function limit($request, $limit = 30)
    {
        //Prepare params
        $this->prepareParams($request);

        $param = $this->param('limit');

        if ($param === 'false') {

            $limit = 1000;

        } elseif ($param !== null && ctype_digit($param) && (int)$param >= 1 && (int)$param < 1000) {

            $limit = (int)$param;

        }//elseif ($param !== null && ctype_digit($param) ...)

        return $limit;
    }
}
