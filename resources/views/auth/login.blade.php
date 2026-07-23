<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SPUnet - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #1a4a7a 100%);
            overflow: hidden;
        }

        .login-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            color: white;
            position: relative;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 1;
        }

        .brand-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 480px;
            margin-bottom: 40px;
        }

        .brand-logo {
            font-size: 3.2rem;
            font-weight: 800;
            letter-spacing: -2px;
            margin-bottom: 8px;
        }

        .brand-logo .spu { color: #ffffff; }
        .brand-logo .net { color: #4ade80; }

        .brand-divider {
            width: 60px;
            height: 3px;
            background: #4ade80;
            margin: 20px auto;
            border-radius: 2px;
        }

        .brand-subtitle {
            font-size: 1.3rem;
            font-weight: 500;
            color: #cbd5e1;
            letter-spacing: 0.5px;
        }

        .brand-module {
            font-size: 1.05rem;
            font-weight: 400;
            color: #94a3b8;
            margin-top: 12px;
            line-height: 1.5;
        }

        .brand-footer {
            position: absolute;
            bottom: 30px;
            left: 0;
            right: 0;
            text-align: center;
            color: #475569;
            font-size: 0.8rem;
            z-index: 1;
        }

        /* Formulário de login */
        .login-form-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 400px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 36px;
            border: 1px solid rgba(255,255,255,0.15);
        }

        .login-header {
            text-align: center;
            margin-bottom: 28px;
            width: 100%;
        }

        .login-header h2 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 6px;
        }

        .login-header p {
            font-size: 0.85rem;
            color: #cbd5e1;
        }

        .form-group {
            margin-bottom: 18px;
            width: 100%;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #e2e8f0;
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: inherit;
            color: #ffffff;
            background: rgba(255,255,255,0.1);
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .form-group input:focus {
            border-color: #4ade80;
            box-shadow: 0 0 0 3px rgba(74,222,128,0.2);
            background: rgba(255,255,255,0.15);
        }

        .form-group input::placeholder {
            color: #94a3b8;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .form-check input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #4ade80;
            cursor: pointer;
        }

        .form-check label {
            font-size: 0.85rem;
            color: #cbd5e1;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: #4ade80;
            color: #0f172a;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s, box-shadow 0.2s;
            letter-spacing: 0.3px;
        }

        .btn-login:hover {
            background: #22c55e;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(74,222,128,0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .forgot-link {
            display: block;
            text-align: center;
            margin-top: 16px;
            font-size: 0.85rem;
        }

        .forgot-link a {
            color: #4ade80;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.3);
            color: #fca5a5;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 18px;
            text-align: center;
        }

        @media (max-width: 600px) {
            .login-container { padding: 30px 20px; }
            .login-form-wrapper { padding: 24px; }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="brand-content">
            <div class="brand-logo">
                <span class="spu">SPU</span><span class="net">net</span>
            </div>
            <div class="brand-divider"></div>
            <div class="brand-subtitle">Sistema de Gestão do Patrimônio da União</div>
            <div class="brand-module">Módulo de Instrução Processual</div>
        </div>

        <div class="login-form-wrapper">
            <div class="login-header">
                <h2>Entrar no sistema</h2>
                <p>Use seu e-mail ou CPF para acessar</p>
            </div>

            @if ($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">E-mail ou CPF</label>
                    <input
                        type="text"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nome@spu.gov.br ou 000.000.000-00"
                        required
                        autofocus
                        autocomplete="username"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Senha</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Digite sua senha"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <div class="form-check">
                    <input type="checkbox" id="remember_me" name="remember">
                    <label for="remember_me">Lembrar-me</label>
                </div>

                <button type="submit" class="btn-login">Entrar</button>

                @if (Route::has('password.request'))
                    <div class="forgot-link">
                        <a href="{{ route('password.request') }}">Esqueceu sua senha?</a>
                    </div>
                @endif
            </form>
        </div>

        <div class="brand-footer">
            Secretaria do Patrimônio da União — Ministério da Gestão e da Inovação em Serviços Públicos
        </div>
    </div>

</body>
</html>
