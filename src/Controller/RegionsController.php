<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

/* File: src/Controller/RegionsController.php */

namespace App\Controller;

use App\Controller\AppController;
use App\Lib\DemoData;
use Cake\Log\Log;

class RegionsController extends AppController
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
        $where   = $this->ContentFilter->wheres($this->request, 'Regions', $fieldContent);
        $contain = $this->ContentFilter->contain($this->request, 'Regions');
        $order   = $this->ContentFilter->order($this->request, 'Regions');
        $limit   = $this->ContentFilter->limit($this->request, 30);

        /*******/
        
        //Enquanto a consulta ao banco estiver desativada, usa os dados de demonstração
        $data = DemoData::filtrar(DemoData::regioes(), $this->request->getQueryParams(), [
            'title' => function ($regiao, $valor) {
                return mb_stripos($regiao->title . ' ' . $regiao->uf . ' ' . implode(' ', $regiao->cidades), $valor) !== false;
            },
        ]);

        //Associado responsável pelas regiões exclusivas
        $responsaveis = [];
        foreach ($data as $regiao) {
            if ($regiao->usuarios_id) {
                $responsaveis[$regiao->id] = DemoData::usuario($regiao->usuarios_id);
            }
        }

        //Data query object
        /*
        $data = $this->Regions->find('all')
                                ->where($where)  
                                ->order($order)  
                                ->contain($contain)
                                ->limit($limit);
        
        /*******/

        //Send object data to view
        $this->set(compact('data', 'responsaveis'));
        $this->set('_serialize', ['data']);
    }

    public function add()
    {
        /*
        //Create a new data entity
        $data = $this->Regions->newEntity();
        
        /*******/
        
        //Access method restriction
        if ($this->request->is('post')) {
            
            //Merge form data into object
            //$data = $this->Regions->patchEntity($data, $this->request->getData());

            /*******/
            /*
            //Save all data
            if ($this->Regions->save($data)) {
                
                //Success message and page redirection
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Regions->save($data))
            
            /*******/
            /*
            //Set error message log
            Log::write('debug', 'RegionsController->add: '.json_encode($data->errors()));

            /*******/
            
            //Sem banco de dados: a gravação é apenas simulada
            return $this->simularGravacao(__('Região cadastrada.'));
            
        }//if ($this->request->is('post'))

        //Send object data to view
        $regiao = null;
        $this->set(compact('regiao'));
        $this->render('form');
    }

    public function edit($id)
    {
        /*
        //Find record data
        $data = $this->Regions->get($id);
        
        /*******/
        
        //Access method restriction
        if ($this->request->is(['patch', 'post', 'put'])) {
            /*
            //Merge form data into object
            $data = $this->Regions->patchEntity($data, $this->request->getData());
            
            /*******/
            /*
            //Save all modification
            if ($this->Regions->save($data)) {
                
                //Success message and page redirection
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Regions->save($data))

            /*******/
            /*
            //Set error message log
            Log::write('debug', 'RegionsController->edit: '.json_encode($data->errors()));

            /*******/
            
            //Sem banco de dados: a gravação é apenas simulada
            return $this->simularGravacao(__('Região atualizada.'));
            
        }//if ($this->request->is(['patch', 'post', 'put']))

        /*******/

        //Send object data to view
        $regioes = DemoData::regioes();
        $regiao = isset($regioes[$id]) ? $regioes[$id] : reset($regioes);
        $responsavel = $regiao->usuarios_id ? DemoData::usuario($regiao->usuarios_id) : null;
        $this->set(compact('regiao', 'responsavel'));
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
        $data = $this->Regions->get($id);
        
        /*******/
        /*
        //Delete record and shows a message
        if ($this->Regions->delete($data)) {
            
            //Success page link
            $this->referer = $this->referer.'?action=deleted';

            //Page redirection
            return $this->redirect($this->referer);
            
        }//if ($this->Regions->delete($data))
        
        /*******/
        /*
        //Set error message log
        Log::write('debug', 'RegionsController->delete: '.json_encode($data->errors()));
        */  
        //Sem banco de dados: a exclusão é apenas simulada
        return $this->simularGravacao(__('Região excluída.'));
    }
}