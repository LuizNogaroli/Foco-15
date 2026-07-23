import os

files = [
    r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\public\foco-02-resumo.html',
    r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\prototipo_html\foco-02-resumo.html'
]

old_code = """                const data = await res.json();
                if (data && data.length > 0) {
                    const rel = data[0].dados_relatorio;"""

new_code = """                const data = await res.json();
                let rel = null;
                let dateObj = new Date();

                if (data && data.length > 0) {
                    rel = data[0].dados_relatorio;
                    dateObj = new Date(data[0].updated_at || Date.now());
                } else {
                    try {
                        const urlReq = `${SUPA_URL}/rest/v1/tabela_requerimentos?select=*&numero_requerimento=eq.${encodeURIComponent(processId)}&limit=1`;
                        const resReq = await fetch(urlReq, {
                            headers: { 'apikey': SUPA_KEY, 'Authorization': `Bearer ${SUPA_KEY}` }
                        });
                        if (resReq.ok) {
                            const reqList = await resReq.json();
                            if (reqList && reqList.length > 0 && reqList[0].dados_json) {
                                const dj = typeof reqList[0].dados_json === 'string' ? JSON.parse(reqList[0].dados_json) : reqList[0].dados_json;
                                rel = {
                                    tem_matricula: dj.tem_matricula || '-',
                                    num_matricula: dj.num_matricula || '-',
                                    cartorio_matricula: dj.cartorio_matricula || '-',
                                    situacao_ocupacional: dj.situacao_ocupacional || '-',
                                    uso_principal: dj.tipo_uso_atual || dj.uso_principal || '-',
                                    condicao_urbanizacao: dj.condicao_urbanizacao || '-',
                                    ha_incidencia: dj.ha_incidencia || '-',
                                    incidencia_ambiental: dj.incidencia_ambiental || [],
                                    obs_incidencia_ambiental: dj.obs_incidencia_ambiental || '-',
                                    ha_riscos: dj.ha_riscos || '-',
                                    riscos: dj.riscos || [],
                                    obs_riscos: dj.obs_riscos || '-',
                                    ha_restricoes: dj.ha_restricoes || '-',
                                    restricoes: dj.restricoes || [],
                                    obs_restricoes: dj.obs_restricoes || '-'
                                };
                                dateObj = new Date(reqList[0].updated_at || Date.now());
                            }
                        }
                    } catch (fErr) {
                        console.warn('Fallback tabela_requerimentos falhou para Aba 2:', fErr);
                    }
                }

                if (rel) {"""

for fpath in files:
    if os.path.exists(fpath):
        with open(fpath, 'r', encoding='utf-8') as f:
            c = f.read()
        if old_code in c:
            c = c.replace(old_code, new_code)
            with open(fpath, 'w', encoding='utf-8') as f:
                f.write(c)
            print('Successfully patched:', fpath)
        else:
            print('old_code not found in:', fpath)
