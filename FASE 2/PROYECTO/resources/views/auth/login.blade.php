@extends('layouts.app', ['title' => 'Iniciar sesión | Almapan', 'bodyClass' => 'auth-page'])

@section('content')
    <main class="login-shell">
        <section class="login-visual" aria-label="Identidad de Almapan">
            <img class="login-visual-backdrop" src="{{ asset('images/login/almapan-background.svg') }}" alt="">
            <div class="login-wordmark">
                <svg class="login-wordmark-wheat" viewBox="0 0 84 54" aria-hidden="true" focusable="false">
                    <defs>
                        <linearGradient id="login-wheat-gold" x1="0" y1="0" x2="0.5" y2="1">
                            <stop stop-color="#fff1ad"/>
                            <stop offset=".6" stop-color="#ffca52"/>
                            <stop offset="1" stop-color="#ee9524"/>
                        </linearGradient>
                    </defs>
                    <path fill="url(#login-wheat-gold)" d="M42 1c13 15 14 35 0 51C28 36 29 16 42 1ZM1 24c19 1 29 10 33 28C16 51 5 42 1 24Zm82 0c-19 1-29 10-33 28 18-1 29-10 33-28Z"/>
                    <path d="M42 49c-3-15-3-25-1-38M31 50C22 40 14 34 6 30m47 20c9-10 17-16 25-20" fill="none" stroke="#ffe7a1" stroke-width="1.2" stroke-linecap="round" opacity=".65"/>
                </svg>
                <h1>Almapan</h1>
                <svg class="login-wordmark-underline" viewBox="0 0 300 31" aria-hidden="true" focusable="false">
                    <path fill="url(#login-wheat-gold)" d="M0 30C79-26 219 33 300 0 235 49 108-9 0 30Z"/>
                </svg>
            </div>
            <img class="login-marraqueta" src="{{ asset('images/login/marraqueta.webp') }}" width="840" height="578" alt="">
        </section>

        <section class="login-panel" aria-labelledby="login-title">
            <div class="login-card">
                <div class="login-heading">
                    <h2 id="login-title">Bienvenido de vuelta</h2>
                    <p>Ingresa para continuar con tu jornada.</p>
                </div>

                @if (session('permission_session_notice'))
                    <div class="form-alert" role="alert">{{ session('permission_session_notice') }}</div>
                @endif

                @if ($errors->any())
                    <div class="form-alert" role="alert" aria-live="polite">
                        Revisa los datos ingresados para continuar.
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" class="login-form" autocomplete="off" data-login-form>
                    @csrf

                    <div class="field-group">
                        <label for="nombre_usuario">Nombre de usuario</label>
                        <input
                            id="nombre_usuario"
                            name="nombre_usuario"
                            type="text"
                            value="{{ old('nombre_usuario') }}"
                            autocomplete="off"
                            autocapitalize="none"
                            spellcheck="false"
                            required
                            autofocus
                            @class(['form-input', 'is-invalid' => $errors->has('nombre_usuario')])
                            @if ($errors->has('nombre_usuario')) aria-describedby="nombre_usuario-error" @endif
                        >
                        @error('nombre_usuario')
                            <p id="nombre_usuario-error" class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label for="password">Contraseña</label>
                        <div class="password-field">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                value=""
                                autocomplete="off"
                                required
                                @class(['form-input', 'is-invalid' => $errors->has('password')])
                                @if ($errors->has('password')) aria-describedby="password-error" @endif
                            >
                            <button
                                type="button"
                                class="password-toggle"
                                data-password-toggle
                                aria-label="Mostrar contraseña"
                                aria-controls="password"
                                aria-pressed="false"
                            >
                                <svg class="login-password-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true" focusable="false">
                                    <path d="M2 12s3.6-6.5 10-6.5S22 12 22 12s-3.6 6.5-10 6.5S2 12 2 12Z"/>
                                    <circle cx="12" cy="12" r="2.7"/>
                                </svg>
                                <span data-toggle-label>Mostrar</span>
                            </button>
                        </div>
                        @error('password')
                            <p id="password-error" class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="primary-button">Iniciar sesión</button>
                </form>

                <p class="login-note">Usa las credenciales entregadas por el administrador.</p>
            </div>
        </section>
    </main>
@endsection
