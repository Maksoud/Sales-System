<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

class SaleGoalsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('ContentFilter');

        /*******/

        //Internal Pages
        $this->Auth->allow(['view', 'index', 'add', 'edit', 'delete']);

    }
    public function view($id)
    {
        //Content filter data
        $contain = $this->ContentFilter->contain($this->request, 'SaleGoals');

        /*******/

        //Data query object
        $data = $this->SaleGoals->get($id, [
            'contain' => $contain
        ]);

        /*******/

        //Send object data to view
        $this->set('data', $data);
        $this->set('_serialize', ['data']);
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
        
        //Data query object
        $data = $this->SaleGoals->find('all')
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
        //Create a new data entity
        $data = $this->SaleGoals->newEntity();

        /*******/
        
        //Access method restriction
        if ($this->request->is('post')) {
            
            //Merge form data into object
            $data = $this->SaleGoals->patchEntity($data, $this->request->getData());

            /*******/

            //Save all data
            if ($this->SaleGoals->save($data)) {
                
                //Success message and page redirection
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->SaleGoals->save($data))

            /*******/

            //Set error message log
            Log::write('debug', 'SaleGoalsController->add: '.json_encode($data->errors()));

            /*******/
            
            //Error message and page redirection
            $this->Flash->error(__('Desculpe, ocorreu um erro e o registro não foi gravado. Por favor, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is('post'))
    }

    public function edit($id)
    {
        //Find record data
        $data = $this->SaleGoals->get($id);

        /*******/
        
        //Access method restriction
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //Merge form data into object
            $data = $this->SaleGoals->patchEntity($data, $this->request->getData());

            /*******/
            
            //Save all modification
            if ($this->SaleGoals->save($data)) {
                
                //Success message and page redirection
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->SaleGoals->save($data))

            /*******/

            //Set error message log
            Log::write('debug', 'SaleGoalsController->edit: '.json_encode($data->errors()));

            /*******/
            
            //Error message and page redirection
            $this->Flash->error(__('Desculpe, ocorreu um erro e o registro não foi gravado. Por favor, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is(['patch', 'post', 'put']))

        /*******/

        //Send object data to view
        $this->set(compact('data'));
        $this->set('_serialize', ['data']);
    }

    public function delete($id)
    {
        //Access method restriction
        $this->request->allowMethod(['post', 'delete']);

        /*******/
        
        //Find record data
        $data = $this->SaleGoals->get($id);

        /*******/

        //Delete record and shows a message
        if ($this->SaleGoals->delete($data)) {
            
            //Success page link
            $this->referer = $this->referer.'?action=deleted';
            
        } else {
            
            //Set error message log
            Log::write('debug', 'SaleGoalsController->delete: '.json_encode($data->errors()));
            
            //Error message
            $this->Flash->error(__('Desculpe, ocorreu um erro e o registro não foi excluído. Por favor, tente novamente'));

        }//else if ($this->SaleGoals->delete($data))

        /*******/

        //Page redirection
        return $this->redirect($this->referer);
    }
}