<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Controller/ReportsController.php */

namespace App\Controller;

use App\Controller\AppController;
use App\Lib\DemoData;

/**
 * Relatórios para impressão (layout "relatorio").
 * Recebem os filtros por GET a partir dos formulários em modal (element report-form).
 * Enquanto não há banco de dados, usam os dados de App\Lib\DemoData.
 */
class ReportsController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        //Internal Pages
        $this->Auth->allow();
    }

    public function beforeRender(\Cake\Event\Event $event)
    {
        parent::beforeRender($event);

        $this->viewBuilder()->setLayout('relatorio');

        //Período informado no filtro (padrão: tudo)
        $inicio = DemoData::parseData($this->request->getQuery('data_inicio'));
        $final  = DemoData::parseData($this->request->getQuery('data_final'));
        $this->set('periodo', [$inicio ? $inicio->format('d/m/Y') : null, $final ? $final->format('d/m/Y') : null]);
    }

    public function orders()
    {
        $pedidos = $this->porPeriodo(DemoData::pedidos());
        $pedidos = DemoData::filtrar($pedidos, $this->request->getQueryParams(), [
            'usuarios_id' => 'usuarios_id', 'status' => 'status', 'tipo' => 'tipo',
        ]);

        $this->set('pedidos', DemoData::maisRecentes($pedidos));
    }

    public function invoices()
    {
        $faturas = $this->porPeriodo(DemoData::faturas());
        $faturas = DemoData::filtrar($faturas, $this->request->getQueryParams(), [
            'usuarios_id' => 'usuarios_id', 'tipo' => 'tipo', 'status' => 'status', 'forma_pagamento' => 'forma_pagamento',
        ]);

        $this->set('faturas', DemoData::maisRecentes($faturas));
    }

    public function commissions()
    {
        $faturas = $this->porPeriodo(array_filter(DemoData::faturas(), function ($f) { return $f->tipo == 'C'; }));
        $faturas = DemoData::filtrar($faturas, $this->request->getQueryParams(), [
            'usuarios_id' => 'usuarios_id',
            'tipo'   => function ($fatura, $valor) { return $fatura->comissao->tipo == $valor; },
            'status' => 'status',
        ]);

        $this->set('faturas', DemoData::maisRecentes($faturas));
    }

    public function payments()
    {
        $saques = $this->porPeriodo(array_filter(DemoData::faturas(), function ($f) { return $f->tipo == 'S'; }));
        $saques = DemoData::filtrar($saques, $this->request->getQueryParams(), [
            'usuarios_id' => 'usuarios_id', 'status' => 'status',
        ]);

        $this->set('saques', DemoData::maisRecentes($saques));
    }

    public function associates()
    {
        $associados = array_filter(DemoData::usuarios(), function ($u) { return in_array($u->planos_id, [3, 4, 5]); });
        $associados = DemoData::filtrar($this->porPeriodo($associados), $this->request->getQueryParams(), [
            'patrocinador_id' => 'patrocinador_id', 'planos_id' => 'planos_id', 'status' => 'status',
        ]);

        $this->set('associados', DemoData::maisRecentes($associados));
    }

    public function clients()
    {
        $clientes = array_filter(DemoData::usuarios(), function ($u) { return $u->planos_id == DemoData::CLIENTE; });
        $clientes = DemoData::filtrar($this->porPeriodo($clientes), $this->request->getQueryParams(), [
            'patrocinador_id' => 'patrocinador_id',
        ]);

        //Pedidos e total comprado por cliente
        $compras = [];
        foreach (DemoData::pedidos() as $pedido) {
            if ($pedido->status == 'C' || $pedido->status == 'V') continue;
            if (!isset($compras[$pedido->usuarios_id])) $compras[$pedido->usuarios_id] = ['pedidos' => 0, 'total' => 0, 'ultimo' => null];
            $compras[$pedido->usuarios_id]['pedidos']++;
            $compras[$pedido->usuarios_id]['total'] += $pedido->total;
            if (!$compras[$pedido->usuarios_id]['ultimo'] || $pedido->created > $compras[$pedido->usuarios_id]['ultimo']) {
                $compras[$pedido->usuarios_id]['ultimo'] = $pedido->created;
            }
        }

        $this->set('clientes', DemoData::maisRecentes($clientes));
        $this->set('compras', $compras);
    }

    public function balances()
    {
        $associados = array_filter(DemoData::usuarios(), function ($u) { return in_array($u->planos_id, [3, 4, 5]); });
        $associados = DemoData::filtrar($associados, $this->request->getQueryParams(), ['planos_id' => 'planos_id']);

        $saldos = [];
        foreach ($associados as $id => $associado) {
            $saldo = DemoData::saldos($id) + ['sacado' => 0];
            foreach (DemoData::faturasDoUsuario($associado) as $fatura) {
                if ($fatura->tipo == 'S' && $fatura->status == 'F') $saldo['sacado'] += $fatura->total;
            }

            $filtro = $this->request->getQuery('saldo');
            if ($filtro && $saldo[$filtro] <= 0) continue;
            $saldos[$id] = $saldo;
        }
        uasort($saldos, function ($a, $b) { return ($b['disponivel'] + $b['bloqueado']) <=> ($a['disponivel'] + $a['bloqueado']); });

        $this->set(compact('associados', 'saldos'));
    }

    /**
     * Progresso das metas de cada associado.
     */
    public function goals()
    {
        $linhas = [];
        foreach (DemoData::usuarios() as $usuario) {
            if (!in_array($usuario->planos_id, [3, 4, 5]) || $usuario->status != 'A') continue;
            if ($this->request->getQuery('planos_id') && $usuario->planos_id != $this->request->getQuery('planos_id')) continue;
            foreach (DemoData::metasDoUsuario($usuario) as $progresso) {
                $linhas[] = ['usuario' => $usuario, 'meta' => $progresso->meta, 'contador' => $progresso->contador];
            }
        }

        $this->set('linhas', $linhas);
        $this->set('planos', DemoData::planosLista());
        $this->set('produtos', DemoData::produtosLista());
    }

    /**
     * Novos cadastros por mês nos últimos 12 meses, com a receita das taxas de inscrição.
     */
    public function registrations()
    {
        $meses = [];
        for ($i = 11; $i >= 0; $i--) {
            $chave = date('Y-m', strtotime("first day of -$i month"));
            $meses[$chave] = [3 => 0, 4 => 0, 5 => 0, 6 => 0, 'taxas' => 0];
        }

        foreach (DemoData::usuarios() as $usuario) {
            $chave = $usuario->created->format('Y-m');
            if (isset($meses[$chave][$usuario->planos_id])) $meses[$chave][$usuario->planos_id]++;
        }
        foreach (DemoData::faturas() as $fatura) {
            if ($fatura->tipo != 'T' || $fatura->status != 'F') continue;
            $chave = $fatura->pagamento->format('Y-m');
            if (isset($meses[$chave])) $meses[$chave]['taxas'] += $fatura->total;
        }

        $this->set('meses', $meses);
        $this->set('planos', DemoData::planosLista());
    }

    /**
     * Tabela de ICMS nas vendas interestaduais (origem: Alagoas, sede da empresa).
     */
    public function taxes()
    {
        $ufs = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA',
                'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];
        $antecipado = ['CE', 'PE', 'BA', 'PB', 'RN', 'SE', 'PI', 'MA'];
        $impostos   = [];
        foreach ($ufs as $uf) {
            $impostos[] = ['origem' => 'AL', 'destino' => $uf, 'valor' => $uf == 'AL' ? 19 : 12, 'antecipado' => in_array($uf, $antecipado)];
        }

        $this->set('impostos', $impostos);
    }

    /**
     * Filtra pelo período informado (data_inicio / data_final).
     */
    protected function porPeriodo(array $lista)
    {
        return DemoData::filtrarPeriodo($lista, $this->request->getQuery('data_inicio'), $this->request->getQuery('data_final'));
    }
}
