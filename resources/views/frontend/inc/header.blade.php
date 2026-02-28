

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
                    <li class="nav-item"><a class="nav-link px-3" href="{{ route('home')}}">{{ __('menu.hospitals') }}</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="{{ route('packages')}}">{{ __('menu.packages') }}</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="{{ route('services')}}">{{ __('menu.services') }}</a></li>
                </ul>
                
                <div class="d-lg-flex align-items-center">
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

                    <a href="tel:+8801333218519" class="nav-link me-lg-3 mb-3 mb-lg-0 small">
                        <i class="fas fa-phone-alt me-2 text-teal"></i>+880 1333 218519
                    </a>
                    
                    <a href="{{ route('contact')}}" class="btn btn-teal-solid w-lg-auto px-4">
                            {{ __('menu.consultation') }}
                        </a>


                </div>


            </div>
        </div>
    </nav>
