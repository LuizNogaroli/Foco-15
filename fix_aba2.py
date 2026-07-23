path = r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\resources\views\processos\abas\aba2.blade.php'

with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

target = """  .valor-original-hint {
      display: block;
      font-size: 11px;
      color: #64748b;
      <div class="accordion-container" style="margin-bottom: 25px;">"""

replacement = """  .valor-original-hint {
      display: block;
      font-size: 11px;
      color: #64748b;
      margin-top: 3px;
      font-style: italic;
  }
</style>
<div class="form-container">

    <h2>Diagnóstico Preliminar</h2>
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
      <div class="accordion-container" style="margin-bottom: 25px;">"""

if target in content:
    content = content.replace(target, replacement)
    with open(path, 'w', encoding='utf-8') as f:
        f.write(content)
    print('Successfully restored and updated aba2.blade.php')
else:
    print('Target string not found in aba2.blade.php')
