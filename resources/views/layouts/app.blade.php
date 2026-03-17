<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'CheckIn on the Fly') }}</title>
    
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700,800" rel="stylesheet">
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body, .card, .login-card, .navbar, .form-control, .dropdown-menu, .btn {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        body {
            min-height: 100vh;
            background-color: var(--bs-body-bg);
            background-size: 40px 40px;
            background-position: 0 0, 20px 20px;
        }

        .login-card {
            background-color: var(--bs-secondary-bg); 
            border: 1px solid var(--bs-border-color);
            border-radius: 24px;
            max-width: 420px;
            width: 100%;
            padding: 3rem;
        }

        .form-control {
            background-color: var(--bs-body-bg);
            color: var(--bs-body-color);
            border: 1px solid var(--bs-border-color);
        }
        
        .form-control:focus {
            background-color: var(--bs-body-bg);
            color: var(--bs-body-color);
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md py-4">
            <div class="container px-4">
                <a class="navbar-brand fs-3 fw-bold link-body-emphasis text-decoration-none" href="{{ url('/') }}">
                    {{ config('app.name', 'CheckIn on the Fly') }}
                </a>

                <div class="d-flex align-items-center ms-auto">
                    <!-- Dark Mode Button -->
                    <button id="theme-toggle" class="btn btn-link link-body-emphasis me-4 fs-4 p-0 text-decoration-none shadow-none">
                        <i id="theme-icon" class="bi bi-moon"></i>
                    </button>

                    <!-- Authentication  -->
                    @guest
                        @if (Route::has('register'))
                            <a class="btn btn-dark rounded-3 px-4 py-2" id="signup-btn" href="{{ route('register') }}">
                                {{ __('Sign Up') }}
                            </a>
                        @endif
                    @else
                        <div class="dropdown">
                            <a id="navbarDropdown" class="btn btn-dark rounded-3 px-4 py-2 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>

        <main class="d-flex align-items-center justify-content-center" style="min-height: 75vh;">
            @yield('content')
        </main>
    </div>

    <!-- Dark Mode Logic -->
    <script>
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', savedTheme);

        window.addEventListener('DOMContentLoaded', () => {
            const themeToggle = document.getElementById('theme-toggle');
            const themeIcon = document.getElementById('theme-icon');
            const signupBtn = document.getElementById('signup-btn');

            function updateUI(theme) {
                if (theme === 'dark') {
                    themeIcon.className = 'bi bi-sun';
                    if(signupBtn) { signupBtn.classList.replace('btn-dark', 'btn-light'); }
                } else {
                    themeIcon.className = 'bi bi-moon';
                    if(signupBtn) { signupBtn.classList.replace('btn-light', 'btn-dark'); }
                }
            }

            updateUI(savedTheme);

            themeToggle.addEventListener('click', () => {
                const currentTheme = document.documentElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                document.documentElement.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                updateUI(newTheme);
            });
        });
    </script>
</body>
</html>