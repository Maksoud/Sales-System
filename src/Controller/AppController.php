<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Number;
use App\Lib\DemoData;

Number::config('', \NumberFormatter::CURRENCY, [
    'before'  => null,
    'pattern' => ' #.##,##0',
    'places'  => '2',
    'zero'    => '0,00'
    ]);

class AppController extends Controller
{
    public function isAuthorized($user)
    {
        // All logged users can access every action
        if (isset($user)) {
            return true;
        }
        return false;
    }
    
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'userModel' => 'Usuarios', //Nome da Tabela de Usuários
                    'fields'    => ['username' => 'username',
                                    'password' => 'password',
                                    'passwordHasher' => 'Blowfish'
                                   ]
                ]
            ],
            'authError'      => 'Você não têm autorização de acessar este conteúdo',
            'loginAction'    => ['controller' => 'Pages', 'action' => 'home'],
            'loginRedirect'  => ['controller' => 'Pages', 'action' => 'home'], 
            'logoutRedirect' => ['controller' => 'Pages', 'action' => 'home'],
            'unauthorizedRedirect' => ['controller' => 'Pages', 'action' => 'home'],
            'storage' => 'Session',
            //'authorize' => 'Controller' 
        ]);
        
        ////////////////////////////////////////////////////////////////////////

        /**
            Configure::write('Dev', 1);     // DESENVOLVEDORES
            Configure::write('Admin', 2);   // ADMINISTRADOR
            Configure::write('SM', 3);      // SUPER MASTER
            Configure::write('Master', 4);  // MASTER
            Configure::write('VIP', 5);     // VIP
            Configure::write('Cliente', 6); // Cliente
         */
        
        //Adicinando valores de planos à constantes
        $this->Dev     = Configure::read('Dev');
        $this->Admin   = Configure::read('Admin');
        $this->SM      = Configure::read('SM');
        $this->Master  = Configure::read('Master');
        $this->VIP     = Configure::read('VIP');
        $this->Cliente = Configure::read('Cliente');

        ////////////////////////////////////////////////////////////////////////

        //Define alguns valores na sessão
        //status 'A' (ativo): com 'P' o painel esconde a loja, o cadastro e o saque
        $this->request->Session()->write(['status_usuario'  => 'A',
                                          'foto_usuario'    => 'usuarios/img.jpg',
                                          'locale'          => 'pt_BR',
                                          'Session.timeout' => 30,
                                          'debug'           => (bool)Configure::read('debug')
                                         ]);
        
        ////////////////////////////////////////////////////////////////////////

        //O usuário logado (nome, login, avisos...) é definido no beforeFilter,
        //conforme o perfil escolhido no seletor "Ver como"

        ////////////////////////////////////////////////////////////////////////

        $title = "Painel Administrativo :: Reiniciando";
        
        ////////////////////////////////////////////////////////////////////////
        
        $this->set(compact('title'));

    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        //Garante um tipo de acesso válido ANTES de montar o menu
        //(antes o padrão era gravado depois, e o primeiro acesso exibia erro no menu)
        $planos_id = (int)$this->request->Session()->read('planos_id');
        if (!$this->isValidPlano($planos_id)) {
            $planos_id = (int)$this->Dev;
            $this->request->Session()->write('planos_id', $planos_id);
        }

        //Define alguns valores na sessão
        $this->request->Session()->write('sessionPlanoId', $this->GETplanoSlug($planos_id));

        //Usuário de demonstração que representa o perfil (enquanto não há login real)
        $usuario = $this->usuarioAtual();
        $this->set('username', $usuario->nome);
        $this->set('login', $usuario->login);
        $this->set('email', $usuario->email);
        $this->set('usuarios_id', $usuario->id);
        $this->set('foto_usuario', 'usuarios/' . $usuario->foto);
        $this->set('status_usuario', $this->request->Session()->read('status_usuario'));
        $this->set('count_avisos', count(DemoData::avisosDoPerfil($planos_id)));

        //Define alguns valores para view
        $this->set('id_planos_usuario', $planos_id);
        $this->set('planos_usuario', $this->GETplanoText($planos_id));
        $this->set('lista_planos', $this->planos());
    }
    
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
    
    /**
     * Mapa id do plano => [slug, nome exibido].
     */
    protected function planos()
    {
        return [
            (int)$this->Dev     => ['Dev',     'Desenvolvedor'],
            (int)$this->Admin   => ['Admin',   'Administrador'],
            (int)$this->SM      => ['SM',      'Super Master'],
            (int)$this->Master  => ['Master',  'Master'],
            (int)$this->VIP     => ['VIP',     'VIP'],
            (int)$this->Cliente => ['Cliente', 'Cliente'],
        ];
    }

    /**
     * Usuário de demonstração do perfil atual.
     */
    protected function usuarioAtual()
    {
        return DemoData::usuarioDoPerfil((int)$this->request->Session()->read('planos_id'));
    }

    /**
     * Perfis de gestão (Dev e Admin).
     */
    protected function isGestao()
    {
        return DemoData::isGestao((int)$this->request->Session()->read('planos_id'));
    }

    /**
     * Resposta padrão das ações que gravariam no banco: sem banco de dados,
     * a operação é apenas simulada e o usuário volta para a tela anterior.
     */
    protected function simularGravacao($mensagem = null)
    {
        $this->Flash->success(($mensagem ?: __('Registro gravado com sucesso')) . ' ' . __('(demonstração: nenhum dado foi alterado)'));
        return $this->redirect($this->referer(['controller' => 'Pages', 'action' => 'home'], true));
    }

    protected function isValidPlano($planos_id)
    {
        return is_numeric($planos_id) && array_key_exists((int)$planos_id, $this->planos());
    }

    //Métodos protegidos: métodos públicos do controller viram URLs acessíveis
    protected function GETplanoSlug($planos_id)
    {
        return $this->isValidPlano($planos_id) ? $this->planos()[(int)$planos_id][0] : null;
    }

    protected function GETplanoText($planos_id)
    {
        return $this->isValidPlano($planos_id) ? $this->planos()[(int)$planos_id][1] : null;
    }

}