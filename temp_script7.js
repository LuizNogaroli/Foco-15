
      function toggleBloco(id, mostrar) {
        const el = document.getElementById(id);
        if (el) el.style.display = mostrar ? "flex" : "none";
      }

      function limparErro(el, idErr) {
        const err = document.getElementById(idErr);
        if (err) err.style.display = "none";
        if (el) el.style.borderColor = "";
      }

      const usoEspecificoMap = {
        "0101": [
          [
            "010101",
            "01.01.01  Sede ou escritório de órgão ou entidade pública federal",
          ],
          [
            "010102",
            "01.01.02  Sede ou escritório de órgão ou entidade pública estadual ou distrital",
          ],
          [
            "010103",
            "01.01.03  Sede ou escritório de órgão ou entidade pública municipal",
          ],
          ["010104", "01.01.04  Representação diplomática ou consular"],
          ["010105", "01.01.05  Sede de organismo internacional"],
          ["010199", "01.01.99  Outro uso administrativo e representativo"],
        ],
        "0102": [
          ["010201", "01.02.01  Agricultura"],
          ["010202", "01.02.02  Pecuária"],
          ["010203", "01.02.03  Aquicultura"],
          ["010204", "01.02.04  Produção florestal"],
          ["010205", "01.02.05  Pesca"],
          [
            "010299",
            "01.02.99  Outro uso agropecuário, aquicultura, florestal ou pesqueiro",
          ],
        ],
        "0103": [
          ["010301", "01.03.01  Unidade de conservação"],
          ["010302", "01.03.02  área de preservação permanente"],
          ["010303", "01.03.03  Reserva legal"],
          [
            "010304",
            "01.03.04  área de reflorestamento ou recuperação ambiental",
          ],
          ["010305", "01.03.05  área de manejo de recursos naturais"],
          ["010399", "01.03.99  Outro uso ambiental e de recursos naturais"],
        ],
        "0104": [
          [
            "010401",
            "01.04.01  Equipamento cultural (museu, teatro, biblioteca, etc.)",
          ],
          [
            "010402",
            "01.04.02  Equipamento esportivo (estádio, ginásio, quadra, etc.)",
          ],
          ["010403", "01.04.03  área de lazer e recreação pública"],
          ["010404", "01.04.04  Parque urbano ou área verde pública"],
          ["010499", "01.04.99  Outro uso cultural, esportivo ou de lazer"],
        ],
        "0105": [
          ["010501", "01.05.01  Evento cultural"],
          ["010502", "01.05.02  Evento esportivo"],
          ["010503", "01.05.03  Evento comercial ou feira"],
          ["010504", "01.05.04  Evento institucional ou cívico"],
          ["010599", "01.05.99  Outro uso em evento de curta duração"],
        ],
        "0106": [
          ["010601", "01.06.01  Habitação de interesse social (HIS)"],
          ["010602", "01.06.02  Habitação de mercado popular"],
          [
            "010603",
            "01.06.03  Habitação para segmentos específicos (idosos, pessoas com deficiência, etc.)",
          ],
          [
            "010604",
            "01.06.04  Habitação em assentamento informal consolidado",
          ],
          ["010699", "01.06.99  Outro uso habitacional"],
        ],
        "0107": [
          ["010701", "01.07.01  Uso industrial"],
          ["010702", "01.07.02  Uso comercial varejista"],
          ["010703", "01.07.03  Uso comercial atacadista"],
          ["010704", "01.07.04  Prestação de serviços"],
          ["010705", "01.07.05  Uso misto (comercial/serviços/residencial)"],
          [
            "010799",
            "01.07.99  Outro uso industrial, comercial ou de serviços",
          ],
        ],
        "0108": [
          ["010801", "01.08.01  Abastecimento de água"],
          ["010802", "01.08.02  Esgotamento sanitário"],
          ["010803", "01.08.03  Energia elétrica"],
          ["010804", "01.08.04  Gás canalizado"],
          ["010805", "01.08.05  Telecomunicações"],
          ["010806", "01.08.06  Resíduos sólidos"],
          [
            "010899",
            "01.08.99  Outro uso em infraestrutura de serviços públicos",
          ],
        ],
        "0109": [
          ["010901", "01.09.01  Rodovia"],
          ["010902", "01.09.02  Ferrovia"],
          ["010903", "01.09.03  Porto ou instalação portuária"],
          ["010904", "01.09.04  Aeroporto ou aeródromo"],
          ["010905", "01.09.05  Hidrovia"],
          [
            "010906",
            "01.09.06  Mobilidade urbana (metrô, BRT, ciclovia, etc.)",
          ],
          ["010999", "01.09.99  Outro uso em infraestrutura de transportes"],
        ],
        "0110": [
          ["011001", "01.10.01  Projeto de requalificação urbana integrada"],
          ["011002", "01.10.02  Operação urbana consorciada"],
          [
            "011003",
            "01.10.03  Projeto de revitalização de área portuária ou industrial",
          ],
          [
            "011099",
            "01.10.99  Outro uso multifinalitário em requalificação urbana",
          ],
        ],
        "0111": [
          ["011101", "01.11.01  Terra indígena"],
          ["011102", "01.11.02  Território quilombola"],
          [
            "011103",
            "01.11.03  área de comunidade tradicional (ribeirinhos, extrativistas, etc.)",
          ],
          [
            "011199",
            "01.11.99  Outro uso por povos originários ou comunidades tradicionais",
          ],
        ],
        "0112": [
          ["011201", "01.12.01  Instituição de ensino federal"],
          ["011202", "01.12.02  Instituição de ensino estadual ou municipal"],
          ["011203", "01.12.03  Instituição de pesquisa"],
          ["011204", "01.12.04  Centro de extensão ou capacitação"],
          ["011299", "01.12.99  Outro uso em ensino, pesquisa e extensão"],
        ],
        "0113": [
          [
            "011301",
            "01.13.01  Centro de assistência social (CRAS, CREAS, etc.)",
          ],
          ["011302", "01.13.02  Abrigo ou albergue"],
          ["011303", "01.13.03  Centro de cidadania ou atendimento ao cidadão"],
          ["011304", "01.13.04  Entidade filantrópica ou sem fins lucrativos"],
          ["011399", "01.13.99  Outro uso socioassistêncial e de cidadania"],
        ],
        "0114": [
          ["011401", "01.14.01  Hospital ou unidade hospitalar"],
          ["011402", "01.14.02  Unidade básica de saúde (UBS/UPA)"],
          ["011403", "01.14.03  Laboratório ou centro de pesquisa em saúde"],
          ["011499", "01.14.99  Outro uso em serviços de saúde"],
        ],
        "0115": [
          ["011501", "01.15.01  Residência funcional de servidor federal"],
          ["011502", "01.15.02  Alojamento coletivo de servidores"],
          ["011599", "01.15.99  Outro uso residencial para servidor"],
        ],
        "0116": [
          ["011601", "01.16.01  Instalação militar"],
          ["011602", "01.16.02  Delegacia, presídio ou unidade de custódia"],
          ["011603", "01.16.03  Corpo de bombeiros"],
          ["011604", "01.16.04  Base ou infraestrutura de defesa nacional"],
          [
            "011699",
            "01.16.99  Outro uso em segurança pública e defesa nacional",
          ],
        ],
        "0117": [
          ["011701", "01.17.01  Templo, igreja ou espaço de culto religioso"],
          [
            "011702",
            "01.17.02  Cemitério ou crematório de vinculação religiosa",
          ],
          ["011799", "01.17.99  Outro uso religioso"],
        ],
        "0118": [["011800", "01.18.00  Sem informação"]],
        "0119": [["011900", "01.19.00  Sem uso definido/vinculação"]],
      };

      function toggleObs56() {
        const checks = document.querySelectorAll(
          '#campo56-checks input[type="checkbox"]',
        );
        const temSelecionado = Array.from(checks).some((cb) => cb.checked);
        toggleBloco("bloco56_obs", temSelecionado);
      }

      function toggleObs57() {
        const checks = document.querySelectorAll(
          '#campo57-checks input[type="checkbox"]',
        );
        const temSelecionado = Array.from(checks).some((cb) => cb.checked);
        toggleBloco("bloco57_obs", temSelecionado);
      }
      function marcarInvalido(el, errId) {
        if (el) el.style.borderColor = "#dc2626";
        const errEl = document.getElementById(errId);
        if (errEl) errEl.style.display = "block";
      }

      function popularCampo53(valor) {
        const campo53 = document.getElementById("campo53");
        campo53.innerHTML = "";
        campo53.disabled = true;

        if (!valor || !usoEspecificoMap[valor]) {
          const opt = document.createElement("option");
          opt.value = "";
          opt.textContent = "Selecione primeiro o tipo de uso imobiliário...";
          campo53.appendChild(opt);
          return;
        }

        const optDefault = document.createElement("option");
        optDefault.value = "";
        optDefault.textContent = "Selecione o tipo de uso específico...";
        campo53.appendChild(optDefault);

        usoEspecificoMap[valor].forEach(([value, label]) => {
          const opt = document.createElement("option");
          opt.value = value;
          opt.textContent = label;
          campo53.appendChild(opt);
        });

        campo53.disabled = false;
      }

      function validarFormulario() {
        let valido = true;
        let primeiro = null;

        document
          .querySelectorAll(".error-msg")
          .forEach((el) => (el.style.display = "none"));
        document
          .querySelectorAll('select,input[type="number"]')
          .forEach((el) => (el.style.borderColor = ""));

        function falha(el, errId) {
          marcarInvalido(el, errId);
          if (!primeiro) primeiro = el;
          valido = false;
        }

        const c51 = document.getElementById("campo51");
        if (!c51.value) falha(c51, "err51");

        const c52 = document.getElementById("campo52");
        if (!c52.value) falha(c52, "err52");

        const c53 = document.getElementById("campo53");
        if (c52.value && !c53.disabled && !c53.value) falha(c53, "err53");

        if (!document.querySelector('input[name="campo54"]:checked')) {
          falha(document.querySelector('input[name="campo54"]'), "err54");
        }

        const c55 = document.getElementById("campo55");
        if (!c55.value) falha(c55, "err55");

        [
          "campo56_radio",
          "campo57_radio",
          "campo58_radio",
          "campo510_radio",
        ].forEach((name) => {
          if (!document.querySelector(`input[name="${name}"]:checked`)) {
            falha(
              document.querySelector(`input[name="${name}"]`),
              "err" + name.replace("campo", "").replace("_radio", ""),
            );
          }
        });

        const c59 = document.getElementById("campo59");
        if (
          c59.value === "" ||
          isNaN(Number(c59.value)) ||
          Number(c59.value) < 0
        )
          falha(c59, "err59");

        const c511 = document.getElementById("campo511");

        const valorCampo511 =
          c511 && c511.selectedIndex > 0
            ? c511.options[c511.selectedIndex].value.trim()
            : "";

        if (!valorCampo511) {
          falha(c511, "err511");
        } else {
          c511.style.borderColor = "";

          const err511 = document.getElementById("err511");
          if (err511) {
            err511.style.display = "none";
          }
        }
      }

      function focarPrimeiro(el) {
        if (!el) return;
        el.scrollIntoView({ behavior: "smooth", block: "center" });
        setTimeout(() => {
          try {
            el.focus();
          } catch (_) {}
        }, 300);
      }

      document.addEventListener("DOMContentLoaded", function () {
        document
          .querySelectorAll("select:not([data-no-custom])")
          .forEach((el) => {
            if (typeof initCustomSelect === "function") initCustomSelect(el);
          });

        // Carregar ações judiciais da tabela_acoes
        (async function () {
          const rip =
            localStorage.getItem("CURRENT_PROCESS_ID") || window.processId;
          console.log(
            `[foco-03] RIP para ações: "${rip}", fetchAcoes existe: ${typeof window.fetchAcoes}`,
          );
          if (!rip || typeof window.fetchAcoes !== "function") {
            console.warn("[foco-03] RIP ou fetchAcoes não disponível");
            return;
          }
          try {
            const acoes = await window.fetchAcoes(rip);
            console.log("[foco-03] Resultado fetchAcoes:", acoes);
            if (acoes) {
              document.getElementById("nup_sei").value = acoes.nup_sei || "";
              document.getElementById("tipo_processo").value =
                acoes.tipo_processo || "";
              document.getElementById("resumo_acao").value = acoes.resumo || "";
              document.getElementById("descricao_acao").value =
                acoes.descricao || "";
            }
          } catch (e) {
            console.error("[foco-03] Erro ao carregar ações:", e);
          }
        })();

        // Carregar dados de contratos anteriores da tabela_spu
        let contratosAnterioresData = [];
        (async function () {
          const processId =
            localStorage.getItem("CURRENT_PROCESS_ID") || window.processId;
          console.log(
            `[foco-03] ProcessId para contratos: "${processId}", fetchSPU existe: ${typeof window.fetchSPU}`,
          );
          if (!processId || typeof window.fetchSPU !== "function") {
            console.warn("[foco-03] ProcessId ou fetchSPU não disponível");
            return;
          }

          // 1. Resolve o RIP real a partir do processId (requerimento)
          let rip = null;
          const SUPA_URL =
            window.SUPABASE_URL ||
            (window.parent && window.parent.SUPABASE_URL);
          const SUPA_KEY =
            window.SUPABASE_ANON_KEY ||
            (window.parent && window.parent.SUPABASE_ANON_KEY);
          if (SUPA_URL && SUPA_KEY) {
            try {
              const urlInd = `${SUPA_URL}/rest/v1/tabela_indicacao?select=dados_json&numero_requerimento=eq.${processId}`;
              const resInd = await fetch(urlInd, {
                headers: {
                  apikey: SUPA_KEY,
                  Authorization: `Bearer ${SUPA_KEY}`,
                },
              });
              if (resInd.ok) {
                const rows = await resInd.json();
                if (
                  rows[0] &&
                  rows[0].dados_json &&
                  rows[0].dados_json.rips &&
                  rows[0].dados_json.rips.length > 0
                ) {
                  rip = rows[0].dados_json.rips[0];
                  console.log(`[foco-03] RIP resolvido para contratos: ${rip}`);
                }
              }
            } catch (e) {
              console.warn(
                "[foco-03] Erro ao buscar RIP na tabela_indicacao para contratos:",
                e,
              );
            }
          }

          // Fallback se não resolvido
          if (!rip) {
            rip = processId;
            console.log(
              `[foco-03] Usando processId como RIP fallback para contratos: ${rip}`,
            );
          }

          try {
            const dadosSPU = await window.fetchSPU(rip);
            console.log(
              "[foco-03] Resultado fetchSPU para contratos:",
              dadosSPU,
            );
            if (dadosSPU && dadosSPU.contratos_anteriores) {
              contratosAnterioresData = dadosSPU.contratos_anteriores;
              renderContratosAnteriores();
            }
          } catch (e) {
            console.error("[foco-03] Erro ao carregar dados SPU:", e);
          }
        })();

        // Carregar e renderizar acordeon de RIP(s) ou Cadastro(s) Mínimo(s)
        (async function() {
            const processId = localStorage.getItem('CURRENT_PROCESS_ID') || window.processId;
            const container = document.getElementById('rips-accordion-container');
            const loadingMsg = document.getElementById('rips-loading-msg');
            
            if (!processId || !container) return;

            const SUPA_URL = window.SUPABASE_URL || (window.parent && window.parent.SUPABASE_URL);
            const SUPA_KEY = window.SUPABASE_ANON_KEY || (window.parent && window.parent.SUPABASE_ANON_KEY);
            
            if (!SUPA_URL || !SUPA_KEY) {
                if (loadingMsg) loadingMsg.textContent = "Erro: Credenciais do banco não disponíveis.";
                return;
            }

            const inlineRips = @json($processo->foco && $processo->foco->rips ? $processo->foco->rips->pluck('numero_rip')->toArray() : []);
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
            }
                
                if (rips.length === 0 && cadastros.length === 0) {
                    if (loadingMsg) loadingMsg.innerHTML = "<i>Nenhum imóvel ou cadastro mínimo associado a este processo.</i>";
                    return;
                }
                
                if (loadingMsg) loadingMsg.style.display = 'none';
                
                // Helper para renderizar campo readonly
                function buildFieldRO(label, value) {
                    return `
                        <div style="display: flex; align-items: baseline; margin-bottom: 6px; padding: 5px 0; font-size: 0.9rem;">
                            <span style="display: flex; width: 240px;">
                                <span style="font-weight: 600; color: #334155; white-space: nowrap;">${label}</span>
                                <span style="flex: 1; border-bottom: 1px dotted #94a3b8; min-width: 10px;"></span>
                                <span style="white-space: nowrap; color: #334155;">:</span>
                            </span>
                            <span style="flex: 1; margin-left: 6px; padding: 3px 10px; background: #f1f5f9; color: #0f172a; border-radius: 3px;">${value || '-'}</span>
                        </div>
                    `;
                }

                // Renderiza cada RIP
                for (const rip of rips) {
                    let dadosSPU = {};
                    try {
                        if (typeof window.fetchSPU === 'function') {
                            dadosSPU = await window.fetchSPU(rip);
                        }
                    } catch (e) {
                        console.warn("Erro ao buscar dados do RIP no SPU:", e);
                    }
                    
                    const block = document.createElement('div');
                    block.style.cssText = "background: white; border: 1px solid #cbd5e1; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);";
                    block.innerHTML = `
                        <div style="background: #e2e8f0; color: #1e293b; padding: 12px 16px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-weight: bold; font-size: 0.95em;" onclick="const b = this.nextElementSibling; const icon = this.querySelector('span:last-child'); if(b.style.display === 'none'){ b.style.display = 'block'; icon.style.transform = 'rotate(180deg)'; } else { b.style.display = 'none'; icon.style.transform = 'rotate(0deg)'; }">
                            <span>🏠 Imóvel (RIP): ${rip}</span>
                            <span style="transition: transform 0.2s;">▼</span>
                        </div>
                        <div style="padding: 16px; display: none; background: #fff;">
                            <div style="display: flex; flex-direction: column;">
                                ${buildFieldRO('Conceituação do Imóvel', dadosSPU.conceituacao)}
                                ${buildFieldRO('Condição de Urbanização', dadosSPU.condicao_urbanizacao)}
                                ${buildFieldRO('Natureza do Terreno', dadosSPU.natureza || dadosSPU.natureza_terreno)}
                                ${buildFieldRO('Tipo de Imóvel', dadosSPU.tipo_imovel)}
                                ${buildFieldRO('CEP', dadosSPU.cep)}
                                ${buildFieldRO('Logradouro', dadosSPU.logradouro || dadosSPU.endereco)}
                                ${buildFieldRO('Bairro', dadosSPU.bairro)}
                                ${buildFieldRO('Município / UF', `${dadosSPU.municipio || ''} / ${dadosSPU.uf || ''}`)}
                                ${buildFieldRO('Área Total (m²)', dadosSPU.area_total)}
                                ${buildFieldRO('Área da União (m²)', dadosSPU.area_uniao || dadosSPU.area_terreno_uniao)}
                                ${buildFieldRO('Área Construída Total (m²)', dadosSPU.area_construida_total)}
                                ${buildFieldRO('Área Construída Disponível (m²)', dadosSPU.area_construida_disponivel)}
                                ${buildFieldRO('Área de Terreno Disponível (m²)', dadosSPU.area_terreno_disponivel)}
                                ${buildFieldRO('Benfeitorias', dadosSPU.benfeitorias)}
                                ${buildFieldRO('Situação da Incorporação', dadosSPU.situacao_incorporacao || dadosSPU.situacao)}
                                ${buildFieldRO('Processo de Incorporação', dadosSPU.processo_incorporacao)}
                                ${buildFieldRO('LPM/1831 ou LMEO Homologadas?', dadosSPU.lpm_homologada)}
                                ${buildFieldRO('Valor da Avaliação (R$)', dadosSPU.valor_avaliado || dadosSPU.valor_avaliacao)}
                                ${buildFieldRO('Data da Avaliação', dadosSPU.data_avaliacao)}
                                ${buildFieldRO('Instrumento de Avaliação', dadosSPU.instrumento_avaliacao)}
                            </div>
                        </div>
                    `;
                    container.appendChild(block);
                }
                
                // Renderiza cada Cadastro Mínimo
                cadastros.forEach((cad, idx) => {
                    const block = document.createElement('div');
                    block.style.cssText = "background: white; border: 1px solid #cbd5e1; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);";
                    block.innerHTML = `
                        <div style="background: #e2e8f0; color: #1e293b; padding: 12px 16px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-weight: bold; font-size: 0.95em;" onclick="const b = this.nextElementSibling; const icon = this.querySelector('span:last-child'); if(b.style.display === 'none'){ b.style.display = 'block'; icon.style.transform = 'rotate(180deg)'; } else { b.style.display = 'none'; icon.style.transform = 'rotate(0deg)'; }">
                            <span>📝 Cadastro Mínimo #${idx + 1} (Sem RIP)</span>
                            <span style="transition: transform 0.2s;">▼</span>
                        </div>
                        <div style="padding: 16px; display: none; background: #fff;">
                            <div style="display: flex; flex-direction: column;">
                                ${buildFieldRO('CEP', cad.cep)}
                                ${buildFieldRO('Área (m²)', cad.area)}
                                ${buildFieldRO('Logradouro', cad.logradouro || cad.endereco)}
                                ${buildFieldRO('Bairro', cad.bairro)}
                                ${buildFieldRO('Município / UF', `${cad.municipio || ''} / ${cad.uf || ''}`)}
                                ${buildFieldRO('Observações', cad.observacoes)}
                            </div>
                        </div>
                    `;
                    container.appendChild(block);
                });
                
            } catch (e) {
                console.error("Erro ao carregar acordeon de imóveis na Aba 3:", e);
                if (loadingMsg) loadingMsg.textContent = "Erro ao carregar informações dos imóveis.";
            }
        })();

        function renderContratosAnteriores() {
          const container = document.getElementById(
            "contratos_anteriores_container",
          );
          if (!container) return;
          container.innerHTML = "";
          if (
            !contratosAnterioresData ||
            contratosAnterioresData.length === 0
          ) {
            container.innerHTML =
              '<span style="font-size: 0.85rem; color: #64748b;">Nenhum contrato anterior registrado para este imóvel.</span>';
            return;
          }
          contratosAnterioresData.forEach((c) => {
            const card = document.createElement("div");
            card.style.cssText =
              "background: #ffffff; border: 1px solid #cbd5e1; padding: 8px 12px; border-radius: 8px; font-size: 0.85rem; color: #334155; box-shadow: 0 1px 2px rgba(0,0,0,0.05); flex: 1; min-width: 200px;";
            card.innerHTML = `
        <strong style="display: block; color: #1e293b; margin-bottom: 2px;">${c.numero}</strong>
        <span style="font-size: 0.8em; color: #64748b;">Vigência: ${c.data_inicio} a ${c.data_fim}</span>
      `;
            container.appendChild(card);
          });
        }

        // Lógica de exibição das observações de CPF/CNPJ irregular
        function checkCpfCnpjRegular() {
          const checked = document.querySelector(
            'input[name="cpf_cnpj_regular"]:checked',
          );
          const bloco = document.getElementById("bloco-cpf-cnpj-irregular-obs");
          if (bloco) {
            const exibir = checked && checked.value === "Não";
            bloco.style.display = exibir ? "flex" : "none";
            if (!exibir) {
              const txt = document.getElementById("obs_cpf_cnpj_irregular");
              if (txt) txt.value = "";
            }
          }
        }
        document
          .querySelectorAll('input[name="cpf_cnpj_regular"]')
          .forEach((radio) => {
            radio.addEventListener("change", checkCpfCnpjRegular);
          });
        setTimeout(checkCpfCnpjRegular, 500);

        document
          .getElementById("campo51")
          .addEventListener("change", function () {
            toggleBloco("bloco51_obs", !!this.value);
            toggleBloco(
              "bloco_contratos_anteriores",
              this.value === "Renovação/alteração contratual",
            );
            limparErro(this, "err51");
          });

        document
          .getElementById("campo52")
          .addEventListener("change", function () {
            limparErro(this, "err52");
            limparErro(document.getElementById("campo53"), "err53");
            popularCampo53(this.value);
          });

        document
          .getElementById("campo53")
          .addEventListener("change", function () {
            limparErro(this, "err53");
          });

        document.querySelectorAll('input[name="campo54"]').forEach((radio) => {
          radio.addEventListener("change", function () {
            toggleBloco("bloco54", this.value === "Sim");
            if (this.value !== "Sim") {
              const desc = document.getElementById("campo54_desc");
              if (desc) desc.value = "";
            }
            limparErro(null, "err54");
          });
        });

        document
          .getElementById("campo55")
          .addEventListener("change", function () {
            limparErro(this, "err55");
            toggleBloco("bloco55_obs", !!this.value);
          });

        [
          { radio: "campo56_radio", grupo: "group-campo56", err: "err56" },
          { radio: "campo57_radio", grupo: "group-campo57", err: "err57" },
          { radio: "campo58_radio", grupo: "group-campo58", err: "err58" },
          { radio: "campo510_radio", grupo: "group-campo510", err: "err510" },
        ].forEach((cfg) => {
          document
            .querySelectorAll(`input[name="${cfg.radio}"]`)
            .forEach((radio) => {
              radio.addEventListener("change", function () {
                const exibir = this.value === "Sim";
                toggleBloco(cfg.grupo, exibir);

                if (!exibir) {
                  document
                    .querySelectorAll(
                      `#${cfg.grupo} input[type="checkbox"], #${cfg.grupo} input[type="radio"]`,
                    )
                    .forEach((cb) => (cb.checked = false));
                  document
                    .querySelectorAll(`#${cfg.grupo} textarea`)
                    .forEach((t) => (t.value = ""));
                  document
                    .querySelectorAll(`#${cfg.grupo} select`)
                    .forEach((s) => (s.value = ""));
                }

                limparErro(null, cfg.err);
              });
            });
        });

        const campo511 = document.getElementById("campo511");

        if (campo511) {
          campo511.addEventListener("change", function () {
            const temValor =
              this.selectedIndex > 0 &&
              this.options[this.selectedIndex].value.trim() !== "";

            toggleBloco("bloco511_obs", temValor);

            if (temValor) {
              this.style.borderColor = "";

              const err511 = document.getElementById("err511");
              if (err511) {
                err511.style.display = "none";
              }
            } else {
              marcarInvalido(this, "err511");
            }
          });

          campo511.addEventListener("input", function () {
            this.dispatchEvent(new Event("change", { bubbles: true }));
          });
        }

        /*
    CORREO APLICADA:
    O boto "Salvar e Enviar SPU/UF" agora valida o formulrio e,
    se estiver tudo correto, navega diretamente para foco-07.html,
    que est na mesma pasta deste arquivo.
  */
      });

      // =========================================================================
      // LÓGICA DE SALVAMENTO E MANIFESTAÇÃO (ABA 3)
      // =========================================================================

      const formReq3 =
        document.getElementById("form03") || document.querySelector("form");
      if (formReq3) {
        formReq3.addEventListener("submit", (e) => {
          e.preventDefault();
        });
      }
      let ultimoRelatorioSalvoAba3 = {};

      async function executarSalvamentoAba3() {
        if (formReq3 && !formReq3.checkValidity()) {
          formReq3.reportValidity();
          const invalidField = formReq3.querySelector(":invalid");
          if (invalidField) {
            invalidField.scrollIntoView({
              behavior: "smooth",
              block: "center",
            });
          }
          alert(
            "Atenção: Existem campos obrigatórios não preenchidos. Por favor, revise o formulário e preencha-os antes de salvar.",
          );
          return false;
        }

        const processId = localStorage.getItem("CURRENT_PROCESS_ID");
        if (window.parent) {
          try {
            if (typeof window.parent.forceSaveDraft === "function") {
              await window.parent.forceSaveDraft();
            }

            const formDataState = window.parent.formDataState || {};

            ultimoRelatorioSalvoAba3 = {
              // 1. Análise do Destinatário
              cpf_cnpj_regular: document.querySelector('input[name="cpf_cnpj_regular"]:checked')?.value || "",
              obs_cpf_cnpj_irregular: document.getElementById("obs_cpf_cnpj_irregular")?.value || "",
              natureza_destinacao: document.getElementById("campo16")?.value || "",
              ha_pendencias_contratuais: document.querySelector('input[name="ha_pendencias_contratuais"]:checked')?.value || "",
              pendencias: Array.from(document.querySelectorAll('input[name="pendencias[]"]:checked')).map(el => el.value),
              pendencias_obs: document.getElementById("obs_pendencias")?.value || "",

              // 2. Capacidade Financeira
              capacidade_fin: document.getElementById("capacidade_fin")?.value || "",

              // 3. Ações judiciais ou órgãos de controle
              nup_sei: document.getElementById("nup_sei")?.value || "",
              tipo_processo: document.getElementById("tipo_processo")?.value || "",
              resumo_acao: document.getElementById("resumo_acao")?.value || "",
              descricao_acao: document.getElementById("descricao_acao")?.value || "",

              // 4. Dados de Comparação de Área e Valor
              area_total_imovel: document.getElementById("area_total_imovel")?.value || "",
              valor_total_imovel: document.getElementById("valor_total_imovel")?.value || "",
              area_terreno_destinada: document.getElementById("area_terreno_destinada")?.value || "",
              area_construida_destinada: document.getElementById("area_construida_destinada")?.value || "",
              valor_area_destinada: document.getElementById("valor_area_destinada")?.value || "",

              // 5. Custos de Manutenção para a SPU
              custos_manutencao: document.querySelector('input[name="custos_manutencao"]:checked')?.value || "",
              custos_valor: document.getElementById("custos_valor")?.value || "",

              // 6. Outros Interessados
              outros_interessados: document.querySelector('input[name="outros_interessados"]:checked')?.value || "",
              obs_outros_interessados: document.getElementById("obs_outros_interessados")?.value || "",

              // 7. Proposta de Destinação e Impactos
              modalidade: document.getElementById("campo51")?.value || "", // Tipo de procedimento
              destinacao_obs: document.getElementById("campo51_obs")?.value || "",
              tipo_uso_imobiliario: document.getElementById("campo52")?.value || "",
              tipo_uso_especifico: document.getElementById("campo53")?.value || "",
              previsao_modificacao: document.querySelector('input[name="campo54"]:checked')?.value || "",
              previsao_modificacao_desc: document.getElementById("campo54_desc")?.value || "",
              compatibilidade_urbanistica: document.getElementById("campo55")?.value || "",
              compatibilidade_urbanistica_obs: document.getElementById("campo55_obs")?.value || "",
              
              vinculacao_programas_radio: document.querySelector('input[name="campo56_radio"]:checked')?.value || "",
              vinculacao_programas: Array.from(document.querySelectorAll('input[name="campo56[]"]:checked')).map(el => el.value),
              vinculacao_programas_obs: document.getElementById("campo56_obs")?.value || "",
              
              vinculacao_politicas_radio: document.querySelector('input[name="campo57_radio"]:checked')?.value || "",
              vinculacao_politicas: Array.from(document.querySelectorAll('input[name="campo57[]"]:checked')).map(el => el.value),
              vinculacao_politicas_obs: document.getElementById("campo57_obs")?.value || "",
              
              expectativa_impacto_social: document.querySelector('input[name="campo58_radio"]:checked')?.value || "",
              impacto_social: document.getElementById("campo58")?.value || "",
              impacto_social_obs: document.getElementById("campo58_obs")?.value || "",
              num_beneficiarios: document.getElementById("campo59")?.value || "",
              
              expectativa_impacto_ambiental: document.querySelector('input[name="campo510_radio"]:checked')?.value || "",
              impacto_ambiental: document.getElementById("campo510")?.value || "",
              impacto_ambiental_obs: document.getElementById("campo510_obs")?.value || "",
              
              cessao_onerosa: document.getElementById("campo511")?.value || "", // Regime de destinação
              cessao_obs: document.getElementById("campo511_obs")?.value || "",
              
              obs_geral_destinacao: document.getElementById("obs224_0")?.value || "",

              // Legados/Metadados extras
              ha_debitos: formDataState["ha_debitos"] || "",
              debitos: formDataState["debitos[]"] || formDataState["debitos"] || [],
              debitos_obs: formDataState["obs_debitos"] || "",
              observacoes_aba3: document.getElementById("observacoes_aba3")?.value || "",
            };
            console.log("DEBUG ABA 3 - Dados a serem salvos no Relatório:", ultimoRelatorioSalvoAba3);

            const urlRel = `${window.parent.SUPABASE_URL}/rest/v1/tabela_relatorios?on_conflict=process_id,aba`;
            const payloadRel = {
              process_id: processId,
              aba: "aba3",
              dados_relatorio: ultimoRelatorioSalvoAba3,
              updated_at: new Date().toISOString(),
            };

            await fetch(urlRel, {
              method: "POST",
              headers: {
                apikey: window.parent.SUPABASE_ANON_KEY,
                Authorization: `Bearer ${window.parent.SUPABASE_ANON_KEY}`,
                "Content-Type": "application/json",
                Prefer: "resolution=merge-duplicates",
              },
              body: JSON.stringify(payloadRel),
            });

            // --- VERSIONAMENTO: gravar snapshot na tabela_versoes_formulario ---
            try {
              const urlVersoes = `${window.parent.SUPABASE_URL}/rest/v1/tabela_versoes_formulario`;
              // Busca a última versão desta aba para incrementar
              const urlUltimaVersao = `${urlVersoes}?processo_id=eq.${encodeURIComponent(processId)}&aba=eq.aba3&order=versao.desc&limit=1`;
              const resUltima = await fetch(urlUltimaVersao, {
                headers: { apikey: window.parent.SUPABASE_ANON_KEY, Authorization: `Bearer ${window.parent.SUPABASE_ANON_KEY}` }
              });
              const arrUltima = await resUltima.json();
              const proximaVersao = (arrUltima.length > 0 ? arrUltima[0].versao : 0) + 1;

              await fetch(urlVersoes, {
                method: "POST",
                headers: {
                  apikey: window.parent.SUPABASE_ANON_KEY,
                  Authorization: `Bearer ${window.parent.SUPABASE_ANON_KEY}`,
                  "Content-Type": "application/json",
                },
                body: JSON.stringify({
                  processo_id: processId,
                  aba: "aba3",
                  versao: proximaVersao,
                  dados_json: ultimoRelatorioSalvoAba3,
                  criado_por: localStorage.getItem("CURRENT_USER_PROFILE") || "SISTEMA"
                })
              });
              console.log(`✅ [foco-03] Versão ${proximaVersao} gravada em tabela_versoes_formulario`);
            } catch (errVersao) {
              console.warn("⚠️ [foco-03] Erro ao gravar versão (não bloqueia):", errVersao);
            }

            return true;
          } catch (err) {
            console.error("❌ [foco-03] Erro durante o salvamento:", err);
            return false;
          }
        }
        return false;
      }

      const btnSalvarRelatorio3 = document.getElementById("btnSalvarRelatorio");

      // ------------------------------------

      const btnManifestacao3 = document.getElementById("btnManifestacao");
      const btnEnviarPainel = document.getElementById("btnEnviarPainel");

      if (btnSalvarRelatorio3) {
        btnSalvarRelatorio3.addEventListener("click", async () => {
          const orig = btnSalvarRelatorio3.innerHTML;
          btnSalvarRelatorio3.innerHTML = "Salvando...";
          const sucesso = await executarSalvamentoAba3();
          btnSalvarRelatorio3.innerHTML = orig;
          if (sucesso) {
            alert("Dados da Aba 3 salvos com sucesso!");
            if (btnManifestacao3) {
              btnManifestacao3.style.display = "block";
            }
          }
        });
      }

      if (btnManifestacao3) {
        btnManifestacao3.addEventListener("click", async () => {
          const orig = btnManifestacao3.innerHTML;
          btnManifestacao3.innerHTML = "Preparando...";
          const sucesso = await executarSalvamentoAba3();
          btnManifestacao3.innerHTML = orig;

          if (!sucesso) return;

          const modalAprovacao = document.getElementById("modalAprovacaoAba3");
          const iframeAprovacao = document.getElementById("iframeAprovacao");
          const chkAprovar = document.getElementById("chkAprovarAba3");
          const btnConfirmarAprov = document.getElementById(
            "btnConfirmarAprovacao",
          );
          const btnCancelarAprov = document.getElementById(
            "btnCancelarAprovacao",
          );
          const btnFecharAprov = document.getElementById(
            "btnFecharModalAprovacao",
          );
          const loadingRelatorio = document.getElementById("loadingRelatorio");
          const conteudoRel = document.getElementById("conteudoRelatorioAprovacao");

        if (modalAprovacao) {
          loadingRelatorio.style.display = "block";
          conteudoRel.style.display = "none";
          chkAprovar.checked = false;
          btnConfirmarAprov.disabled = true;

          modalAprovacao.style.display = "flex";

          const onCheckChange = (ev) => {
            btnConfirmarAprov.disabled = !ev.target.checked;
          };
          chkAprovar.removeEventListener("change", onCheckChange);
          chkAprovar.addEventListener("change", onCheckChange);

          const fecharModal = () => {
            modalAprovacao.style.display = "none";
          };
          if (btnCancelarAprov) btnCancelarAprov.onclick = fecharModal;
          if (btnFecharAprov) btnFecharAprov.onclick = fecharModal;

          // Carrega o HTML do resumo e depois popula com os dados (Sem iframe!)
          try {
            const processId = localStorage.getItem("CURRENT_PROCESS_ID");
            const SUPA_URL = window.parent?.SUPABASE_URL;
            const SUPA_KEY = window.parent?.SUPABASE_ANON_KEY;

            if (!SUPA_URL || !SUPA_KEY) {
              throw new Error("Credenciais do Supabase não encontradas.");
            }

            // 1. Busca o HTML do resumo
            const htmlRes = await fetch("foco-03-resumo.html?t=" + new Date().getTime());
            if (!htmlRes.ok) throw new Error("Erro ao carregar template do resumo.");
            const rawHtml = await htmlRes.text();

            // 2. Extrai apenas o container do relatório
            const parser = new DOMParser();
            const doc = parser.parseFromString(rawHtml, "text/html");
            const reportContainer = doc.getElementById("content");
            
            if (!reportContainer) throw new Error("Template de relatório inválido.");
            
            // Insere no DOM local
            conteudoRel.innerHTML = reportContainer.innerHTML;

            // 3. Busca os dados do Supabase
            const url = `${SUPA_URL}/rest/v1/tabela_relatorios?select=*&process_id=eq.${encodeURIComponent(processId)}&aba=eq.aba3&limit=1`;
            const dataRes = await fetch(url, {
              headers: { apikey: SUPA_KEY, Authorization: `Bearer ${SUPA_KEY}` }
            });

            if (!dataRes.ok) throw new Error("Erro ao buscar dados do relatório.");
            const data = await dataRes.json();

            if (data && data.length > 0) {
              ultimoRelatorioSalvoAba3 = data[0].dados_relatorio;
              const rel = ultimoRelatorioSalvoAba3;

              // Popula os elementos do resumo inserido
              conteudoRel.querySelector("#val_cpf_cnpj_regular").textContent = rel.cpf_cnpj_regular || '-';
              conteudoRel.querySelector("#val_obs_cpf_cnpj_irregular").textContent = rel.obs_cpf_cnpj_irregular || '-';
              conteudoRel.querySelector("#val_natureza").textContent = rel.natureza_destinacao || '-';
              conteudoRel.querySelector("#val_pendencias").textContent = (rel.ha_pendencias_contratuais === 'Sim' && rel.pendencias && rel.pendencias.length > 0) ? (Array.isArray(rel.pendencias) ? rel.pendencias.join(', ') : rel.pendencias) : rel.ha_pendencias_contratuais || '-';
              conteudoRel.querySelector("#val_pendencias_obs").textContent = rel.pendencias_obs || '-';

              conteudoRel.querySelector("#val_capacidade_fin").textContent = rel.capacidade_fin ? (rel.capacidade_fin === 'demonstrada' ? 'Demonstrada formalmente' : rel.capacidade_fin === 'não demonstrada' ? 'Não demonstrada' : 'Não se aplica') : '-';

              conteudoRel.querySelector("#val_nup_sei").textContent = rel.nup_sei || '-';
              conteudoRel.querySelector("#val_tipo_processo").textContent = rel.tipo_processo || '-';
              conteudoRel.querySelector("#val_resumo_acao").textContent = rel.resumo_acao || '-';
              conteudoRel.querySelector("#val_descricao_acao").textContent = rel.descricao_acao || '-';

              conteudoRel.querySelector("#val_area_total_imovel").textContent = rel.area_total_imovel || '-';
              conteudoRel.querySelector("#val_valor_total_imovel").textContent = rel.valor_total_imovel || '-';
              conteudoRel.querySelector("#val_area_terreno_destinada").textContent = rel.area_terreno_destinada || '-';
              conteudoRel.querySelector("#val_area_construida_destinada").textContent = rel.area_construida_destinada || '-';
              conteudoRel.querySelector("#val_valor_area_destinada").textContent = rel.valor_area_destinada || '-';

              conteudoRel.querySelector("#val_custos_manutencao").textContent = rel.custos_manutencao || '-';
              conteudoRel.querySelector("#val_custos_valor").textContent = rel.custos_valor || '-';
              conteudoRel.querySelector("#val_outros_interessados").textContent = rel.outros_interessados || '-';
              conteudoRel.querySelector("#val_obs_outros_interessados").textContent = rel.obs_outros_interessados || '-';

              conteudoRel.querySelector("#val_modalidade").textContent = rel.modalidade || '-';
              conteudoRel.querySelector("#val_destinacao_obs").textContent = rel.destinacao_obs || '-';

              const mapaUsoImobiliario = {
                  "0101": "01.01 Uso administrativo e representativo",
                  "0102": "01.02 Uso para agropecuária, aquicultura, produção florestal e pesca",
                  "0103": "01.03 Uso ambiental e dos recursos naturais",
                  "0104": "01.04 Uso cultural, esportivo e de lazer",
                  "0105": "01.05 Uso em eventos de curta duração",
                  "0106": "01.06 Uso habitacional",
                  "0107": "01.07 Uso industrial, comercial ou de prestação de serviços",
                  "0108": "01.08 Uso em infraestrutura de serviços públicos",
                  "0109": "01.09 Uso em infraestrutura de transportes",
                  "0110": "01.10 Uso multifinalitário em projeto de requalificação urbana",
                  "0111": "01.11 Uso por povos originários e comunidades tradicionais",
                  "0112": "01.12 Uso em serviço de ensino, pesquisa e extensão",
                  "0113": "01.13 Uso em serviço socioassistêncial e de cidadania",
                  "0114": "01.14 Uso em serviços de saúde",
                  "0115": "01.15 Uso residential para servidor",
                  "0116": "01.16 Uso para segurança pública e defesa nacional",
                  "0117": "01.17 Uso religioso",
                  "0118": "01.18 Sem informação",
                  "0119": "01.19 Sem uso definido/vinculação"
              };
              conteudoRel.querySelector("#val_tipo_uso_imobiliario").textContent = mapaUsoImobiliario[rel.tipo_uso_imobiliario] || rel.tipo_uso_imobiliario || '-';
              conteudoRel.querySelector("#val_tipo_uso_especifico").textContent = rel.tipo_uso_especifico || '-';

              conteudoRel.querySelector("#val_cessao").textContent = rel.cessao_onerosa || '-';
              conteudoRel.querySelector("#val_cessao_obs").textContent = rel.cessao_obs || '-';

              conteudoRel.querySelector("#val_previsao_modificacao").textContent = rel.previsao_modificacao || '-';
              conteudoRel.querySelector("#val_previsao_modificacao_desc").textContent = rel.previsao_modificacao_desc || '-';
              conteudoRel.querySelector("#val_compatibilidade_urbanistica").textContent = rel.compatibilidade_urbanistica || '-';
              conteudoRel.querySelector("#val_compatibilidade_urbanistica_obs").textContent = rel.compatibilidade_urbanistica_obs || '-';

              conteudoRel.querySelector("#val_vinculacao_programas_radio").textContent = rel.vinculacao_programas_radio || '-';
              conteudoRel.querySelector("#val_vinculacao_programas").textContent = (Array.isArray(rel.vinculacao_programas) ? rel.vinculacao_programas.join(', ') : rel.vinculacao_programas) || '-';
              conteudoRel.querySelector("#val_vinculacao_programas_obs").textContent = rel.vinculacao_programas_obs || '-';

              conteudoRel.querySelector("#val_vinculacao_politicas_radio").textContent = rel.vinculacao_politicas_radio || '-';
              conteudoRel.querySelector("#val_vinculacao_politicas").textContent = (Array.isArray(rel.vinculacao_politicas) ? rel.vinculacao_politicas.join(', ') : rel.vinculacao_politicas) || '-';
              conteudoRel.querySelector("#val_vinculacao_politicas_obs").textContent = rel.vinculacao_politicas_obs || '-';

              conteudoRel.querySelector("#val_expectativa_impacto_social").textContent = rel.expectativa_impacto_social || '-';
              conteudoRel.querySelector("#val_impacto_social").textContent = rel.impacto_social || '-';
              conteudoRel.querySelector("#val_num_beneficiarios").textContent = rel.num_beneficiarios || '-';
              conteudoRel.querySelector("#val_impacto_social_obs").textContent = rel.impacto_social_obs || '-';

              conteudoRel.querySelector("#val_expectativa_impacto_ambiental").textContent = rel.expectativa_impacto_ambiental || '-';
              conteudoRel.querySelector("#val_impacto_ambiental").textContent = rel.impacto_ambiental || '-';
              conteudoRel.querySelector("#val_impacto_ambiental_obs").textContent = rel.impacto_ambiental_obs || '-';

              conteudoRel.querySelector("#val_obs_geral_destinacao").textContent = rel.obs_geral_destinacao || '-';

              const mapaDespacho = {
                  "aprovar": "✅ Aprovar e Concluir Processo",
                  "devolver_aba2": "⚠️ Devolver para Caracterização (Aba 2)",
                  "devolver_aba1": "🛑 Indicação do Imóvel"
              };
              conteudoRel.querySelector("#val_despacho_final").textContent = mapaDespacho[rel.despacho_final] || rel.despacho_final || '-';
              conteudoRel.querySelector("#val_motivo_devolucao").textContent = rel.motivo_devolucao || '-';

              const dateObj = new Date(data[0].updated_at);
              conteudoRel.querySelector("#val_data_relatorio").textContent = dateObj.toLocaleString("pt-BR");
              conteudoRel.querySelector("#val_base_id").textContent = processId;

              // Renderiza selo de aprovação
              if (rel.aprovacao && rel.aprovacao.status) {
                  const aprovDate = new Date(rel.aprovacao.data).toLocaleString("pt-BR");
                  const perfilAss = rel.aprovacao.perfil || "Perfil Atual";
                  const obsAss = rel.aprovacao.observacoes ? rel.aprovacao.observacoes : "Sem observações adicionais.";
                  
                  const metaDiv = conteudoRel.querySelector('div[style*="border-left: 6px solid #1a7a4a"]');
                  if (metaDiv) {
                      metaDiv.innerHTML += `
                          <div style="margin-top: 25px; padding-top: 15px; border-top: 1px dashed #ccc; color: #333;">
                              <h4 style="margin:0 0 10px 0; color: #1e3a5f;">Conclusão e Manifestação</h4>
                              <div style="background: #e8f5e9; padding: 15px; border-radius: 4px; border-left: 4px solid #166534; margin-bottom: 15px;">
                                  <p style="margin: 0 0 10px 0; font-size: 13px; color: #166534;">
                                      <strong>Declaração:</strong> Declaro que as informações consignadas neste formulário foram inseridas com base nos dados disponíveis nos sistemas oficiais, nos documentos constantes do processo e nas verificações realizadas no âmbito desta unidade, estando compatíveis com os elementos analisados.
                                  </p>
                                  <div style="font-size: 14px; color: #166534;">
                                      <strong>✅ Aprovado e Assinado Digitalmente</strong>
                                      <br>Data: ${aprovDate}
                                      <br>Perfil Responsável: <strong>${perfilAss}</strong>
                                  </div>
                              </div>
                              <div style="background: #f8fafc; padding: 15px; border-radius: 4px; border: 1px solid #cbd5e1;">
                                  <h5 style="margin:0 0 8px 0; color: #334155; font-size: 14px;">Observações da Manifestação:</h5>
                                  <p style="margin: 0; font-size: 13px; color: #475569; white-space: pre-wrap;">${obsAss}</p>
                              </div>
                          </div>
                      `;
                  }
              }

              loadingRelatorio.style.display = "none";
              conteudoRel.style.display = "block";
            } else {
              loadingRelatorio.innerText = "Nenhum relatório salvo encontrado para a Aba 3. Salve a Aba 3 para gerar.";
            }
          } catch (err) {
            console.error(err);
            loadingRelatorio.innerText = "Erro ao carregar o relatório: " + err.message;
          }

          btnConfirmarAprov.onclick = async () => {
            const origBtn = btnConfirmarAprov.innerHTML;
            btnConfirmarAprov.innerHTML = "Salvando...";

            try {
              const processId = localStorage.getItem("CURRENT_PROCESS_ID");
              const urlRelPatch = `${window.parent.SUPABASE_URL}/rest/v1/tabela_relatorios?process_id=eq.${encodeURIComponent(processId)}&aba=eq.aba3`;

              const observacoes = document.getElementById("txtObservacoesAba3")
                ? document.getElementById("txtObservacoesAba3").value
                : "";
              const perfilLogado =
                localStorage.getItem("CURRENT_USER_PROFILE") ||
                "Equipe SPU/UF (Destinação)";

              ultimoRelatorioSalvoAba3.aprovacao = {
                status: true,
                data: new Date().toISOString(),
                perfil: perfilLogado,
                observacoes: observacoes,
              };

              await fetch(urlRelPatch, {
                method: "PATCH",
                headers: {
                  apikey: window.parent.SUPABASE_ANON_KEY,
                  Authorization: `Bearer ${window.parent.SUPABASE_ANON_KEY}`,
                  "Content-Type": "application/json",
                },
                body: JSON.stringify({
                  dados_relatorio: ultimoRelatorioSalvoAba3,
                  updated_at: new Date().toISOString(),
                }),
              });
            } catch (e) {
              console.warn("⚠️ [foco-03] Erro ao salvar aprovação no relatório (não crítico):", e);
            }

            // Sempre mostra o botão e fecha o modal, independente de erros no relatório
            if (btnEnviarPainel) {
              btnEnviarPainel.style.display = "block";
            }
            fecharModal();
            btnConfirmarAprov.innerHTML = origBtn;
          };
        }
        });
      }

      if (btnEnviarPainel) {
        btnEnviarPainel.addEventListener("click", async () => {
          btnEnviarPainel.disabled = true;
          btnEnviarPainel.innerHTML = "⏳ Enviando...";

          const processId = localStorage.getItem("CURRENT_PROCESS_ID");

          // --- Salva o status diretamente via fetch (não depende de window.parent) ---
          const SUPA_URL = window.parent?.SUPABASE_URL || window.SUPABASE_URL;
          const SUPA_KEY = window.parent?.SUPABASE_ANON_KEY || window.SUPABASE_ANON_KEY;

          if (processId && SUPA_URL && SUPA_KEY) {
            try {
              let novoCheckpoint = 'Validação análise de viabilidade - Chefia';
              let novoStatus = 'Validação análise de viabilidade - Chefia';
              let novaInstancia = 'Chefia';
              let novoPerfil = 'Chefia';

              // Verifica se já existe linha para esse processo
              const resGet = await fetch(
                `${SUPA_URL}/rest/v1/tabela_status_fluxo?select=id&numero_requerimento=eq.${encodeURIComponent(processId)}&order=id.desc&limit=1`,
                { headers: { apikey: SUPA_KEY, Authorization: `Bearer ${SUPA_KEY}` } }
              );
              const existData = await resGet.json();
              const dadosJson = { 
                  checkpoint: novoCheckpoint, 
                  status_geral: novoStatus,
                  tag_fluxo: "Em andamento",
                  status: novoStatus,
                  instancia: novaInstancia,
                  perfil: novoPerfil
              };

              if (existData.length > 0) {
                await fetch(
                  `${SUPA_URL}/rest/v1/tabela_status_fluxo?numero_requerimento=eq.${encodeURIComponent(processId)}`,
                  {
                    method: 'PATCH',
                    headers: { apikey: SUPA_KEY, Authorization: `Bearer ${SUPA_KEY}`, 'Content-Type': 'application/json' },
                    body: JSON.stringify({ dados_json: dadosJson })
                  }
                );
              } else {
                await fetch(
                  `${SUPA_URL}/rest/v1/tabela_status_fluxo`,
                  {
                    method: 'POST',
                    headers: { apikey: SUPA_KEY, Authorization: `Bearer ${SUPA_KEY}`, 'Content-Type': 'application/json' },
                    body: JSON.stringify({ numero_requerimento: processId, dados_json: dadosJson })
                  }
                );
              }
              console.log("✅ [foco-03] Checkpoint salvo:", novoCheckpoint, "para", processId);
            } catch(e) {
              console.error("❌ [foco-03] Erro ao salvar checkpoint:", e);
            }
          } else {
            console.warn("⚠️ [foco-03] Sem processId ou credenciais para salvar checkpoint");
          }

          if (window.parent?.formDataState) {
            delete window.parent.formDataState.status_devolucao;
            delete window.parent.formDataState.motivo_devolucao;
            delete window.parent.formDataState.resposta_devolucao;
          }
          if (typeof window.parent?.forceSaveDraft === "function") {
            await window.parent.forceSaveDraft();
          }

          // Salvar Snapshot Histórico no Supabase antes de trocar de aba
          if (window.parent && typeof window.parent.salvarSnapshotHistorico === 'function') {
              await window.parent.salvarSnapshotHistorico('Aba 3 (Destinação)');
          }

          const rootWindow = window.parent?.parent || window.parent || window;
          const btnTabNext = rootWindow.document?.querySelector('button[data-url="aba7.html"]');
          if (btnTabNext) {
            await new Promise(resolve => setTimeout(resolve, 600));
            btnTabNext.click();
            setTimeout(() => {
              const iframeAba7 = rootWindow.document?.getElementById('frame');
              if (iframeAba7 && iframeAba7.contentWindow) {
                iframeAba7.contentWindow.postMessage({ type: 'RELOAD_DELIBERACOES' }, '*');
              }
            }, 800);
          } else {
            alert("Manifestação concluída! Verifique o painel principal.");
          }
        });
      }
    