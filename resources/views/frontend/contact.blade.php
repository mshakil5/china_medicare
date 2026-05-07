@extends('frontend.layouts.master')

@section('content')

<style>
    /* ✅ Overlay CSS to ensure text is readable over dynamic banner image */
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
                {!! $banner->long_title ?? 'Get in <span class="text-teal">Touch</span>' !!}
            </h1>
            
            @if($banner->short_description)
                <p class="text-light-gray mx-auto max-w-600">{{ $banner->short_description }}</p>
            @else
                <p class="text-light-gray mx-auto max-w-600">Start your medical journey today. Our team is ready to help you find the best healthcare solution in China.</p>
            @endif
        @else
            <span class="badge rounded-pill bg-dark-teal mb-3 py-2 px-3 border-teal-thin">
                <i class="far fa-comment-dots text-teal me-2"></i> Free Consultation
            </span>
            <h1 class="display-5 fw-bold text-white mb-3">Get in <span class="text-teal">Touch</span></h1>
            <p class="text-light-gray mx-auto max-w-600">Start your medical journey today. Our team is ready to help you find the best healthcare solution in China.</p>
        @endif
    </div>
</section>


{{-- ✅ 2. Contact Info & Form Section --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            
            {{-- Left Column: Contact Details --}}
            <div class="col-lg-5 col-xl-4">
                <h3 class="fw-bold mb-4">We're Here to Help</h3>
                
                <div class="row g-3">
                    
                    {{-- Dynamic Phone --}}
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="contact-info-card p-4 bg-white shadow-sm rounded-4">
                            <div class="icon-circle bg-teal-light text-teal mb-3"><i class="fas fa-phone-alt"></i></div>
                            <h6 class="fw-bold">Phone</h6>
                            <p class="small text-muted mb-1">{{ $company->phone1 ?? 'N/A' }}</p>
                            <p class="x-small text-teal mb-0">International hotline available</p>
                        </div>
                    </div>

                    {{-- Dynamic Email --}}
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="contact-info-card p-4 bg-white shadow-sm rounded-4">
                            <div class="icon-circle bg-blue-light text-primary mb-3"><i class="fas fa-envelope"></i></div>
                            <h6 class="fw-bold">Email</h6>
                            <p class="small text-muted mb-1">{{ $company->email1 ?? 'N/A' }}</p>
                            <p class="x-small text-teal mb-0">We respond within 24 hours</p>
                        </div>
                    </div>

                    {{-- Dynamic Address --}}
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="contact-info-card p-4 bg-white shadow-sm rounded-4">
                            <div class="icon-circle bg-orange-light text-warning mb-3"><i class="fas fa-map-marker-alt"></i></div>
                            <h6 class="fw-bold">Head Office</h6>
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
                            {{-- 
                                Note: If your database stores ONLY the URL (e.g., https://www.google.com/maps/embed...), use src="{{ $company->google_map }}"
                                If your database stores the FULL IFRAME HTML TAG, change the line below to: {!! $company->google_map !!}
                            --}}
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
                                <p class="text-muted mb-0"><i class="fas fa-map-marker-alt me-2"></i>Map not available</p>
                            </div>
                        @endif
                    </div>
                    <div class="map-overlay p-3 text-white">
                        <p class="fw-bold mb-0">{{ $company->address1 ?? 'China' }}</p>
                        <p class="x-small mb-0">Global Medical Tourism Hub</p>
                    </div>
                </div>

            </div>

            {{-- Right Column: Contact Form --}}
            <div class="col-lg-7 col-xl-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-lg-5">
                    <h4 class="fw-bold mb-2">Send Us an Inquiry</h4>
                    <p class="text-muted small mb-4">Fill out the form below and our medical coordinator will contact you within 24 hours.</p>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('contact.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Full Name *</label>
                                <input type="text" name="full_name" class="form-control" placeholder="Your full name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Email Address *</label>
                                <input type="email" name="email" class="form-control" placeholder="your@email.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Phone Number</label>
                                <input type="tel" name="phone" class="form-control" placeholder="+1 234 567 8900">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Your Country</label>
                                <input type="text" name="country" class="form-control" placeholder="Country of residence">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small fw-bold">Additional Details</label>
                                <textarea name="message" class="form-control" rows="4" placeholder="Tell us about your medical requirements..."></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold">Upload Medical Records</label>
                                <p class="text-muted x-small">
                                    Share your medical history, test results, or prescriptions (Max 10MB per file)
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
                                    <p class="small mb-0">Click to upload or drag and drop</p>
                                    <p class="x-small text-muted mt-1">PDF, JPG, PNG, DOC (MAX. 10MB)</p>

                                    <p id="fileName" class="small text-success mt-2"></p>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="w-100 py-3 fw-bold btn btn-teal-solid w-lg-auto px-4">
                                    <i class="fas fa-paper-plane me-2"></i> Submit Inquiry
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</section>

{{-- Hidden FAQ section (kept exactly as you had it) --}}
<section class="py-5 bg-white d-none">
    <div class="container py-lg-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Frequently Asked Questions</h2>
            <p class="text-muted">Have questions? We have answers.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="faq-item p-4 bg-light rounded-4 h-100">
                    <h6 class="fw-bold">How long does the visa process take?</h6>
                    <p class="small text-muted mb-0">Medical visas typically take 3-5 business days with our expedited service.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="faq-item p-4 bg-light rounded-4 h-100">
                    <h6 class="fw-bold">Is there interpreter service?</h6>
                    <p class="small text-muted mb-0">Yes, we provide 24/7 professional medical interpreters in multiple languages.</p>
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
        if (input.files && input.files[0]) {
            const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2);
            if (input.files[0].size > 10 * 1024 * 1024) {
                fileNameSpan.innerHTML = '<span class="text-danger">File is too large! Max 10MB allowed.</span>';
                input.value = ''; // Clear the invalid file
            } else {
                fileNameSpan.innerHTML = '<i class="fas fa-check-circle me-1"></i> ' + input.files[0].name + ' (' + fileSize + ' MB)';
            }
        } else {
            fileNameSpan.innerHTML = '';
        }
    }
</script>
@endsection