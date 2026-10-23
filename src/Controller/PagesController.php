<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class PagesController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        //Autoriza a exibição das páginas
        //'update' NÃO é público: ele executa comandos git no servidor
        $this->Auth->allow(['changeTypeOfAccess', 'login', 'logout', 'home', 'content', 'modalContent']);

        //Páginas Internas
        $this->Auth->allow(['regioesIndex', 'planosIndex', 'metasIndex', 'comissoesIndex', 'produtosIndex', 'usuariosIndex']);

    }

    public function regioesIndex()
    {
        //
    }

    public function planosIndex()
    {
        //
    }

    public function metasIndex()
    {
        //
    }

    public function comissoesIndex()
    {
        //
    }

    public function produtosIndex()
    {
        //
    }

    public function usuariosIndex()
    {
        //
    }

    public function modalContent()
    {
        //
    }
    
    public function changeTypeOfAccess($planos_id = null)
    {
        //Muda o tipo do acesso (somente para um plano existente)
        if ($this->isValidPlano($planos_id)) {
            $this->request->Session()->write('planos_id', (int)$planos_id);
        } else {
            $this->Flash->error(__('Tipo de acesso inválido'));
        }

        //Without template
        $this->autoRender = false;

        return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
    }
    
    public function login()
    {

        if ($this->request->is('post')) {
            
            $user = $this->Auth->identify();

            if ($user) {

                $this->Auth->setUser($user);
                
                //GRAVA VARIÁVEIS NA SESSÃO
                $this->session(); 
                
                //REDIRECIONA PARA PÁGINA INICIAL
                return $this->redirect($this->Auth->redirectUrl());

            }//if ($user)
            
            $this->Flash->error(__('Usuário/senha incorreto, tente novamente'));
            return $this->redirect($this->Auth->logout());

        }//if ($this->request->is('post'))

    }
    
    public function logout() 
    {
        $this->request->Session()->destroy();
        $this->Flash->success(__('Sessão Finalizada'));
        return $this->redirect($this->Auth->logout());
    }
    
    public function home()
    {
        
        //SALDOS DO USUÁRIO
        $saldo_disponivel = 1234.56;
        $saldo_bloqueado = 2469.12;

        $this->set(compact('saldo_disponivel', 'saldo_bloqueado'));
        
        /**********************************************************************/
        
        //METAS DO USUÁRIO
        $metas = ['1'=> ['tipo'           => 'I',
                         'meta'           => 10,
                         'qtganha'        => 10,
                         'de_planos_id'   => 3,
                         'para_planos_id' => 4,
                         'produtos_id'    => '',
                         'bonificacao_produtos_id' => 1
                        ],
                  '2'=> ['tipo'           => 'I',
                         'meta'           => 10,
                         'qtganha'        => 1,
                         'de_planos_id'   => 3,
                         'para_planos_id' => 5,
                         'produtos_id'    => '',
                         'bonificacao_produtos_id' => 1
                        ],
                  '3'=> ['tipo'           => 'V',
                         'meta'           => 10,
                         'qtganha'        => 1,
                         'de_planos_id'   => 4,
                         'para_planos_id' => 5,
                         'produtos_id'    => '',
                         'bonificacao_produtos_id' => 1
                        ],
                  '4'=> ['tipo'           => 'V',
                         'meta'           => 10,
                         'qtganha'        => 1,
                         'de_planos_id'   => 5,
                         'para_planos_id' => 5,
                         'produtos_id'    => '',
                         'bonificacao_produtos_id' => 1
                        ],
                 ];
        $this->set('metas', $metas);
        
        /**********************************************************************/
        //DASHBOARD
        /**********************************************************************/

        //Metas
        $smToM = $smToVip = $mToVip = $VipToVip = [];
        for ($i = 0; $i <= 10; $i++) {
            $smToM[$i] = $smToVip[$i] = $mToVip[$i] = $VipToVip[$i] = 0;
        }//for ($i = 0; $i <= 10; $i++)
        
        /************************/
        
        //SM indicando Master
        // if ($usuarios_meta->usuario['planos_id'] == '3' && $meta->para_planos_id == '4') {
        //     //echo 'SM indicando Master: '.$usuarios_meta->contador.'<br>';
        //     $smToM[$usuarios_meta->contador] += 1;
        // }
        
        //SM indicando VIP
        // if ($usuarios_meta->usuario['planos_id'] == '3' && $meta->para_planos_id == '5') {
        //     //echo 'SM indicando VIP: '.$usuarios_meta->contador.'<br>';
        //     $smToVip[$usuarios_meta->contador] += 1;
        // }
        
        //Master indicando VIP
        // if ($usuarios_meta->usuario['planos_id'] == '4' && $meta->para_planos_id == '5') {
        //     //echo 'Master indicando VIP: '.$usuarios_meta->contador.'<br>';
        //     $mToVip[$usuarios_meta->contador] += 1;
        // }
        
        //VIP indicando VIP
        // if ($usuarios_meta->usuario['planos_id'] == '5' && $meta->para_planos_id == '5') {
        //     //echo 'VIP indicando VIP: '.$usuarios_meta->contador.'<br>';
        //     $VipToVip[$usuarios_meta->contador] += 1;
        // }
            
        //debug($smToM);
        //debug($smToVip);
        //debug($mToVip);
        //debug($VipToVip);
        
        $this->set(compact('smToM', 'smToVip', 'mToVip', 'VipToVip'));
        
        /**********************************************************************/
        
    }

    public function update()
    {
        //Somente POST: um link GET pode ser disparado por robôs/pré-carregamento do navegador
        if (!$this->request->is('post')) {
            $this->Flash->error(__('Sistema NÃO atualizado'));
            return $this->redirect($this->referer());
        }

        //Somente desenvolvedores
        if ((int)$this->request->Session()->read('planos_id') !== (int)$this->Dev) {
            $this->Flash->error(__('Você não têm autorização de acessar este conteúdo'));
            return $this->redirect($this->referer());
        }

        //O USO DESSA OPÇÃO É PREJUDICIAL AOS ARQUIVOS DE LOG QUE SERÃO SOBRESCRITOS
        $shell  = (string)shell_exec("git reset --hard FETCH_HEAD 2>&1");
        $shell .= (string)shell_exec("git clean -df 2>&1");
        $shell .= (string)shell_exec("git pull origin master 2>&1");

        //Grava o log fora do webroot (antes ficava público em webroot/log.log)
        $textoLog  = PHP_EOL . '================================================';
        $textoLog .= PHP_EOL . 'Data: ' . date('d/m/Y - H:i:s');
        $textoLog .= PHP_EOL . $shell;
        $textoLog .= PHP_EOL . '================================================' . PHP_EOL;
        @file_put_contents(LOGS . 'update.log', $textoLog, FILE_APPEND);

        $this->Flash->success(__('Atualização realizada com sucesso'));
        return $this->redirect($this->referer());
    }
    
    public function debugMode()
    {
        if (Configure::read('debug') == true) {
            Configure::write('debug', 0);
            $this->Flash->warning('Modo DEBUG desativado!');
        } else {
            Configure::write('debug', 1);
            $this->Flash->warning('Modo DEBUG ativo!');
        }
        return $this->redirect($this->referer());
    }
    
    public function display(...$path)
    {
        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }
}