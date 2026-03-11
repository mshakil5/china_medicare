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
                    <a href="/all-hospitals" class="btn btn-outline-dark rounded-pill px-4">View All Hospitals</a>
                </div>
            </div>

            <div class="row g-4">
                @foreach($hospitals as $hospital)
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm hospital-card">
                        <img src="{{ asset($hospital->image) }}" class="card-img-top" alt="{{ $hospital->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold">{{ $hospital->name }}</h5>
                            <p class="text-muted small">{{ $hospital->specialty }}</p>
                            <a href="{{ url('hospitals/'.$hospital->slug) }}" class="text-teal fw-bold text-decoration-none small">
                                View Details <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center d-md-none mt-4">
                <a href="/all-hospitals" class="btn btn-outline-dark rounded-pill px-4">View All Hospitals</a>
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
                @foreach($services as $service)
                    @php
                        $trans = $service->translate();
                        $features = $trans->features ?? [];
                    @endphp

                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="service-card-new p-4 h-100 bg-white shadow-sm border-0">

                            <div class="icon-circle bg-{{ $service->color }}-light mb-4">
                                <i class="fas {{ $service->icon }} text-{{ $service->color }}"></i>
                            </div>

                            <h6 class="fw-bold">{{ $trans->title }}</h6>

                            <p class="x-small text-muted mb-3">
                                {{ $trans->description }}
                            </p>

                            <ul class="service-bullets list-unstyled mb-0">
                                @foreach(array_slice($features, 0, 3) as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                @endforeach
            </div>



        </div>
    </section>



    <section class="why-choose-section py-5">
        <div class="container py-lg-5">
            <div class="text-center mb-5">
                <h6 class="text-teal text-uppercase fw-bold small mb-2 letter-spacing-1">
                    {{ __('Why Choose Us') }}
                </h6>
                <h2 class="display-6 fw-bold text-white mb-3">
                    {{ __('Your Trusted Partner in') }} 
                    <span class="text-teal">{{ __('Medical Tourism') }}</span>
                </h2>
            </div>

            <div class="row g-4">
                @foreach($whyChooseItems as $item)

                    @php
                        $translation = $item->translations
                            ->where('locale', app()->getLocale())
                            ->first();
                    @endphp

                    @if($translation)
                        <div class="col-md-6 col-lg-4">
                            <div class="why-card p-4 h-100">
                                <div class="why-icon-box mb-4">
                                    {{-- If icon column stores class name like: fas fa-hospital-alt --}}
                                    <i class="{{ $item->icon }}"></i>
                                </div>

                                <h5 class="text-white fw-bold mb-3">
                                    {{ $translation->title }}
                                </h5>

                                <p class="text-light-gray small mb-0">
                                    {{ $translation->description }}
                                </p>
                            </div>
                        </div>
                    @endif

                @endforeach
            </div>
        </div>
    </section>


    
    <!-- blog section -->
    <section class="py-5 bg-light med-blog-section">
        <div class="container py-lg-4">
            <div class="row align-items-end mb-5 text-center text-md-start">
                <div class="col-md-8">
                    <h2 class="fw-bold display-6">Latest <span class="text-teal">Medical News</span></h2>
                </div>
                <div class="col-md-4 text-md-end d-none d-md-block">
                    <a href="{{ route('front.blog') }}" class="btn btn-outline-teal rounded-pill px-4">View All Articles</a>
                </div>
            </div>

            <div class="row g-4">
                @foreach($blogs as $blog)
                    @php $info = $blog->translation(); @endphp
                    <div class="col-md-6 col-lg-4">
                        <article class="card h-100 border-0 shadow-sm med-blog-card">
                            <div class="med-blog-img-wrapper">
                                <img src="{{ asset($blog->image) }}" class="card-img-top" alt="{{ $info->title }}">
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3 small text-muted">
                                    <span><i class="far fa-calendar-alt me-2"></i>{{ $blog->created_at->format('M d, Y') }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $blog->read_time }}</span>
                                </div>
                                <h5 class="fw-bold mb-3 med-blog-title">
                                    <a href="{{ route('front.blog.details', $blog->slug) }}" class="text-dark text-decoration-none">
                                        {{ $info->title }}
                                    </a>
                                </h5>
                                <p class="text-muted small mb-4">{{ Str::limit($info->summary, 120) }}</p>
                                <a href="{{ route('front.blog.details', $blog->slug) }}" class="text-teal fw-bold text-decoration-none small">
                                    Read Full Article <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- blog section -->


    <!-- our team section -->

    <style>
        /* --- Team Section Unique Styles --- */
        :root {
            --med-teal: #14b8a6;
            --med-teal-soft: rgba(20, 184, 166, 0.1);
        }

        .med-team-card {
            background: transparent;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            padding: 10px;
            border-radius: 20px;
        }

        .med-team-img-wrapper {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            aspect-ratio: 4/5; /* Maintains professional portrait look */
        }

        .med-team-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        /* Social Overlay */
        .med-team-socials {
            position: absolute;
            bottom: -50px; /* Hidden initially */
            left: 0;
            width: 100%;
            padding: 20px;
            background: linear-gradient(to top, rgba(20, 184, 166, 0.8), transparent);
            display: flex;
            justify-content: center;
            gap: 15px;
            transition: bottom 0.4s ease;
        }

        .med-team-socials a {
            width: 35px;
            height: 35px;
            background: white;
            color: var(--med-teal);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .med-team-socials a:hover {
            background: var(--med-teal);
            color: white;
        }

        /* Hover Effects */
        .med-team-card:hover .med-team-img-wrapper img {
            transform: scale(1.1);
        }

        .med-team-card:hover .med-team-socials {
            bottom: 0;
        }

        .med-team-card:hover {
            background: #ffffff;
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        }

        /* Typography & Badges */
        .bg-teal-soft {
            background-color: var(--med-teal-soft);
            color: var(--med-teal);
        }

        .btn-outline-teal {
            border: 1px solid var(--med-teal);
            color: var(--med-teal);
            transition: 0.3s;
        }

        .btn-outline-teal:hover {
            background-color: var(--med-teal);
            color: white;
        }

        /* Responsive Adjustments */
        @media (max-width: 576px) {
            .med-team-img-wrapper {
                aspect-ratio: 1/1; /* Square on small mobile for better fit */
            }
        }
    </style>


    <section class="py-5 bg-white med-team-section">
        <div class="container py-lg-4">
            <div class="row mb-5 text-center">
                <div class="col-lg-7 mx-auto">
                    <h2 class="display-6 fw-bold mb-3">Meet Our <span class="text-teal">Team</span></h2>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-sm-6">
                    <div class="med-team-card text-center">
                        <div class="med-team-img-wrapper mb-3">
                            <img src="https://images.unsplash.com/photo-1559839734-2b71f153678e?auto=format&fit=crop&w=500" alt="Dr. Sarah Johnson" class="img-fluid">
                            <div class="med-team-socials">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                        <div class="med-team-info">
                            <h5 class="fw-bold mb-1">Dr. Sarah Johnson</h5>
                            <p class="text-muted small mb-3">MD, Harvard Medical School</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="med-team-card text-center">
                        <div class="med-team-img-wrapper mb-3">
                            <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=500" alt="Dr. Chen Wei" class="img-fluid">
                            <div class="med-team-socials">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                        <div class="med-team-info">
                            <h5 class="fw-bold mb-1">Dr. Chen Wei</h5>
                            <p class="text-muted small mb-3">Senior Surgeon, 15+ Yrs Exp</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="med-team-card text-center">
                        <div class="med-team-img-wrapper mb-3">
                            <img src="https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&w=500" alt="Dr. Elena Rodriguez" class="img-fluid">
                            <div class="med-team-socials">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                        <div class="med-team-info">
                            <h5 class="fw-bold mb-1">Dr. Elena Rodriguez</h5>
                            <p class="text-muted small mb-3">Specialist, MD (Barcelona)</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="med-team-card text-center">
                        <div class="med-team-img-wrapper mb-3">
                            <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=500" alt="Dr. James Smith" class="img-fluid">
                            <div class="med-team-socials">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                        <div class="med-team-info">
                            <span class="badge bg-teal-soft text-teal mb-2">Neurology</span>
                            <h5 class="fw-bold mb-1">Dr. James Smith</h5>
                            <p class="text-muted small mb-3">Ph.D. Neurosciences</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
    <!-- our team section -->




    <section class="cta-section py-5 text-white text-center d-none">
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

    <style>
        .partners-scroll-section {
            background: #fff;
        }

        .partners-scroll-wrapper {
            overflow: hidden;
            position: relative;
        }

        .partners-scroll-track {
            display: flex;
            width: max-content;
            animation: partnersScroll 25s linear infinite;
        }

        .partner-logo {
            padding: 10px 40px;
            display: flex;
            align-items: center;
        }

        .partner-logo img {
            height: 60px;
            width: auto;
            object-fit: contain;
            filter: grayscale(100%);
            transition: 0.3s;
        }

        .partner-logo img:hover {
            filter: grayscale(0%);
            transform: scale(1.05);
        }

        /* pause animation on hover */
        .partners-scroll-wrapper:hover .partners-scroll-track {
            animation-play-state: paused;
        }

        /* animation */
        @keyframes partnersScroll {
            from {
                transform: translateX(0);
            }
            to {
                transform: translateX(-50%);
            }
        }



        /* Mobile Responsive */
        @media (max-width: 768px) {

            .partner-logo {
                padding: 10px 20px;
            }

            .partner-logo img {
                height: 40px;
            }

            .partners-scroll-track {
                animation: partnersScroll 18s linear infinite;
            }

        }

    </style>

    <div class="partners-scroll-section py-5 border-bottom">
        <div class="container text-center">
            <h3 class="mb-4 fw-bold">Our Partners</h3>
            <div class="partners-scroll-wrapper">
                <div class="partners-scroll-track">
                    {{-- First set of logos --}}
                    @foreach($partners as $partner)
                        <div class="partner-logo">
                            <img src="{{ asset($partner->image) }}" alt="Partner">
                        </div>
                    @endforeach

                    {{-- Duplicate set for smooth infinite scroll --}}
                    @foreach($partners as $partner)
                        <div class="partner-logo">
                            <img src="{{ asset($partner->image) }}" alt="Partner">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>



@endsection

@section('script')


@endsection