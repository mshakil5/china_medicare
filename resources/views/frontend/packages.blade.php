@extends('frontend.layouts.master')

@section('content')

<style>
    .contact-hero {
        background-size: cover;
        background-position: center;
        position: relative;
    }
    .contact-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 100%);
        z-index: 1;
    }
    .contact-hero .container {
        position: relative;
        z-index: 2;
    }
    .category-section {
        margin-bottom: 3rem;
    }
    .category-divider {
        height: 3px;
        background: linear-gradient(to right, #0d9488, transparent);
        border: none;
        margin-top: 0.5rem;
    }
    .category-icon-box {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #0d9488, #14b8a6);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
</style>

{{-- ✅ Dynamic Banner Section --}}
<section class="contact-hero py-5" 
         style="background-image: url('{{ $banner->image_url ?? asset('assets/images/default-banner.jpg') }}');">
    <div class="container py-lg-4 text-center">
        @if($banner)
            @if($banner->short_title)
                <span class="badge rounded-pill bg-dark-teal mb-3 py-2 px-3 border-teal-thin">
                    <i class="far fa-comment-dots text-teal me-2"></i> {{ $banner->short_title }}
                </span>
            @endif
            
            <h1 class="display-5 fw-bold text-white mb-3">
                {!! $banner->long_title ?? __('home.packages_page_title') !!}
            </h1>
            
            @if($banner->short_description)
                <p class="text-light-gray mx-auto max-w-600">{{ $banner->short_description }}</p>
            @else
                <p class="text-light-gray mx-auto max-w-600">{{ __('home.packages_page_subtitle') }}</p>
            @endif
        @else
            <span class="badge rounded-pill bg-dark-teal mb-3 py-2 px-3 border-teal-thin">
                <i class="far fa-comment-dots text-teal me-2"></i> {{ __('home.free_consultation') }}
            </span>
            <h1 class="display-5 fw-bold text-white mb-3">{!! __('home.packages_page_title') !!}</h1>
            <p class="text-light-gray mx-auto max-w-600">{{ __('home.packages_page_subtitle') }}</p>
        @endif
    </div>
</section>


{{-- ✅ Packages Section - Category Wise --}}
<section class="py-5 bg-white">
    <div class="container py-lg-4">
        <div class="row align-items-end mb-5">
            <div class="col-md-8 text-center text-md-start">
                <h6 class="text-teal text-uppercase fw-bold small mb-2 letter-spacing-1">{{ __('home.all_inclusive_packages') }}</h6>
                <h2 class="display-6 fw-bold mb-3">{!! __('home.popular_packages_short') !!}</h2>
                <p class="text-muted max-w-600">{{ __('home.packages_description') }}</p>
            </div>
            <div class="col-md-4 text-md-end d-none d-md-block">
            </div>
        </div>

        @if(empty($activeCategories))
            <div class="alert alert-info text-center py-5">
                <i class="fas fa-info-circle fa-2x mb-3 d-block"></i>
                <h5>{{ __('home.no_packages_available') }}</h5>
                <p class="text-muted">{{ __('home.no_packages_text') }}</p>
            </div>
        @else

            @foreach($activeCategories as $categoryKey => $categoryLabel)
                @php
                    $categoryPackages = $packages->get($categoryKey);
                @endphp

                <div class="category-section">
                    
                    {{-- ✅ Category Header --}}
                    <div class="d-flex align-items-center mb-4">
                        <div class="category-icon-box me-3">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0">{{ $categoryLabel }}</h4>
                            <small class="text-muted">
                                {{ count($categoryPackages) > 1 
                                    ? __('home.packages_available', ['count' => count($categoryPackages)]) 
                                    : __('home.package_available', ['count' => count($categoryPackages)]) 
                                }}
                            </small>
                        </div>
                        <hr class="flex-grow-1 ms-4">
                    </div>

                    {{-- ✅ Packages Grid --}}
                    <div class="row g-4">
                        @foreach($categoryPackages as $package)

                            @php
                                $translation = $package->translations
                                    ->where('locale', app()->getLocale())
                                    ->first();
                                
                                if (!$translation) {
                                    $translation = $package->translations
                                        ->where('locale', 'en')
                                        ->first();
                                }

                                $features = $translation->features ?? [];
                                
                                $features = array_filter($features, function($f) {
                                    return !empty($f) && trim($f) !== '';
                                });
                            @endphp

                            <div class="col-lg-4 col-md-6">
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
                                                    <i class="fas fa-star me-1"></i> {{ __('home.featured') }}
                                                </span>
                                            @endif

                                            @if($package->is_popular)
                                                <span class="badge bg-teal-soft text-teal">
                                                    <i class="fas fa-chart-line me-1"></i> {{ __('home.popular') }}
                                                </span>
                                            @endif
                                        </div>

                                        <span class="category-pill">
                                            {{ $categoryLabel }}
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
                                            {{ Str::limit(strip_tags($translation->description ?? ''), 120) }}
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
                                                        {{ __('home.more_services', ['count' => count($features) - 3]) }}
                                                    </li>
                                                @endif
                                            @endif
                                        </ul>


                                        <a href="{{ route('package.details', $package->id) }}" 
                                           class="btn btn-teal-solid w-100 py-2">
                                            {{ __('home.view_details') }}
                                        </a>

                                    </div>

                                </div>
                            </div>

                        @endforeach
                    </div>

                    {{-- ✅ Divider between categories (except last) --}}
                    @if(!$loop->last)
                        <hr class="my-5 opacity-25">
                    @endif

                </div>

            @endforeach

        @endif

        <div class="text-center d-md-none mt-4">
            <button class="btn btn-outline-dark rounded-pill px-4">{{ __('home.view_all_packages') }}</button>
        </div>
    </div>
</section>

@endsection

@section('script')
@endsection