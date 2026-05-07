<style>
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
    
    /* Optional: Reduce spacing for stacked phone numbers */
    .phone-stack .nav-link {
        padding-top: 2px;
        padding-bottom: 2px;
        line-height: 1.4;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home')}}">
            <img src="{{ asset('uploads/company/' . $company->company_logo) }}" alt="Company Logo" height="90">
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link px-3" href="{{ route('home')}}">{{ __('menu.home') }}</a></li>
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

                <!-- ✅ Dynamic Phone Numbers (Stacked) -->
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