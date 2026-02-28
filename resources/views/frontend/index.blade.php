@extends('frontend.layouts.master')

@section('content')




    @if($hero)
    <section class="hero-section text-white overflow-hidden">
        <div class="container py-5">
            <div class="row gy-5 align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <span class="badge rounded-pill bg-dark-teal mb-3 py-2 px-3">
                        <i class="fas fa-circle text-teal me-2 small"></i> {{ $hero->badge }}
                    </span>

                    <h1 class="display-5 fw-bold mb-3 hero-title">
                        {!! $hero->title !!}
                    </h1>

                    <p class="text-light-gray mb-4 lead">{{ $hero->description }}</p>
                    
                    <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3 mb-5">
                        @if($hero->btn1_url)
                        <a href="{{ $hero->btn1_url }}" class="btn btn-teal-solid btn-lg px-4">
                            {{ $hero->btn1_text }} <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        @endif

                        @if($hero->video_url)
                        <a href="{{ $hero->video_url }}" class="btn btn-outline-light btn-lg px-4">Watch Video</a>
                        @endif
                    </div>

                    <div class="row g-3 stats-row">
                        @if($hero->stats)
                            @foreach($hero->stats as $stat)
                                <div class="col-4 col-sm-4">
                                    <h3 class="fw-bold mb-0">{{ $stat['value'] ?? '' }}</h3>
                                    <p class="small text-light-gray">{{ $stat['label'] ?? '' }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="hero-img-wrapper position-relative mx-auto">
                        <img src="{{ asset($hero->image) }}" class="img-fluid rounded-4 main-hero-img" alt="Hero Image">
                        
                        <div class="floating-info-card jci-position d-none d-sm-flex">
                            <div class="icon-box bg-light-teal text-teal"><i class="fas fa-shield-alt"></i></div>
                            <div>
                                <p class="fw-bold mb-0">{{ $hero->info_cards[0]['title'] ?? 'JCI Accredited' }}</p>
                                <p class="x-small text-muted mb-0">{{ $hero->info_cards[0]['sub'] ?? 'International Standards' }}</p>
                            </div>
                        </div>

                        <div class="floating-info-card support-position d-none d-sm-flex">
                            <div class="icon-box bg-light-yellow text-warning"><i class="fas fa-globe"></i></div>
                            <div>
                                <p class="fw-bold mb-0">{{ $hero->info_cards[1]['title'] ?? '24/7 Support' }}</p>
                                <p class="x-small text-muted mb-0">{{ $hero->info_cards[1]['sub'] ?? 'Multilingual Team' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif



    <section class="py-5 bg-white">
        <div class="container py-lg-4">
            <div class="row align-items-end mb-5 text-center text-md-start">
                <div class="col-md-8">
                    <h6 class="text-teal text-uppercase fw-bold small mb-2">Partner Hospitals</h6>
                    <h2 class="fw-bold">Featured <span class="text-teal">Hospitals</span></h2>
                    <p class="text-muted">World-class medical facilities with expert specialists.</p>
                </div>
                <div class="col-md-4 text-md-end d-none d-md-block">
                    <button class="btn btn-outline-dark rounded-pill px-4">View All Hospitals</button>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm hospital-card">
                        <img src="https://images.unsplash.com/photo-1586773860418-d37222d8fce2?auto=format&fit=crop&w=400" class="card-img-top" alt="Beijing">
                        <div class="card-body p-4">
                            <h5 class="fw-bold">Beijing United</h5>
                            <p class="text-muted small">Cardiology & Oncology</p>
                            <a href="#" class="text-teal fw-bold text-decoration-none small">View Details <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm hospital-card">
                        <img src="https://images.unsplash.com/photo-1512678080530-7760d81faba6?auto=format&fit=crop&w=400" class="card-img-top" alt="Shanghai">
                        <div class="card-body p-4">
                            <h5 class="fw-bold">Shanghai Jiahui</h5>
                            <p class="text-muted small">Orthopedics</p>
                            <a href="#" class="text-teal fw-bold text-decoration-none small">View Details <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm hospital-card">
                        <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=400" class="card-img-top" alt="Guangzhou">
                        <div class="card-body p-4">
                            <h5 class="fw-bold">Guangzhou Union</h5>
                            <p class="text-muted small">Neurology Center</p>
                            <a href="#" class="text-teal fw-bold text-decoration-none small">View Details <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm hospital-card">
                        <img src="https://images.unsplash.com/photo-1632833239869-a37e3a5806d2?auto=format&fit=crop&w=400" class="card-img-top" alt="Huashan">
                        <div class="card-body p-4">
                            <h5 class="fw-bold">Huashan Hospital</h5>
                            <p class="text-muted small">General Surgery</p>
                            <a href="#" class="text-teal fw-bold text-decoration-none small">View Details <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center d-md-none mt-4">
                 <button class="btn btn-outline-dark rounded-pill px-4">View All Hospitals</button>
            </div>
        </div>
    </section>



    <section class="py-5 bg-white">
        <div class="container py-lg-4">
            <div class="row align-items-end mb-5">
                <div class="col-md-8 text-center text-md-start">
                    <h6 class="text-teal text-uppercase fw-bold small mb-2 letter-spacing-1">All-Inclusive Packages</h6>
                    <h2 class="display-6 fw-bold mb-3">Popular <span class="text-teal">Medical Packages</span></h2>
                    <p class="text-muted max-w-600">Comprehensive treatment packages with transparent pricing and full support throughout your medical journey.</p>
                </div>
                <div class="col-md-4 text-md-end d-none d-md-block">
                    <button class="btn btn-outline-dark rounded-pill px-4 py-2">
                        <i class="fas fa-box-open me-2"></i> View All Packages <i class="fas fa-arrow-right ms-2 small"></i>
                    </button>
                </div>
            </div>

            <div class="row g-4">
                @foreach($packages as $package)
                    @php
                        $translation = $package->translations->where('locale', app()->getLocale())->first();
                        $features = is_array($package->features) ? $package->features : json_decode($package->features, true);
                    @endphp

                    <div class="col-lg-4 col-md-6 {{ $loop->last ? 'mx-auto' : '' }}">
                        <div class="card h-100 border-0 shadow-sm package-card">
                            
                            <div class="position-relative">
                                <img 
                                    src="{{ $package->image ? asset($package->image) : 'https://via.placeholder.com/600x400' }}" 
                                    class="card-img-top"
                                    alt="{{ $translation->title ?? '' }}"
                                >

                                <div class="card-badges p-3 position-absolute top-0 start-0 w-100 d-flex gap-2">

                                    @if($package->is_featured)
                                        <span class="badge bg-warning-soft text-warning">
                                            <i class="fas fa-star me-1"></i> Featured
                                        </span>
                                    @endif

                                    @if($package->is_popular)
                                        <span class="badge bg-teal-soft text-teal">
                                            <i class="fas fa-chart-line me-1"></i> Popular
                                        </span>
                                    @endif

                                </div>

                                <span class="category-pill">{{ $package->category }}</span>
                            </div>

                            <div class="card-body p-4">

                                <h5 class="fw-bold mb-1">
                                    {{ $translation->title ?? '' }}
                                </h5>

                                <p class="text-muted small mb-3">
                                    {{ $translation->subtitle ?? '' }}
                                </p>

                                <p class="card-text text-muted small mb-4">
                                    {{ $translation->description ?? '' }}
                                </p>

                                {{-- Features --}}
                                <ul class="list-unstyled mb-4 package-features">
                                    @if($features)
                                        @foreach(array_slice($features, 0, 3) as $feature)
                                            <li>
                                                <i class="fas fa-check-circle text-teal me-2"></i>
                                                {{ $feature }}
                                            </li>
                                        @endforeach

                                        @if(count($features) > 3)
                                            <li class="text-muted ps-4 small">
                                                +{{ count($features) - 3 }} more services
                                            </li>
                                        @endif
                                    @endif
                                </ul>

                                <div class="d-flex justify-content-between align-items-center border-top pt-3 mb-3">
                                    <span class="small text-muted">
                                        <i class="far fa-calendar-alt me-2"></i> 
                                        {{ $package->duration }}
                                    </span>
                                    <span class="small text-muted">
                                        <i class="fas fa-map-marker-alt me-2"></i> 
                                        {{ $package->cities_count }} cities
                                    </span>
                                </div>

                                <h4 class="fw-bold text-teal mb-3">
                                    {{ $package->price_range }}
                                </h4>

                                <a href="#" class="btn btn-teal-solid w-100 py-2">
                                    View Details
                                </a>

                            </div>
                        </div>
                    </div>

                @endforeach
            </div>

            <div class="text-center d-md-none mt-4">
                <button class="btn btn-outline-dark rounded-pill px-4">View All Packages</button>
            </div>
        </div>
    </section>




    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="text-teal text-uppercase fw-bold small">Comprehensive Care</h6>
                <h2 class="display-6 fw-bold">One-Stop Medical Tourism <span class="text-teal">Services</span></h2>
                <p class="text-muted mx-auto" style="max-width: 600px;">From your first inquiry to post-treatment recovery, we handle every detail of your medical journey to China.</p>
            </div>

            <div class="row g-4">
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="service-card-new p-4 h-100 bg-white shadow-sm border-0">
                        <div class="icon-circle bg-teal-light mb-4"><i class="fas fa-stethoscope text-teal"></i></div>
                        <h6 class="fw-bold">Medical Consultation</h6>
                        <p class="x-small text-muted mb-3">Connect with top specialists for personalized treatment plans.</p>
                        <ul class="service-bullets list-unstyled mb-0">
                            <li>Expert recommendations</li>
                            <li>Treatment planning</li>
                            <li>Cost estimates</li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="service-card-new p-4 h-100 bg-white shadow-sm border-0">
                        <div class="icon-circle bg-blue-light mb-4"><i class="fas fa-plane text-blue"></i></div>
                        <h6 class="fw-bold">Visa Assistance</h6>
                        <p class="x-small text-muted mb-3">Complete support for medical visa applications with expedited processing.</p>
                        <ul class="service-bullets list-unstyled mb-0">
                            <li>Document preparation</li>
                            <li>Embassy coordination</li>
                            <li>Express processing</li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="service-card-new p-4 h-100 bg-white shadow-sm border-0">
                        <div class="icon-circle bg-orange-light mb-4"><i class="fas fa-hotel text-orange"></i></div>
                        <h6 class="fw-bold">Accommodation</h6>
                        <p class="x-small text-muted mb-3">Premium hotels and recovery apartments near partner hospitals.</p>
                        <ul class="service-bullets list-unstyled mb-0">
                            <li>Hospital proximity</li>
                            <li>Long-stay discounts</li>
                            <li>Accessible rooms</li>
                        </ul>
                    </div>
                </div>
                </div>
        </div>
    </section>



    <section class="why-choose-section py-5">
        <div class="container py-lg-5">
            <div class="text-center mb-5">
                <h6 class="text-teal text-uppercase fw-bold small mb-2 letter-spacing-1">Why Choose Us</h6>
                <h2 class="display-6 fw-bold text-white mb-3">Your Trusted Partner in <span class="text-teal">Medical Tourism</span></h2>
                <p class="text-light-gray mx-auto" style="max-width: 650px;">We've helped thousands of international patients receive world-class healthcare in China.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="why-card p-4 h-100">
                        <div class="why-icon-box mb-4">
                            <i class="fas fa-hospital-alt"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-3">Top-Tier Hospitals</h5>
                        <p class="text-light-gray small mb-0">All partner hospitals are JCI accredited or hold equivalent international certifications.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="why-card p-4 h-100">
                        <div class="why-icon-box mb-4">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-3">Transparent Pricing</h5>
                        <p class="text-light-gray small mb-0">No hidden fees. Get detailed cost breakdowns before making any decisions.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="why-card p-4 h-100">
                        <div class="why-icon-box mb-4">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-3">Fast Processing</h5>
                        <p class="text-light-gray small mb-0">Expedited visa processing and appointment scheduling within 48 hours.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="why-card p-4 h-100">
                        <div class="why-icon-box mb-4">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-3">Expert Team</h5>
                        <p class="text-light-gray small mb-0">Medical coordinators with healthcare backgrounds assist you throughout.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="why-card p-4 h-100">
                        <div class="why-icon-box mb-4">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-3">Quality Guaranteed</h5>
                        <p class="text-light-gray small mb-0">We stand behind our service with comprehensive satisfaction guarantees.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="why-card p-4 h-100">
                        <div class="why-icon-box mb-4">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-3">24/7 Support</h5>
                        <p class="text-light-gray small mb-0">Round-the-clock assistance in multiple languages whenever you need help.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="cta-section py-5 text-white text-center">
        <div class="container py-4">
            <h2 class="display-5 fw-bold mb-3">Ready to Start Your Medical Journey?</h2>
            <p class="mb-5 opacity-90">Get a free consultation with our medical tourism experts and discover the <br class="d-none d-md-block"> best treatment options for you.</p>
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                <a href="#" class="btn btn-light text-teal fw-bold px-4 py-3 rounded-3 shadow-sm">
                    <i class="far fa-comment-dots me-2"></i> Free Consultation <i class="fas fa-arrow-right ms-2"></i>
                </a>
                <a href="#" class="btn btn-outline-light px-4 py-3 rounded-3">Explore Hospitals</a>
            </div>
        </div>
    </section>

    <div class="trust-bar py-4 border-bottom">
        <div class="container text-center">
            <p class="small text-muted mb-4">Trusted by International Patients Worldwide</p>
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-4 gap-md-5 opacity-50">
                <span class="fw-bold h5 mb-0">JCI Accredited</span>
                <span class="fw-bold h5 mb-0">WHO Recognized</span>
                <span class="fw-bold h5 mb-0">MTQUA Certified</span>
                <span class="fw-bold h5 mb-0">ISO 9001</span>
                <span class="fw-bold h5 mb-0">Global Healthcare</span>
            </div>
        </div>
    </div>



@endsection

@section('script')


@endsection