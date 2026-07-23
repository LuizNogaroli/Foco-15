# Variáveis Repassadas para Views (Compact) e Função de Perfil Atual

## Contexto
O sistema utiliza o `ProcessoController@show` para exibir as abas individuais de um processo (Aba 1, 2, 3, etc.). O acesso aos campos editáveis nas abas é controlado via permissões em tela (`@if`) verificando tanto o `status_atual` do processo quanto o `$perfil` do usuário.

## Problema
Os campos da Aba 3 estavam travados (com `disabled`) para preenchimento, apesar de o usuário ter logado com a atribuição correta (perfil simulado "Todos" / Admin). A causa foi dupla:
1. O método `getPerfilAtual()` no backend resolvia falhamente o perfil simulado "ALL". Ao não tratar `if ($simulado === 'ALL')`, a lógica escoava para ler a *Role* nativa do usuário. O resultado era que ele retornava `"Direção"`, e a view da Aba 3 exigia especificamente `"ALL"` ou `"Equipe Destinação"`.
2. E, o mais importante, a variável `$perfil` não estava sendo empacotada no `compact()` pelo controller ao retornar a view, tornando qualquer verificação `isset($perfil)` em tela falsa.

## Solução e Aprendizado
- A função `getPerfilAtual()` precisa prever retornos base padronizados ("ALL") para fluxos administrativos e tratar adequadamente variáveis como "ALL" advindas de simulação de cookies.
- **Sempre verifique as variáveis sendo exportadas do Controller para a View via `compact()` ou matrizes asociativas.** Se a lógica do front-end (`.blade.php`) depende fortemente de uma variável do Controller para liberar bloqueios CSS ou disabled HTML, garantir sua propagação correta no final do bloco do método é fundamental.
