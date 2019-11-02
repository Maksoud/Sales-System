<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

/* File: src/Controller/SaleCommissionsController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

class SaleCommissionsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('ContentFilter');

        /*******/

        //Internal Pages
        $this->Auth->allow(['index', 'add', 'edit', 'delete']);

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
        $where   = $this->ContentFilter->wheres($this->request, 'SaleCommissions', $fieldContent);
        $contain = $this->ContentFilter->contain($this->request, 'SaleCommissions');
        $order   = $this->ContentFilter->order($this->request, 'SaleCommissions');
        $limit   = $this->ContentFilter->limit($this->request, 30);

        /*******/
        
        //Data query object
        /*
        $data = $this->SaleCommissions->find('all')
                                ->where($where)  
                                ->order($order)  
                                ->contain($contain)
                                ->limit($limit);
        
        /*******/

        //Send object data to view
        $this->set(compact('data'));
        $this->set('_serialize', ['data']);
    }

    public function add()
    {
        /*
        //Create a new data entity
        $data = $this->SaleCommissions->newEntity();
        
        /*******/
        
        //Access method restriction
        if ($this->request->is('post')) {
            
            //Merge form data into object
            //$data = $this->SaleCommissions->patchEntity($data, $this->request->getData());

            /*******/
            /*
            //Save all data
            if ($this->SaleCommissions->save($data)) {
                
                //Success message and page redirection
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->SaleCommissions->save($data))
            
            /*******/
            /*
            //Set error message log
            Log::write('debug', 'SaleCommissionsController->add: '.json_encode($data->errors()));

            /*******/
            
            //Error message and page redirection
            $this->Flash->error(__('Desculpe, ocorreu um erro e o registro não foi gravado. Por favor, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is('post'))
    }

    public function edit($id)
    {
        /*
        //Find record data
        $data = $this->SaleCommissions->get($id);
        
        /*******/
        
        //Access method restriction
        if ($this->request->is(['patch', 'post', 'put'])) {
            /*
            //Merge form data into object
            $data = $this->SaleCommissions->patchEntity($data, $this->request->getData());
            
            /*******/
            /*
            //Save all modification
            if ($this->SaleCommissions->save($data)) {
                
                //Success message and page redirection
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->SaleCommissions->save($data))

            /*******/
            /*
            //Set error message log
            Log::write('debug', 'SaleCommissionsController->edit: '.json_encode($data->errors()));

            /*******/
            
            //Error message and page redirection
            $this->Flash->error(__('Desculpe, ocorreu um erro e o registro não foi gravado. Por favor, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is(['patch', 'post', 'put']))

        /*******/

        //Send object data to view
        $data = null;
        $this->set(compact('data'));
        $this->set('_serialize', ['data']);
    }

    public function delete($id)
    {
        /*
        //Access method restriction
        $this->request->allowMethod(['post', 'delete']);

        /*******/
        /*
        //Find record data
        $data = $this->SaleCommissions->get($id);
        
        /*******/
        /*
        //Delete record and shows a message
        if ($this->SaleCommissions->delete($data)) {
            
            //Success page link
            $this->referer = $this->referer.'?action=deleted';

            //Page redirection
            return $this->redirect($this->referer);
            
        }//if ($this->SaleCommissions->delete($data))
        
        /*******/
        /*
        //Set error message log
        Log::write('debug', 'SaleCommissionsController->delete: '.json_encode($data->errors()));
        */  
        //Error message
        $this->Flash->error(__('Desculpe, ocorreu um erro e o registro não foi excluído. Por favor, tente novamente'));

        //Page redirection
        return $this->redirect($this->referer());
    }
}