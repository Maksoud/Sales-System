<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Lib/DemoData.php */

namespace App\Lib;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * Dados simulados para apresentar o sistema em uso enquanto não há banco de dados.
 *
 * Tudo é gerado de forma determinística (mesma semente = mesmos dados) e com datas
 * relativas ao dia atual, então o painel sempre parece "vivo". Os registros são
 * coerentes entre si: comissões nascem das faturas pagas, saques respeitam o saldo
 * liberado e os saldos do painel são calculados a partir dessas faturas.
 *
 * Os campos seguem o esquema do projeto de origem (mineralli.sql), para facilitar
 * a troca por consultas reais ao banco no futuro.
 */
class DemoData
{
    const DEV     = 1;
    const ADMIN   = 2;
    const SM      = 3;
    const MASTER  = 4;
    const VIP     = 5;
    const CLIENTE = 6;

    //Usuário que representa cada perfil no seletor "Ver como"
    const USUARIO_POR_PERFIL = [1 => 1, 2 => 2, 3 => 3, 4 => 6, 5 => 13, 6 => 28];

    //Dias para a comissão ser liberada após o pagamento da fatura de origem
    const DIAS_LIBERACAO = 30;

    protected static $data = null;
    protected static $seed = 20190823;

    /**************************************************************************/
    // Acesso aos dados
    /**************************************************************************/

    public static function planos()
    {
        return self::get('planos');
    }

    /** Lista id => título, para selects */
    public static function planosLista($somenteRede = false)
    {
        $lista = [];
        foreach (self::planos() as $id => $plano) {
            if ($somenteRede && !in_array($id, [self::SM, self::MASTER, self::VIP])) {
                continue;
            }
            $lista[$id] = $plano->title;
        }
        return $lista;
    }

    public static function produtos($somenteAtivos = false)
    {
        $produtos = self::get('produtos');
        if ($somenteAtivos) {
            $produtos = array_filter($produtos, function ($p) { return $p->status == 'A'; });
        }
        return $produtos;
    }

    public static function produtosLista()
    {
        $lista = [];
        foreach (self::produtos() as $id => $produto) {
            $lista[$id] = $produto->title;
        }
        return $lista;
    }

    public static function produto($id)
    {
        $produtos = self::produtos();
        return isset($produtos[$id]) ? $produtos[$id] : reset($produtos);
    }

    public static function usuarios()
    {
        return self::get('usuarios');
    }

    public static function usuario($id)
    {
        $usuarios = self::usuarios();
        return isset($usuarios[$id]) ? $usuarios[$id] : null;
    }

    /** Associados da rede (SM, Master e VIP) em ordem alfabética: id => nome */
    public static function associadosLista($incluirClientes = false)
    {
        $planos = [self::SM, self::MASTER, self::VIP];
        if ($incluirClientes) {
            $planos[] = self::CLIENTE;
        }
        $lista = [];
        foreach (self::usuarios() as $id => $usuario) {
            if (in_array($usuario->planos_id, $planos)) {
                $lista[$id] = $usuario->nome;
            }
        }
        asort($lista);
        return $lista;
    }

    /** Usuário que representa o perfil escolhido no seletor "Ver como" */
    public static function usuarioDoPerfil($planos_id)
    {
        $mapa = self::USUARIO_POR_PERFIL;
        $id   = isset($mapa[$planos_id]) ? $mapa[$planos_id] : 1;
        return self::usuario($id);
    }

    public static function isGestao($planos_id)
    {
        return in_array((int)$planos_id, [self::DEV, self::ADMIN]);
    }

    public static function pedidos()
    {
        return self::get('pedidos');
    }

    public static function pedido($id)
    {
        $pedidos = self::pedidos();
        return isset($pedidos[$id]) ? $pedidos[$id] : reset($pedidos);
    }

    public static function faturas()
    {
        return self::get('faturas');
    }

    public static function fatura($id)
    {
        $faturas = self::faturas();
        return isset($faturas[$id]) ? $faturas[$id] : reset($faturas);
    }

    public static function avisos()
    {
        return self::get('avisos');
    }

    public static function aviso($id)
    {
        $avisos = self::avisos();
        return isset($avisos[$id]) ? $avisos[$id] : reset($avisos);
    }

    /** Avisos ativos destinados ao perfil (todos ou o plano específico) */
    public static function avisosDoPerfil($planos_id)
    {
        return array_filter(self::avisos(), function ($aviso) use ($planos_id) {
            $paraPerfil = empty($aviso->planos_id) || $aviso->planos_id == $planos_id || self::isGestao($planos_id);
            return $paraPerfil && $aviso->ativo;
        });
    }

    /** Regras de comissão (Sistema > Comissões) */
    public static function comissoes()
    {
        return self::get('comissoes');
    }

    /** Regras de metas (Sistema > Metas) */
    public static function metas()
    {
        return self::get('metas');
    }

    public static function regioes()
    {
        return self::get('regioes');
    }

    /** Pedidos feitos pelo usuário. Para a gestão: as bonificações que ela lançou */
    public static function pedidosDoUsuario($usuario)
    {
        if (self::isGestao($usuario->planos_id)) {
            return array_filter(self::pedidos(), function ($p) { return $p->tipo == 'B'; });
        }
        return array_filter(self::pedidos(), function ($p) use ($usuario) {
            return $p->usuarios_id == $usuario->id;
        });
    }

    /**
     * Extrato do usuário. Para a gestão, o extrato é o caixa da empresa:
     * taxas e pedidos recebidos e saques pagos aos associados.
     */
    public static function faturasDoUsuario($usuario)
    {
        if (self::isGestao($usuario->planos_id)) {
            return array_filter(self::faturas(), function ($f) {
                return in_array($f->tipo, ['T', 'P', 'S']) && $f->status == 'F';
            });
        }
        return array_filter(self::faturas(), function ($f) use ($usuario) {
            return $f->usuarios_id == $usuario->id;
        });
    }

    /** Saldo disponível e bloqueado (a receber) do usuário */
    public static function saldos($usuarios_id)
    {
        $disponivel = $bloqueado = 0;

        foreach (self::faturas() as $fatura) {
            if ($fatura->usuarios_id != $usuarios_id) {
                continue;
            }
            if ($fatura->tipo == 'C' && $fatura->status == 'F') $disponivel += $fatura->total;
            if ($fatura->tipo == 'C' && $fatura->status == 'P') $bloqueado  += $fatura->total;
            if ($fatura->tipo == 'S' && $fatura->status != 'C') $disponivel -= $fatura->total;
        }

        return ['disponivel' => round($disponivel, 2), 'bloqueado' => round($bloqueado, 2)];
    }

    /** Indicados diretos do usuário */
    public static function filhos($usuarios_id)
    {
        $filhos = self::get('filhos');
        $lista  = [];
        if (isset($filhos[$usuarios_id])) {
            foreach ($filhos[$usuarios_id] as $id) {
                $lista[$id] = self::usuario($id);
            }
        }
        return $lista;
    }

    /** Todos os ids abaixo do usuário na rede */
    public static function descendentes($usuarios_id)
    {
        $ids = [];
        foreach (self::filhos($usuarios_id) as $id => $filho) {
            $ids[] = $id;
            $ids   = array_merge($ids, self::descendentes($id));
        }
        return $ids;
    }

    /** Progresso das metas do usuário: lista de entidades {meta, contador} */
    public static function metasDoUsuario($usuario)
    {
        $lista = [];

        foreach (self::metas() as $meta) {
            if ($meta->de_planos_id != $usuario->planos_id) {
                continue;
            }

            $contador = 0;
            if ($meta->tipo == 'I') {
                foreach (self::filhos($usuario->id) as $filho) {
                    if ($filho->planos_id == $meta->para_planos_id && $filho->status == 'A') $contador++;
                }
            } else {
                foreach (self::pedidosDoUsuario($usuario) as $pedido) {
                    if (!in_array($pedido->status, ['S', 'T', 'F'])) continue;
                    foreach ($pedido->pedidos_produtos as $item) {
                        if ($item->produtos_id == $meta->produtos_id) $contador += $item->quantidade;
                    }
                }
            }

            $lista[] = new Entity(['meta' => $meta, 'contador' => min($contador, $meta->meta)]);
        }

        return $lista;
    }

    /**************************************************************************/
    // Filtros usados nas telas de busca
    /**************************************************************************/

    /**
     * Aplica os filtros da query string sobre uma lista de entidades.
     * $campos: nome do parâmetro => campo da entidade (ou callable que recebe a entidade e o valor).
     * Parâmetros especiais: "mes", "ano" e "dia" usam o campo created.
     */
    public static function filtrar(array $lista, array $query, array $campos = [])
    {
        return array_filter($lista, function ($item) use ($query, $campos) {

            foreach ($query as $param => $valor) {

                if (is_array($valor) || trim((string)$valor) === '') {
                    continue;
                }
                $valor = trim((string)$valor);

                if (in_array($param, ['mes', 'ano', 'dia']) && $item->has('created')) {
                    $formato = ['mes' => 'n', 'ano' => 'Y', 'dia' => 'j'];
                    if ((int)$item->created->format($formato[$param]) !== (int)$valor) return false;
                    continue;
                }

                if (!isset($campos[$param])) {
                    continue;
                }

                $campo = $campos[$param];

                if (is_callable($campo)) {
                    if (!$campo($item, $valor)) return false;
                } elseif ($param == 'id' || $param == 'pedido') {
                    if ((int)$item->get($campo) !== (int)$valor) return false;
                } else {
                    if ((string)$item->get($campo) !== $valor) return false;
                }
            }

            return true;
        });
    }

    /** Filtra pelo período de datas dd/mm/aaaa (campos data_inicio / data_final) */
    public static function filtrarPeriodo(array $lista, $inicio, $final, $campo = 'created')
    {
        $inicio = self::parseData($inicio);
        $final  = self::parseData($final);

        return array_filter($lista, function ($item) use ($inicio, $final, $campo) {
            $data = $item->get($campo);
            if (!$data) return false;
            if ($inicio && $data->format('Y-m-d') < $inicio->format('Y-m-d')) return false;
            if ($final && $data->format('Y-m-d') > $final->format('Y-m-d')) return false;
            return true;
        });
    }

    public static function parseData($texto)
    {
        if (!$texto || !preg_match('#^(\d{2})/(\d{2})/(\d{4})$#', trim($texto), $m)) {
            return null;
        }
        return FrozenTime::create((int)$m[3], (int)$m[2], (int)$m[1], 0, 0, 0);
    }

    /** Ordena por data de criação, mais recentes primeiro */
    public static function maisRecentes(array $lista)
    {
        uasort($lista, function ($a, $b) {
            return $b->created->getTimestamp() - $a->created->getTimestamp();
        });
        return $lista;
    }

    /**************************************************************************/
    // Geração dos dados
    /**************************************************************************/

    protected static function get($chave)
    {
        if (self::$data === null) {
            self::build();
        }
        return self::$data[$chave];
    }

    protected static function rand($min, $max)
    {
        self::$seed = (self::$seed * 1103515245 + 12345) & 0x7fffffff;
        return $min + (self::$seed % ($max - $min + 1));
    }

    protected static function pick(array $lista)
    {
        $lista = array_values($lista);
        return $lista[self::rand(0, count($lista) - 1)];
    }

    /** Data de $dias atrás num horário comercial, nunca no futuro */
    protected static function diasAtras($dias, $hora = null)
    {
        $agora = FrozenTime::now();
        $data  = $agora->subDays($dias)->setTime($hora === null ? self::rand(8, 19) : $hora, self::rand(0, 59), self::rand(0, 59));
        return $data > $agora ? $agora->subMinutes(self::rand(5, 90)) : $data;
    }

    protected static function build()
    {
        self::$seed = 20190823;
        self::$data = [];

        self::buildPlanos();
        self::buildProdutos();
        self::buildRegioes();
        self::buildUsuarios();
        self::buildRegras();
        self::buildMovimentacao();
        self::buildAvisos();
    }

    protected static function buildPlanos()
    {
        $planos = [
            self::DEV     => ['Dev',     'Desenvolvedor', 0,     null, null],
            self::ADMIN   => ['Admin',   'Administrador', 0,     null, null],
            self::SM      => ['SM',      'Super Master',  15000, 1,    30],
            self::MASTER  => ['Master',  'Master',        5000,  1,    10],
            self::VIP     => ['VIP',     'VIP',           1200,  1,    3],
            self::CLIENTE => ['Cliente', 'Cliente',       0,     null, null],
        ];

        foreach ($planos as $id => $p) {
            self::$data['planos'][$id] = new Entity([
                'id' => $id, 'slug' => $p[0], 'title' => $p[1], 'taxa' => $p[2],
                'produtos_id' => $p[3], 'qtprodutos' => $p[4],
                'created' => self::diasAtras(900, 9), 'modified' => self::diasAtras(120, 10),
            ]);
        }
    }

    protected static function buildProdutos()
    {
        $produtos = [
            1 => ['Mineralizador de Água 4 em 1', 'Sistema 4 em 1 que filtra, purifica, mineraliza e equilibra o pH da água.', 489.90, 'mineralizador.jpg', 'A'],
            2 => ['Cartucho Mineralizador (refil)', 'Refil com sais minerais para o mineralizador. Troca recomendada a cada 6 meses.', 129.90, 'filtro.jpg', 'A'],
            3 => ['Pré-filtro de Sedimentos', 'Retém areia, ferrugem e partículas sólidas antes do cartucho mineralizador.', 39.90, 'filtro.jpg', 'A'],
            4 => ['Reservatório em Acrílico', 'Reservatório transparente de 10 litros. Peça de reposição do mineralizador.', 89.90, 'mineralizador.jpg', 'A'],
            5 => ['Tampa Superior', 'Tampa superior com encaixe para o pré-filtro. Peça de reposição.', 59.90, 'mineralizador.jpg', 'A'],
            6 => ['Boia de Nível', 'Boia que controla o nível de água do reservatório.', 24.90, 'mineralizador.jpg', 'A'],
            7 => ['Kit VIP', '1 portfólio, 3 catálogos, 20 flyers, 1 manual e 3 mineralizadores.', 1290.00, 'kit-vip.jpg', 'A'],
            8 => ['Kit Master', '1 portfólio, 5 catálogos, 20 flyers, apostila de treinamento e 30 mineralizadores.', 9990.00, 'kit-master.jpg', 'A'],
            9 => ['Garrafa Térmica 1L', 'Garrafa de inox com a marca Sales-System. Fora de linha.', 69.90, 'produto.jpg', 'I'],
        ];

        foreach ($produtos as $id => $p) {
            self::$data['produtos'][$id] = new Entity([
                'id' => $id, 'title' => $p[0], 'descricao' => $p[1], 'valor' => $p[2],
                'imagem' => $p[3], 'status' => $p[4], 'ordem' => $id,
                'comissoes' => $id <= 2 || $id >= 7,
                'created' => self::diasAtras(820 - $id * 40, 10), 'modified' => self::diasAtras(30 + $id * 5, 15),
            ]);
        }
    }

    protected static function buildRegioes()
    {
        $regioes = [
            1 => ['Ceará',       'CE', 'Sim', ['Fortaleza', 'Caucaia', 'Sobral', 'Juazeiro do Norte'], 3],
            2 => ['Pernambuco',  'PE', 'Sim', ['Recife', 'Olinda', 'Caruaru', 'Petrolina'], 4],
            3 => ['Bahia',       'BA', 'Sim', ['Salvador', 'Feira de Santana', 'Vitória da Conquista', 'Ilhéus'], 5],
            4 => ['Alagoas',     'AL', 'Não', ['Maceió', 'Arapiraca'], null],
            5 => ['Rio Grande do Norte', 'RN', 'Não', ['Natal', 'Mossoró'], null],
        ];

        foreach ($regioes as $id => $r) {
            self::$data['regioes'][$id] = new Entity([
                'id' => $id, 'title' => $r[0], 'uf' => $r[1], 'exclusiva' => $r[2], 'cidades' => $r[3],
                'usuarios_id' => $r[4],
                'created' => self::diasAtras(760 - $id * 30, 9), 'modified' => self::diasAtras(200 - $id * 20, 11),
            ]);
        }
    }

    protected static function buildUsuarios()
    {
        //id, nome, login, plano, patrocinador, dias desde o cadastro, status
        $lista = [
            [1,  'Renée Maksoud',        'maksoudrodrigues',  1, null, 900, 'A'],
            [2,  'Equipe Sales-System',   'reiniciando',       2, null, 900, 'A'],
            [3,  'Carlos Eduardo Lima',  'carloslima',        3, 2,    690, 'A'],
            [4,  'Patrícia Nogueira',    'patricianogueira',  3, 2,    640, 'A'],
            [5,  'Roberto Sampaio',      'robertosampaio',    3, 2,    590, 'A'],
            [6,  'Fernanda Rocha',       'fernandarocha',     4, 3,    540, 'A'],
            [7,  'Marcelo Tavares',      'marcelotavares',    4, 3,    470, 'A'],
            [8,  'Luciana Freitas',      'lucianafreitas',    4, 3,    300, 'A'],
            [9,  'André Barbosa',        'andrebarbosa',      4, 4,    510, 'A'],
            [10, 'Camila Teixeira',      'camilateixeira',    4, 4,    380, 'A'],
            [11, 'Rafael Monteiro',      'rafaelmonteiro',    4, 5,    450, 'A'],
            [12, 'Beatriz Cardoso',      'beatrizcardoso',    4, 5,    210, 'A'],
            [13, 'Juliana Martins',      'julianamartins',    5, 6,    330, 'A'],
            [14, 'Thiago Ribeiro',       'thiagoribeiro',     5, 6,    280, 'A'],
            [15, 'Larissa Gomes',        'larissagomes',      5, 6,    160, 'A'],
            [16, 'Diego Albuquerque',    'diegoalbuquerque',  5, 6,    45,  'A'],
            [17, 'Vanessa Pires',        'vanessapires',      5, 7,    300, 'A'],
            [18, 'Gustavo Mendes',       'gustavomendes',     5, 7,    120, 'A'],
            [19, 'Aline Correia',        'alinecorreia',      5, 8,    90,  'A'],
            [20, 'Bruno Carvalho',       'brunocarvalho',     5, 9,    350, 'A'],
            [21, 'Mariana Lopes',        'marianalopes',      5, 9,    200, 'A'],
            [22, 'Felipe Araújo',        'felipearaujo',      5, 10,   260, 'I'],
            [23, 'Renata Moura',         'renatamoura',       5, 11,   310, 'A'],
            [24, 'Leonardo Castro',      'leonardocastro',    5, 11,   75,  'A'],
            [25, 'Tatiane Farias',       'tatianefarias',     5, 12,   4,   'P'],
            [26, 'Rodrigo Pacheco',      'rodrigopacheco',    5, 13,   140, 'A'],
            [27, 'Natália Brandão',      'nataliabrandao',    5, 13,   2,   'P'],
            [28, 'Pedro Henrique Alves', 'pedroalves',        6, 13,   250, 'A'],
            [29, 'Sônia Regina Dias',    'soniadias',         6, 13,   180, 'A'],
            [30, 'João Victor Cunha',    'joaocunha',         6, 13,   35,  'A'],
            [31, 'Márcia Fontes',        'marciafontes',      6, 14,   150, 'A'],
            [32, 'Eduardo Siqueira',     'eduardosiqueira',   6, 20,   220, 'A'],
            [33, 'Cláudia Bezerra',      'claudiabezerra',    6, 17,   95,  'A'],
            [34, 'Antônio Rangel',       'antoniorangel',     6, 23,   60,  'A'],
            [35, 'Helena Vasconcelos',   'helenavasconcelos', 6, 6,    20,  'A'],
        ];

        $ruas    = ['Rua das Acácias', 'Av. Santos Dumont', 'Rua Barão de Studart', 'Av. Boa Viagem', 'Rua do Sol',
                    'Rua Monsenhor Tabosa', 'Av. Sete de Setembro', 'Rua da Aurora', 'Rua Padre Valdevino', 'Av. Oceânica',
                    'Rua Coronel Linhares', 'Rua das Flores', 'Av. Washington Soares', 'Rua Silva Jatahy'];
        $bairros = ['Centro', 'Aldeota', 'Meireles', 'Boa Viagem', 'Pituba', 'Barra', 'Graças', 'Cocó', 'Itaigara', 'Casa Forte'];
        $bancos  = ['001 - Banco do Brasil', '104 - Caixa Econômica Federal', '237 - Bradesco', '341 - Itaú Unibanco',
                    '260 - Nu Pagamentos', '077 - Banco Inter', '033 - Santander'];
        $ddd     = ['CE' => '85', 'PE' => '81', 'BA' => '71', 'AL' => '82'];
        $cep     = ['CE' => '60', 'PE' => '50', 'BA' => '40', 'AL' => '57'];

        $usuarios = $filhos = [];

        foreach ($lista as $u) {
            list($id, $nome, $login, $plano, $patrocinador, $dias, $status) = $u;

            //A região é a do Super Master responsável; os demais herdam do patrocinador
            $regioes_id = null;
            foreach (self::$data['regioes'] as $regiao) {
                if ($regiao->usuarios_id == $id) $regioes_id = $regiao->id;
            }
            if (!$regioes_id && $patrocinador && isset($usuarios[$patrocinador])) {
                $regioes_id = $usuarios[$patrocinador]->regioes_id;
            }
            $regiao = self::$data['regioes'][$regioes_id ?: 4];
            $cidade = $id <= 2 ? 'Maceió' : self::pick($regiao->cidades);
            $uf     = $regiao->uf;

            $created = self::diasAtras($dias);
            $pf      = !($plano == self::SM && $id == 5);

            $usuarios[$id] = new Entity([
                'id'              => $id,
                'nome'            => $nome,
                'login'           => $login,
                'planos_id'       => $plano,
                'plano'           => self::$data['planos'][$plano],
                'patrocinador_id' => $patrocinador,
                'regioes_id'      => $id > 2 ? $regiao->id : null,
                'regiao'          => $id > 2 ? $regiao : null,
                'status'          => $status,
                'foto'            => $id == 1 ? 'img.jpg' : 'user_default.png',
                'tipo_de_pessoa'  => $pf ? 'F' : 'J',
                'cpf'             => sprintf('%03d.%03d.%03d-%02d', self::rand(100, 999), self::rand(100, 999), self::rand(100, 999), self::rand(10, 99)),
                'cnpj'            => $pf ? null : sprintf('%02d.%03d.%03d/0001-%02d', self::rand(10, 99), self::rand(100, 999), self::rand(100, 999), self::rand(10, 99)),
                'rg'              => (string)self::rand(1000000, 9999999),
                'orgao_expedidor' => 'SSP',
                'estado_expedidor'=> $uf,
                'nascimento'      => FrozenTime::create(self::rand(1965, 1998), self::rand(1, 12), self::rand(1, 28)),
                'estado_civil'    => self::pick(['S', 'C', 'C', 'U', 'D']),
                'endereco'        => self::pick($ruas),
                'numero'          => (string)self::rand(12, 2400),
                'complemento'     => self::rand(0, 2) ? '' : 'Apto ' . self::rand(101, 1204),
                'bairro'          => self::pick($bairros),
                'cep'             => $cep[$uf] . sprintf('%03d-%03d', self::rand(0, 999), self::rand(0, 999)),
                'cidade'          => $cidade,
                'estado'          => $uf,
                'pais'            => 'Brasil',
                'email'           => $login . '@exemplo.com.br',
                'telefone'        => sprintf('(%s) 9%04d-%04d', $ddd[$uf], self::rand(8000, 9999), self::rand(0, 9999)),
                'banco'           => self::pick($bancos),
                'agencia'         => sprintf('%04d', self::rand(1, 4999)),
                'conta'           => sprintf('%05d-%d', self::rand(10000, 99999), self::rand(0, 9)),
                'tipo_conta'      => self::rand(0, 3) ? 'C' : 'P',
                'pix'             => $login . '@exemplo.com.br',
                'created'         => $created,
                'modified'        => self::diasAtras(min($dias, self::rand(0, 60))),
                'last_login'      => self::diasAtras($status == 'I' ? self::rand(90, 150) : self::rand(0, 9)),
            ]);

            if ($patrocinador) {
                $filhos[$patrocinador][] = $id;
            }
        }

        //Patrocinador como entidade, para exibir nas telas
        foreach ($usuarios as $usuario) {
            $usuario->Patrocinador = $usuario->patrocinador_id ? $usuarios[$usuario->patrocinador_id] : null;
            $usuario->clean();
        }

        //Usuários dos perfis aparecem como "acessando agora"
        foreach (self::USUARIO_POR_PERFIL as $id) {
            $usuarios[$id]->last_login = FrozenTime::now()->subMinutes(self::rand(1, 20));
        }

        self::$data['usuarios'] = $usuarios;
        self::$data['filhos']   = $filhos;
    }

    protected static function buildRegras()
    {
        //Regras de comissão: tipo, %, nível na rede acima de quem pagou, origem (T = taxa, P = pedido)
        $comissoes = [
            1 => ['ID', 10, 1, 'T'], 2 => ['II', 5, 2, 'T'], 3 => ['IM', 2, 3, 'T'],
            4 => ['VD', 10, 1, 'P'], 5 => ['VI', 5, 2, 'P'], 6 => ['VM', 2, 3, 'P'],
        ];
        foreach ($comissoes as $id => $c) {
            self::$data['comissoes'][$id] = new Entity([
                'id' => $id, 'tipo' => $c[0], 'porcentagem' => $c[1], 'nivel' => $c[2], 'origem' => $c[3],
                'created' => self::diasAtras(700 - $id * 10, 9), 'modified' => self::diasAtras(90, 14),
            ]);
        }

        //Metas: tipo (I = indicação, V = venda), de plano, para plano, meta, quantidade ganha, produto vendido, bonificação
        $metas = [
            1 => ['I', 3, 4, 10, 10, null, 1],
            2 => ['I', 3, 5, 10, 1,  null, 1],
            3 => ['I', 4, 5, 10, 1,  null, 1],
            4 => ['I', 5, 5, 10, 1,  null, 1],
            5 => ['V', 5, null, 50, 5, 2, 2],
            6 => ['V', 4, null, 100, 1, 1, 7],
        ];
        foreach ($metas as $id => $m) {
            self::$data['metas'][$id] = new Entity([
                'id' => $id, 'tipo' => $m[0], 'de_planos_id' => $m[1], 'para_planos_id' => $m[2], 'meta' => $m[3],
                'qtganha' => $m[4], 'produtos_id' => $m[5], 'bonificacao_produtos_id' => $m[6],
                'created' => self::diasAtras(650 - $id * 15, 10), 'modified' => self::diasAtras(60, 16),
            ]);
        }
    }

    /**
     * Pedidos, faturas, comissões e saques, nesta ordem, pois uns dependem dos outros.
     */
    protected static function buildMovimentacao()
    {
        $usuarios = self::$data['usuarios'];
        $produtos = self::$data['produtos'];
        $hoje     = FrozenTime::now();
        $pedidos  = $faturas = [];

        //Monta a fatura (com os campos que todas as telas usam)
        $novaFatura = function (array $campos) {
            return new Entity($campos + [
                'forma_pagamento' => 'D', 'qt_parcelas' => 1, 'parcela_atual' => 1, 'pagamento' => null,
                'desconto' => 0, 'valor_frete' => 0, 'valor_icms' => 0, 'obs' => null, 'boleto' => null, 'nf' => null,
                'pedido' => null, 'ParentFaturas' => null, 'comissao' => null,
            ]);
        };

        //Status do pedido conforme a idade
        $statusPorIdade = function ($dias) {
            if ($dias < 2)  return self::pick(['V', 'V', 'P']);
            if ($dias < 6)  return self::pick(['P', 'P', 'S']);
            if ($dias < 15) return self::pick(['S', 'T', 'T']);
            if ($dias < 30) return self::pick(['T', 'F', 'F']);
            return self::rand(0, 9) ? 'F' : 'C';
        };

        $novoPedido = function ($usuario, $tipo, $created, $status, array $itens, $frete = 0) use ($produtos, $hoje) {
            $total = $frete;
            $linhas = [];
            foreach ($itens as $produtos_id => $item) {
                list($quantidade, $valor) = $item;
                $total += $quantidade * $valor;
                $linhas[] = new Entity([
                    'produtos_id' => $produtos_id, 'produto' => $produtos[$produtos_id],
                    'quantidade' => $quantidade, 'valor_unitario' => $valor,
                ]);
            }
            $despacho = in_array($status, ['T', 'F']) ? $created->addDays(self::rand(3, 6)) : null;
            return new Entity([
                'usuarios_id' => $usuario->id, 'usuario' => $usuario, 'tipo' => $tipo, 'status' => $status,
                'pedidos_produtos' => $linhas, 'valor_frete' => $frete, 'valor_icms' => 0, 'icms_antecipado' => false,
                'total' => round($total, 2), 'created' => $created,
                'modified' => $despacho && $despacho < $hoje ? $despacho : $created->addHours(self::rand(1, 30)),
                'dtdespacho' => $despacho, 'dtentrega' => $despacho ? $despacho->addDays(self::rand(4, 9)) : null,
                'cod_rastreio' => $despacho ? sprintf('QB%09dBR', self::rand(100000000, 999999999)) : null,
                'obs' => null, 'nf' => null, 'xml' => null, 'boleto' => null, 'fatura' => null,
            ]);
        };

        /************************************************************/
        //1. Taxas de inscrição (fatura T) + pedido de bonificação de inscrição (tipo E)
        foreach ($usuarios as $usuario) {
            if (!in_array($usuario->planos_id, [self::SM, self::MASTER, self::VIP])) continue;

            $plano = $usuario->plano;
            $pago  = $usuario->status != 'P';
            $forma = self::pick(['C', 'D', 'B']);

            $fatura = $novaFatura([
                'usuarios_id' => $usuario->id, 'usuario' => $usuario, 'tipo' => 'T', 'status' => $pago ? 'F' : 'P',
                'forma_pagamento' => $forma, 'total' => $plano->taxa, 'created' => $usuario->created,
                'vencimento' => $usuario->created->addDays(3),
                'pagamento' => $pago ? $usuario->created->addDays(self::rand(0, 2))->setTime(self::rand(9, 17), self::rand(0, 59)) : null,
                'boleto' => !$pago && $forma == 'B' ? 'boleto.pdf' : null,
                'obs' => 'Taxa de inscrição no plano ' . $plano->title,
            ]);
            $faturas[] = $fatura;

            $dias   = (int)$usuario->created->diffInDays($hoje);
            $status = $pago ? $statusPorIdade(max($dias - 2, 6)) : 'P';
            if ($status == 'C') $status = 'F';

            $pedido = $novoPedido($usuario, 'E', $usuario->created->addMinutes(2), $status,
                                  [$plano->produtos_id => [$plano->qtprodutos, 0]]);
            $pedido->fatura = $fatura;
            $pedido->obs    = 'Produtos inclusos na inscrição do plano ' . $plano->title;
            $fatura->pedido = $pedido;
            $pedidos[] = $pedido;
        }

        /************************************************************/
        //2. Pedidos de compra (tipo N) com faturas de pedido (tipo P), parceladas ou não
        $compradores = [];
        foreach ($usuarios as $usuario) {
            if ($usuario->status != 'A' || self::isGestao($usuario->planos_id)) continue;
            $peso = ['3' => 3, '4' => 3, '5' => 3, '6' => 2][$usuario->planos_id];
            for ($i = 0; $i < $peso; $i++) $compradores[] = $usuario;
        }

        //Garante histórico para os usuários dos perfis de demonstração
        $roteiro = [3, 3, 6, 6, 6, 13, 13, 13, 13, 28, 28, 28];
        for ($i = 0; $i < 40; $i++) {
            $roteiro[] = self::pick($compradores)->id;
        }

        foreach ($roteiro as $n => $usuarios_id) {
            $usuario = $usuarios[$usuarios_id];
            $maxDias = (int)min(200, $usuario->created->diffInDays($hoje) - 1);
            $dias    = $n < 6 ? self::rand(0, 12) : self::rand(0, max(1, $maxDias));
            $created = self::diasAtras($dias);
            $status  = $statusPorIdade($dias);

            //Quantidades conforme o perfil: quem está acima na rede compra para revender
            $faixa = [self::SM => [10, 40], self::MASTER => [4, 20], self::VIP => [1, 8], self::CLIENTE => [1, 2]][$usuario->planos_id];
            $itens = [];
            $catalogo = $usuario->planos_id == self::CLIENTE ? [1, 2, 2, 3, 6] : [1, 1, 2, 2, 3, 4, 5, 6];
            if ($usuario->planos_id == self::VIP && self::rand(0, 5) == 0) $catalogo = [7];
            if ($usuario->planos_id == self::MASTER && self::rand(0, 6) == 0) $catalogo = [8];
            $qtItens = in_array($catalogo[0], [7, 8]) ? 1 : self::rand(1, 3);
            for ($i = 0; $i < $qtItens; $i++) {
                $produtos_id = self::pick($catalogo);
                $qt = in_array($produtos_id, [7, 8]) ? 1 : self::rand($faixa[0], $faixa[1]);
                $itens[$produtos_id] = [$qt, $produtos[$produtos_id]->valor];
            }
            $volume = array_sum(array_map(function ($i) { return $i[0]; }, $itens));
            $frete  = $status == 'V' ? 0 : round(min(390, 18 + $volume * self::rand(3, 6) + self::rand(0, 99) / 100), 2);

            $pedido = $novoPedido($usuario, 'N', $created, $status, $itens, $frete);
            if ($status == 'C') $pedido->obs = 'Cancelado a pedido do associado.';
            $pedidos[] = $pedido;

            //Faturas do pedido
            $forma     = self::pick(['C', 'C', 'D', 'B']);
            $parcelas  = $forma == 'C' ? self::rand(1, 3) : ($forma == 'B' ? self::rand(1, 2) : 1);
            $valorParc = round($pedido->total / $parcelas, 2);

            for ($p = 1; $p <= $parcelas; $p++) {
                $vencimento = $created->addDays(3 + ($p - 1) * 30);
                if ($status == 'C') {
                    $situacao = 'C';
                } elseif (in_array($status, ['V', 'P'])) {
                    $situacao = 'P';
                } else {
                    $situacao = ($p == 1 || $vencimento < $hoje) ? 'F' : 'P';
                }

                $fatura = $novaFatura([
                    'usuarios_id' => $usuario->id, 'usuario' => $usuario, 'tipo' => 'P', 'status' => $situacao,
                    'forma_pagamento' => $forma, 'qt_parcelas' => $parcelas, 'parcela_atual' => $p,
                    'total' => $valorParc, 'valor_frete' => $p == 1 ? $frete : 0, 'created' => $created->addMinutes(1),
                    'vencimento' => $vencimento,
                    'pagamento' => $situacao == 'F' ? min($vencimento, $created->addDays(self::rand(0, 2)))->setTime(self::rand(9, 18), self::rand(0, 59)) : null,
                    'boleto' => $situacao == 'P' && $forma == 'B' && $status != 'V' ? 'boleto.pdf' : null,
                    'nf' => $situacao == 'F' && $p == 1 ? 'nf.pdf' : null,
                    'pedido' => $pedido,
                ]);
                $faturas[] = $fatura;
                if ($p == 1) $pedido->fatura = $fatura;
            }
            if (in_array($status, ['S', 'T', 'F'])) $pedido->nf = 'nf.pdf';
        }

        /************************************************************/
        //3. Bonificações por meta atingida (tipo B), lançadas pela administração
        foreach ([[3, 1, 10, 70], [6, 1, 1, 40], [13, 2, 5, 18], [20, 1, 1, 8], [4, 1, 10, 3]] as $b) {
            list($usuarios_id, $produtos_id, $qt, $dias) = $b;
            $created = self::diasAtras($dias);
            $status  = $statusPorIdade(max($dias, 3));
            $pedido  = $novoPedido($usuarios[$usuarios_id], 'B', $created, $status == 'C' ? 'F' : $status,
                                   [$produtos_id => [$qt, 0]]);
            $pedido->obs = 'Bonificação por meta atingida, lançada pela administração.';
            $pedidos[] = $pedido;
        }

        /************************************************************/
        //4. Comissões (fatura C) sobre taxas e pedidos pagos, subindo a rede do pagador
        $regras = self::$data['comissoes'];
        foreach ($faturas as $origem) {
            if (!in_array($origem->tipo, ['T', 'P']) || $origem->status != 'F') continue;

            $beneficiario = $origem->usuario->Patrocinador;
            $nivel = 1;
            while ($beneficiario && !self::isGestao($beneficiario->planos_id) && $nivel <= 3) {

                foreach ($regras as $regra) {
                    if ($regra->origem != $origem->tipo || $regra->nivel != $nivel) continue;
                    if ($beneficiario->planos_id == self::CLIENTE || $beneficiario->status == 'I') continue;

                    $base       = $origem->total - $origem->valor_frete;
                    $liberacao  = $origem->pagamento->addDays(self::DIAS_LIBERACAO);
                    $liberada   = $liberacao <= $hoje;

                    $faturas[] = $novaFatura([
                        'usuarios_id' => $beneficiario->id, 'usuario' => $beneficiario, 'tipo' => 'C',
                        'status' => $liberada ? 'F' : 'P', 'forma_pagamento' => 'D',
                        'total' => round($base * $regra->porcentagem / 100, 2),
                        'created' => $origem->pagamento->addMinutes(5), 'vencimento' => $liberacao,
                        'pagamento' => $liberada ? $liberacao->setTime(6, 0) : null,
                        'ParentFaturas' => $origem, 'pedido' => $origem->pedido, 'comissao' => $regra,
                        'obs' => $regra->porcentagem . '% sobre ' . ($origem->tipo == 'T' ? 'a taxa de inscrição de ' : 'o pedido de ') . $origem->usuario->nome,
                    ]);
                }

                $beneficiario = $beneficiario->Patrocinador;
                $nivel++;
            }
        }

        /************************************************************/
        //5. Saques (fatura S): um já pago e, para alguns, um pendente de aprovação
        $liberado = [];
        foreach ($faturas as $fatura) {
            if ($fatura->tipo == 'C' && $fatura->status == 'F') {
                $liberado[$fatura->usuarios_id] = (isset($liberado[$fatura->usuarios_id]) ? $liberado[$fatura->usuarios_id] : 0) + $fatura->total;
            }
        }

        $comPendente = [3, 4, 6, 9, 11, 13, 20, 23];
        foreach ($liberado as $usuarios_id => $valor) {
            if ($valor < 300) continue;
            $usuario = $usuarios[$usuarios_id];

            $pagos = $valor > 2500 ? [self::rand(70, 110), self::rand(20, 50)] : ($valor > 700 ? [self::rand(20, 60)] : []);
            foreach ($pagos as $diasAtras) {
                $sacado  = floor($valor * self::rand(30, 45) / 100 / 10) * 10;
                $created = self::diasAtras($diasAtras);
                $faturas[] = $novaFatura([
                    'usuarios_id' => $usuarios_id, 'usuario' => $usuario, 'tipo' => 'S', 'status' => 'F',
                    'total' => $sacado, 'created' => $created, 'vencimento' => $created->addDays(5),
                    'pagamento' => $created->addDays(self::rand(1, 4))->setTime(self::rand(9, 17), self::rand(0, 59)),
                    'obs' => 'Transferência para ' . $usuario->banco . ' ag. ' . $usuario->agencia . ' c/c ' . $usuario->conta,
                ]);
                $valor -= $sacado;
            }

            if (in_array($usuarios_id, $comPendente)) {
                $created = self::diasAtras(self::rand(0, 4));
                $faturas[] = $novaFatura([
                    'usuarios_id' => $usuarios_id, 'usuario' => $usuario, 'tipo' => 'S', 'status' => 'P',
                    'total' => floor($valor * self::rand(40, 60) / 100 / 10) * 10, 'created' => $created,
                    'vencimento' => $created->addDays(5),
                    'obs' => 'Transferência para ' . $usuario->banco . ' ag. ' . $usuario->agencia . ' c/c ' . $usuario->conta,
                ]);
            }
        }

        /************************************************************/
        //IDs em ordem cronológica: os mais novos têm os maiores números
        usort($pedidos, function ($a, $b) { return $a->created->getTimestamp() - $b->created->getTimestamp(); });
        usort($faturas, function ($a, $b) { return $a->created->getTimestamp() - $b->created->getTimestamp(); });

        $lista = [];
        foreach ($pedidos as $i => $pedido) {
            $pedido->id = 1001 + $i;
            $lista[$pedido->id] = $pedido;
        }
        self::$data['pedidos'] = $lista;

        $lista = [];
        foreach ($faturas as $i => $fatura) {
            $fatura->id = 5001 + $i;
            $lista[$fatura->id] = $fatura;
        }
        foreach ($lista as $fatura) {
            $fatura->pedidos_id  = $fatura->pedido ? $fatura->pedido->id : null;
            $fatura->faturas_id  = $fatura->ParentFaturas ? $fatura->ParentFaturas->id : null;
            $fatura->modified    = $fatura->pagamento ?: $fatura->created;
            $fatura->clean();
        }
        foreach (self::$data['pedidos'] as $pedido) {
            $pedido->faturas_id = $pedido->fatura ? $pedido->fatura->id : null;
            $pedido->clean();
        }
        self::$data['faturas'] = $lista;
    }

    protected static function buildAvisos()
    {
        $hoje = FrozenTime::now();

        //título, texto, plano de destino, dias desde a criação, validade em dias (null = sem validade), banner
        $avisos = [
            ['Bem-vindo ao novo painel Sales-System',
             '<p>O painel foi totalmente renovado. Agora você acompanha <strong>pedidos, faturas, comissões e metas</strong> em um só lugar, de qualquer dispositivo.</p><p>Use o menu <em>Financeiro</em> para consultar seu extrato e solicitar saques.</p>',
             null, 45, null, null],
            ['Atualização da tabela de preços',
             '<p>A partir do dia 1º os refis e peças de reposição tiveram reajuste médio de 4,5%. O mineralizador mantém o preço atual.</p>',
             null, 62, null, null],
            ['Comissões liberadas em 30 dias',
             '<p>As comissões ficam <strong>bloqueadas por 30 dias</strong> após a confirmação do pagamento da fatura de origem. Depois desse prazo elas passam automaticamente para o saldo disponível.</p>',
             null, 28, null, null],
            ['Convenção Regional Nordeste',
             '<p>Super Masters: a convenção regional acontece em Fortaleza no próximo mês. Confirme a presença da sua equipe até o fim desta semana.</p>',
             self::SM, 6, 30, null],
            ['Treinamento online para Masters',
             '<p>Nesta quinta, às 19h, treinamento sobre <strong>apresentação do plano de negócios</strong> e acompanhamento de metas. O link será enviado por e-mail.</p>',
             self::MASTER, 3, 7, null],
            ['Campanha do mês: bônus em dobro',
             '<p>VIPs que atingirem a meta de indicações até o fim do mês recebem a bonificação em dobro.</p>',
             self::VIP, 9, 22, null],
            ['Prazo de expedição no feriado',
             '<p>Os pedidos pagos durante o feriado serão expedidos no primeiro dia útil seguinte.</p>',
             null, 40, -25, null],
            ['Manutenção programada do sistema',
             '<p>O painel ficará indisponível no domingo, das 2h às 4h, para manutenção programada.</p>',
             null, 15, -10, null],
        ];

        $lista = [];
        foreach ($avisos as $i => $a) {
            list($title, $texto, $planos_id, $dias, $validade, $banner) = $a;
            $created  = self::diasAtras($dias);
            $validade = $validade === null ? null : $hoje->addDays($validade)->setTime(23, 59);
            $id       = 301 + $i;
            $lista[$id] = new Entity([
                'id' => $id, 'title' => $title, 'aviso' => $texto, 'planos_id' => $planos_id,
                'plano' => $planos_id ? self::$data['planos'][$planos_id] : null,
                'validade' => $validade, 'ativo' => $validade === null || $validade >= $hoje,
                'banner' => $banner, 'youtube' => null, 'created' => $created, 'modified' => $created,
            ]);
        }

        self::$data['avisos'] = self::maisRecentes($lista);
    }
}
