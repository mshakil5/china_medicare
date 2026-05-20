@extends('frontend.layouts.master')

@section('content')

@php $info = $blog->translation(); @endphp
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="/" class="text-teal text-decoration-none">{{ __('menu.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('front.blog') }}" class="text-teal text-decoration-none">{{ __('menu.blog') }}</a></li>
                        <li class="breadcrumb-item active">{{ Str::limit($info->title, 30) }}</li>
                    </ol>
                </nav>

                <h1 class="fw-bold display-5 mb-3">{{ $info->title }}</h1>
                
                <div class="med-article-body text-muted">
                    <p class="lead text-dark mb-4">{{ $info->summary }}</p>
                    
                    <img src="{{ asset($blog->image) }}" class="img-fluid rounded-4 mb-4 w-100" alt="{{ $info->title }}">

                    <div class="description-content text-dark">
                        {!! $info->description !!}
                    </div>
                </div>
                
                <div class="mt-5 pt-4 border-top">
                    <span class="me-2 fw-bold small">{{ __('home.tags') }}</span>
                    @if($info->tags)
                        @foreach(explode(',', $info->tags) as $tag)
                            <a href="#" class="badge bg-light text-muted text-decoration-none rounded-pill px-3 py-2 me-2">
                                {{ trim($tag) }}
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sticky-top" style="top: 2rem;">
                    <div class="card border-0 shadow-sm mb-4 rounded-4 d-none">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3">{{ __('home.search_articles') }}</h6>
                            <form action="{{ route('front.blog') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control border-0 bg-light" placeholder="{{ __('home.type_keywords') }}">
                                    <button class="btn btn-teal text-white px-3"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4 rounded-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-4">{{ __('home.trending_now') }}</h6>
                            @foreach($trending as $tBlog)
                                @php $tInfo = $tBlog->translation(); @endphp
                                <div class="d-flex mb-3">
                                    <img src="{{ asset($tBlog->image) }}" class="rounded-3 me-3" style="width: 80px; height: 60px; object-fit: cover;" alt="Post">
                                    <div>
                                        <a href="{{ route('front.blog.details', $tBlog->slug) }}" class="text-dark text-decoration-none small fw-bold d-block mb-1">
                                            {{ Str::limit($tInfo->title, 45) }}
                                        </a>
                                        <small class="text-muted">{{ $tBlog->created_at->format('M d, Y') }}</small>
                                    </div>
                                </div>
                            @endforeach
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