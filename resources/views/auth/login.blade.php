
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iniciar sesión | Meraki Signature</title>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #BD8980;
            --primary-dark: #A96F68;
            --rose: #F7E9E8;
            --champagne: #D5B69C;
            --ivory: #FBF9F7;
            --text: #55464A;
            --muted: #9C8D91;
            --border: #EFE6E5;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            background: var(--ivory);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
        }

        /* Panel de identidad */
        .brand-panel {
            width: 48%;
            background: linear-gradient(
                145deg,
                #F7E9E8 0%,
                #F1DEDA 55%,
                #E8D0C8 100%
            );
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }

        .brand-panel::before {
            content: "";
            position: absolute;
            width: 420px;
            height: 420px;
            border: 1px solid rgba(255,255,255,.6);
            border-radius: 50%;
            top: -180px;
            right: -170px;
        }

        .brand-panel::after {
            content: "";
            position: absolute;
            width: 350px;
            height: 350px;
            border: 1px solid rgba(255,255,255,.5);
            border-radius: 50%;
            bottom: -170px;
            left: -130px;
        }

        .brand-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 430px;
        }

        .brand-logo {
            width: min(100%, 320px);
            height: auto;
            margin-bottom: 35px;
        }

        .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 500;
            line-height: 1.3;
            margin-bottom: 18px;
        }

        .brand-description {
            color: #816F73;
            font-size: 14px;
            line-height: 1.9;
        }

        .brand-line {
            width: 55px;
            height: 2px;
            background: var(--champagne);
            margin: 28px auto;
        }

        /* Panel de acceso */
        .form-panel {
            width: 52%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 35px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
        }

        .eyebrow {
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 11px;
            color: var(--primary-dark);
            font-weight: 700;
            margin-bottom: 14px;
        }

        .login-title {
            font-family: 'Playfair Display', serif;
            font-size: 39px;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .login-subtitle {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.8;
            margin-bottom: 38px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 9px;
        }

        .form-control {
            padding: 13px 15px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: #fff;
            color: var(--text);
            font-size: 14px;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(189,137,128,.12);
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper .form-control {
            padding-right: 50px;
        }

        .toggle-password {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: var(--muted);
            cursor: pointer;
        }

        .remember-label {
            font-size: 13px;
            color: var(--muted);
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-login {
            width: 100%;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-size: 14px;
            font-weight: 600;
            transition: .2s;
        }

        .btn-login:hover {
            background: var(--primary-dark);
            color: white;
            transform: translateY(-1px);
        }

        .login-footer {
            margin-top: 45px;
            text-align: center;
            color: var(--muted);
            font-size: 12px;
        }

        @media (max-width: 850px) {
            .login-wrapper {
                flex-direction: column;
            }

            .brand-panel,
            .form-panel {
                width: 100%;
            }

            .brand-panel {
                padding: 35px 25px;
            }

            .brand-logo {
                max-width: 180px;
                margin-bottom: 10px;
            }

            .brand-title {
                font-size: 24px;
            }

            .brand-description,
            .brand-line {
                display: none;
            }

            .form-panel {
                padding: 45px 25px;
            }

            .login-title {
                font-size: 33px;
            }
        }
    </style>
</head>

<body>

<div class="login-wrapper">

    <!-- Identidad Meraki -->
    <section class="brand-panel">
        <div class="brand-content">

            <img
                src="{{ asset('images/meraki-logo.png') }}"
                alt="Meraki Estudio de Belleza"
                class="brand-logo"
            >

            <div class="brand-line"></div>

            <h2 class="brand-title">
                Belleza con esencia propia.
            </h2>

            <p class="brand-description">
                Un espacio creado para organizar tus ideas,
                cuidar cada detalle y hacer crecer
                lo que construyes con pasión.
            </p>

        </div>
    </section>

    <!-- Formulario -->
    <section class="form-panel">

        <div class="login-card">

            <div class="eyebrow">
                MERAKI SIGNATURE
            </div>

            <h1 class="login-title">
                ¡Hola, Pao!
            </h1>

            <p class="login-subtitle">
                Qué gusto tenerte de vuelta.
                Ingresa tus datos para acceder a tu espacio de trabajo.
            </p>

            @if ($errors->any())
                <div class="alert alert-danger rounded-3 small" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="username" class="form-label">
                        Nombre de usuario
                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="form-control"
                        placeholder="Ingresa tu nombre de usuario"
                        value="{{ old('username') }}"
                        autocomplete="username"
                        autocapitalize="none"
                        spellcheck="false"
                        required
                        autofocus
                    >
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        Contraseña
                    </label>

                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="Ingresa tu contraseña"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            id="togglePassword"
                            aria-label="Mostrar contraseña"
                            aria-pressed="false"
                        >
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="remember"
                        value="1"
                        id="remember"
                    >

                    <label class="form-check-label remember-label"
                           for="remember">
                        Recordar mi sesión
                    </label>
                </div>

                <button type="submit" class="btn-login">
                    Iniciar sesión
                    <i class="bi bi-arrow-right ms-2"></i>
                </button>

            </form>

            <div class="login-footer">
                Meraki Signature · Gestión de belleza
            </div>

        </div>

    </section>

</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function () {
        const isHidden = passwordInput.type === 'password';

        passwordInput.type = isHidden ? 'text' : 'password';

        eyeIcon.className = isHidden
            ? 'bi bi-eye-slash'
            : 'bi bi-eye';

        togglePassword.setAttribute(
            'aria-label',
            isHidden ? 'Ocultar contraseña' : 'Mostrar contraseña'
        );

        togglePassword.setAttribute(
            'aria-pressed',
            String(isHidden)
        );
    });
</script>

</body>
</html>
