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
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home')}}">
                {{-- <img src="logo.png" alt="China Medicare" style="height: 90px; width: auto;"> --}}
                <img src="{{ asset('uploads/company/' . $company->company_logo) }}" alt="Company Logo" height="90">
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link px-3" href="{{ route('home')}}">Home</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="{{ route('home')}}">Hospitals</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="{{ route('packages')}}">Packages</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="{{ route('services')}}">Services</a></li>
                </ul>
                <div class="d-lg-flex align-items-center">
                    <a href="tel:+864001234567" class="nav-link me-lg-3 mb-3 mb-lg-0 small">
                        <i class="fas fa-phone-alt me-2 text-teal"></i>+880 1333 218519
                    </a>
                    <a href="{{ route('home')}}" class="btn btn-teal-solid w-lg-auto px-4">Free Consultation</a>
                </div>
            </div>
        </div>
    </nav>
