@extends('frontend.layouts.master')

@section('content')


<nav class="py-3 bg-light border-bottom">
    <div class="container">
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item"><a href="/" class="text-teal text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="#" class="text-teal text-decoration-none">Packages</a></li>
            <li class="breadcrumb-item active">{{ $translation->title }}</li>
        </ol>
    </div>
</nav>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-teal-soft text-teal">{{ $package->category }}</span>
                    @if($package->is_popular)
                        <span class="badge bg-warning-soft text-dark"><i class="fas fa-star me-1"></i>Most Booked</span>
                    @endif
                </div>
                
                <h1 class="fw-bold display-6 mb-2">{{ $translation->title }}</h1>
                <p class="text-muted mb-4 d-none">
                    <i class="fas fa-map-marker-alt me-2 text-teal"></i>
                    Available in {{ $package->cities_count }} Locations
                </p>

                <div class="rounded-4 overflow-hidden mb-5 shadow-sm">
                    <img src="{{ asset($package->image) }}" class="img-fluid w-100" alt="{{ $translation->title }}" style="max-height: 450px; object-fit: cover;">
                </div>

                <div class="mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="fw-bold mb-0">Package Overview</h4>
                        <span class="badge bg-light text-teal border border-teal px-3 py-2">
                            <i class="far fa-clock me-1"></i> {{ $package->duration }}
                        </span>
                    </div>
                    <div class="text-muted lead-sm">
                        {{ $translation->description }}
                    </div>
                </div>

                <div class="mb-5">
                    <h4 class="fw-bold mb-4">What's Included</h4>
                    <div class="row g-3">
                        @if(!empty($features))
                            @foreach($features as $feature)
                                <div class="col-md-6">
                                    <div class="d-flex p-3 bg-light rounded-3 h-100 align-items-center">
                                        <i class="fas fa-check-circle text-teal me-3"></i>
                                        <div>
                                            <h6 class="fw-bold mb-0">{{ $feature }}</h6>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 text-muted">Contact us for full feature details.</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px; border-radius: 20px;">
                    <div class="card-body p-4 text-center">
                        <div class="mb-4">
                            <small class="text-muted d-block mb-1">Estimated Package Price</small>
                            <h2 class="fw-bold text-teal mb-0">{{ $package->price_range ?? 'Price on Request' }}</h2>
                        </div>
                        
                        <div class="d-grid gap-3">
                            <a class="btn btn-teal-solid py-3 fw-bold rounded-pill" href="{{ route('contact')}}">Book This Package</a>
                        </div>
                        <hr class="my-4">
                        <div class="text-center">
                            <p class="small text-muted mb-2">Need a custom quote?</p>
                            <a href="#" class="text-teal fw-bold text-decoration-none">Talk to a Specialist <i class="fas fa-chevron-right ms-1 small"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@section('script')


@endsection