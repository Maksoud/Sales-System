# Status e badges

Status **sempre** aparece como badge (`label label-*` do Bootstrap, reestilizado, ou `ss-badge`).
A cor segue o significado, não a entidade. Use estes mapas nos helpers (`statusLabel()`) e nunca
monte a classe à mão no template.

| Significado | Classe | Exemplo |
|---|---|---|
| Concluído, pago, ativo | `label-success` | Finalizado, Concluído, Ativo |
| Aguardando ação de alguém | `label-warning` | Pendente, Aguardando pagamento |
| Em andamento (fluxo normal) | `label-primary` | Em preparação, Aguardando entrega |
| Em análise / informação | `label-info` | Calculando frete e impostos |
| Problema que exige ação | `label-danger` | Vencida, Bloqueado |
| Encerrado sem efeito | `label-default` | Cancelado, Inativo, Fora de linha |

Cancelado é **neutro** (cinza), não vermelho: não é um erro, só não vale mais.
Vermelho fica para o que pede atenção (vencido, bloqueado, erro).

Adicione `ss-badge--dot` quando o badge aparece sozinho numa coluna de status (fica mais leve):
`<span class="label label-success ss-badge--dot">Ativo</span>`.

## Faturas (`FaturasHelper`)

| Código | Texto | Classe |
|---|---|---|
| P | Pendente | `label-warning` |
| P + vencimento < hoje | Vencida | `label-danger` |
| F | Finalizada | `label-success` |
| C | Cancelada | `label-default` |

## Pedidos (`PedidosHelper`)

| Código | Texto | Classe |
|---|---|---|
| V | Calculando frete e impostos | `label-info` |
| P | Aguardando pagamento | `label-warning` |
| S | Em preparação para envio | `label-primary` |
| T | Aguardando entrega | `label-primary` |
| F | Concluído | `label-success` |
| C | Cancelado | `label-default` |

Na visualização do pedido, a sequência V → P → S → T → F aparece em `ss-steps`
(ver [visualizacao.md](visualizacao.md#linha-do-tempo-de-status)).

## Usuários / associados (`UsuariosHelper`)

| Código | Texto | Classe |
|---|---|---|
| A | Ativo | `label-success` |
| P | Pendente | `label-warning` |
| I | Inativo | `label-default` |
| C | Cancelado | `label-default` |

## Produtos

| Código | Texto na gestão | Texto na loja | Classe |
|---|---|---|---|
| A | Ativo | Disponível | `label-success` |
| I | Inativo | Fora de linha | `label-default` |

Helper: `ProdutosHelper::statusLabel($status, $loja = false)` (`$loja = true` usa os textos da loja).

## Avisos

| Situação | Texto | Classe |
|---|---|---|
| Dentro do período | Ativo | `label-success` |
| Período encerrado | Encerrado | `label-default` |
| Ainda não começou | Agendado | `label-info` |

## Tipos (não são status)

Tipo de fatura (Comissão, Saque, Pedido, Taxa) e tipo de pedido (Normal, Bonificação) são
categorias: mostre como texto simples com ícone (`fundamentos.md › Ícones`), não como badge
colorido. Se precisar destacar, use `label-default`.

## Exemplo de helper

```php
public function statusLabel($status, $vencimento = null)
{
    if ($status == 'P' && $vencimento && $vencimento->isPast()) {
        return '<span class="label label-danger">' . __('Vencida') . '</span>';
    }
    $classes = ['P' => 'warning', 'F' => 'success', 'C' => 'default'];
    $classe  = isset($classes[$status]) ? $classes[$status] : 'default';
    return '<span class="label label-' . $classe . '">' . h($this->status($status)) . '</span>';
}
```
