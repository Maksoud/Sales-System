<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Controller/InvoicesController.php */

namespace App\Controller;

use App\Controller\AppController;
use App\Lib\DemoData;

/**
 * Faturas: taxas de inscrição, pedidos, comissões e saques.
 * Enquanto não há banco de dados, as telas usam os dados de App\Lib\DemoData.
 */
class InvoicesController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        //Internal Pages
        $this->Auth->allow();
    }

    /**
     * Gestão: todas as faturas (Extrato Geral). O filtro "tipo" define o título:
     * S = Solicitações de Saques, T = Taxas de Inscrição, P = Faturas de Pedidos, C = Faturas de Comissões.
     */
    public function index()
    {
        $faturas = DemoData::filtrar(DemoData::faturas(), $this->request->getQueryParams(), [
            'id'              => 'id',
            'pedido'          => 'pedidos_id',
            'tipo'            => 'tipo',
            'status'          => 'status',
            'forma_pagamento' => 'forma_pagamento',
            'busca'           => function ($fatura, $valor) {
                return mb_stripos($fatura->usuario->nome . ' ' . $fatura->usuario->login, $valor) !== false;
            },
        ]);

        $this->set('faturas', DemoData::maisRecentes($faturas));
        $this->set('resumo', $this->resumo($faturas));
    }

    /**
     * Extrato do usuário logado. Para a gestão, o caixa da empresa.
     */
    public function statement()
    {
        $usuario = $this->usuarioAtual();

        $faturas = DemoData::filtrar(DemoData::faturasDoUsuario($usuario), $this->request->getQueryParams(), [
            'id' => 'id', 'tipo' => 'tipo', 'status' => 'status',
        ]);

        $this->set('faturas', DemoData::maisRecentes($faturas));
        $this->set('saldos', DemoData::saldos($usuario->id));
        $this->set('resumo', $this->resumo($faturas));
        $this->set('gestao', $this->isGestao());
    }

    /**
     * Solicitação de saque (modal).
     */
    public function withdraw()
    {
        if ($this->request->is('post')) {
            return $this->simularGravacao(__('Solicitação de saque enviada. O pagamento é feito em até 5 dias úteis.'));
        }

        $usuario = $this->usuarioAtual();
        $this->set('usuario', $usuario);
        $this->set('saldos', DemoData::saldos($usuario->id));
        $this->set('gestao', $this->isGestao());
        $this->set('pendentes', count(DemoData::filtrar(DemoData::faturas(), ['tipo' => 'S', 'status' => 'P'], ['tipo' => 'tipo', 'status' => 'status'])));
    }

    /**
     * Detalhes da fatura (modal).
     */
    public function view($id = null)
    {
        $this->set('fatura', DemoData::fatura($id));
        $this->set('gestao', $this->isGestao());
    }

    /**
     * Dados bancários da empresa para pagar uma fatura (modal).
     */
    public function bankDetails($id = null)
    {
        $this->set('fatura', DemoData::fatura($id));
    }

    /**
     * Baixa (pagamento) de uma fatura.
     */
    public function settle($id = null)
    {
        $this->request->allowMethod(['post']);
        return $this->simularGravacao(__('Fatura {0} baixada com sucesso.', str_pad($id, 6, '0', STR_PAD_LEFT)));
    }

    public function cancel($id = null)
    {
        $this->request->allowMethod(['post']);
        return $this->simularGravacao(__('Fatura {0} cancelada.', str_pad($id, 6, '0', STR_PAD_LEFT)));
    }

    /**
     * Filtros dos relatórios (modais). Os relatórios abrem em ReportsController.
     */
    public function report()
    {
        $this->set('associados', DemoData::associadosLista(true));
    }

    public function paymentsReport()
    {
        $this->set('associados', DemoData::associadosLista());
    }

    public function balancesReport()
    {
        $this->set('planos', DemoData::planosLista(true));
    }

    /**
     * Totais por status para o resumo no topo das listas.
     */
    protected function resumo(array $faturas)
    {
        $resumo = ['quantidade' => count($faturas), 'P' => 0, 'F' => 0, 'C' => 0];
        foreach ($faturas as $fatura) {
            $resumo[$fatura->status] += $fatura->total;
        }
        return $resumo;
    }
}
