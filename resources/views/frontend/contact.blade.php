@extends('frontend.layouts.master')

@section('content')





<section class="contact-hero py-5">
    <div class="container py-lg-4 text-center">
        <span class="badge rounded-pill bg-dark-teal mb-3 py-2 px-3 border-teal-thin">
            <i class="far fa-comment-dots text-teal me-2"></i> Free Consultation
        </span>
        <h1 class="display-5 fw-bold text-white mb-3">Get in <span class="text-teal">Touch</span></h1>
        <p class="text-light-gray mx-auto max-w-600">Start your medical journey today. Our team is ready to help you find the best healthcare solution in China.</p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5 col-xl-4">
                <h3 class="fw-bold mb-4">We're Here to Help</h3>
                
                <div class="row g-3">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="contact-info-card p-4 bg-white shadow-sm rounded-4">
                            <div class="icon-circle bg-teal-light text-teal mb-3"><i class="fas fa-phone-alt"></i></div>
                            <h6 class="fw-bold">Phone</h6>
                            <p class="small text-muted mb-1">+86 188 1056 1453</p>
                            <p class="x-small text-teal mb-0">International hotline available</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="contact-info-card p-4 bg-white shadow-sm rounded-4">
                            <div class="icon-circle bg-blue-light text-primary mb-3"><i class="fas fa-envelope"></i></div>
                            <h6 class="fw-bold">Email</h6>
                            <p class="small text-muted mb-1">chinamedicare.cn@gmail.com</p>
                            <p class="x-small text-teal mb-0">We respond within 24 hours</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="contact-info-card p-4 bg-white shadow-sm rounded-4">
                            <div class="icon-circle bg-orange-light text-warning mb-3"><i class="fas fa-map-marker-alt"></i></div>
                            <h6 class="fw-bold">Head Office</h6>
                            <p class="small text-muted mb-0">No 30, Shuangqing Road, Haidian District, Beijing - 100084.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 rounded-4 overflow-hidden shadow-sm position-relative">
                    <div class="ratio ratio-16x9">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3412.1234567890!2d121.505228!3d31.235862!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x35b270e505e2fdef%3A0x8f4e687341584dd6!2zODggU2hpIEppIERhIERhbywgTHVqaWF6dWksIFB1IERvbmcgWGluIFF1LCBTaGFuZyBIYWkgU2hpLCBDaGluYSwgMjAwMTIw!5e0!3m2!1sen!2s!4v1700000000000!5m2!1sen!2s" 
                            width="600" 
                            height="450" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    <div class="map-overlay p-3 text-white">
                        <p class="fw-bold mb-0">Shanghai, China</p>
                        <p class="x-small mb-0">Global Medical Tourism Hub</p>
                    </div>
                </div>


            </div>

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
                                <input type="text" name="full_name" class="form-control" placeholder="Your full name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Email Address *</label>
                                <input type="email" name="email" class="form-control" placeholder="your@email.com">
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
                                <textarea name="message" class="form-control" rows="4"></textarea>
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

<section class="py-5 bg-white">
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


@endsection