import os

files = [
    r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\public\foco-01-resumo.html',
    r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\prototipo_html\foco-01-resumo.html'
]

replacement_js = """                const data = await res.json();
                let rel = null;
                let dateObj = new Date();

                if (data && data.length > 0) {
                    rel = data[0].dados_relatorio;
                    dateObj = new Date(data[0].updated_at);
                } else {
                    try {
                        const reqUrl = `${SUPA_URL}/rest/v1/tabela_requerimentos?select=*&numero_requerimento=eq.${encodeURIComponent(processId)}&limit=1`;
                        const reqRes = await fetch(reqUrl, { headers: { 'apikey': SUPA_KEY, 'Authorization': `Bearer ${SUPA_KEY}` } });
                        if (reqRes.ok) {
                            const reqList = await reqRes.json();
                            if (reqList && reqList.length > 0) {
                                const dj = reqList[0].dados_json || {};
                                rel = {
                                    nome_requerente: dj.interessado || dj.nome_requerente || 'Prefeitura / Órgão Interessado',
                                    cpf_cnpj: dj.cpf_cnpj || 'Não informado',
                                    telefone: dj.telefone || '-',
                                    pessoa_estrangeira: dj.pessoa_estrangeira || 'Não',
                                    numero_requerimento: reqList[0].numero_requerimento || processId,
                                    data_requerimento: dj.data_req || (reqList[0].created_at ? new Date(reqList[0].created_at).toLocaleDateString('pt-BR') : '-'),
                                    processo_sei: dj.processo_sei || '-',
                                    prioridade_legal: dj.prioridade_legal || 'Não',
                                    nome_rep: dj.nome_rep || '-',
                                    cpf_cnpj_rep: dj.cpf_cnpj_rep || '-',
                                    telefone_rep: dj.telefone_rep || '-',
                                    conceituacao_imovel: dj.conceituacao_imovel || 'Imóvel/Área referente ao requerimento ' + processId,
                                    rips: dj.rips || [],
                                    cadastros_minimos: dj.cadastros_minimos || [],
                                    solicitacao_criacao_rip: dj.solicitacao_criacao_rip || '-'
                                };
                                dateObj = new Date(reqList[0].updated_at || Date.now());
                            }
                        }
                    } catch(fErr) {
                        console.warn('Fallback tabela_requerimentos falhou:', fErr);
                    }
                }

                if (rel) {"""

for fpath in files:
    if os.path.exists(fpath):
        with open(fpath, 'r', encoding='utf-8') as f:
            lines = f.readlines()
        
        new_lines = []
        skip = False
        for line in lines:
            if 'const data = await res.json();' in line:
                new_lines.append(replacement_js + '\n')
                skip = True
            elif skip and 'if (rel) {' in line:
                skip = False
            elif not skip:
                new_lines.append(line)
                
        with open(fpath, 'w', encoding='utf-8') as f:
            f.writelines(new_lines)
        print('Successfully fixed:', fpath)
