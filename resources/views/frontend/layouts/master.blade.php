
<!DOCTYPE html>
<html lang="en">
<head>

    
    @php
        $company = App\Models\CompanyDetails::select('company_name', 'fav_icon', 'google_site_verification', 'footer_content', 'facebook', 'twitter', 'linkedin', 'website', 'phone1', 'email1', 'address1','company_logo','copyright','google_map')->first();
    @endphp


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>China Medicare - Fully Responsive</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    
    <!-- Favicon -->
    <link href="{{ asset('images/company/' . $company->fav_icon) }}" rel="icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/company/' . $company->fav_icon) }}">
    <title>{{ $company->meta_title ?? $company->company_name }}</title>
        {!! SEOMeta::generate() !!}
        {!! OpenGraph::generate() !!}
        {!! Twitter::generate() !!}


    <link rel="stylesheet" href="{{ asset('resources/frontend/style.css') }}">

</head>
<body>






    @include('frontend.inc.header')

        @yield('content')

    @include('frontend.cookies')

    @include('frontend.inc.footer')




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('script')

</body>
</html>
