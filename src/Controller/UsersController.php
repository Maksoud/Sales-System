<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Controller/UsersController.php */

namespace App\Controller;

use App\Controller\AppController;
use App\Lib\DemoData;

/**
 * Usuários e associados: rede, cadastro, dados pessoais e bancários.
 * Enquanto não há banco de dados, as telas usam os dados de App\Lib\DemoData.
 */
class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        //Internal Pages
        $this->Auth->allow();
    }

    /**
     * Sistema > Usuários.
     */
    public function index()
    {
        $usuarios = DemoData::filtrar(DemoData::usuarios(), $this->request->getQueryParams(), [
            'planos_id' => 'planos_id',
            'status'    => 'status',
            'nome'      => function ($usuario, $valor) {
                return mb_stripos($usuario->nome . ' ' . $usuario->login, $valor) !== false;
            },
            'patrocinador' => function ($usuario, $valor) {
                return $usuario->Patrocinador && mb_stripos($usuario->Patrocinador->nome . ' ' . $usuario->Patrocinador->login, $valor) !== false;
            },
        ]);

        $this->set('usuarios', DemoData::maisRecentes($usuarios));
        $this->set('planos', DemoData::planosLista());
    }

    /**
     * Minha Rede (modal): árvore de indicados. A gestão vê a rede inteira.
     */
    public function network()
    {
        $raiz = $this->isGestao() ? DemoData::usuario(DemoData::ADMIN) : $this->usuarioAtual();

        $this->set('raiz', $raiz);
        $this->set('total', count(DemoData::descendentes($raiz->id)));
    }

    /**
     * Cadastrar Associado (modal).
     */
    public function add()
    {
        if ($this->request->is('post')) {
            return $this->simularGravacao(__('Associado cadastrado. A fatura da taxa de inscrição foi enviada por e-mail.'));
        }

        $planos_id = (int)$this->request->Session()->read('planos_id');

        //Cada plano só cadastra planos iguais ou abaixo dele
        $planos = DemoData::planosLista(true) + [DemoData::CLIENTE => DemoData::planos()[DemoData::CLIENTE]->title];
        if (!$this->isGestao()) {
            $planos = array_filter($planos, function ($id) use ($planos_id) { return $id >= $planos_id; }, ARRAY_FILTER_USE_KEY);
        }

        $this->set('planos', $planos);
        $this->set('taxas', DemoData::planos());
        $this->set('patrocinadores', DemoData::associadosLista());
        $this->set('usuario', $this->usuarioAtual());
        $this->set('gestao', $this->isGestao());
    }

    /**
     * Dados do associado (modal de consulta).
     */
    public function view($id = null)
    {
        $usuario = DemoData::usuario($id) ?: $this->usuarioAtual();

        $this->set('usuario', $usuario);
        $this->set('saldos', DemoData::saldos($usuario->id));
        $this->set('indicados', count(DemoData::filhos($usuario->id)));
    }

    /**
     * Edição do cadastro pela gestão (modal).
     */
    public function edit($id = null)
    {
        if ($this->request->is(['post', 'put', 'patch'])) {
            return $this->simularGravacao(__('Cadastro atualizado.'));
        }
        $this->set('usuario', DemoData::usuario($id) ?: $this->usuarioAtual());
        $this->set('planos', DemoData::planosLista());
        $this->set('edicao', true);
        $this->render('profile');
    }

    /**
     * Meus Dados (modal).
     */
    public function profile()
    {
        if ($this->request->is(['post', 'put', 'patch'])) {
            return $this->simularGravacao(__('Seus dados foram atualizados.'));
        }
        $this->set('usuario', $this->usuarioAtual());
        $this->set('planos', DemoData::planosLista());
        $this->set('edicao', false);
    }

    /**
     * Alterar Minha Senha (modal).
     */
    public function password()
    {
        if ($this->request->is(['post', 'put', 'patch'])) {
            return $this->simularGravacao(__('Senha alterada.'));
        }
    }

    /**
     * Dados Bancários (modal).
     */
    public function bank()
    {
        if ($this->request->is(['post', 'put', 'patch'])) {
            return $this->simularGravacao(__('Dados bancários atualizados.'));
        }
        $this->set('usuario', $this->usuarioAtual());
    }

    /**
     * Mudança de plano pela gestão (modal).
     */
    public function changePlan($id = null)
    {
        if ($this->request->is(['post', 'put', 'patch'])) {
            return $this->simularGravacao(__('Plano alterado. A fatura da diferença foi gerada.'));
        }
        $this->set('usuario', DemoData::usuario($id) ?: $this->usuarioAtual());
        $this->set('planos', DemoData::planos());
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        return $this->simularGravacao(__('Usuário excluído.'));
    }

    /**
     * Filtros dos relatórios (modais). Os relatórios abrem em ReportsController.
     */
    public function report()
    {
        $this->set('patrocinadores', DemoData::associadosLista());
        $this->set('planos', DemoData::planosLista(true));
    }

    public function clientsReport()
    {
        $this->set('patrocinadores', DemoData::associadosLista());
    }
}
