@php
    $analise = $dados3['dados_analise'] ?? $dados3 ?? [];
@endphp
<div style="display:flex;flex-direction:column;">
    <!-- 1. Análise do Destinatário -->
    <div style="font-size:0.95rem; font-weight:700; color:#1e3a5f; margin-bottom:10px;">Análise do Destinatário</div>
    
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">CPF/CNPJ regular?</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['cpf_cnpj_regular'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Observações CPF/CNPJ:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['obs_cpf_cnpj_irregular'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Natureza da Destinação (Jurídica):</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['campo16'] ?? '-' }}</span>
    </div>
    
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Possui destinação ativa com SPU?</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['destinacao_ativa'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Contratos Ativos (SPU):</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['contratos_destinacao_ativa'] ?? '-' }}</span>
    </div>

    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Pendências Contratuais/Documentais?</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['ha_pendencias_contratuais'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Detalhes da Pendência:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ is_array($analise['pendencias'] ?? null) ? implode(', ', $analise['pendencias']) : ($analise['pendencias'] ?? '-') }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Observações sobre Pendências:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['obs_pendencias'] ?? '-' }}</span>
    </div>

    <!-- 2. Capacidade Financeira -->
    <div style="margin-top:16px; padding-top:16px; border-top:1px dashed #cbd5e1; margin-bottom: 10px;">
        <div style="font-size:0.95rem; font-weight:700; color:#1e3a5f; margin-bottom:10px;">Capacidade Financeira</div>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Capacidade orçamentária/financeira:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['capacidade_fin'] ?? '-' }}</span>
    </div>

    <!-- 3. Ações judiciais ou órgãos de controle -->
    <div style="margin-top:16px; padding-top:16px; border-top:1px dashed #cbd5e1; margin-bottom: 10px;">
        <div style="font-size:0.95rem; font-weight:700; color:#1e3a5f; margin-bottom:10px;">Ações judiciais ou órgãos de controle</div>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">NUP SEI:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['nup_sei'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Tipo de Processo:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['tipo_processo'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Resumo:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['resumo_acao'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Descrição:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['descricao_acao'] ?? '-' }}</span>
    </div>

    <!-- 4. Dados de Comparação de Área e Valor -->
    <div style="margin-top:16px; padding-top:16px; border-top:1px dashed #cbd5e1; margin-bottom: 10px;">
        <div style="font-size:0.95rem; font-weight:700; color:#1e3a5f; margin-bottom:10px;">Dados de Comparação de Área e Valor</div>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Área total do imóvel (m²):</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['area_total_imovel'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Valor total do imóvel (R$):</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['valor_total_imovel'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Área do terreno destinada (m²):</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['area_terreno_destinada'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Área construída destinada (m²):</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['area_construida_destinada'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Valor da área destinada (R$):</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['valor_area_destinada'] ?? '-' }}</span>
    </div>

    <!-- 5. Custos de Manutenção para a SPU -->
    <div style="margin-top:16px; padding-top:16px; border-top:1px dashed #cbd5e1; margin-bottom: 10px;">
        <div style="font-size:0.95rem; font-weight:700; color:#1e3a5f; margin-bottom:10px;">Custos de Manutenção para a SPU</div>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Quem arcará com custos de manutenção?</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['custos_manutencao'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Valor anual estimado (Custos):</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['custos_valor'] ?? '-' }}</span>
    </div>

    <!-- 6. Outros Interessados -->
    <div style="margin-top:16px; padding-top:16px; border-top:1px dashed #cbd5e1; margin-bottom: 10px;">
        <div style="font-size:0.95rem; font-weight:700; color:#1e3a5f; margin-bottom:10px;">Outros Interessados</div>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Existem outros interessados?</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['outros_interessados'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Observações sobre outros interessados:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $analise['obs_outros_interessados'] ?? '-' }}</span>
    </div>
</div>
