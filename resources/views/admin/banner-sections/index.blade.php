@extends('admin.pages.master')
@section('title', 'Banner Section Management')
@section('content')

    <div class="container-fluid" id="newBtnSection">
        <div class="row mb-3">
            <div class="col-auto">
                <button class="btn btn-primary" id="newBtn">
                    <i class="ri-add-line me-1"></i> Add New Banner Section
                </button>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="addThisFormContainer" style="display:none;">
        <div class="row justify-content-center">
            <div class="col-xl-11">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 id="cardTitle" class="mb-0">Add New Banner Section</h4>
                        <button type="button" id="FormCloseBtnTop" class="btn btn-sm btn-light">
                            <i class="ri-close-line"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <form id="createThisForm">
                            @csrf
                            <input type="hidden" id="codeid" name="id">

                            <!-- Tab Navigation -->
                            <ul class="nav nav-tabs mb-4" id="bannerTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" 
                                        data-bs-target="#general" type="button" role="tab">
                                        <i class="ri-file-text-line me-1"></i> General
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="seo-tab" data-bs-toggle="tab" 
                                        data-bs-target="#seo" type="button" role="tab">
                                        <i class="ri-search-line me-1"></i> SEO
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="bannerTabContent">

                                <!-- General Tab -->
                                <div class="tab-pane fade show active" id="general" role="tabpanel">

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Page <span class="text-danger">*</span></label>
                                            <select id="page" name="page" class="form-select" required>
                                                <option value="">-- Select Page --</option>
                                                <option value="About">About</option>
                                                <option value="Blog">Blog</option>
                                                <option value="Packages">Packages</option>
                                                <option value="Hospital">Hospital</option>
                                                <option value="Services">Services</option>
                                                <option value="Contact">Contact</option>
                                                <option value="Gallery">Gallery</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Section Name</label>
                                            <input type="text" id="name" name="name" class="form-control" 
                                                placeholder="e.g. About Hero Banner">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Status</label>
                                            <select id="status" name="status" class="form-select">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Short Title</label>
                                            <input type="text" id="short_title" name="short_title" class="form-control" 
                                                placeholder="e.g. Welcome to Our Organization">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Short Description</label>
                                            <input type="text" id="short_description" name="short_description" class="form-control" 
                                                placeholder="Brief one-line description">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Long Title</label>
                                        <textarea id="long_title" name="long_title" class="form-control" rows="2" 
                                            placeholder="Detailed heading for the banner"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Long Description</label>
                                        <textarea id="long_description" name="long_description" class="form-control" rows="3" 
                                            placeholder="Detailed description for the banner section"></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Banner Image</label>
                                            <input type="file" id="banner_image" name="image" class="form-control" 
                                                accept="image/*">
                                            <small class="text-muted">Recommended: 1920x600px, JPG/PNG/WebP, Max 2MB</small>
                                            <div id="imagePreviewBox" class="mt-2" style="display:none;">
                                                <img id="imagePreview" src="" width="200" height="80"
                                                    style="object-fit:cover; border-radius:6px; border:1px solid #dee2e6;">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- SEO Tab -->
                                <div class="tab-pane fade" id="seo" role="tabpanel">

                                    <div class="mb-3">
                                        <label class="form-label">Meta Title</label>
                                        <input type="text" id="meta_title" name="meta_title" class="form-control" 
                                            placeholder="SEO title for this page">
                                        <small class="text-muted">Recommended: 50-60 characters</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Meta Description</label>
                                        <textarea id="meta_description" name="meta_description" class="form-control" rows="3" 
                                            placeholder="Brief description for search engines"></textarea>
                                        <small class="text-muted">Recommended: 150-160 characters</small>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Meta Image</label>
                                            <input type="file" id="meta_image" name="meta_image" class="form-control" 
                                                accept="image/*">
                                            <small class="text-muted">Recommended: 1200x630px (OG Image)</small>
                                            <div id="metaImagePreviewBox" class="mt-2" style="display:none;">
                                                <img id="metaImagePreview" src="" width="150" height="80"
                                                    style="object-fit:cover; border-radius:6px; border:1px solid #dee2e6;">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Meta Keywords</label>
                                            <textarea id="meta_keywords" name="meta_keywords" class="form-control" rows="4" 
                                                placeholder="keyword1, keyword2, keyword3"></textarea>
                                            <small class="text-muted">Comma separated keywords</small>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="mb-3 text-end border-top pt-3">
                                <button type="button" id="addBtn" class="btn btn-primary" value="Create">
                                    <i class="ri-save-line me-1"></i> Save Banner Section
                                </button>
                                <button type="button" id="FormCloseBtn" class="btn btn-light">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="contentContainer">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Banner Sections</h4>
            </div>
            <div class="card-body">
                <table id="bannerTable" class="table table-bordered table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Page</th>
                            <th>Name</th>
                            <th>Short Title</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#bannerTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('banner-section.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'page', name: 'page' },
                    { data: 'name', name: 'name' },
                    { data: 'short_title', name: 'short_title' },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[1, 'asc']]
            });

            // New Button Click
            $('#newBtn').click(function() {
                resetForm();
                $('#cardTitle').text('Add New Banner Section');
                $('#addBtn').val('Create').html('<i class="ri-save-line me-1"></i> Save Banner Section');
                $('#addThisFormContainer').show(300);
                $('#newBtn').hide();
                // Reset to General tab
                $('#general-tab').tab('show');
            });

            // Close Form
            $('#FormCloseBtn, #FormCloseBtnTop').click(function() {
                $('#addThisFormContainer').hide(200);
                $('#newBtn').show(100);
            });

            // Reset Form
            function resetForm() {
                $('#createThisForm')[0].reset();
                $('#codeid').val('');
                $('#status').val('1');
                $('#imagePreviewBox').hide();
                $('#metaImagePreviewBox').hide();
            }

            // Create / Update Logic
            $('#addBtn').click(function() {
                var btn = this;
                var url = $(btn).val() === 'Create' 
                    ? "{{ route('banner-section.store') }}" 
                    : "{{ route('banner-section.update') }}";
                var form = document.getElementById('createThisForm');
                var fd = new FormData(form);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(btn).prop('disabled', true).html('<i class="ri-loader-4-line ri-spin me-1"></i> Saving...');
                    },
                    success: function(res) {
                        showSuccess(res.message);
                        setTimeout(function() {
                            resetForm();
                        }, 3000);
                        $('#addThisFormContainer').hide();
                        $('#newBtn').show();
                        table.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            showError(Object.values(xhr.responseJSON.errors)[0][0]);
                        } else {
                            showError('Something went wrong');
                        }
                    },
                    complete: function() {
                        $(btn).prop('disabled', false).html(
                            $(btn).val() === 'Create' 
                                ? '<i class="ri-save-line me-1"></i> Save Banner Section'
                                : '<i class="ri-save-line me-1"></i> Update Banner Section'
                        );
                    }
                });
            });

            // Edit Logic
            $(document).on('click', '.EditBtn', function() {
                var id = $(this).data('id');
                $.get("{{ url('/admin/banner-section') }}/" + id + "/edit", function(res) {
                    $('#codeid').val(res.id);
                    $('#page').val(res.page);
                    $('#name').val(res.name);
                    $('#short_title').val(res.short_title);
                    $('#long_title').val(res.long_title);
                    $('#short_description').val(res.short_description);
                    $('#long_description').val(res.long_description);
                    $('#status').val(res.status ? '1' : '0');

                    // SEO Fields
                    $('#meta_title').val(res.meta_title);
                    $('#meta_description').val(res.meta_description);
                    $('#meta_keywords').val(res.meta_keywords);

                    // Image Preview
                    if (res.image) {
                        $('#imagePreview').attr('src', '/' + res.image);
                        $('#imagePreviewBox').show();
                    } else {
                        $('#imagePreviewBox').hide();
                    }

                    // Meta Image Preview
                    if (res.meta_image) {
                        $('#metaImagePreview').attr('src', '/' + res.meta_image);
                        $('#metaImagePreviewBox').show();
                    } else {
                        $('#metaImagePreviewBox').hide();
                    }

                    $('#cardTitle').text('Update Banner Section');
                    $('#addBtn').val('Update').html('<i class="ri-save-line me-1"></i> Update Banner Section');
                    $('#addThisFormContainer').show(300);
                    $('#newBtn').hide();

                    // Switch to General tab
                    $('#general-tab').tab('show');
                });
            });


            // Image Preview on file select
            $('#banner_image').on('change', function() {
                previewImage(this, '#imagePreview', '#imagePreviewBox');
            });

            $('#meta_image').on('change', function() {
                previewImage(this, '#metaImagePreview', '#metaImagePreviewBox');
            });

            function previewImage(input, imgSelector, boxSelector) {
                var file = input.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $(imgSelector).attr('src', e.target.result);
                        $(boxSelector).show();
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
    </script>
@endsection