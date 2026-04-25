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



    @if ($hospitals->count() > 0)
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
    @endif



    <style>
        /* Scroll Reveal Animation */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(60px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* Optional: Stagger delay for child cards */
        .scroll-reveal .card,
        .scroll-reveal .service-card-new {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .scroll-reveal.revealed .card,
        .scroll-reveal.revealed .service-card-new {
            opacity: 1;
            transform: translateY(0);
        }

        /* Stagger animation delays for each card */
        .scroll-reveal.revealed .col-lg-4:nth-child(1) .card,
        .scroll-reveal.revealed .col-xl-3:nth-child(1) .service-card-new { transition-delay: 0.1s; }

        .scroll-reveal.revealed .col-lg-4:nth-child(2) .card,
        .scroll-reveal.revealed .col-xl-3:nth-child(2) .service-card-new { transition-delay: 0.2s; }

        .scroll-reveal.revealed .col-lg-4:nth-child(3) .card,
        .scroll-reveal.revealed .col-xl-3:nth-child(3) .service-card-new { transition-delay: 0.3s; }

        .scroll-reveal.revealed .col-lg-4:nth-child(4) .card,
        .scroll-reveal.revealed .col-xl-3:nth-child(4) .service-card-new { transition-delay: 0.4s; }

        .scroll-reveal.revealed .col-lg-4:nth-child(5) .card,
        .scroll-reveal.revealed .col-xl-3:nth-child(5) .service-card-new { transition-delay: 0.5s; }

        .scroll-reveal.revealed .col-lg-4:nth-child(6) .card,
        .scroll-reveal.revealed .col-xl-3:nth-child(6) .service-card-new { transition-delay: 0.6s; }


    </style>


    
    @if ($packages->count() > 0)
    <section class="py-5 bg-white scroll-reveal">
        <div class="container py-lg-4">
            <div class="row align-items-end mb-5">
                <div class="col-md-8 text-center text-md-start">
                    <h6 class="text-teal text-uppercase fw-bold small mb-2 letter-spacing-1">All-Inclusive Packages</h6>
                    <h2 class="display-6 fw-bold mb-3">Popular <span class="text-teal">Medical Packages</span></h2>
                    <p class="text-muted max-w-600">Comprehensive treatment packages with transparent pricing and full support throughout your medical journey.</p>
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

                                <div class="d-flex justify-content-between align-items-center border-top pt-3 mb-3 d-none">
                                    <span class="small text-muted">
                                        <i class="far fa-calendar-alt me-2"></i> 
                                        {{ $package->duration }}
                                    </span>
                                    <span class="small text-muted">
                                        <i class="fas fa-map-marker-alt me-2"></i> 
                                        {{ $package->cities_count }} cities
                                    </span>
                                </div>

                                <h4 class="fw-bold text-teal mb-3  d-none">
                                    {{ $package->price_range }}
                                </h4>

                                <a href="{{route('package.details', $package->id)}}" class="btn btn-teal-solid w-100 py-2">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    
    <style>
        /* Hidden features - initially collapsed */
        .features-hidden {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-out, opacity 0.3s ease-out;
            opacity: 0;
        }

        .features-hidden.expanded {
            max-height: 500px; /* Adjust based on max possible features */
            opacity: 1;
            transition: max-height 0.5s ease-in, opacity 0.4s ease-in;
        }

        /* Toggle button styling */
        .feature-toggle {
            cursor: pointer;
            padding: 4px 0 !important;
            transition: color 0.2s ease;
        }

        .feature-toggle:hover .toggle-text {
            color: var(--bs-teal, #0d9488);
        }

        .feature-toggle .toggle-text {
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            transition: color 0.2s ease;
            display: inline-flex;
            align-items: center;
        }

        /* When expanded, change icon and text */
        .feature-toggle.is-expanded .toggle-text::after {
            content: 'Show less';
        }

        .feature-toggle.is-expanded .toggle-text i {
            transform: rotate(45deg);
        }


        /* Hide the default text node, we use ::after instead */
        .feature-toggle .toggle-text {
            font-size: 0;
        }

        .feature-toggle .toggle-text::after {
            font-size: 0.75rem;
        }

        .feature-toggle .toggle-text i {
            font-size: 0.75rem;
            margin-right: 4px;
            transition: transform 0.3s ease;
        }
    </style>

    @if ($services->count() > 0)
    <section class="py-5 bg-white scroll-reveal">
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
                        $visibleFeatures = array_slice($features, 0, 3);
                        $hiddenFeatures = array_slice($features, 3);
                        $hiddenCount = count($hiddenFeatures);
                        $uniqueId = 'service-' . $service->id;
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
                                @foreach($visibleFeatures as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach

                                @if($hiddenCount > 0)
                                    <div id="{{ $uniqueId }}-hidden" class="features-hidden">
                                        @foreach($hiddenFeatures as $feature)
                                            <li>{{ $feature }}</li>
                                        @endforeach
                                    </div>

                                    <li class="feature-toggle mt-1" onclick="toggleFeatures('{{ $uniqueId }}', this)">
                                        <span class="toggle-text">
                                            <i class="fas fa-plus-circle me-1 text-teal"></i>
                                            +{{ $hiddenCount }} more
                                        </span>
                                    </li>
                                @endif
                            </ul>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif


    @if ($whyChooseItems->count() > 0)
        

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

    @endif

    
    @if ($blogs->count() > 0)
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
    @endif




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


    @if ($teams->count() > 0)
    <section class="py-5 bg-white med-team-section">
        <div class="container py-lg-4">
            <div class="row mb-5 text-center">
                <div class="col-lg-7 mx-auto">
                    <h2 class="display-6 fw-bold mb-3">Meet Our <span class="text-teal">Team</span></h2>
                </div>
            </div>

            <div class="row g-4">
                @foreach($teams as $member)
                    <div class="col-lg-3 col-sm-6">
                        <div class="med-team-card text-center">
                            <div class="med-team-img-wrapper mb-3">
                                {{-- Dynamic Image with Fallback --}}
                                <img src="{{ $member->image ? asset($member->image) : 'https://via.placeholder.com/500x500?text=No+Image' }}" 
                                    alt="{{ $member->name }}" 
                                    class="img-fluid">
                                
                                <div class="med-team-socials">
                                    {{-- Show LinkedIn only if exists --}}
                                    @if($member->linkedin)
                                        <a href="{{ $member->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                    @endif
                                    
                                    {{-- Show Email only if exists --}}
                                    @if($member->email)
                                        <a href="mailto:{{ $member->email }}"><i class="fas fa-envelope"></i></a>
                                    @endif
                                </div>
                            </div>

                            <div class="med-team-info">
                                {{-- Show Specialty Badge only if exists --}}
                                @if($member->specialty)
                                    <span class="badge bg-teal-soft text-teal mb-2">{{ $member->specialty }}</span>
                                @endif

                                <h5 class="fw-bold mb-1">{{ $member->name }}</h5>
                                <p class="text-muted small mb-3">{{ $member->designation }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
        </div>
    </section>
    @endif


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

    @if ($partners->count() > 0)
        
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

    @endif







<!-- ====== GALLERY SECTION ====== -->
@if($galleryPreview->isNotEmpty())
<section class="hglry-section py-5">
    <div class="container py-lg-3">

        <!-- Section Header -->
        <div class="row align-items-end mb-4">
            <div class="col-md-8">
                <h2 class="fw-bold">Our <span class="text-teal">Gallery</span></h2>
            </div>
            <div class="col-md-4 text-md-end d-none d-md-block">
                <a href="{{ route('gallery') }}" class="btn btn-outline-dark rounded-pill px-4">
                    View Full Gallery <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>

        <!-- Asymmetric Preview Grid -->
        <div class="hglry-preview-grid">

            @foreach($galleryPreview as $index => $item)
                @php
                    $isFirst = $index === 0;
                    $imgSrc = $item->type === 'video' && $item->thumbnail
                        ? asset($item->thumbnail)
                        : asset($item->file_path);
                    $fullSrc = asset($item->file_path);
                @endphp

                <div class="hglry-pi {{ $isFirst ? 'hglry-pi--hero' : '' }}"
                     data-hglry-type="{{ $item->type }}"
                     data-hglry-src="{{ $fullSrc }}"
                     data-hglry-title="{{ $item->title }}"
                     data-hglry-sub="{{ $item->subtitle ?? '' }}">
                    <img src="{{ $imgSrc }}" alt="{{ $item->title }}" loading="lazy">

                    @if($item->type === 'video')
                        <div class="hglry-video-tag">
                            <i class="fas fa-play" style="font-size:.5rem;"></i> Video
                        </div>
                        <div class="hglry-play-circle">
                            <i class="fas fa-play" style="margin-left:3px;"></i>
                        </div>
                    @endif

                    <div class="hglry-pi-overlay">
                        <div class="hglry-pi-label">
                            {{ $item->title }}
                            @if($item->subtitle)
                                <span>{{ $item->subtitle }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- "View More" Tile --}}
            @if($galleryTotal > 4)
                <a href="{{ route('gallery') }}" class="hglry-more-tile">
                    <img src="{{ asset($galleryPreview->last()->type === 'video' && $galleryPreview->last()->thumbnail ? $galleryPreview->last()->thumbnail : $galleryPreview->last()->file_path) }}"
                         alt="More Gallery" loading="lazy">
                    <div class="hglry-more-content">
                        <div class="hglry-more-num">{{ $galleryTotal - 4 }}+</div>
                        <div class="hglry-more-txt">More Photos<br>&amp; Videos</div>
                        <div class="mt-2">
                            <span style="font-size:.75rem; color:#D8202A; font-weight:600;">
                                View Gallery <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </a>
            @endif

        </div><!-- end grid -->

        <!-- Mobile CTA -->
        <div class="text-center d-md-none mt-4">
            <a href="{{ route('gallery') }}" class="btn btn-outline-dark rounded-pill px-4">
                View Full Gallery <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>

    </div>
</section>
@endif

<!-- ====== LIGHTBOX ====== -->
<div class="hglry-lightbox" id="hglryLightbox" role="dialog" aria-modal="true" aria-label="Media Viewer">
    <button class="hglry-lb-close" id="hglryClose"><i class="fas fa-times"></i></button>
    <div class="hglry-lb-media" id="hglryMedia"></div>
    <div class="hglry-lb-caption">
        <span id="hglryTitle">Title</span>
        <span id="hglrySub">Sub</span>
    </div>
</div>




@endsection

@section('script')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const scrollElements = document.querySelectorAll('.scroll-reveal');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    // Optional: Stop observing after animation
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,        // Trigger when 10% is visible
            rootMargin: '0px 0px -50px 0px'  // Slight offset from bottom
        });

        scrollElements.forEach(el => {
            observer.observe(el);
        });
    });


    function toggleFeatures(uniqueId, toggleElement) {
    const hiddenDiv = document.getElementById(uniqueId + '-hidden');
    
    if (!hiddenDiv) return;

    const isExpanded = hiddenDiv.classList.contains('expanded');
    const hiddenCount = hiddenDiv.querySelectorAll('li').length;
    const toggleText = toggleElement.querySelector('.toggle-text');

    if (isExpanded) {
        // Collapse
        hiddenDiv.classList.remove('expanded');
        toggleElement.classList.remove('is-expanded');
        toggleText.setAttribute('data-count', hiddenCount);
    } else {
        // Expand
        hiddenDiv.classList.add('expanded');
        toggleElement.classList.add('is-expanded');
    }
}

// Fix: Set initial count text properly
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.feature-toggle').forEach(toggle => {
        const hiddenDiv = toggle.previousElementSibling;
        if (hiddenDiv) {
            const count = hiddenDiv.querySelectorAll('li').length;
            toggle.querySelector('.toggle-text').setAttribute('data-count', count);
        }
    });

    // Override CSS ::after with JS for dynamic count
    const style = document.createElement('style');
    style.textContent = `
        .feature-toggle:not(.is-expanded) .toggle-text::after {
            content: attr(data-count) ' more';
        }
        .feature-toggle.is-expanded .toggle-text::after {
            content: 'Show less';
        }
    `;
    document.head.appendChild(style);
});

</script>

<script>
(function () {
    const tiles   = document.querySelectorAll('.hglry-pi[data-hglry-src]');
    if (!tiles.length) return;

    const lb      = document.getElementById('hglryLightbox');
    const mediaEl = document.getElementById('hglryMedia');
    const titleEl = document.getElementById('hglryTitle');
    const subEl   = document.getElementById('hglrySub');
    const closeEl = document.getElementById('hglryClose');
    let activeMedia = null;

    function openHglry(src, type, title, sub) {
        mediaEl.innerHTML = '';
        if (type === 'video') {
            const v = document.createElement('video');
            v.src = src;
            v.controls = true;
            v.autoplay = true;
            mediaEl.appendChild(v);
            activeMedia = v;
        } else {
            const i = document.createElement('img');
            i.src = src;
            i.alt = title;
            mediaEl.appendChild(i);
            activeMedia = i;
        }
        titleEl.textContent = title || '';
        subEl.textContent = sub || '';
        lb.classList.add('hglry-lb-open');
        document.body.style.overflow = 'hidden';
    }

    function closeHglry() {
        lb.classList.remove('hglry-lb-open');
        document.body.style.overflow = '';
        if (activeMedia && activeMedia.pause) {
            activeMedia.pause();
            activeMedia.src = '';
        }
        mediaEl.innerHTML = '';
        activeMedia = null;
    }

    tiles.forEach(tile => {
        tile.addEventListener('click', function () {
            openHglry(
                this.dataset.hglrySrc,
                this.dataset.hglryType,
                this.dataset.hglryTitle || '',
                this.dataset.hglrySub || ''
            );
        });
    });

    closeEl.addEventListener('click', closeHglry);
    lb.addEventListener('click', function (e) {
        if (e.target === lb) closeHglry();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeHglry();
    });
})();
</script>

@endsection