<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckIn on the Fly</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">CheckIn on the Fly</a>
            <div class="d-flex">
                <a href="{{ route('login') }}" class="btn btn-outline-light me-2">{{ __('Dashboard') }}</a>
                <a href="{{ route('register') }}" class="btn btn-primary">{{ __('Criar Conta') }}</a>
            </div>
        </div>
    </nav>

    <header class="py-5 bg-light border-bottom mb-4">
        <div class="container text-center my-5">
            <h1 class="display-3 fw-bold">Gestão de Eventos <span class="text-primary">On the Fly</span></h1>
            {{-- A solução completa para gestão de inscrições, validação de presenças e análise de CRM --}}
            {{-- Plataforma integrada para gestão de participantes, check-in por QR Code e acompanhamento automatizado. --}}
            <p class="lead">{{ __('A solução completa para check-in digital, móvel e gestão de clientes (CRM)') }}</p>
        </div>
    </header>

    <!-- Showcase -->
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0 bg-dark text-white p-4">
                    <h3>{{ __('Dashboard Inteligente') }}</h3>
                    <p>{{ __('Controle todos os seus eventos num único lugar com métricas em tempo real.') }}</p>
                    <img src="{{ asset('images/stock_forest.jpg') }}" class="img-fluid rounded">
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0 p-4">
                    <h3>{{ __('Check-in Rápido') }}</h3>
                    <p>{{ __('Valide entradas na porta através do scanner de QR Code em qualquer dispositivo.') }}</p>
                    <img src="{{ asset('images/stock_forest.jpg') }}" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>

    <!-- Features Showcase (Side by Side) -->
    <section class="py-5">
        <div class="container">
            <!-- Feature 1 -->
            <div class="row align-items-center mb-5">
                <div class="col-md-6">
                    <h2 class="fw-bold">Gestão Multitenant <span class="text-primary">Total</span></h2>
                    <p class="lead">{{ __('Crie a sua própria organização e gira múltiplos eventos de forma independente. Ideal para empresas de eventos ou instituições académicas.') }}</p>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-check-circle-fill text-primary"></i> {{ __('Isolamento total de dados entre organizadores.') }}</li>
                        <li><i class="bi bi-check-circle-fill text-primary"></i> {{ __('Convide a sua equipa e atribua papéis (Organizador/Scan Only).') }}</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('images/stock_forest.jpg') }}" class="img-fluid rounded shadow-lg" alt="Dashboard">
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="row align-items-center mb-5 flex-md-row-reverse">
                <div class="col-md-6 text-md-end">
                    <h2 class="fw-bold">Marketing <span class="text-primary">Multicanal</span></h2>
                    <p class="lead">{{ __('Mantenha os seus participantes informados. Envie lembretes automáticos e o QR Code via E-mail ou WhatsApp (Twilio Integration).') }}</p>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-check-circle-fill text-primary"></i> {{ __('Agendamento de lembretes (customizáveis).') }}</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('images/stock_forest.jpg') }}" class="img-fluid rounded shadow-lg" alt="Marketing">
                </div>
            </div>
        </div>
    </section>

    <!-- Landing Page Examples -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Adaptável a qualquer <span class="text-primary">Cenário</span></h2>
                <p class="text-muted">{{ __('A nossa template dinâmica ajusta-se ao tema do seu evento.')}}</p>
            </div>
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <img src="{{ asset('images/stock_forest.jpg') }}" class="card-img-top" alt="Conferência">
                        <div class="card-body">
                            <h5>{{ __('Conferências Tech') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <img src="{{ asset('images/stock_forest.jpg') }}" class="card-img-top" alt="Workshops">
                        <div class="card-body">
                            <h5>{{ __('Workshops Académicos') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <img src="{{ asset('images/stock_forest.jpg') }}" class="card-img-top" alt="Festivais">
                        <div class="card-body">
                            <h5>{{ __('Festivais e Lazer') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">Perguntas Frequentes</h2>
            <div class="accordion shadow-sm" id="faqAccordion">
                <!-- FAQ Item 1 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            O CheckIn on the Fly é gratuito?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Sim, o projeto foi desenvolvido num contexto académico (IPLeiria) e está disponível em código aberto no GitHub.
                        </div>
                    </div>
                </div>
                <!-- FAQ Item 2 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            Como funciona o envio via WhatsApp?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Utilizamos a API oficial do Twilio. ...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 bg-dark text-white-50">
        <div class="container text-center">
            <div class="mb-4 d-flex justify-content-center align-items-center gap-3 flex-wrap">
            <a href="https://github.com/checkin-fly-team/checkin-on-the-fly" class="text-white">
                <i class="bi bi-github"></i> GitHub
            </a>

            <a href="https://www.ipleiria.pt/estg/" class="text-white d-flex align-items-center">
                <img src="{{ asset('images/ipleiria_estg.webp') }}" alt="IPLeiria" style="height:20px;" class="me-2">
                IPLeiria
            </a>
        </div>
            <small>&copy; 2025/26 - {{ __('Desenvolvido para a unidade curricular de Projeto Informático.') }}</small>
        </div>
    </footer>
</body>
</html>