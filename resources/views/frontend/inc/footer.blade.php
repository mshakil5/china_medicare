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
                        {{$company->footer_content}}
                    </p>
                </div>

                <div class="col-6 col-md-3 col-lg-2">
                    <h6 class="text-white fw-bold mb-4">Quick Links</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ route('home')}}">Home</a></li>
                        <li><a href="{{ route('home')}}">Hospitals</a></li>
                        <li><a href="{{ route('packages')}}">Packages</a></li>
                        <li><a href="{{ route('services')}}">Services</a></li>
                        <li><a href="{{ route('contact')}}">Contact</a></li>
                    </ul>
                </div>


                <div class="col-md-6 col-lg-6">
                    <h6 class="text-white fw-bold mb-4">Contact Us</h6>
                    <ul class="list-unstyled footer-contact">
                        <li><i class="fas fa-phone-alt me-3"></i>+880 1333 218519</li>
                        <li><i class="fas fa-envelope me-3"></i>chinamedicare.cn@gmail.com</li>
                        <li><i class="fas fa-map-marker-alt me-3"></i>73 A Gulshan Avenue, 3rd Floor, Silvy Heights,
                            <br><span class="ms-4 ps-2">Gulshan, Dhaka - 1212.</span></li>

 
                        <li><i class="fas fa-map-marker-alt me-3"></i>No 30, Shuangqing Road, Haidian District, 

                                <br><span class="ms-4 ps-2">Beijing - 100084.</span></li>
                    </ul>
                </div>
            </div>

            <hr class="border-secondary my-5">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="small text-muted mb-0">© 2026 China Medicare. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="small text-muted text-decoration-none me-3">Privacy Policy</a>
                    <a href="#" class="small text-muted text-decoration-none">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
