@extends('frontend.layouts.master')

@section('content')



    <section class="contact-hero py-5">
        <div class="container py-lg-4 text-center">
            <span class="badge rounded-pill bg-dark-teal mb-3 py-2 px-3 border-teal-thin">
                <i class="far fa-comment-dots text-teal me-2"></i> Free Consultation
            </span>
            <h1 class="display-5 fw-bold text-white mb-3">Get in <span class="text-teal">Touch</span></h1>
            <p class="text-light-gray mx-auto max-w-600">Start your medical journey today. Our team is ready to help you find the best healthcare solution in China.</p>
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
                </div>
            </div>

            <div class="row g-4">
                @foreach($packages as $package)

                    @php
                        $translation = $package->translations
                            ->where('locale', app()->getLocale())
                            ->first();

                        $features = is_array($package->features)
                            ? $package->features
                            : json_decode($package->features, true);
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

                                <span class="category-pill">
                                    {{ $package->category }}
                                </span>

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

                                <a href="{{ route('package.details', $package->id) }}" 
                                class="btn btn-teal-solid w-100 py-2">
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




@endsection

@section('script')


@endsection