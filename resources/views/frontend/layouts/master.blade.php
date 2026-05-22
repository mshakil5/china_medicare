<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
    @php
        $company = App\Models\CompanyDetails::select(
            'company_name', 'fav_icon', 'google_site_verification',
            'bing_site_verification', 'footer_content', 'facebook',
            'twitter', 'linkedin', 'instagram', 'youtube', 'website', 'phone1', 'phone2', 'email1',
            'address1', 'company_logo', 'footer_logo', 'copyright',
            'google_map', 'meta_title', 'meta_description', 'meta_keywords',
            'og_image', 'canonical_url', 'google_analytics_id',
            'google_tag_manager_id', 'robots_index', 'robots_follow'
        )->first();

        // Fallback chain: page-specific → company OG image → hardcoded default
        if (isset($pageImage) && $pageImage) {
            // Page-specific image already set (e.g., package details)
        } elseif ($company->og_image) {
            $pageImage = asset('uploads/company/' . $company->og_image);
        } else {
            // ✅ Hardcoded default OG image - upload this file once
            $pageImage = asset('images/og-default.jpg');
        }

        $pageTitle       = $pageTitle       ?? $company->meta_title       ?? 'China Medicare | Trusted Healthcare Services';
        $pageDescription = $pageDescription ?? $company->meta_description ?? 'China Medicare offers comprehensive health check-up packages, specialist consultations, advanced cancer treatment, and cardiac procedures.';
        $pageKeywords    = $pageKeywords    ?? $company->meta_keywords    ?? 'China Medicare, healthcare, medical check-up';
        $canonicalUrl    = $canonicalUrl    ?? ($company->canonical_url  ?? url()->current());
        $robotsIndex     = $robotsIndex     ?? $company->robots_index     ?? 'index';
        $robotsFollow    = $robotsFollow    ?? $company->robots_follow    ?? 'follow';
    @endphp

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- ===== PRIMARY META TAGS ===== -->
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

    <!-- ===== CANONICAL ===== -->
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <!-- ===== FAVICON ===== -->
    <!-- ===== FAVICON ===== -->
    @if($company->fav_icon)
        <!-- Generic icon tag (Works for .ico, .png, .jpg) -->
        <link rel="icon" href="{{ asset('uploads/company/' . $company->fav_icon) }}">
        <!-- Apple Touch Icon (For iOS home screen bookmarks) -->
        <link rel="apple-touch-icon" href="{{ asset('uploads/company/' . $company->fav_icon) }}">
    @endif

    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">

    <!-- ===== OPEN GRAPH / FACEBOOK ===== -->
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

    <!-- ===== TWITTER CARD ===== -->
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

    <!-- ===== SITE VERIFICATION ===== -->
    @if($company->google_site_verification)
        <meta name="google-site-verification" content="{{ $company->google_site_verification }}">
    @endif
    @if($company->bing_site_verification)
        <meta name="msvalidate.01" content="{{ $company->bing_site_verification }}">
    @endif

    <!-- ===== GEO TAGS ===== -->
    @if($company->address1)
        <meta name="geo.region" content="CN">
        <meta name="geo.placename" content="{{ $company->address1 }}">
    @endif

    <!-- ===== PRECONNECT ===== -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">

    <!-- ===== STYLESHEETS ===== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('resources/frontend/style.css') }}">

    <!-- ===== GOOGLE TAG MANAGER (HEAD) ===== -->
    @if($company->google_tag_manager_id)
        <script>
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{{ $company->google_tag_manager_id }}');
        </script>
    @endif

    <!-- ===== PAGE-SPECIFIC STRUCTURED DATA ===== -->
    @yield('structured-data')

</head>
<body>

    <!-- ===== GOOGLE TAG MANAGER (BODY) ===== -->
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

    <!-- ===== SCRIPTS ===== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ===== GOOGLE ANALYTICS ===== -->
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