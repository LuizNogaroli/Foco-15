<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestão SPU - FOCO</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles-forms.css') }}">
    <style>
        .active-tab {
            background-color: #cbd5e1 !important;
            color: #1e293b !important;
            border-color: #94a3b8 !important;
            transform: scale(1.1);
        }
    </style>
    <script>
        window.SUPABASE_URL = "https://rzdmnzuweyzhilfcungl.supabase.co";
        window.SUPABASE_ANON_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InJ6ZG1uenV3ZXl6aGlsZmN1bmdsIiwicm9sZSI6ImFub24iLCJpYXQiOjE3ODE4NTk5NTcsImV4cCI6MjA5NzQzNTk1N30.IqRxw3n2c-zNCccbgOUfh7wLy8eNnOVKJzwa8AsoSnU";
        window.CURRENT_PROCESS_ID = "{{ $processo->numero_requerimento }}";
        localStorage.setItem('CURRENT_PROCESS_ID', '{{ $processo->numero_requerimento }}');
    </script>
    <style>
        .circle-btn.preenchida {
            background-color: #64748b !important;
            color: #fff !important;
            border-color: #475569 !important;
        }
    </style>
</head>
<body style="background: #f1f5f9;">

<main style="padding-top: 20px;">
    @if(session('success'))
        <div id="toast-success" style="position: fixed; top: 30px; left: 50%; transform: translateX(-50%); background-color: #dcfce7; color: #166534; padding: 16px 32px; border-radius: 8px; text-align: center; font-weight: bold; border: 1px solid #22c55e; box-shadow: 0 10px 25px rgba(0,0,0,0.1); z-index: 9999; font-size: 1.1rem; display: flex; align-items: center; gap: 10px; transition: opacity 0.5s ease;">
            <span style="font-size: 1.3rem;">✔</span> {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('toast-success');
                if (toast) {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 500);
                }
            }, 4000);
        </script>
    @endif

    @if($errors->any())
        <div style="background-color: #fee2e2; color: #991b1b; padding: 15px; margin: 20px auto; border-radius: 5px; max-width: 800px; border: 1px solid #ef4444;">
            <strong>Atenção:</strong>
            <ul style="margin-top: 8px; margin-bottom: 0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    
    <div class="main-content">

        @if ($aba == 1)
            @include('processos.abas.aba1', ['processo' => $processo, 'dados' => $dados, 'requerimento' => $requerimento ?? null])
        @elseif ($aba == 2)
            @include('processos.abas.aba2', ['processo' => $processo, 'dados' => $dados, 'requerimento' => $requerimento ?? null])
        @elseif ($aba == 3)
            @include('processos.abas.aba3', ['processo' => $processo, 'dados' => $dados, 'requerimento' => $requerimento ?? null])
        @elseif ($aba == 7)
            @include('processos.abas.aba7', ['processo' => $processo, 'dados' => $dados])
        @else
            <div style="text-align: center; padding: 50px; background: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <h2 style="color: #64748b;">Em breve</h2>
                <p>A aba {{ $aba }} ainda não foi migrada para o sistema.</p>
            </div>
        @endif
    </div>

</main>

<script>
    var ProcessoID = {{ $processo->id }};
    var AbaAtual = {{ $aba }};

    function toggleAccordion(header) {
        const content = header.nextElementSibling;
        const icon = header.querySelector('.accordion-icon');
        if (content) {
            const isCollapsed = content.classList.contains('collapsed');

            if (isCollapsed) {
                content.classList.remove('collapsed');
                content.style.display = 'block';
            } else {
                content.classList.add('collapsed');
                content.style.display = 'none';
            }

            if (icon) {
                icon.style.transform = isCollapsed ? 'rotate(180deg)' : 'rotate(0deg)';
            }
            header.classList.toggle('active', !isCollapsed);
        }
    }
</script>

<script src="{{ asset('js/db.js') }}"></script>
<script src="{{ asset('js/fetch_spu.js') }}"></script>
<script src="{{ asset('js/custom-select.js') }}"></script>
<script src="{{ asset('js/formulario.js') }}"></script>
<script src="{{ asset('js/hints.js') }}"></script>
@if ($aba == 1)
    <script src="{{ asset('js/foco-01.js') }}?v=20260720_02"></script>
@elseif ($aba == 2)
    <script src="{{ asset('js/foco-02-v2.js') }}"></script>
@elseif ($aba == 3)
    <!-- JS da Aba 3 está embutido no próprio aba3.blade.php -->
@elseif ($aba == 7)
    <script src="{{ asset('js/foco-07.js') }}"></script>
@endif

</body>
</html>
