@extends('frontend.layouts.master')

@section('content')

    <section class="py-5 bg-light med-blog-section">
        <div class="container py-lg-4">
            <div class="row align-items-end mb-5 text-center text-md-start">
                <div class="col-md-8">
                    <h2 class="fw-bold display-6">{!! __('home.latest_medical_news') !!}</h2>
                </div>
            </div>

            <div class="row g-4">
                @foreach($blogs as $blog)
                    @php $info = $blog->translation(); @endphp
                    <div class="col-md-6 col-lg-4">
                        <article class="card h-100 border-0 shadow-sm med-blog-card">
                            <div class="med-blog-img-wrapper">
                                <img src="{{ asset($blog->image) }}" class="card-img-top" alt="{{ $info->title }}">
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3 small text-muted">
                                    <span><i class="far fa-calendar-alt me-2"></i>{{ $blog->created_at->format('M d, Y') }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $blog->read_time }}</span>
                                </div>
                                <h5 class="fw-bold mb-3 med-blog-title">
                                    <a href="{{ route('front.blog.details', $blog->slug) }}" class="text-dark text-decoration-none">
                                        {{ $info->title }}
                                    </a>
                                </h5>
                                <p class="text-muted small mb-4">{{ Str::limit($info->summary, 120) }}</p>
                                <a href="{{ route('front.blog.details', $blog->slug) }}" class="text-teal fw-bold text-decoration-none small">
                                    {{ __('home.read_full_article') }} <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection

@section('script')


@endsection