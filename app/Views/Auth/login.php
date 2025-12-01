<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AKUNTANSI WEB</title>
    <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/@fortawesome/fontawesome-free/css/all.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 50%, #004085 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background Elements */
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -250px;
            right: -250px;
            animation: float 20s infinite ease-in-out;
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            bottom: -200px;
            left: -200px;
            animation: float 15s infinite ease-in-out reverse;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            50% {
                transform: translate(30px, 30px) rotate(180deg);
            }
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 450px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .login-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.4);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .login-icon i {
            font-size: 40px;
            color: #ffffff;
        }

        .login-title {
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .login-subtitle {
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }

        .form-check {
            margin-bottom: 25px;
        }

        .form-check-label {
            color: #555;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            border-radius: 10px;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.5);
            background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            margin-top: 30px;
            text-align: center;
            padding-top: 25px;
            border-top: 1px solid #e0e0e0;
        }

        .login-footer a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .login-footer a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .login-footer p {
            margin-bottom: 10px;
            color: #666;
        }

        .alert {
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: none;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert ul {
            margin-bottom: 0;
            padding-left: 20px;
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 16px;
        }

        .input-icon .form-control {
            padding-left: 45px;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 30px 20px;
            }

            .login-title {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-icon">
                    <i class="fas fa-calculator"></i>
                </div>
                <h1 class="login-title">AKUNTANSI WEB</h1>
                <p class="login-subtitle">Sistem Informasi Akuntansi - AKN<br>Sekolah Vokasi IPB</p>
            </div>

            <?= view('Myth\Auth\Views\_message_block') ?>

            <form action="<?= url_to('login') ?>" method="post">
                <?= csrf_field() ?>

                <?php if ($config->validFields === ['email']): ?>
                    <div class="form-group">
                        <label for="login">
                            <i class="fas fa-envelope"></i> <?=lang('Auth.email')?>
                        </label>
                        <div class="input-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" 
                                   class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" 
                                   name="login" 
                                   id="login"
                                   placeholder="<?=lang('Auth.email')?>"
                                   required>
                        </div>
                        <div class="invalid-feedback">
                            <?= session('errors.login') ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="form-group">
                        <label for="login">
                            <i class="fas fa-user"></i> <?=lang('Auth.emailOrUsername')?>
                        </label>
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" 
                                   class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" 
                                   name="login" 
                                   id="login"
                                   placeholder="<?=lang('Auth.emailOrUsername')?>"
                                   required>
                        </div>
                        <div class="invalid-feedback">
                            <?= session('errors.login') ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> <?=lang('Auth.password')?>
                    </label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               name="password" 
                               id="password"
                               class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" 
                               placeholder="<?=lang('Auth.password')?>"
                               required>
                    </div>
                    <div class="invalid-feedback">
                        <?= session('errors.password') ?>
                    </div>
                </div>

                <?php if ($config->allowRemembering): ?>
                    <div class="form-check">
                        <input type="checkbox" 
                               name="remember" 
                               class="form-check-input" 
                               id="remember"
                               <?php if (old('remember')) : ?> checked <?php endif ?>>
                        <label class="form-check-label" for="remember">
                            <?=lang('Auth.rememberMe')?>
                        </label>
                    </div>
                <?php endif; ?>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> <?=lang('Auth.loginAction')?>
                </button>
            </form>

            <div class="login-footer">
                <?php if ($config->allowRegistration) : ?>
                    <p><a href="<?= url_to('register') ?>"><?=lang('Auth.needAnAccount')?></a></p>
                <?php endif; ?>
                <?php if ($config->activeResetter): ?>
                    <p><a href="<?= url_to('forgot') ?>"><?=lang('Auth.forgotYourPassword')?></a></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>

