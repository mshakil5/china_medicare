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
                    <li><i class="fas fa-phone-alt me-3"></i>+880 1333 218519</li>
                    <li><i class="fab fa-whatsapp me-3"></i>+86 188 1056 1453</li>
                    <li><i class="fas fa-envelope me-3"></i>chinamedicare.cn@gmail.com</li>

                    <li><i class="fas fa-map-marker-alt me-3"></i>No 30, Shuangqing Road, Haidian District, 
                            <br><span class="">Beijing - 100084.</span></li>
                    <li><i class="fas fa-map-marker-alt me-3"></i>73 A Gulshan Avenue, 3rd Floor, Silvy Heights,
                        <br><span class="">Gulshan, Dhaka - 1212.</span></li>
                </ul>
            </div>
        </div>

        <hr class="border-secondary my-5">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="small text-muted mb-0">{{ __('home.copyright') }}</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="#" class="small text-muted text-decoration-none me-3">{{ __('home.privacy_policy') }}</a>
                <a href="#" class="small text-muted text-decoration-none">{{ __('home.terms_of_service') }}</a>
            </div>
        </div>
    </div>
</footer>