<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Controller/OrdersController.php */

namespace App\Controller;

use App\Controller\AppController;
use App\Lib\DemoData;

/**
 * Pedidos: loja, meus pedidos e gestão dos pedidos da loja.
 * Enquanto não há banco de dados, as telas usam os dados de App\Lib\DemoData.
 */
class OrdersController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        //Internal Pages
        $this->Auth->allow();
    }

    /**
     * Gestão: pedidos de todos os associados (Gerenciar > Pedidos da loja).
     */
    public function index()
    {
        $pedidos = DemoData::filtrar(DemoData::pedidos(), $this->request->getQueryParams(), [
            'id'     => 'id',
            'status' => function ($pedido, $valor) {
                //"M": pedidos que dependem de uma ação da empresa
                return $valor == 'M' ? in_array($pedido->status, ['V', 'S', 'T']) : $pedido->status == $valor;
            },
            'tipo'   => 'tipo',
        ]);

        $this->set('pedidos', DemoData::maisRecentes($pedidos));
    }

    /**
     * Loja: novo pedido. Para a gestão, lança uma bonificação para um associado.
     */
    public function store()
    {
        if ($this->request->is('post')) {
            if ($this->isGestao()) {
                return $this->simularGravacao(__('Bonificação lançada com sucesso.'));
            }
            $this->Flash->success(__('Pedido realizado! Nossa equipe vai calcular o frete e os impostos e você receberá a fatura por e-mail.') . ' ' . __('(demonstração: nenhum dado foi alterado)'));
            return $this->redirect(['action' => 'myOrders']);
        }

        $this->set('produtos', DemoData::produtos(true));
        $this->set('usuario', $this->usuarioAtual());
        $this->set('associados', DemoData::associadosLista());
        $this->set('gestao', $this->isGestao());
    }

    /**
     * Pedidos do usuário logado.
     */
    public function myOrders()
    {
        $pedidos = DemoData::filtrar(DemoData::pedidosDoUsuario($this->usuarioAtual()), $this->request->getQueryParams(), [
            'id' => 'id', 'status' => 'status', 'tipo' => 'tipo',
        ]);

        $this->set('pedidos', DemoData::maisRecentes($pedidos));
        $this->set('gestao', $this->isGestao());
    }

    /**
     * Detalhes do pedido (modal).
     */
    public function view($id = null)
    {
        $this->set('pedido', DemoData::pedido($id));
    }

    /**
     * Informar envio do pedido (modal).
     */
    public function delivery($id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            return $this->simularGravacao(__('Envio do pedido registrado.'));
        }
        $this->set('pedido', DemoData::pedido($id));
    }

    /**
     * Informar frete e impostos do pedido (modal).
     */
    public function values($id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            return $this->simularGravacao(__('Valores do pedido informados. A fatura foi enviada ao associado.'));
        }
        $this->set('pedido', DemoData::pedido($id));
    }

    public function finishDelivery($id = null)
    {
        $this->request->allowMethod(['post']);
        return $this->simularGravacao(__('Entrega confirmada. Pedido concluído.'));
    }

    public function cancelDelivery($id = null)
    {
        $this->request->allowMethod(['post']);
        return $this->simularGravacao(__('Envio cancelado. O pedido voltou para preparação.'));
    }

    public function markReceived($id = null)
    {
        $this->request->allowMethod(['post']);
        return $this->simularGravacao(__('Obrigado! Recebimento do pedido confirmado.'));
    }

    /**
     * Filtros do relatório de pedidos (modal). O relatório abre em Reports::orders.
     */
    public function report()
    {
        $this->set('associados', DemoData::associadosLista(true));
    }
}
