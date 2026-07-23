import sys

path = r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\resources\views\configuracoes.blade.php'
with open(path, 'r', encoding='utf-8') as f:
    lines = f.readlines()

new_lines = []
for line in lines:
    if '<div class="panel-header">' in line:
        new_lines.append('            <div id="panelGestao">\n')
        new_lines.append(line)
    elif '</section>' in line:
        new_lines.append('            </div><!-- end panelGestao -->\n\n')
        new_lines.append('            <!-- NOVO PAINEL DE STATUS -->\n')
        new_lines.append('            <div id="panelStatus" style="display: none;">\n')
        new_lines.append('                <div class="panel-header">\n')
        new_lines.append('                    <h2>Administrar Status</h2>\n')
        new_lines.append('                    <p>Altere o status de um requerimento específico.</p>\n')
        new_lines.append('                </div>\n')
        new_lines.append('                <div class="card">\n')
        new_lines.append('                    <div class="search-box" style="margin-bottom: 20px;">\n')
        new_lines.append('                        <input type="text" id="inputProcessId" placeholder="Digite o ID do Requerimento" style="width: 300px; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e1; margin-right: 10px;">\n')
        new_lines.append('                        <button class="btn-primary" onclick="buscarStatusRequerimento()" style="padding: 10px 20px;">Buscar Status</button>\n')
        new_lines.append('                    </div>\n')
        new_lines.append('                    <div id="statusResult" style="display: none;">\n')
        new_lines.append('                        <div style="background: #f8fafc; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #1e3a5f;">\n')
        new_lines.append('                            <strong>Status Atual:</strong> <span id="currentStatusText" style="color: #1e3a5f; margin-left: 5px;"></span>\n')
        new_lines.append('                        </div>\n')
        new_lines.append('                        <h3 style="margin-bottom: 10px; font-size: 14px; color: #475569;">Alterar para:</h3>\n')
        new_lines.append('                        <select id="selectNewStatus" style="width: 100%; max-width: 400px; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e1; margin-bottom: 20px;">\n')
        new_lines.append('                            <!-- Preenchido via JS -->\n')
        new_lines.append('                        </select>\n')
        new_lines.append('                        <div>\n')
        new_lines.append('                            <button class="btn-primary" onclick="salvarNovoStatus()" style="background-color: #059669;">Salvar Novo Status</button>\n')
        new_lines.append('                        </div>\n')
        new_lines.append('                    </div>\n')
        new_lines.append('                </div>\n')
        new_lines.append('            </div><!-- end panelStatus -->\n')
        new_lines.append(line)
    else:
        new_lines.append(line)

with open(path, 'w', encoding='utf-8') as f:
    f.writelines(new_lines)

print('File updated successfully')
