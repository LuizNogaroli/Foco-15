# Conversão de Autosave para Salvamento Manual (Rascunhos)

## Motivação e Contexto
Embora o mecanismo de autosave forneça uma excelente experiência ao evitar perda de dados, em certos requisitos de negócio ou por determinação direta do cliente, pode ser necessário desativá-lo. Geralmente, isso é solicitado para dar ao usuário total governança sobre quando um estado "temporário" da aplicação é comitado, impedindo requisições indesejadas que sobrecarreguem o banco com estados inconsistentes no meio da digitação.

## Abordagem Técnica Recomendada
Para migrar um sistema AJAX baseado em temporizadores (debounce timer de eventos `input`/`change`) para salvamento explícito sem perder a infraestrutura:
1. **Desacoplamento de Eventos:** Retire o `addEventListener` geral que ficava pendurado no formulário inteiro.
2. **Exposição Global:** Exponha a função original que gerencia a coleta do JSON do DOM (`saveDraft()`) associando-a no objeto window, por exemplo `window._saveDraft = saveDraft`.
3. **Injeção de Gatilho Explícito:** Na View, posicione os botões (como "Salvar Rascunho") estrategicamente que chamam o gatilho, sem dar bind em comportamentos padrão de submit.
4. **Preservação do Load:** A rotina de carregamento original na inicialização (ex: `DOMContentLoaded -> loadDraft()`) **deve ser intocada**, pois é o que assegura que, em caso de atualização da página, a versão rascunhada anterior seja reidratada na UI.

*Nota da evolução Foco-15 (22/07/2026).*
