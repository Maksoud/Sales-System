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
    public $params = array();

    public function __construct()
    {
        //Construct function content
    }

    public function prepareParams($request = array())
    {
        if ($request->is('post')) {
           
            $params = $request->data; 

        } else {

           $params = $request->query;

        }//else if ($request->is('post'))

        /*******/

        $this->params = $params;
    }  

    /*
    * Help for filter all parameters and requests for searching the contents
    */
    public function fields($request, $table) 
    {
        //Prepare params
        $this->prepareParams($request);

        /*******/

        //Set variables
        $fields = [$table . '.id', $table . '.title', $table . 'created', $table . 'modified'];

        /*******/

        return $fields;
    } 

    /*
     * Help for filter all parameters and requests for searching the contacts
     *  $table = Table name
     *  $field = Field name of the table
     *  $detail = Type of comparison (like, specific)
    */
    public function wheres($request, $table, $fieldList) 
    {
        //Prepare params
        $this->prepareParams($request);

        /*******/

        //Set variables
        $where = [];

        /*******/
        
        if (!empty($fieldList)) {

            foreach ($fieldList as $field) {

                if (!empty($this->params[$field['content']]) && $field['detail'] == 'like') {
                    
                    $where[] = '(' . $table . '.' . $field['content'] . ' LIKE "%' . $this->params[$field['content']] . '%")';

                } elseif (!empty($this->params[$field['content']]) && $field['detail'] == 'specific') {

                    $where[] = '(' . $table . '.' . $field['content'] . ' = "' . $this->params[$field['content']] . '")';

                }//elseif ($field['detail'] == 'specific')
                
            }//foreach ($fieldList as $field)

        }//if (!empty($fieldList))

        /*******/
        
        return $where;
    }

    public function order($request, $table)
    {
        //Prepare params
        $this->prepareParams($request);

        /*******/

        //Set variables
        $order = $table . '.id';
        $orderType = 'DESC';

        /*******/
        
        if (!empty($this->params['orderBy'])) {

            if ($this->params['orderBy'] == 'rand') {
                
                $orderString = "rand()";

            } else {

                $order = $table . "." . $this->params['orderBy'];

                /*******/

                if (!empty($this->params['orderType'])) {
                    
                    $orderType = $this->params['orderType'];

                }//if (!empty($this->params['orderType']))

                /*******/

                $orderString = $order . ' ' . $orderType;

            }//else if ($this->params['orderBy'] == 'rand')

        } else {

            $orderString = $order . ' ' . $orderType;

        }//else if (!empty($this->params['orderBy']))

        /*******/

        return $orderString;
    }

    /**
     * At this function, you could put all dependencies list to identify through $request params
     */
    public function contain($request, $table) 
    {
        //Prepare params
        $this->prepareParams($request);

        /*******/

        //Set variables
        $contain = [];

        /*******/

        if ($table == 'SaleGoals') {

            $contain[] = 'GoalsDetails';
            $contain[] = 'ProductGoals';

        } elseif ($table == 'SaleCommissions') {

            $contain[] = 'CommissionsDetails';

        }//elseif ($table == 'SaleCommissions')

        /*******/

        return $contain; 
    }

    public function limit($request, $limit = 30)
    {
        //Prepare params
        $this->prepareParams($request);

        /*******/

        if (!empty($this->params['limit'])) {

            if (@is_numeric($this->params['limit']) && $this->params['limit'] < 1000) { 
                
                $limit = $this->params['limit'];

            } elseif (@$this->params['limit'] == 'false') {

                $limit = 1000; 

            }//elseif (@$this->params['limit'] == 'false')

        }//if (!empty($this->params['limit']))

        /*******/

        return $limit;
    }
}