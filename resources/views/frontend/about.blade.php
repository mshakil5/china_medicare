@extends('frontend.layouts.master')

@section('content')

@php
    // Detect current language
    $locale = app()->getLocale();
    
    // Set variables based on language
    if ($locale == 'bn') {
        $image = $companyDetails->about_image2;
        $text = $companyDetails->about_us_bn;
        $badgeText = 'আমাদের সম্পর্কে';
        $heroTitle = 'চায়না মেডিকেয়ার সম্পর্কে';
        $heroSubtitle = 'সীমানা পেরিয়ে স্বাস্থ্যসেবা';
    } else {
        $image = $companyDetails->about_image1;
        $text = $companyDetails->about_us_en;
        $badgeText = 'Who We Are';
        $heroTitle = 'About China Medicare';
        $heroSubtitle = 'Healthcare Beyond Borders';
    }

    // Fallbacks: If the specific language image/text is missing, use the other one
    if (!$image) {
        $image = ($locale == 'bn') ? $companyDetails->about_image1 : $companyDetails->about_image2;
    }
    if (!$text) {
        $text = ($locale == 'bn') ? $companyDetails->about_us_en : $companyDetails->about_us_bn;
    }
@endphp

<style>
    .about-hero {
        background-size: cover;
        background-position: center;
        position: relative;
    }
    .about-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 100%);
        z-index: 1;
    }
    .about-hero .container { position: relative; z-index: 2; }
    
    .about-img-card {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 1rem 3rem rgba(0,0,0,0.15);
        position: relative;
    }
    .about-img-card::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; width: 100%; height: 30%;
        background: linear-gradient(to top, rgba(0,0,0,0.4), transparent);
    }
</style>

{{-- Hero Section --}}
<section class="about-hero py-5" style="background-image: url('{{ asset('assets/images/about-hero-bg.jpg') }}');">
    <div class="container py-lg-4 text-center">
        <span class="badge rounded-pill bg-dark-teal mb-3 py-2 px-3 border-teal-thin">
            <i class="fas fa-heartbeat text-teal me-2"></i> {{ $badgeText }}
        </span>
        <h1 class="display-5 fw-bold text-white mb-3">{{ $heroTitle }}</h1>
        <p class="text-light-gray mx-auto max-w-600">{{ $heroSubtitle }}</p>
    </div>
</section>

{{-- Main Content Section --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center g-5">
            
            {{-- Left Column: Dynamic Image --}}
            <div class="col-lg-6">
                @if($image)
                    <div class="about-img-card">
                        <img src="{{ asset($image) }}" class="img-fluid w-100" alt="{{ $heroTitle }}">
                    </div>
                @else
                    <div class="bg-white p-5 rounded-4 text-center shadow-sm">
                        <i class="fas fa-images text-muted fs-1"></i>
                        <p class="mt-3 text-muted">
                            {{ $locale == 'bn' ? 'ছবি যোগ করা হয়নি' : 'No image uploaded yet' }}
                        </p>
                    </div>
                @endif
            </div>

            {{-- Right Column: Dynamic Text --}}
            <div class="col-lg-6">
                <span class="badge rounded-pill bg-teal-light text-teal mb-3 py-2 px-3 border-teal-thin">
                    {{ $badgeText }}
                </span>
                
                <div class="text-dark">
                    @if($text)
                        {!! $text !!}
                    @else
                        <p class="text-muted">
                            {{ $locale == 'bn' ? 'বিষয়বস্তু শীঘ্রই আসছে...' : 'Content coming soon...' }}
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>

@endsection