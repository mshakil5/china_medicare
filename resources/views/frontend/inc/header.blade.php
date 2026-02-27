{{-- <div class="top-bar">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-phone me-2"></i> {{ $company->phone1 }}
            <i class="fas fa-envelope ms-4 me-2"></i> {{ $company->email1 }}
        </div>

        <div class="d-flex align-items-center">
            <a href="{{ $company->facebook }}" class="social-link"><i class="fab fa-facebook-f me-3"></i></a>
            <a href="{{ $company->instagram }}" class="social-link"><i class="fab fa-instagram me-3"></i></a>
            <a href="{{ $company->linkedin }}" class="social-link"><i class="fab fa-linkedin-in me-3"></i></a>
            <a href="{{ $company->website }}" class="social-link"><i class="fas fa-globe me-2"></i></a>

            @php
                $locale = app()->getLocale();
            @endphp

            <div class="dropdown d-inline">
                <span class="dropdown-toggle d-flex align-items-center gap-2 cursor-pointer" data-bs-toggle="dropdown">
                    <span class="text-capitalize">
                        {{ match($locale) {
                            'de' => __('header.german'),
                            'fr' => __('header.french'),
                            'es' => __('header.spanish'),
                            'it' => __('header.italian'),
                            default => __('header.english')
                        } }}
                    </span>
                </span>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 {{ $locale === 'en' ? 'active' : '' }}"
                           href="{{ route('lang.switch', 'en') }}">
                            <img src="{{ asset('resources/flags/gb.svg') }}" width="18" height="14">
                            {{ __('header.english') }}
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 {{ $locale === 'it' ? 'active' : '' }}"
                           href="{{ route('lang.switch', 'it') }}">
                            <img src="{{ asset('resources/flags/it.svg') }}" width="18" height="14">
                            {{ __('header.italian') }}
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 {{ $locale === 'es' ? 'active' : '' }}"
                           href="{{ route('lang.switch', 'es') }}">
                            <img src="{{ asset('resources/flags/es.svg') }}" width="18" height="14">
                            {{ __('header.spanish') }}
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 {{ $locale === 'de' ? 'active' : '' }}"
                           href="{{ route('lang.switch', 'de') }}">
                            <img src="{{ asset('resources/flags/de.svg') }}" width="18" height="14">
                            {{ __('header.german') }}
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 {{ $locale === 'fr' ? 'active' : '' }}"
                           href="{{ route('lang.switch', 'fr') }}">
                            <img src="{{ asset('resources/flags/fr.svg') }}" width="18" height="14">
                            {{ __('header.french') }}
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>

@php
    $categories = \App\Models\Category::with('products')->where('status', 1)->get();
@endphp

<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-success" href="{{ route('home') }}">
            <img src="{{ asset('images/company/' . $company->company_logo) }}" alt="Company Logo" height="40">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">{{ __('header.home') }}</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('aboutUs') }}">{{ __('header.about_us') }}</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="prodDrop" role="button" data-bs-toggle="dropdown">
                        {{ __('header.products') }}
                    </a>

                    <ul class="dropdown-menu">
                        @foreach ($categories as $category)
                            <li>
                                <a class="dropdown-item" href="{{ route('category.show', $category->slug) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('rAndD') }}">{{ __('header.r_and_d') }}</a>
                </li>

                <li class="nav-item ms-lg-3">
                    <a class="btn-inquire" href="{{ route('inquire') }}">{{ __('header.inquire_now') }}</a>
                </li>
            </ul>
        </div>
    </div>
</nav> --}}


    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.html">
                <img src="logo.png" alt="China Medicare" style="height: 90px; width: auto;">
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link px-3" href="index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="hospital.html">Hospitals</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="package.html">Packages</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="service.html">Services</a></li>
                </ul>
                <div class="d-lg-flex align-items-center">
                    <a href="tel:+864001234567" class="nav-link me-lg-3 mb-3 mb-lg-0 small">
                        <i class="fas fa-phone-alt me-2 text-teal"></i>+880 1333 218519
                    </a>
                    <a href="contact.html" class="btn btn-teal-solid w-lg-auto px-4">Free Consultation</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-section text-white overflow-hidden">
        <div class="container py-5">
            <div class="row gy-5 align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <span class="badge rounded-pill bg-dark-teal mb-3 py-2 px-3">
                        <i class="fas fa-circle text-teal me-2 small"></i> Your Gateway to World-Class Healthcare
                    </span>
                    <h1 class="display-5 fw-bold mb-3 hero-title">Experience Premier <br><span class="text-accent">Medical Care</span> in China</h1>
                    <p class="text-light-gray mb-4 lead">Discover China's finest hospitals with our comprehensive one-stop medical tourism service. From consultation to recovery.</p>
                    
                    <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3 mb-5">
                        <button class="btn btn-teal-solid btn-lg px-4">Explore Hospitals <i class="fas fa-arrow-right ms-2"></i></button>
                        <button class="btn btn-outline-light btn-lg px-4">Watch Video</button>
                    </div>

                    <div class="row g-3 stats-row">
                        <div class="col-4 col-sm-4">
                            <h3 class="fw-bold mb-0">50+</h3>
                            <p class="small text-light-gray">Partners</p>
                        </div>
                        <div class="col-4 col-sm-4">
                            <h3 class="fw-bold mb-0">10K+</h3>
                            <p class="small text-light-gray">Patients</p>
                        </div>
                        <div class="col-4 col-sm-4">
                            <h3 class="fw-bold mb-0">98%</h3>
                            <p class="small text-light-gray">Satisfied</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="hero-img-wrapper position-relative mx-auto">
                        <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=800" class="img-fluid rounded-4 main-hero-img" alt="Clinic">
                        
                        <div class="floating-info-card jci-position d-none d-sm-flex">
                            <div class="icon-box bg-light-teal text-teal"><i class="fas fa-shield-alt"></i></div>
                            <div>
                                <p class="fw-bold mb-0">JCI Accredited</p>
                                <p class="x-small text-muted mb-0">International Standards</p>
                            </div>
                        </div>

                        <div class="floating-info-card support-position d-none d-sm-flex">
                            <div class="icon-box bg-light-yellow text-warning"><i class="fas fa-globe"></i></div>
                            <div>
                                <p class="fw-bold mb-0">24/7 Support</p>
                                <p class="x-small text-muted mb-0">Multilingual Team</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>