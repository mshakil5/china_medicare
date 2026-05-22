@extends('admin.pages.master')
@section('title', 'Company About Us')

@section('header-styles')
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                @if (session()->has('success'))
                    <div class="alert alert-success pt-3 mb-3" id="successMessage">{{ session()->get('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0 flex-grow-1">About Us Management</h3>
                    </div>

                    <form action="{{ route('admin.aboutUs') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row g-3">

                                <!-- Image Uploads -->
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Image 1</label>
                                    <input type="file" name="about_image1" class="form-control" accept="image/*" onchange="previewImage(this, 'preview1')">
                                    @if($companyDetails->about_image1)
                                        <img id="preview1" src="{{ asset($companyDetails->about_image1) }}" class="mt-2 rounded" height="100">
                                    @else
                                        <img id="preview1" src="" class="mt-2 rounded d-none" height="100">
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Image 2</label>
                                    <input type="file" name="about_image2" class="form-control" accept="image/*" onchange="previewImage(this, 'preview2')">
                                    @if($companyDetails->about_image2)
                                        <img id="preview2" src="{{ asset($companyDetails->about_image2) }}" class="mt-2 rounded" height="100">
                                    @else
                                        <img id="preview2" src="" class="mt-2 rounded d-none" height="100">
                                    @endif
                                </div>

                                <!-- English Content -->
                                <div class="col-sm-12 mt-4">
                                    <div class="form-group">
                                        <label>About Us (English)</label>
                                        <textarea name="about_us_en" class="form-control summernote">{!! $companyDetails->about_us_en ?? '' !!}</textarea>
                                    </div>
                                </div>

                                <!-- Bangla Content -->
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>About Us (বাংলা)</label>
                                        <textarea name="about_us_bn" class="form-control summernote">{!! $companyDetails->about_us_bn ?? '' !!}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-secondary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Summernote with necessary features
            $('.summernote').summernote({
                height: 250,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
        });

        // Image Preview Function
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).attr('src', e.target.result).removeClass('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection