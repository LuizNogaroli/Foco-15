# KB: Autorização e Submissão na Aba 3 (Foco-15)
Data: 2026-07-21T22:00:00-03:00

## O Desafio Enfrentado (Contexto)
Ao trabalhar na "Aba 3" de formulários (`aba3.blade.php`), enfrentamos dois problemas estruturais:
1. **Falha Silenciosa de Bloqueio UI**: O formulário ficava completamente desabilitado (`disabled`) para o perfil adequado ("Técnico - Destinação"), embora o backend fornecesse os cargos de forma correta. O sistema de simulação de perfil via Cookie (`perfil_simulado`) não casava perfeitamente com os checks de view do Blade.
2. **Race Condition na Submissão Híbrida**: Na transição entre Supabase e Laravel nativo, o form enviava os dados POST para o Laravel _enquanto_ ainda enviava requisições Javascript (fetch) para a base antiga. O Laravel rejeitava com TypeErrors (`htmlspecialchars()`) devido a arrays complexos de Pendências.

## Como a Solução Arquitetural Funciona
**A. Consistência de Estado Front/Backend via Controller**:
Para resolver o problema 1 de Autorização, a responsabilidade de interpretar cookies (`perfil_simulado`) ou perfis Reais da `Spatie` foi extraída totalmente da View.
O Controlador `ProcessoController::getPerfilAtual()` agora gera uma string canônica de `$perfil` (ex: "Equipe Destinação") e a fornece ao Blade.
A View, por sua vez, só aprova edição se `$perfil` bater com a Aba **E** se o status do processo ditar que ele está pronto para a aba.
Exemplo no Blade:
```php
$canEditAba3 = false;
if (isset($perfil) && ($perfil === 'ALL' || $perfil === 'Equipe Destinação')) {
    if (in_array($processo->status_atual, ['Análise de Viabilidade'])) {
        $canEditAba3 = true;
    }
}
```
Isso anula erros de Javascript, Cookies não parseados ou perfis invisíveis.

**B. Submissão Síncrona Garantida (Promessas JS)**:
Para resolver o problema 2, o formulário agora contém um _event listener_ preventivo no evento `submit`. 
Ele pausa o fluxo do navegador (`e.preventDefault()`), executa o `executarSalvamentoAba3()` que faz as comunicações JS necessárias em _background_. Somente se essas Promises retornarem TRUE, o listener libera a view para chamar explicitamente `form.submit()`. 
Isso garante integridade de dados e evita erros fatais no core do Laravel.

---
*Este registro integra a Base de Conhecimento contínua (KB) do sistema Foco-15, e deve ser referenciado em implementações futuras de outras Abas.*
