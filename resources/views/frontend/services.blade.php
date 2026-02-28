@extends('frontend.layouts.master')

@section('content')

    
<section class="services-header-bg py-5">
    <div class="container py-lg-4 text-center">
        <nav aria-label="breadcrumb" class="d-flex justify-content-center mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="text-teal text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Services</li>
            </ol>
        </nav>
        <h6 class="text-teal text-uppercase fw-bold small letter-spacing-1">Comprehensive Support</h6>
        <h1 class="display-5 fw-bold text-white mb-3">One-Stop <span class="text-teal">Services</span></h1>
        <p class="text-light-gray mx-auto max-w-700">From consultation to recovery, we handle every aspect of your medical journey to China with care and precision.</p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container py-3">
        <div class="row g-4 justify-content-center">

            @foreach($services as $service)

                @php
                    $translation = $service->translations
                        ->where('locale', app()->getLocale())
                        ->first();

                    $features = $translation && is_array($translation->features)
                        ? $translation->features
                        : json_decode($translation->features ?? '[]', true);

                    // Dynamic color classes
                    $colorClass = match($service->color) {
                        'orange' => 'bg-warning-light text-warning',
                        'blue' => 'bg-blue-light text-primary',
                        'teal' => 'bg-teal-light text-teal',
                        default => 'bg-teal-light text-teal'
                    };
                @endphp

                @if($translation)
                <div class="col-lg-10">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden service-long-card">
                        <div class="row g-0">

                            {{-- Left Side --}}
                            <div class="col-md-5 col-xl-4 p-4 p-lg-5 bg-white border-end-light">
                                <div class="icon-box-rounded {{ $colorClass }} mb-4">
                                    <i class="{{ $service->icon }} fs-4"></i>
                                </div>

                                <h4 class="fw-bold mb-3">
                                    {{ $translation->title }}
                                </h4>

                                <p class="text-muted small mb-0">
                                    {{ $translation->description }}
                                </p>
                            </div>

                            {{-- Right Side --}}
                            <div class="col-md-7 col-xl-8 p-4 p-lg-5 bg-white-50">
                                <h6 class="fw-bold small text-uppercase text-muted mb-4">
                                    What's Included
                                </h6>

                                <div class="row g-3">
                                    @foreach($features as $feature)
                                        <div class="col-sm-6 d-flex align-items-start">
                                            <i class="fas fa-check-circle text-teal mt-1 me-2"></i>
                                            <span class="small">
                                                {{ $feature }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                @endif

            @endforeach

        </div>
    </div>
</section>






@endsection

@section('script')


@endsection