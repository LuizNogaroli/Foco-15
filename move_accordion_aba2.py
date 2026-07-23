path = r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\resources\views\processos\abas\aba2.blade.php'

with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

target = """    <h2>Diagnóstico Preliminar</h2>
    @php
        $simuladoCookie = request()->cookie('perfil_simulado');
        $user = auth()->user();
        $isAdmin = $user && ($user->hasRole('Administrador') || $user->hasRole('Direção'));
        
        $canEditAba2 = false;
        if ($simuladoCookie === 'ALL' || $simuladoCookie === 'CARACTERIZACAO') {
            $canEditAba2 = true;
        } elseif (!$simuladoCookie && $isAdmin) {
            $canEditAba2 = true;
        } elseif ($user && $user->hasRole('Equipe Caracterização')) {
            $canEditAba2 = true;
        }
    @endphp
    <fieldset @if(!$canEditAba2) disabled @endif>
    <form method="POST" action="{{ route('processos.tramitar', $processo->id) }}" id="form02">
        @csrf
        <input type="hidden" name="aba_atual" value="2">
        <input type="hidden" name="next_aba" value="index">
      <!-- ========== ACCORDION ABA 1 (SOMENTE LEITURA) ========== -->
      <div class="accordion-container" style="margin-bottom: 25px;">
        <div class="accordion-item" id="acc_aba1" style="border: 2px solid #1e3a5f;">
          <div class="accordion-header" style="background-color: #1e3a5f; color: white;" onclick="this.nextElementSibling.classList.toggle('active'); this.classList.toggle('active');">
            <span>📋 Indicação do Imóvel</span>
            <span class="accordion-icon" style="transition: transform 0.3s;">▼</span>
          </div>
          <div class="accordion-body" style="padding: 0;">
            <iframe src="{{ asset('foco-01-resumo.html') }}" title="Aba 1 (Indicação do Imóvel)" style="width: 100%; height: 72vh; min-height: 520px; border: none; display: block; background: #ffffff; border-radius: 0 0 8px 8px;"></iframe>
          </div>
        </div>
      </div>
      <!-- ======================================================= -->"""

replacement = """    <h2>Diagnóstico Preliminar</h2>

    <!-- ========== ACCORDION ABA 1 (SOMENTE LEITURA) ========== -->
    <div class="accordion-container" style="margin-bottom: 25px;">
      <div class="accordion-item" id="acc_aba1" style="border: 2px solid #1e3a5f;">
        <div class="accordion-header" style="background-color: #1e3a5f; color: white;" onclick="this.nextElementSibling.classList.toggle('active'); this.classList.toggle('active');">
          <span>📋 Indicação do Imóvel</span>
          <span class="accordion-icon" style="transition: transform 0.3s;">▼</span>
        </div>
        <div class="accordion-body" style="padding: 0;">
          <iframe src="{{ asset('foco-01-resumo.html') }}" title="Aba 1 (Indicação do Imóvel)" style="width: 100%; height: 72vh; min-height: 520px; border: none; display: block; background: #ffffff; border-radius: 0 0 8px 8px;"></iframe>
        </div>
      </div>
    </div>
    <!-- ======================================================= -->

    @php
        $simuladoCookie = request()->cookie('perfil_simulado');
        $user = auth()->user();
        $isAdmin = $user && ($user->hasRole('Administrador') || $user->hasRole('Direção'));
        
        $canEditAba2 = false;
        if ($simuladoCookie === 'ALL' || $simuladoCookie === 'CARACTERIZACAO') {
            $canEditAba2 = true;
        } elseif (!$simuladoCookie && $isAdmin) {
            $canEditAba2 = true;
        } elseif ($user && $user->hasRole('Equipe Caracterização')) {
            $canEditAba2 = true;
        }
    @endphp
    <fieldset @if(!$canEditAba2) disabled @endif>
    <form method="POST" action="{{ route('processos.tramitar', $processo->id) }}" id="form02">
        @csrf
        <input type="hidden" name="aba_atual" value="2">
        <input type="hidden" name="next_aba" value="index">"""

if target in content:
    content = content.replace(target, replacement)
    with open(path, 'w', encoding='utf-8') as f:
        f.write(content)
    print('Updated aba2.blade.php')
else:
    print('Target not found in aba2.blade.php')
