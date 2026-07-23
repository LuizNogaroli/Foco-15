path = r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\resources\views\processos\abas\aba3.blade.php'

with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

target = """            try {
                // Busca indicações da tabela_indicacao
                const urlInd = `${SUPA_URL}/rest/v1/tabela_indicacao?select=dados_json&numero_requerimento=eq.${processId}`;
                const resInd = await fetch(urlInd, {
                    headers: { 'apikey': SUPA_KEY, 'Authorization': `Bearer ${SUPA_KEY}` }
                });
                
                if (!resInd.ok) throw new Error("Erro ao buscar tabela_indicacao");
                const rows = await resInd.json();
                
                let rips = [];
                let cadastros = [];
                
                if (rows && rows[0] && rows[0].dados_json) {
                    rips = rows[0].dados_json.rips || [];
                    cadastros = rows[0].dados_json.cadastros_minimos || [];
                }"""

replacement = """            const inlineRips = @json($processo->foco && $processo->foco->rips ? $processo->foco->rips->pluck('numero_rip')->toArray() : []);
            const inlineCadastros = @json($processo->foco && $processo->foco->cadastrosMinimos ? $processo->foco->cadastrosMinimos->toArray() : []);
            
            let rips = [];
            let cadastros = [];
            
            try {
                const urlInd = `${SUPA_URL}/rest/v1/tabela_indicacao?select=dados_json&numero_requerimento=eq.${encodeURIComponent(processId)}`;
                const resInd = await fetch(urlInd, {
                    headers: { 'apikey': SUPA_KEY, 'Authorization': `Bearer ${SUPA_KEY}` }
                });
                if (resInd.ok) {
                    const rows = await resInd.json();
                    if (rows && rows[0] && rows[0].dados_json) {
                        rips = rows[0].dados_json.rips || [];
                        cadastros = rows[0].dados_json.cadastros_minimos || [];
                    }
                }
            } catch(e1) {
                console.warn("Erro ao buscar tabela_indicacao:", e1);
            }

            if (rips.length === 0 && cadastros.length === 0) {
                try {
                    const urlReq = `${SUPA_URL}/rest/v1/tabela_requerimentos?select=*&numero_requerimento=eq.${encodeURIComponent(processId)}&limit=1`;
                    const resReq = await fetch(urlReq, {
                        headers: { 'apikey': SUPA_KEY, 'Authorization': `Bearer ${SUPA_KEY}` }
                    });
                    if (resReq.ok) {
                        const reqRows = await resReq.json();
                        if (reqRows && reqRows[0] && reqRows[0].dados_json) {
                            const dj = typeof reqRows[0].dados_json === 'string' ? JSON.parse(reqRows[0].dados_json) : reqRows[0].dados_json;
                            rips = dj.rips || [];
                            cadastros = dj.cadastros_minimos || [];
                        }
                    }
                } catch(e2) {
                    console.warn("Erro ao buscar fallback tabela_requerimentos:", e2);
                }
            }

            if (rips.length === 0 && inlineRips.length > 0) {
                rips = inlineRips;
            }
            if (cadastros.length === 0 && inlineCadastros.length > 0) {
                cadastros = inlineCadastros;
            }"""

if target in content:
    content = content.replace(target, replacement)
    with open(path, 'w', encoding='utf-8') as f:
        f.write(content)
    print("Successfully updated RIP accordion load logic in aba3.blade.php")
else:
    print("Target string not found in aba3.blade.php")
