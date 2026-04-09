<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
    @php
        $company = App\Models\CompanyDetails::select(
            'company_name', 
            'fav_icon', 
            'google_site_verification',
            'bing_site_verification',
            'footer_content', 
            'facebook', 
            'twitter', 
            'linkedin', 
            'website', 
            'phone1', 
            'email1', 
            'address1',
            'company_logo',
            'footer_logo',
            'copyright',
            'google_map',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'og_image',
            'canonical_url',
            'google_analytics_id',
            'google_tag_manager_id',
            'robots_index',
            'robots_follow'
        )->first();

        // Page-specific SEO (override if available)
        $pageTitle = $pageTitle ?? $company->meta_title ?? $company->company_name;
        $pageDescription = $pageDescription ?? $company->meta_description ?? null;
        $pageKeywords = $pageKeywords ?? $company->meta_keywords ?? null;
        $pageImage = $pageImage ?? ($company->og_image ? asset('images/company/' . $company->og_image) : asset('images/company/' . $company->company_logo));
        $canonicalUrl = $canonicalUrl ?? ($company->canonical_url ?? url()->current());
        $robotsIndex = $robotsIndex ?? $company->robots_index ?? 'index';
        $robotsFollow = $robotsFollow ?? $company->robots_follow ?? 'follow';
    @endphp

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Primary Meta Tags -->
    <title>{{ $pageTitle }}</title>
    <meta name="title" content="{{ $pageTitle }}">
    @if($pageDescription)
        <meta name="description" content="{{ Str::limit($pageDescription, 160) }}">
    @endif
    @if($pageKeywords)
        <meta name="keywords" content="{{ $pageKeywords }}">
    @endif
    <meta name="author" content="{{ $company->company_name }}">
    <meta name="robots" content="{{ $robotsIndex }}, {{ $robotsFollow }}, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ $canonicalUrl }}">
    
    <!-- Hreflang (if multilingual) -->
    {{-- <link rel="alternate" hreflang="en" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="zh" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="x-default" href="{{ url()->current() }}"> --}}

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/company/' . $company->fav_icon) }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/company/' . $company->fav_icon) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/company/' . $company->fav_icon) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/company/' . $company->fav_icon) }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    @if($pageDescription)
        <meta property="og:description" content="{{ Str::limit($pageDescription, 200) }}">
    @endif
    <meta property="og:image" content="{{ $pageImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $company->company_name }}">
    <meta property="og:site_name" content="{{ $company->company_name }}">
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ $canonicalUrl }}">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    @if($pageDescription)
        <meta name="twitter:description" content="{{ Str::limit($pageDescription, 200) }}">
    @endif
    <meta name="twitter:image" content="{{ $pageImage }}">
    <meta name="twitter:image:alt" content="{{ $company->company_name }}">
    @if($company->twitter)
        <meta name="twitter:site" content="@{{ str_replace(['https://twitter.com/', 'https://x.com/', '@'], '', $company->twitter) }}">
    @endif

    <!-- Site Verification -->
    @if($company->google_site_verification)
        <meta name="google-site-verification" content="{{ $company->google_site_verification }}">
    @endif
    @if($company->bing_site_verification)
        <meta name="msvalidate.01" content="{{ $company->bing_site_verification }}">
    @endif

    <!-- Geo Tags (for local business) -->
    @if($company->address1)
        <meta name="geo.region" content="CN">
        <meta name="geo.placename" content="{{ $company->address1 }}">
    @endif

    <!-- Preconnect for Performance -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">
    <link rel="dns-prefetch" href="https://www.google-analytics.com">

    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('resources/frontend/style.css') }}">






    <!-- Page-specific structured data placeholder -->
    @yield('structured-data')

</head>
<body>

    <!-- Google Tag Manager (BODY) -->
    @if($company->google_tag_manager_id)
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id={{ $company->google_tag_manager_id }}"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
    @endif

    @include('frontend.inc.header')

    @yield('content')

    @include('frontend.cookies')

    @include('frontend.inc.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Google Analytics -->
    @if($company->google_analytics_id)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $company->google_analytics_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $company->google_analytics_id }}', {
                page_title: '{{ $pageTitle }}',
                page_location: '{{ $canonicalUrl }}'
            });
        </script>
    @endif

    @yield('script')

</body>

</html>