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

        $this->request->Session()->write(['planos_id'       => 3,
                                          'status_usuario'  => 'P',
                                          'foto_usuario'    => 'usuarios/img.jpg',
                                          'locale'          => 'pt_BR',
                                          'Session.timeout' => 30,
                                          'debug'           => true
                                         ]);
        
        ////////////////////////////////////////////////////////////////////////

        //Registra o nome do usuário para consulta
        $this->set('username', 'Renée Maksoud');
        $this->set('login', 'maksoudrodrigues');
        $this->set('count_avisos', 99);
        $this->set('email', 'em@il.com');
        $this->set('usuarios_id', 1);
        $this->set('foto_usuario', $this->request->Session()->read('foto_usuario'));
        $this->set('status_usuario', 'A');
        $this->set('id_planos_usuario', $this->request->Session()->read('planos_id'));
        $this->set('planos_usuario', $this->GETplanoText($this->request->Session()->read('planos_id')));

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
    
}