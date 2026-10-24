<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Controller/NoticesController.php */

namespace App\Controller;

use App\Controller\AppController;
use App\Lib\DemoData;

/**
 * Avisos enviados aos associados (todos ou por plano).
 * Enquanto não há banco de dados, as telas usam os dados de App\Lib\DemoData.
 */
class NoticesController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        //Internal Pages
        $this->Auth->allow();
    }

    /**
     * Gerenciar > Avisos.
     */
    public function index()
    {
        $avisos = DemoData::filtrar(DemoData::avisos(), $this->request->getQueryParams(), [
            'planos_id' => function ($aviso, $valor) {
                return $valor === 'todos' ? empty($aviso->planos_id) : $aviso->planos_id == $valor;
            },
            'busca' => function ($aviso, $valor) {
                return mb_stripos($aviso->title, $valor) !== false;
            },
        ]);

        $this->set('avisos', $avisos);
        $this->set('planos', DemoData::planosLista(true));
    }

    /**
     * Avisos do usuário logado (modal do sino no cabeçalho).
     */
    public function pending()
    {
        $this->set('avisos', DemoData::avisosDoPerfil((int)$this->request->Session()->read('planos_id')));
    }

    public function view($id = null)
    {
        $this->set('aviso', DemoData::aviso($id));
    }

    public function add()
    {
        if ($this->request->is('post')) {
            return $this->simularGravacao(__('Aviso enviado.'));
        }
        $this->set('aviso', null);
        $this->set('planos', DemoData::planosLista(true));
        $this->render('form');
    }

    public function edit($id = null)
    {
        if ($this->request->is(['post', 'put', 'patch'])) {
            return $this->simularGravacao(__('Aviso atualizado.'));
        }
        $this->set('aviso', DemoData::aviso($id));
        $this->set('planos', DemoData::planosLista(true));
        $this->render('form');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        return $this->simularGravacao(__('Aviso excluído.'));
    }
}
