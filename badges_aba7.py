with open('resources/views/processos/abas/aba7.blade.php', 'r', encoding='utf-8') as f:
    c = f.read()

c = c.replace('<span class="acordeao-badge-pendente" id="pendente-A">⏳ Pendente</span>', '@if(!isset(["assinatura_chefia_nome"]))<span class="acordeao-badge-pendente" id="pendente-A">⏳ Pendente</span>@endif')
c = c.replace('<span class="acordeao-badge-ok" id="badge-A-ok">✔ Concluído</span>', '@if(isset(["assinatura_chefia_nome"]))<span class="acordeao-badge-ok visivel" id="badge-A-ok" style="display:inline-block">✔ Concluído</span>@endif')

c = c.replace('<span class="acordeao-badge-pendente" id="pendente-B">⏳ Pendente</span>', '@if(!isset(["assinatura_coordenacao_nome"]))<span class="acordeao-badge-pendente" id="pendente-B">⏳ Pendente</span>@endif')
c = c.replace('<span class="acordeao-badge-ok" id="badge-B-ok">✔ Concluído</span>', '@if(isset(["assinatura_coordenacao_nome"]))<span class="acordeao-badge-ok visivel" id="badge-B-ok" style="display:inline-block">✔ Concluído</span>@endif')

c = c.replace('<span class="acordeao-badge-pendente" id="pendente-C">⏳ Pendente</span>', '@if(!isset(["assinatura_superintendencia_nome"]))<span class="acordeao-badge-pendente" id="pendente-C">⏳ Pendente</span>@endif')
c = c.replace('<span class="acordeao-badge-ok" id="badge-C-ok">✔ Concluído</span>', '@if(isset(["assinatura_superintendencia_nome"]))<span class="acordeao-badge-ok visivel" id="badge-C-ok" style="display:inline-block">✔ Concluído</span>@endif')

with open('resources/views/processos/abas/aba7.blade.php', 'w', encoding='utf-8') as f:
    f.write(c)
