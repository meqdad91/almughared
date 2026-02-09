<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>{{ config('app.name', 'Al Mughared') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

            body {
                font-family: 'Inter', 'Segoe UI', sans-serif;
                min-height: 100vh;
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                overflow-x: hidden;
            }

            .guest-wrapper {
                width: 100%;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem 1rem;
                position: relative;
            }

            /* Decorative background elements */
            .guest-wrapper::before {
                content: '';
                position: absolute;
                top: -200px;
                right: -200px;
                width: 500px;
                height: 500px;
                background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 70%);
                border-radius: 50%;
                pointer-events: none;
            }

            .guest-wrapper::after {
                content: '';
                position: absolute;
                bottom: -150px;
                left: -150px;
                width: 400px;
                height: 400px;
                background: radial-gradient(circle, rgba(139, 92, 246, 0.1) 0%, transparent 70%);
                border-radius: 50%;
                pointer-events: none;
            }

            .guest-container {
                width: 100%;
                max-width: 480px;
                position: relative;
                z-index: 1;
            }

            .logo-section {
                text-align: center;
                margin-bottom: 2rem;
            }

            .logo-section a {
                text-decoration: none;
                display: inline-block;
            }

            .logo-text {
                font-size: 2.5rem;
                font-weight: 800;
                background: linear-gradient(135deg, #818cf8, #a78bfa, #c084fc);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                letter-spacing: -1px;
            }

            .logo-subtitle {
                color: #94a3b8;
                font-size: 0.9rem;
                margin-top: 0.25rem;
                font-weight: 400;
            }

            .guest-card {
                background: rgba(30, 41, 59, 0.8);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(148, 163, 184, 0.1);
                border-radius: 1.25rem;
                padding: 2.5rem;
                box-shadow:
                    0 25px 50px -12px rgba(0, 0, 0, 0.4),
                    0 0 0 1px rgba(148, 163, 184, 0.05);
            }

            @media (max-width: 480px) {
                .guest-card {
                    padding: 2rem 1.5rem;
                    border-radius: 1rem;
                }
                .logo-text {
                    font-size: 2rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="guest-wrapper">
            <div class="guest-container">
                <div class="logo-section">
                    <a href="/">
                        <div class="logo-text">Al Mughared</div>
                        <div class="logo-subtitle">Training Management Platform</div>
                    </a>
                </div>

                <div class="guest-card">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
