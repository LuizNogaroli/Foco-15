path = r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\resources\views\processos\abas\aba3.blade.php'

with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

target = """<div class="form-container">
  <h2>Análise de Viabilidade e Proposta de Destinação</h2>
  @php
      $simuladoCookie = request()->cookie('perfil_simulado');
      $user = auth()->user();
      $isAdmin = $user && ($user->hasRole('Administrador') || $user->hasRole('Direção'));
      
      $canEditAba3 = false;
      if ($simuladoCookie === 'ALL' || $simuladoCookie === 'DESTINACAO') {
          $canEditAba3 = true;
      } elseif (!$simuladoCookie && $isAdmin) {
          $canEditAba3 = true;
      } elseif ($user && $user->hasRole('Equipe Destinação')) {
          $canEditAba3 = true;
      }
  @endphp
  <fieldset @if(!$canEditAba3) disabled @endif>
    <form method="POST" action="{{ route('processos.tramitar', $processo->id) }}" id="form03">
        @csrf
        <input type="hidden" name="aba_atual" value="3">
        <input type="hidden" name="next_aba" value="index">
        <!-- ========== ACCORDIONS DE REVISÃO (ABAS 1 E 2) ========== -->"""

replacement = """<div class="form-container">
  <h2>Análise de Viabilidade e Proposta de Destinação</h2>
  <form method="POST" action="{{ route('processos.tramitar', $processo->id) }}" id="form03">
      @csrf
      <input type="hidden" name="aba_atual" value="3">
      <input type="hidden" name="next_aba" value="index">
      <!-- ========== ACCORDIONS DE REVISÃO (ABAS 1 E 2) ========== -->"""

target_after_accordions = """        </div>
        <!-- ========================================================= -->"""

replacement_after_accordions = """        </div>
        <!-- ========================================================= -->

  @php
      $simuladoCookie = request()->cookie('perfil_simulado');
      $user = auth()->user();
      $isAdmin = $user && ($user->hasRole('Administrador') || $user->hasRole('Direção'));
      
      $canEditAba3 = false;
      if ($simuladoCookie === 'ALL' || $simuladoCookie === 'DESTINACAO') {
          $canEditAba3 = true;
      } elseif (!$simuladoCookie && $isAdmin) {
          $canEditAba3 = true;
      } elseif ($user && $user->hasRole('Equipe Destinação')) {
          $canEditAba3 = true;
      }
  @endphp
  <fieldset @if(!$canEditAba3) disabled @endif>"""

if target in content and target_after_accordions in content:
    content = content.replace(target, replacement)
    content = content.replace(target_after_accordions, replacement_after_accordions)
    with open(path, 'w', encoding='utf-8') as f:
        f.write(content)
    print('Successfully updated aba3.blade.php accordions')
else:
    print('Targets not found in aba3.blade.php')
