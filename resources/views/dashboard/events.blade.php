@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-lg-row align-items-stretch align-items-lg-center justify-content-between mb-5 gap-3">
        <div class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center gap-3">
            <!-- Search -->
            <form action="{{ route('dashboard') }}" method="GET" style="width: 100%; max-width: 400px;" class="mb-0" >
                <div class="position-relative">
                    <i class="bi bi-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--bs-secondary-color);"></i>
                    
                    <input type="text" name="search" value="{{ request('search') }}" 
                        class="form-control form-control-lg shadow-sm search-bar-custom" 
                        placeholder="Pesquisar evento..." 
                        style="padding-left: 45px; border-radius: 12px; height: 48px;">
                    
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                </div>
            </form>

            <!-- Status Filter -->
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle rounded-pill px-4 shadow-sm border-0 d-flex align-items-center justify-content-between w-100 w-md-auto" 
                        type="button" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                        style="background-color: #6c757d; color: white; height: 48px; min-width: 180px;">
                    <span>{{ request('status') ? ucfirst(request('status')) : 'Selecionar Estado' }}</span>
                </button>
                
                <ul class="dropdown-menu border-0 shadow-lg mt-2 w-100 w-md-auto" aria-labelledby="statusDropdown">
                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">Todos</a></li>
                    <li><hr class="dropdown-divider"></li>
                    @foreach(['upcoming', 'ongoing', 'complete', 'cancelled'] as $s)
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('dashboard', ['status' => $s]) }}">
                                <span class="status-dot status-{{ $s }} me-2"></span>
                                {{ ucfirst($s) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Create Event -->
        <div class="ms-lg-auto d-flex align-items-center">
            <a href="{{ route('events.index') }}" 
            class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm d-inline-flex align-items-center justify-content-center w-100 w-lg-auto" 
            style="background-color: #6c757d; border: none; color: white; font-weight: 600; height: 48px; white-space: nowrap;">
                Criar evento
            </a>
        </div>
    </div>

    <!-- Status Filter Alternative -->
    <div class="d-flex gap-2 mb-5 flex-wrap">
        <a href="{{ route('dashboard') }}" 
            class="filter-badge bg-all {{ !request('status') ? 'active-filter' : '' }}">
            Todos
        </a>
        @foreach(['upcoming', 'ongoing', 'complete', 'cancelled'] as $s)
            <a href="{{ route('dashboard', ['status' => $s, 'search' => request('search')]) }}" 
            class="filter-badge status-{{ $s }} {{ request('status') == $s ? 'active-filter' : '' }}">
            {{ ucfirst($s) }}
            </a>
        @endforeach
    </div>





    <!-- My Events Section -->
    <div class="mb-5">
        <div class="d-flex align-items-center mb-4">
            <h5 class="fw-bold mb-0">Os meus eventos</h5>
            <span class="badge badge-theme-invert ms-2 shadow-sm">{{ count($myEvents) }}</span>
        </div>
        
        <div class="row g-4">
            @forelse($myEvents as $event)
                <div class="col-md-4 col-lg-3">
                    <a href="{{ route('events.information.index', $event->id) }}" class="card event-card h-100 shadow-sm position-relative">
                        {{-- SaaS Pill --}}
                        {{-- <div class="status-badge status-{{ $event->status }}">
                            {{ $event->status }}
                        </div> --}}

                        {{-- Glassmorphism Tag --}}
                        {{-- <div class="status-glass status-{{ $event->status }}">
                            {{ ucfirst($event->status) }}
                        </div> --}}

                        {{-- Discreet Glow Dot --}}
                        <div class="status-dot-container status-{{ $event->status }}">
                            <div class="dot"></div>
                            <span class="status-label">{{ ucfirst($event->status) }}</span>
                        </div>
                                                
                        <img src="{{ $event->image ? asset('storage/'.$event->image) : asset('images/placeholder.jpg') }}"
                            onerror="this.onerror=null;this.src='{{ asset('images/placeholder.jpg') }}';"
                            class="card-img-top"
                            alt="{{ $event->title }}"
                            style="height: 160px; object-fit: cover;">
                                                
                        <div class="card-body">
                            <h6 class="card-title fw-bold mb-1 text-truncate">{{ $event->title }}</h6>
                            <p class="text-muted mb-0 small">
                                <i class="bi bi-geo-alt"></i> {{ $event->location }}
                            </p>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="p-5 text-center bg-light rounded-4 border border-dashed">
                        <i class="bi bi-calendar-event fs-1 text-muted"></i>
                        <p class="mt-3 text-muted">Ainda não criaste nenhum evento.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Shared Events Section -->
    <div class="mt-5">
        <div class="d-flex align-items-center mb-4">
            <h5 class="fw-bold mb-0">Eventos partilhados</h5>
            <span class="badge badge-theme-invert ms-2 shadow-sm">{{ count($sharedEvents) }}</span>
        </div>
        
        <div class="row g-4">
            @forelse($sharedEvents as $event)
                <div class="col-md-4 col-lg-3">
                    <a href="{{ route('events.information.index', $event->id) }}" class="card event-card h-100 shadow-sm position-relative">
                        {{-- Discreet Glow Dot --}}
                        <div class="status-dot-container status-{{ $event->status }}">
                            <div class="dot"></div>
                            <span class="status-label">{{ ucfirst($event->status) }}</span>
                        </div>
                        
                        <img src="{{ $event->image ? asset('storage/'.$event->image) : asset('images/placeholder.jpg') }}"
                            onerror="this.onerror=null;this.src='{{ asset('images/placeholder.jpg') }}';"
                            class="card-img-top"
                            alt="{{ $event->title }}"
                            style="height: 160px; object-fit: cover;">
                        
                        <div class="card-body">
                            <h6 class="card-title fw-bold mb-1 text-truncate">{{ $event->title }}</h6>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <p class="text-muted mb-0 small">
                                    <i class="bi bi-geo-alt"></i> {{ $event->location }}
                                </p>
                                <span class="badge badge-theme-invert" style="font-size: 0.7rem;">
                                    {{ ucwords(str_replace('_', ' ', $event->auth_user_role)) }}
                                </span>
                            </div>

                            {{-- <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="badge bg-info text-dark" style="font-size: 0.7rem;">{{ ucwords(str_replace('_', ' ', $event->auth_user_role)) }}</span>
                                <small class="text-muted">{{ ucwords($event->organizer->name) }}</small>
                            </div> --}}
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted small italic">Nenhum evento partilhado contigo.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection

<style>
    .event-card {
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.2s;
        border: 1px solid var(--bs-border-color);

        &:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .status-bar {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 60px;
            height: 12px;
            border-radius: 4px;
        }
    }

    .status-upcoming {
        background-color: #ffc107;
        color: #000;
    }
    .status-ongoing {
        background-color: #00ff88;
        color: #000;
    }
    .status-complete {
        background-color: #0d6efd;
        color: #fff;
    }
    .status-cancelled {
        background-color: #dc3545;
        color: #fff;
    }
    .bg-all {
        background-color: #6c757d;
        color: #fff;
    }

    #statusDropdown {
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }



    .search-bar-custom {
        border: 1px solid var(--bs-border-color) !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
        transition: all 0.2s ease;
    }

    .search-bar-custom:focus {
        border-color: var(--bs-primary) !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15) !important;
        background-color: var(--bs-body-bg) !important;
    }

    .search-bar-custom::placeholder {
        color: var(--bs-secondary-color);
        opacity: 0.7;
    }

    .dropdown-item.active {
        background-color: #f8f9fa;
        color: #000;
        font-weight: bold;
    }

    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }



    .badge-theme-invert {
        background-color: var(--bs-emphasis-color) !important;
        color: var(--bs-body-bg) !important;
    }


    /* second filter method */
    .filter-badge {
        display: inline-block;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 2px solid transparent;
        margin-right: 5px;
    }

    .active-filter {
        border-color: #000 !important;
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }
    [data-bs-theme="dark"] .active-filter {
        border-color: #fff !important;
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.1);
    }

    .filter-badge:hover {
        opacity: 0.8;
        color: inherit;
    }

    



    /* SaaS Pill */
    /* .status-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        z-index: 10;
    }

    .status-upcoming  { background-color: rgba(255, 193, 7, 0.9); color: #000; }
    .status-ongoing   { background-color: rgba(0, 255, 136, 0.9); color: #000; }
    .status-complete  { background-color: rgba(13, 110, 253, 0.9); color: #fff; }
    .status-cancelled { background-color: rgba(220, 53, 69, 0.9); color: #fff; } */



    /* Glassmorphism Tag */
    /* .status-glass {
        position: absolute;
        top: 0;
        right: 0;
        padding: 6px 15px;
        border-bottom-left-radius: 15px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border-left: 1px solid rgba(255,255,255,0.3);
        border-bottom: 1px solid rgba(255,255,255,0.3);
        font-size: 11px;
        font-weight: 700;
        color: #fff;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }

    .status-glass::before {
        content: '';
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .status-upcoming::before  { background-color: #ffc107; }
    .status-ongoing::before   { background-color: #00ff88; box-shadow: 0 0 8px #00ff88; }
    .status-complete::before  { background-color: #0d6efd; }
    .status-cancelled::before { background-color: #dc3545; } */



    /* Discreet Glow Dot */
    .status-dot-container {
        position: absolute;
        top: 15px;
        right: 15px;
        display: flex;
        align-items: center;
        background: rgba(0,0,0,0.5);
        padding: 3px 10px;
        border-radius: 20px;
    }

    .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 6px;
    }

    .status-label {
        color: #fff;
        font-size: 10px;
        font-weight: 600;
    }   

    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.5); opacity: 0.5; }
        100% { transform: scale(1); opacity: 1; }
    }

    .status-ongoing .dot { 
        background-color: #00ff88; 
        animation: pulse 2s infinite; 
    }
    .status-upcoming .dot  { background-color: #ffc107; }
    .status-complete .dot  { background-color: #0d6efd; }
    .status-cancelled .dot { background-color: #dc3545; }
</style>