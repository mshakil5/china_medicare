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
    /* Honeypot - hidden from humans, bots will fill it */
    .hp-field {
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        height: 0;
        width: 0;
        z-index: -1;
        overflow: hidden;
    }
</style>

{{-- ✅ 1. Dynamic Banner Section --}}
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
                {!! $banner->long_title ?? __('home.contact_page_title') !!}
            </h1>
            
            @if($banner->short_description)
                <p class="text-light-gray mx-auto max-w-600">{{ $banner->short_description }}</p>
            @else
                <p class="text-light-gray mx-auto max-w-600">{{ __('home.contact_page_subtitle') }}</p>
            @endif
        @else
            <span class="badge rounded-pill bg-dark-teal mb-3 py-2 px-3 border-teal-thin">
                <i class="far fa-comment-dots text-teal me-2"></i> {{ __('home.free_consultation') }}
            </span>
            <h1 class="display-5 fw-bold text-white mb-3">{!! __('home.contact_page_title') !!}</h1>
            <p class="text-light-gray mx-auto max-w-600">{{ __('home.contact_page_subtitle') }}</p>
        @endif
    </div>
</section>


{{-- ✅ 2. Contact Info & Form Section --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            
            {{-- Left Column: Contact Details --}}
            <div class="col-lg-5 col-xl-4">
                <h3 class="fw-bold mb-4">{{ __('home.were_here_to_help') }}</h3>
                
                <div class="row g-3">
                    
                    {{-- Dynamic Phone --}}
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="contact-info-card p-4 bg-white shadow-sm rounded-4">
                            <div class="icon-circle bg-teal-light text-teal mb-3"><i class="fas fa-phone-alt"></i></div>
                            <h6 class="fw-bold">{{ __('home.phone') }}</h6>
                            <p class="small text-muted mb-1">{{ $company->phone1 ?? 'N/A' }}</p>
                            <p class="x-small text-teal mb-0">{{ __('home.international_hotline') }}</p>
                        </div>
                    </div>

                    {{-- Dynamic Email --}}
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="contact-info-card p-4 bg-white shadow-sm rounded-4">
                            <div class="icon-circle bg-blue-light text-primary mb-3"><i class="fas fa-envelope"></i></div>
                            <h6 class="fw-bold">{{ __('home.email') }}</h6>
                            <p class="small text-muted mb-1">{{ $company->email1 ?? 'N/A' }}</p>
                            <p class="x-small text-teal mb-0">{{ __('home.respond_within_24h') }}</p>
                        </div>
                    </div>

                    {{-- Dynamic Address --}}
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="contact-info-card p-4 bg-white shadow-sm rounded-4">
                            <div class="icon-circle bg-orange-light text-warning mb-3"><i class="fas fa-map-marker-alt"></i></div>
                            <h6 class="fw-bold">{{ __('home.head_office') }}</h6>
                            <p class="small text-muted mb-0">
                                {{ $company->address1 ?? 'N/A' }} 
                                @if($company->address2)
                                    <br>{{ $company->address2 }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Dynamic Google Map --}}
                <div class="mt-4 rounded-4 overflow-hidden shadow-sm position-relative">
                    <div class="ratio ratio-16x9">
                        @if(!empty($company->google_map))
                            <iframe 
                                src="{{ $company->google_map }}" 
                                width="600" 
                                height="450" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        @else
                            <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                <p class="text-muted mb-0"><i class="fas fa-map-marker-alt me-2"></i>{{ __('home.map_not_available') }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="map-overlay p-3 text-white">
                        <p class="fw-bold mb-0">{{ $company->address1 ?? 'Dhaka' }}</p>
                        <p class="x-small mb-0">{{ __('home.global_medical_hub') }}</p>
                    </div>
                </div>

                <div class="mt-4 rounded-4 overflow-hidden shadow-sm position-relative">
                    <div class="ratio ratio-16x9">
                        @if(!empty($company->google_map))
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3055.895064085665!2d116.3482322759909!3d40.01079147150782!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNDDCsDAwJzM4LjkiTiAxMTbCsDIxJzAyLjkiRQ!5e0!3m2!1sen!2sbd!4v1778160556033!5m2!1sen!2sbd" 
                                width="600" 
                                height="450" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        @else
                            <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                <p class="text-muted mb-0"><i class="fas fa-map-marker-alt me-2"></i>{{ __('home.map_not_available') }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="map-overlay p-3 text-white">
                        <p class="fw-bold mb-0">No 30, Shuangqing Road, Haidian District, Beijing - 100084.</p>
                    </div>
                </div>

            </div>

            {{-- Right Column: Contact Form --}}
            <div class="col-lg-7 col-xl-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-lg-5">
                    <h4 class="fw-bold mb-2">{{ __('home.send_inquiry') }}</h4>
                    <p class="text-muted small mb-4">{{ __('home.send_inquiry_text') }}</p>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('contact.store') }}" method="POST" enctype="multipart/form-data" id="contactForm">
                        @csrf

                        {{-- ===== ANTI-SPAM: Honeypot Field ===== --}}
                        {{-- Humans won't see this; bots auto-fill all fields --}}
                        <div class="hp-field">
                            <label>Leave this empty</label>
                            <input type="text" name="website_url" tabindex="-1" autocomplete="off">
                        </div>

                        {{-- ===== ANTI-SPAM: Time-based check ===== --}}
                        {{-- Records when the page was loaded; if form submitted too fast = bot --}}
                        <input type="hidden" name="form_loaded_at" value="{{ time() }}">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">{{ __('home.full_name') }}</label>
                                <input type="text" name="full_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">{{ __('home.email_address') }}</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">{{ __('home.phone_number') }}</label>
                                <input type="tel" name="phone" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">{{ __('home.your_country') }}</label>
                                <input type="text" name="country" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small fw-bold">{{ __('home.additional_details') }}</label>
                                <textarea name="message" class="form-control" rows="4"></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold">{{ __('home.upload_medical_records') }}</label>
                                <p class="text-muted x-small">
                                    {{ __('home.upload_info') }}
                                </p>

                                <div class="upload-dropzone p-4 text-center rounded-4 mt-3 position-relative"
                                    onclick="document.getElementById('fileInput').click()"
                                    style="cursor:pointer; border:2px dashed #ddd;">
                                    
                                    <input type="file"
                                        id="fileInput"
                                        name="file"
                                        class="d-none"
                                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                                        onchange="showFileName(this)">

                                    <i class="fas fa-cloud-upload-alt text-muted fs-2 mb-2"></i>
                                    <p class="small mb-0">{{ __('home.click_to_upload') }}</p>
                                    <p class="x-small text-muted mt-1">{{ __('home.upload_formats') }}</p>

                                    <p id="fileName" class="small text-success mt-2"></p>
                                </div>
                            </div>

                            {{-- ===== Math CAPTCHA ===== --}}
                            <div class="col-md-6 mt-3">
                                <label class="form-label small fw-bold">
                                    Solve the math: {{ $num1 ?? 1 }} + {{ $num2 ?? 1 }} = ?
                                </label>
                                <input type="number" name="captcha_answer" class="form-control @error('captcha_answer') is-invalid @enderror" required autocomplete="off">
                                @error('captcha_answer')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="w-100 py-3 fw-bold btn btn-teal-solid w-lg-auto px-4">
                                    <i class="fas fa-paper-plane me-2"></i> {{ __('home.submit_inquiry') }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</section>

{{-- Hidden FAQ section --}}
<section class="py-5 bg-white d-none">
    <div class="container py-lg-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold">{{ __('home.faq_title') }}</h2>
            <p class="text-muted">{{ __('home.faq_subtitle') }}</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="faq-item p-4 bg-light rounded-4 h-100">
                    <h6 class="fw-bold">{{ __('home.faq_visa_q') }}</h6>
                    <p class="small text-muted mb-0">{{ __('home.faq_visa_a') }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="faq-item p-4 bg-light rounded-4 h-100">
                    <h6 class="fw-bold">{{ __('home.faq_interpreter_q') }}</h6>
                    <p class="small text-muted mb-0">{{ __('home.faq_interpreter_a') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')

<script>
    function showFileName(input) {
        const fileNameSpan = document.getElementById('fileName');
        const tooLargeMsg = "{{ __('home.file_too_large') }}";
        if (input.files && input.files[0]) {
            const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2);
            if (input.files[0].size > 10 * 1024 * 1024) {
                fileNameSpan.innerHTML = '<span class="text-danger">' + tooLargeMsg + '</span>';
                input.value = '';
            } else {
                fileNameSpan.innerHTML = '<i class="fas fa-check-circle me-1"></i> ' + input.files[0].name + ' (' + fileSize + ' MB)';
            }
        } else {
            fileNameSpan.innerHTML = '';
        }
    }
</script>
@endsection