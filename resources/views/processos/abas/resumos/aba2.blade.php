<div style="display:flex;flex-direction:column;">
    <div style="font-size:0.95rem; font-weight:700; color:#1e3a5f; margin-bottom:10px;">Ocupação e Uso Atual</div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Situação Ocupacional:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $dados2['situacao_ocupacional'] ?? '-' }}</span>
    </div>
    @if(isset($dados2['situacao_ocupacional']) && $dados2['situacao_ocupacional'] == 'Desocupado')
        <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
            <span style="width:300px;font-weight:600;color:#334155;">Tempo de Desocupação:</span>
            <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $dados2['tempo_desocupacao'] ?? '-' }}</span>
        </div>
    @elseif(isset($dados2['situacao_ocupacional']) && $dados2['situacao_ocupacional'] == 'Ocupado irregularmente')
        <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
            <span style="width:300px;font-weight:600;color:#334155;">Data de Conhecimento da Ocupação:</span>
            <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $dados2['data_conhecimento_ocupacao'] ?? '-' }}</span>
        </div>
    @endif
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Tipo de Uso Atual:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $dados2['tipo_uso_atual'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Uso Específico Atual:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $dados2['tipo_uso_especifico_atual'] ?? '-' }}</span>
    </div>

    <div style="margin-top:16px; padding-top:16px; border-top:1px dashed #cbd5e1; margin-bottom: 10px;">
        <div style="font-size:0.95rem; font-weight:700; color:#1e3a5f; margin-bottom:10px;">Incidências, Riscos e Restrições</div>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Há incidência ambiental?</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ is_array($dados2['ha_incidencia'] ?? null) ? implode(', ', $dados2['ha_incidencia']) : ($dados2['ha_incidencia'] ?? '-') }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Detalhes da Incidência Ambiental:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $dados2['incidencia_ambiental'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Há riscos?</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ is_array($dados2['ha_riscos'] ?? null) ? implode(', ', $dados2['ha_riscos']) : ($dados2['ha_riscos'] ?? '-') }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Detalhes dos Riscos:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $dados2['riscos'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Há restrições urbanísticas/legais?</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ is_array($dados2['ha_restricoes'] ?? null) ? implode(', ', $dados2['ha_restricoes']) : ($dados2['ha_restricoes'] ?? '-') }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Detalhes das Restrições:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $dados2['restricoes'] ?? '-' }}</span>
    </div>

    <div style="margin-top:16px; padding-top:16px; border-top:1px dashed #cbd5e1; margin-bottom: 10px;">
        <div style="font-size:0.95rem; font-weight:700; color:#1e3a5f; margin-bottom:10px;">Geolocalização e Observações</div>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Latitude:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $dados2['latitude'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Longitude:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $dados2['longitude'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Observações Gerais (Diagnóstico):</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $dados2['observacoes_aba2'] ?? '-' }}</span>
    </div>
</div>
