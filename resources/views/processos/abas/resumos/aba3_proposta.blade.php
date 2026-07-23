@php
    $proposta = $dados3['proposta_destinacao'] ?? $dados3 ?? [];
@endphp
<div style="display:flex;flex-direction:column;">
    <!-- Proposta de Destinação e Impactos -->
    <div style="font-size:0.95rem; font-weight:700; color:#1e3a5f; margin-bottom:10px;">Proposta de Destinação e Impactos</div>
    
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Tipo de Procedimento:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['tipo_procedimento'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Observações do Procedimento:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['campo51_obs'] ?? '-' }}</span>
    </div>

    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Tipo de Uso (Imobiliário):</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['tipo_uso_imobiliario'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Uso Específico:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['tipo_uso_especifico'] ?? '-' }}</span>
    </div>

    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Regime de Destinação Proposto:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['regime_destinacao'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Observações adicionais (Regime):</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['campo511_obs'] ?? '-' }}</span>
    </div>

    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Previsão de modificação física?</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['campo54'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Descrição da modificação:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['campo54_desc'] ?? '-' }}</span>
    </div>

    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Compatibilidade urbanística:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['compatibilidade_urbanistica'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Observações compatibilidade:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['campo55_obs'] ?? '-' }}</span>
    </div>

    <div style="margin-top:16px; padding-top:16px; border-top:1px dashed #cbd5e1; margin-bottom: 10px;">
        <div style="font-size:0.95rem; font-weight:700; color:#1e3a5f; margin-bottom:10px;">Programas e Políticas</div>
    </div>
    
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Vinculação com Programas Governamentais?</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['campo56_radio'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Programas Governamentais:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ is_array($proposta['campo56'] ?? null) ? implode(', ', $proposta['campo56']) : ($proposta['campo56'] ?? '-') }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Observações Programas Governamentais:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['campo56_obs'] ?? '-' }}</span>
    </div>

    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Vinculação com Políticas Públicas?</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['campo57_radio'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Políticas Públicas:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ is_array($proposta['campo57'] ?? null) ? implode(', ', $proposta['campo57']) : ($proposta['campo57'] ?? '-') }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Observações Políticas Públicas:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['campo57_obs'] ?? '-' }}</span>
    </div>

    <div style="margin-top:16px; padding-top:16px; border-top:1px dashed #cbd5e1; margin-bottom: 10px;">
        <div style="font-size:0.95rem; font-weight:700; color:#1e3a5f; margin-bottom:10px;">Impactos Esperados</div>
    </div>

    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Expectativa de impacto social?</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['campo58_radio'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Impacto Social esperado:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['impacto_social'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Número estimado de beneficiários:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['num_beneficiarios'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Observações Impacto Social:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['impacto_social_obs'] ?? '-' }}</span>
    </div>

    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Expectativa de impacto ambiental?</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['campo510_radio'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Impacto Ambiental esperado:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['impacto_ambiental'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:300px;font-weight:600;color:#334155;">Observações Impacto Ambiental:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $proposta['impacto_ambiental_obs'] ?? '-' }}</span>
    </div>
</div>
