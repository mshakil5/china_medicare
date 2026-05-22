<style>
    /* --- Responsive Logo --- */
    .nav-logo {
        height: 52px; /* Mobile size */
        width: auto;
        transition: height 0.3s ease;
    }
    @media (min-width: 992px) {
        .nav-logo {
            height: 90px; /* Desktop size */
        }
    }

    /* --- Topbar Adjustments --- */
    .topbar {
        background-color: #1a1a2e; /* Dark background */
        font-size: 0.85rem;
    }
    .topbar a, .topbar span {
        color: #ced4da;
        transition: color 0.3s;
    }
    .topbar a:hover {
        color: #ffffff;
    }
    .topbar-social a {
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
        margin-left: 6px;
    }
    .topbar-social a:hover {
        background: var(--primary-teal);
        color: #fff;
    }

    /* --- Navbar Adjustments --- */
    .btn-teal-solid {
        background: var(--primary-teal);
        color: white;
        border: none;
        transition: 0.3s;
    }
    .btn-teal-solid:hover { 
        background: #24B24B; 
        color: white; 
    }

    /* Nav link hover effect */
    #mainNav .navbar-nav .nav-link {
        position: relative;
        transition: color 0.3s ease;
    }
    #mainNav .navbar-nav .nav-link:hover {
        color: #D7202A;
    }
    #mainNav .navbar-nav .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: #D7202A;
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }
    #mainNav .navbar-nav .nav-link:hover::after {
        width: 70%;
    }
    
    /* Reduce spacing for stacked phone numbers */
    .phone-stack .nav-link {
        padding-top: 2px;
        padding-bottom: 2px;
        line-height: 1.4;
    }

    /* FIX: Ensure sticky works even if parent has overflow issues */
    html, body {
        overflow-x: visible !important;
    }
</style>

{{-- Wrap both Topbar and Nav in a single sticky header --}}
<header class="sticky-top" style="z-index: 1050;">

    {{-- Top Bar (Hidden on mobile) --}}
    <div class="topbar py-2 d-none d-lg-block">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-4">
                @if($company->email1)
                    <span><i class="fas fa-envelope me-1"></i> {{ $company->email1 }}</span>
                @endif
            </div>
            <div class="topbar-social">
                @if(!empty($company->facebook)) <a href="{{ $company->facebook }}" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a> @endif
                @if(!empty($company->twitter)) <a href="{{ $company->twitter }}" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a> @endif
                @if(!empty($company->linkedin)) <a href="{{ $company->linkedin }}" target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a> @endif
                @if(!empty($company->instagram)) <a href="{{ $company->instagram }}" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a> @endif
                @if(!empty($company->youtube)) <a href="{{ $company->youtube }}" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a> @endif
                @if(!empty($company->website)) <a href="{{ $company->website }}" target="_blank" title="Website"><i class="fas fa-globe"></i></a> @endif
            </div>
        </div>
    </div>

    {{-- Main Navigation --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home')}}">
                {{-- Removed height="90" and added class="nav-logo" --}}
                <img src="{{ asset('uploads/company/' . $company->company_logo) }}" alt="Company Logo" class="nav-logo">
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link px-3" href="{{ route('home')}}">{{ __('menu.home') }}</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="{{ route('aboutUs')}}">{{ __('menu.about') }}</a></li>
                    <li class="nav-item d-none"><a class="nav-link px-3" href="{{ route('home')}}">{{ __('menu.hospitals') }}</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="{{ route('packages')}}">{{ __('menu.packages') }}</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="{{ route('services')}}">{{ __('menu.services') }}</a></li>
                </ul>
                
                <div class="d-lg-flex align-items-center">
                    
                    <!-- Language Dropdown -->
                    <div class="dropdown me-lg-3 mb-3 mb-lg-0">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-globe me-1"></i> 
                            {{ App::getLocale() == 'en' ? 'English' : 'বাংলা' }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langDropdown">
                            <li>
                                <a class="dropdown-item {{ App::getLocale() == 'en' ? 'active' : '' }}" href="{{ route('lang.switch', 'en') }}">English</a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ App::getLocale() == 'bn' ? 'active' : '' }}" href="{{ route('lang.switch', 'bn') }}">বাংলা</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Dynamic Phone Numbers (Stacked) -->
                    <div class="phone-stack d-flex flex-column align-items-lg-end mb-3 mb-lg-0 me-lg-3">
                        @if($company->phone1)
                            <a href="tel:{{ preg_replace('/[^0-9\+]/', '', $company->phone1) }}" class="nav-link small">
                                <i class="fas fa-phone-alt me-2 text-teal"></i>{{ $company->phone1 }}
                            </a>
                        @endif
                        
                        @if(!empty($company->phone2))
                            <a href="tel:{{ preg_replace('/[^0-9\+]/', '', $company->phone2) }}" class="nav-link small">
                                <i class="fab fa-whatsapp me-2 text-teal"></i>{{ $company->phone2 }}
                            </a>
                        @endif
                    </div>
                    
                    <!-- CTA Button -->
                    <a href="{{ route('contact')}}" class="btn btn-teal-solid w-lg-auto px-4">
                        {{ __('menu.consultation') }}
                    </a>

                </div>
            </div>
        </div>
    </nav>

</header>