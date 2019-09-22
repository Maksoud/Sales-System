<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\Number;

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

        //Registra o nome do usuário para consulta
        $this->set('username', $this->Auth->user('nome'));
        $this->set('login', $this->Auth->user('login'));
        $this->set('usuarios_id', $this->Auth->user('id'));
        $this->set('foto_usuario', $this->request->Session()->read('Auth.User.foto'));
        $this->set('status_usuario', $this->Auth->user('status'));
        $this->set('id_planos_usuario', $this->Auth->user('planos_id'));
        $this->set('planos_usuario', $this->GETplanoText($this->Auth->user('planos_id')));

        ////////////////////////////////////////////////////////////////////////
        // $count_avisos = $this->AvisosListar->listar($this->Auth->user('id'), $this->Auth->user('planos_id'));
        // $count_avisos = count($count_avisos->toArray());
        ////////////////////////////////////////////////////////////////////////

        $title = "Painel Administrativo :: Reiniciando";
        
        ////////////////////////////////////////////////////////////////////////
        
        $this->set(compact('title', 'tipos_planos', 'count_avisos'));

    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->request->Session()->write(['sessionPlanoId'  => 'Dev',
                                          'status_usuario'  => 'P',
                                          'foto_usuario'    => 'usuarios/img.jpg',
                                          'locale'          => 'pt_BR',
                                          'Session.timeout' => 30,
                                          'debug'           => true
                                         ]);

        $this->set('count_avisos', 99);
        $this->set('email', 'em@il.com');
        

        $foto_usuario = $this->request->Session()->read('foto_usuario');
        $this->set('foto_usuario', $foto_usuario);

        // $tipo_planos = ['Dev', 'Admin', 'SM', 'Master', 'VIP', 'Cliente'];
    }
    
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
    
    public function GETplanoSlug($planos_id)
    {
        if ($planos_id == $this->Dev)         return "Dev";
        elseif ($planos_id == $this->Admin)   return "Admin";
        elseif ($planos_id == $this->SM)      return "SM";
        elseif ($planos_id == $this->Master)  return "Master";
        elseif ($planos_id == $this->VIP)     return "VIP";
        elseif ($planos_id == $this->Cliente) return "Cliente";
    }
    
    public function GETplanoText($planos_id)
    {
        if ($planos_id == $this->Dev)         return "Desenvolvedor";
        elseif ($planos_id == $this->Admin)   return "Administrador";
        elseif ($planos_id == $this->SM)      return "Super Master";
        elseif ($planos_id == $this->Master)  return "Master";
        elseif ($planos_id == $this->VIP)     return "VIP";
        elseif ($planos_id == $this->Cliente) return "Cliente";
    }
    
    public function session()
    {
        $this->request->Session()->write('sessionPlano', $this->GETplanoText($this->Auth->user('planos_id')));
        $this->request->Session()->write('sessionPlanoId', $this->Auth->user('planos_id'));
        $foto = $this->request->Session()->read('Auth.User.foto');
        $this->request->Session()->write('Auth.User.foto', "usuarios/" . $foto);
    }
    
}