<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Controller/ProductsController.php */

namespace App\Controller;

use App\Controller\AppController;
use App\Lib\DemoData;

/**
 * Produtos da loja.
 * Enquanto não há banco de dados, as telas usam os dados de App\Lib\DemoData.
 */
class ProductsController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        //Internal Pages
        $this->Auth->allow();
    }

    public function index()
    {
        $produtos = DemoData::filtrar(DemoData::produtos(), $this->request->getQueryParams(), [
            'status' => 'status',
            'title'  => function ($produto, $valor) {
                return mb_stripos($produto->title . ' ' . $produto->descricao, $valor) !== false;
            },
        ]);

        //Quantidade vendida de cada produto (pedidos não cancelados)
        $vendidos = [];
        foreach (DemoData::pedidos() as $pedido) {
            if ($pedido->status == 'C') continue;
            foreach ($pedido->pedidos_produtos as $item) {
                $vendidos[$item->produtos_id] = (isset($vendidos[$item->produtos_id]) ? $vendidos[$item->produtos_id] : 0) + $item->quantidade;
            }
        }

        $this->set(compact('produtos', 'vendidos'));
    }

    public function view($id = null)
    {
        $this->set('produto', DemoData::produto($id));
    }

    public function add()
    {
        if ($this->request->is('post')) {
            return $this->simularGravacao(__('Produto cadastrado.'));
        }
        $this->set('produto', null);
        $this->render('form');
    }

    public function edit($id = null)
    {
        if ($this->request->is(['post', 'put', 'patch'])) {
            return $this->simularGravacao(__('Produto atualizado.'));
        }
        $this->set('produto', DemoData::produto($id));
        $this->render('form');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        return $this->simularGravacao(__('Produto excluído.'));
    }
}
