<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

/* File: src/Controller/SaleGoalsController.php */

namespace App\Controller;

use App\Controller\AppController;
use App\Lib\DemoData;
use Cake\Log\Log;

class SaleGoalsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('ContentFilter');

        /*******/

        //Internal Pages
        $this->Auth->allow(['index', 'add', 'edit', 'delete', 'report']);

    }

    /**
     * Filtros do relatório de metas (modal). O relatório abre em Reports::goals.
     */
    public function report()
    {
        $this->set('planos', DemoData::planosLista(true));
    }

    public function index()
    {
        //Content filter data
        $fieldContent = [0 => ['content' => 'id',
                               'detail'  => 'specific'
                              ],
                         1 => ['content' => 'title',
                               'detail'  => 'like'
                              ]
                        ];
        $where   = $this->ContentFilter->wheres($this->request, 'SaleGoals', $fieldContent);
        $contain = $this->ContentFilter->contain($this->request, 'SaleGoals');
        $order   = $this->ContentFilter->order($this->request, 'SaleGoals');
        $limit   = $this->ContentFilter->limit($this->request, 30);

        /*******/
        
        //Enquanto a consulta ao banco estiver desativada, usa os dados de demonstração
        $data     = DemoData::metas();
        $planos   = DemoData::planos();
        $produtos = DemoData::produtosLista();

        //Data query object
        /*
        $data = $this->SaleGoals->find('all')
                                ->where($where)  
                                ->order($order)  
                                ->contain($contain)
                                ->limit($limit);
        */
        /*******/

        //Send object data to view
        $this->set(compact('data', 'planos', 'produtos'));
        $this->set('_serialize', ['data']);
    }

    public function add()
    {
        /*
        //Create a new data entity
        $data = $this->SaleGoals->newEntity();
        */
        /*******/
        
        //Access method restriction
        if ($this->request->is('post')) {
            
            //Merge form data into object
            //$data = $this->SaleGoals->patchEntity($data, $this->request->getData());

            /*******/
            /*
            //Save all data
            if ($this->SaleGoals->save($data)) {
                
                //Success message and page redirection
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->SaleGoals->save($data))
            */
            /*******/
            /*
            //Set error message log
            Log::write('debug', 'SaleGoalsController->add: '.json_encode($data->errors()));

            /*******/
            
            //Sem banco de dados: a gravação é apenas simulada
            return $this->simularGravacao(__('Meta cadastrada.'));
            
        }//if ($this->request->is('post'))

        //Send object data to view
        $meta = null;
        $planos   = DemoData::planosLista(true);
        $produtos = DemoData::produtosLista();
        $this->set(compact('meta', 'planos', 'produtos'));
        $this->render('form');
    }

    public function edit($id)
    {
        /*
        //Find record data
        $data = $this->SaleGoals->get($id);
        */
        /*******/
        
        //Access method restriction
        if ($this->request->is(['patch', 'post', 'put'])) {
            /*
            //Merge form data into object
            $data = $this->SaleGoals->patchEntity($data, $this->request->getData());
            */
            /*******/
            /*
            //Save all modification
            if ($this->SaleGoals->save($data)) {
                
                //Success message and page redirection
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->SaleGoals->save($data))
            */

            /*******/
            /*
            //Set error message log
            Log::write('debug', 'SaleGoalsController->edit: '.json_encode($data->errors()));

            /*******/
            
            //Sem banco de dados: a gravação é apenas simulada
            return $this->simularGravacao(__('Meta atualizada.'));
            
        }//if ($this->request->is(['patch', 'post', 'put']))

        /*******/

        //Send object data to view
        $metas = DemoData::metas();
        $meta = isset($metas[$id]) ? $metas[$id] : reset($metas);
        $planos   = DemoData::planosLista(true);
        $produtos = DemoData::produtosLista();
        $this->set(compact('meta', 'planos', 'produtos'));
        $this->render('form');
    }

    public function delete($id)
    {
        /*
        //Access method restriction
        $this->request->allowMethod(['post', 'delete']);

        /*******/
        /*
        //Find record data
        $data = $this->SaleGoals->get($id);
        
        /*******/
        /*
        //Delete record and shows a message
        if ($this->SaleGoals->delete($data)) {
            
            //Success page link
            $this->referer = $this->referer.'?action=deleted';

            //Page redirection
            return $this->redirect($this->referer);
            
        }//if ($this->SaleGoals->delete($data))
        
        /*******/
        /*
        //Set error message log
        Log::write('debug', 'SaleGoalsController->delete: '.json_encode($data->errors()));
        */  
        //Sem banco de dados: a exclusão é apenas simulada
        return $this->simularGravacao(__('Meta excluída.'));
    }
}