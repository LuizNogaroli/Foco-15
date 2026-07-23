<div style="display:flex;flex-direction:column;">
    @php $req = $requerimento ?? null; @endphp
    
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Nome do Requerente:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->nome_requerente ?? '-' }}</span></div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">CPF/CNPJ:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->cpf_cnpj_requerente ?? '-' }}</span></div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Telefone:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->contato_requerente ?? '-' }}</span></div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Número do Requerimento:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->numero_requerimento ?? $processo->numero_requerimento }}</span></div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Data do Requerimento:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->data_hora_recebimento ?? $processo->created_at?->format('d/m/Y') ?? '-' }}</span></div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Número do Processo SEI:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->nup_sei ?? '-' }}</span></div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Prioridade Legal:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;color:#ea580c;font-weight:bold;">{{ $req?->prioridade_legal ?? 'Não se aplica' }}</span></div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Tipo de Requerimento:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->tipo_requerimento ?? $processo->tipo_requerimento ?? '-' }}</span></div>

    @if($req?->nome_representante)
    <div style="margin-top:16px; padding-top:16px; border-top:1px dashed #cbd5e1;">
        <div style="font-size:0.85rem; font-weight:700; color:#1e3a5f; margin-bottom:10px;">Representante Legal</div>
        <div style="display:flex;flex-direction:column;">
            <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Nome:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->nome_representante ?? '-' }}</span></div>
            <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">CPF/CNPJ do Representante:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->cpf_cnpj_representante ?? '-' }}</span></div>
            <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Telefone do Representante:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->contato_representante ?? '-' }}</span></div>
        </div>
    </div>
    @endif
    
    <div style="margin-top:16px; padding-top:16px; border-top:1px dashed #cbd5e1; margin-bottom: 10px;">
        <div style="font-size:0.85rem; font-weight:700; color:#1e3a5f; margin-bottom:10px;">Conceituação do Imóvel</div>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:240px;font-weight:600;color:#334155;">Conceituação do Imóvel:</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $dados1['conceituacao_imovel'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:240px;font-weight:600;color:#334155;">É Resposta a uma Devolução?</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $dados1['resposta_devolucao'] ?? '-' }}</span>
    </div>
    <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;">
        <span style="width:240px;font-weight:600;color:#334155;">Criação de novos RIPs?</span>
        <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $dados1['solicitacao_criacao_rip'] ?? '-' }}</span>
    </div>
</div>
