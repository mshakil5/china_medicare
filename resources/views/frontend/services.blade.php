@extends('frontend.layouts.master')

@section('content')

<style>
    /* ✅ Dynamic background with overlay */
    .services-header-bg {
        background-size: cover;
        background-position: center;
        position: relative;
    }
    .services-header-bg::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 100%);
        z-index: 1;
    }
    .services-header-bg .container {
        position: relative;
        z-index: 2;
    }
</style>

{{-- ✅ Dynamic Banner Section --}}
<section class="services-header-bg py-5" 
         style="background-image: url('{{ $banner->image_url ?? asset('assets/images/default-banner.jpg') }}');">
    <div class="container py-lg-4 text-center">
        
        @if($banner)
            @if($banner->short_title)
                <h6 class="text-teal text-uppercase fw-bold small letter-spacing-1">{{ $banner->short_title }}</h6>
            @else
                <h6 class="text-teal text-uppercase fw-bold small letter-spacing-1">{{ __('home.services_banner_subtitle') }}</h6>
            @endif

            <h1 class="display-5 fw-bold text-white mb-3">
                {!! $banner->long_title ?? __('home.services_banner_title') !!}
            </h1>

            @if($banner->short_description)
                <p class="text-light-gray mx-auto max-w-700">{{ $banner->short_description }}</p>
            @else
                <p class="text-light-gray mx-auto max-w-700">{{ __('home.services_banner_description') }}</p>
            @endif
        @else
            <h6 class="text-teal text-uppercase fw-bold small letter-spacing-1">{{ __('home.services_banner_subtitle') }}</h6>
            <h1 class="display-5 fw-bold text-white mb-3">{!! __('home.services_banner_title') !!}</h1>
            <p class="text-light-gray mx-auto max-w-700">{{ __('home.services_banner_description') }}</p>
        @endif
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
                                    {{ __('home.whats_included') }}
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