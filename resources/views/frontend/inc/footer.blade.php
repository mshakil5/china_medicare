<style>
    /* Footer Social Icons */
    .footer-social a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
        color: #ced4da;
        margin-right: 8px;
        transition: all 0.3s ease;
    }
    .footer-social a:hover {
        background: var(--primary-teal);
        color: #ffffff;
        transform: translateY(-3px);
    }
</style>

<footer class="footer-main pt-5 pb-3">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4">
                <div class="d-flex align-items-center mb-3">
                    <a class="navbar-brand d-flex align-items-center" href="{{ route('home')}}">
                        <img src="{{ asset('uploads/company/' . $company->footer_logo) }}" alt="Company Logo" height="90">
                    </a>
                </div>
                <p class="text-light-gray small pe-lg-5">
                    {{ __('home.footer_text') }}
                </p>
                
                {{-- Footer Social Links --}}
                <div class="footer-social mt-3">
                    @if(!empty($company->facebook)) <a href="{{ $company->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a> @endif
                    @if(!empty($company->twitter)) <a href="{{ $company->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a> @endif
                    @if(!empty($company->linkedin)) <a href="{{ $company->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a> @endif
                    @if(!empty($company->instagram)) <a href="{{ $company->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a> @endif
                    @if(!empty($company->youtube)) <a href="{{ $company->youtube }}" target="_blank"><i class="fab fa-youtube"></i></a> @endif
                    @if(!empty($company->website)) <a href="{{ $company->website }}" target="_blank"><i class="fas fa-globe"></i></a> @endif
                </div>
            </div>

            <div class="col-6 col-md-3 col-lg-2">
                <h6 class="text-white fw-bold mb-4">{{ __('home.quick_links') }}</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('home')}}">{{ __('menu.home') }}</a></li>
                    <li><a href="{{ route('packages')}}">{{ __('menu.packages') }}</a></li>
                    <li><a href="{{ route('services')}}">{{ __('menu.services') }}</a></li>
                    <li><a href="{{ route('contact')}}">{{ __('menu.contact') }}</a></li>
                </ul>
            </div>

            <div class="col-md-6 col-lg-6">
                <h6 class="text-white fw-bold mb-4">{{ __('home.contact_us') }}</h6>
                <ul class="list-unstyled footer-contact">
                    @if($company->phone1)
                        <li><i class="fas fa-phone-alt me-3"></i>{{ $company->phone1 }}</li>
                    @endif
                    @if($company->phone2)
                        <li><i class="fab fa-whatsapp me-3"></i>{{ $company->phone2 }}</li>
                    @endif
                    @if($company->email1)
                        <li><i class="fas fa-envelope me-3"></i>{{ $company->email1 }}</li>
                    @endif

                    @if($company->address1)
                        <li><i class="fas fa-map-marker-alt me-3"></i>{{ $company->address1 }}</li>
                    @endif
                </ul>
            </div>
        </div>

        <hr class="border-secondary my-5">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="small text-muted mb-0">
                    &copy; {{ date('Y') }} {{ $company->company_name ?? 'China Medicare' }}. {{ __('home.copyright') }}
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="#" class="small text-muted text-decoration-none me-3">{{ __('home.privacy_policy') }}</a>
                <a href="#" class="small text-muted text-decoration-none">{{ __('home.terms_of_service') }}</a>
            </div>
        </div>
    </div>
</footer>