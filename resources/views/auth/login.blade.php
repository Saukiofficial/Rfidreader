<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            width: 100%;
        }

        .login-container {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            width: 100vw;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #06b6d4 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 30%, rgba(59, 130, 246, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(6, 182, 212, 0.3) 0%, transparent 50%);
        }

        .login-card-wrapper {
            background: white;
            border-radius: 24px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            display: flex;
            min-height: 600px;
            position: relative;
            z-index: 1;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .welcome-section {
            flex: 1;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #06b6d4 100%);
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 2px,
                rgba(255, 255, 255, 0.05) 2px,
                rgba(255, 255, 255, 0.05) 4px
            );
            animation: movePattern 20s linear infinite;
        }

        @keyframes movePattern {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .school-logo {
            width: 60px;
            height: 60px;
            margin-bottom: 40px;
            position: relative;
            z-index: 2;
            animation: logoFloat 3s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        .school-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 8px;
            filter: brightness(0) invert(1);
        }

        .welcome-title {
            color: white;
            font-size: 42px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .welcome-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 40px;
            position: relative;
            z-index: 2;
        }

        .view-more-btn {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 2;
            width: fit-content;
        }

        .view-more-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .login-section {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #f8fafc;
        }

        .login-title {
            color: #1e293b;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            text-align: center;
        }

        .login-subtitle {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 40px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-label {
            display: block;
            color: #374151;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
            outline: none;
            font-family: inherit;
        }

        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-input::placeholder {
            color: #9ca3af;
            font-size: 14px;
        }

        .input-error {
            color: #ef4444;
            font-size: 12px;
            margin-top: 6px;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 24px 0;
        }

        .remember-container {
            display: flex;
            align-items: center;
        }

        .remember-checkbox {
            width: 18px;
            height: 18px;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            margin-right: 8px;
            accent-color: #3b82f6;
        }

        .remember-label {
            color: #6b7280;
            font-size: 14px;
            cursor: pointer;
            user-select: none;
        }

        .forgot-link {
            color: #3b82f6;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: #2563eb;
        }

        .login-button {
            width: 100%;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
            margin-bottom: 24px;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.6);
        }

        .signup-section {
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }

        .signup-link {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            display: inline-block;
            margin-top: 8px;
            transition: transform 0.3s ease;
        }

        .signup-link:hover {
            transform: translateY(-1px);
        }

        .status-message {
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .login-card-wrapper {
                flex-direction: column;
                max-width: 400px;
                min-height: auto;
            }

            .welcome-section {
                padding: 40px 30px;
                text-align: center;
            }

            .welcome-title {
                font-size: 28px;
            }

            .login-section {
                padding: 40px 30px;
            }

            .form-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card-wrapper">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <div class="school-logo">
                    <img src="{{ asset('images/logo-smk-mahardhika.png') }}" alt="SMK Mahardhika Logo">
                </div>
                <h1 class="welcome-title">Hello,<br>welcome!</h1>
                <p class="welcome-subtitle">Sistem Informasi Absensi Siswa SMK Mahardhika. Kelola kehadiran siswa dengan mudah dan efisien.</p>
                <button class="view-more-btn" onclick="window.open('#', '_blank')">View more</button>
            </div>

            <!-- Login Section -->
            <div class="login-section">
                <h2 class="login-title">Welcome To Absensi<br>SMK MAHARDHIKA</h2>
                <p class="login-subtitle">Sistem Informasi Absensi Siswa</p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="status-message">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email address</label>
                        <input id="email"
                               class="form-input"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="name@mail.com"
                               required
                               autofocus
                               autocomplete="username" />
                        @if ($errors->get('email'))
                            <div class="input-error">
                                @foreach ($errors->get('email') as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input id="password"
                               class="form-input"
                               type="password"
                               name="password"
                               placeholder="••••••••••••"
                               required
                               autocomplete="current-password" />
                        @if ($errors->get('password'))
                            <div class="input-error">
                                @foreach ($errors->get('password') as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="form-row">
                        <!-- Remember Me -->
                        <div class="remember-container">
                            <input id="remember_me"
                                   type="checkbox"
                                   class="remember-checkbox"
                                   name="remember">
                            <label for="remember_me" class="remember-label">
                                {{ __('Remember me') }}
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="login-button">
                        {{ __('Login') }}
                    </button>

                    <div class="signup-section">
                        <p>Not a member yet?</p>
                        <a href="#" class="signup-link">Sign up</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
