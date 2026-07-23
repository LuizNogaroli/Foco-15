with open('resources/views/processos/show.blade.php', 'r', encoding='utf-8') as f:
    show = f.read()

# Add the right sidebar back inside <main>
sidebar_html = """
    <div style="display: flex; gap: 20px;">
        <div class="main-content" style="flex: 1;">
"""

sidebar_right = """
        </div>
        <aside class="sidebar-right" style="width: 300px; padding: 20px; background: white; border-left: 1px solid #ddd; height: calc(100vh - 100px); overflow-y: auto; position: sticky; top: 100px;">
            <h3 style="color: #1e3a5f; border-bottom: 2px solid #ea580c; padding-bottom: 10px;">Resumo do Processo</h3>
            <p><strong>Nº Requerimento:</strong> {{ $processo->numero_requerimento }}</p>
            <p><strong>Tipo:</strong> {{ $processo->tipo_requerimento }}</p>
            <p><strong>Status Atual:</strong> {{ $processo->status_atual }}</p>
            <p><strong>UF:</strong> {{ $processo->uf }}</p>
            <p><strong>Tramitação:</strong> 
                <span class="badge {{ $processo->tramitacao === 'Devolvido' ? 'bg-danger' : 'bg-primary' }}">
                    {{ $processo->tramitacao }}
                </span>
            </p>
        </aside>
    </div>
"""

# Replace <div class="main-content"> ... </div> with the new flex layout
import re
show = re.sub(r'<div class="main-content">', sidebar_html, show, flags=re.DOTALL)
show = re.sub(r'        @endif\n    </div>', '        @endif\n' + sidebar_right, show, flags=re.DOTALL)

with open('resources/views/processos/show.blade.php', 'w', encoding='utf-8') as f:
    f.write(show)
