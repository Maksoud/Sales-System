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
        $this->Auth->allow(['regioesIndex', 'changeTypeOfAccess', 'login', 'logout', 'home', 'update', 'content', 'modalContent', 'modal2']);

    }

    public function regioesIndex()
    {
        //
    }
    
    public function changeTypeOfAccess($planos_id)
    {
        //Muda o tipo do acesso
        $this->request->Session()->write('planos_id', $planos_id);

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
        
        $this->set(compact('usuarios'));
        
        /**********************************************************************/
        
        $this->set(compact('faturas'));
        
        /**********************************************************************/
        
        $this->set(compact('pedidos'));
        
        /**********************************************************************/
        
        $this->set(compact('saldos_disponivel', 'saldos_bloqueado'));
        
        /**********************************************************************/
        
        //Metas
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
        if ($this->request->is(['get'])) {
                
                //CRIA DIRETÓRIO SE NÃO EXISTIR 
                if (!file_exists('log.log')) {
                    @fopen('log.log', 'x+');
                }//if (!file_exists('log.log'))
                
                //O USO DESSA OPÇÃO É PREJUDICIAL AOS ARQUIVOS DE LOG QUE SERÃO SOBRESCRITOS
                $shell = shell_exec("git reset --hard FETCH_HEAD 2>&1");
                $shell .= shell_exec("git clean -df 2>&1");
                
                $shell .= shell_exec("git pull origin master 2>&1");
                
                $textoLog  = PHP_EOL . '================================================ <br />';
                $textoLog .= PHP_EOL . "Data: " . date('d'."/".'m'."/".'Y'." - ".'H'.":".'i'.":".'s') . '<br>';
                $textoLog .= PHP_EOL . $shell . '<br>';
                $textoLog .= PHP_EOL . '================================================ <br />';
                
                $arquivoLog = fopen('log.log', 'r+');
                fwrite($arquivoLog, $textoLog);
                fclose($arquivoLog);
                
                $this->Flash->success(__('Atualização realizada com sucesso'));
                return $this->redirect($this->referer());

        }//if ($this->request->is(['get']))

        $this->Flash->error(__('Sistema NÃO atualizado'));
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