@extends('admin.pages.master')
@section('title', 'Medical Packages')

@section('css')
<style>
    .img-preview-container {
        position: relative;
        display: inline-block;
        margin-bottom: 10px;
    }
    .img-preview-container img {
        width: 120px;
        height: 90px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #e9ecef;
    }
    .img-preview-container .remove-img {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #dc3545;
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }
    .spinner-border {
        width: 1.2rem;
        height: 1.2rem;
        margin-right: 0.5rem;
    }
    .seo-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-top: 15px;
    }
    .feature-tag {
        display: inline-flex;
        align-items: center;
        background: #e7f5ff;
        border: 1px solid #74c0fc;
        color: #1971c2;
        padding: 4px 10px;
        border-radius: 20px;
        margin: 2px;
        font-size: 13px;
    }
    .feature-tag .remove-feature {
        margin-left: 6px;
        cursor: pointer;
        color: #e03131;
    }
    .tab-content {
        min-height: 200px;
    }
    .features-section {
        background: #f0fdf4;
        border: 1px solid #86efac;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }
</style>
@endsection

@section('content')

<div class="container-fluid" id="newBtnSection">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Medical Packages</h4>
        <button type="button" class="btn btn-primary" id="newBtn">
            <i class="ri-add-line me-1"></i> Add New Package
        </button>
    </div>
</div>

<div class="container-fluid" id="addThisFormContainer" style="display: none;">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0" id="cardTitle">Add New Medical Package</h4>
            <button type="button" id="FormCloseBtn" class="btn btn-sm btn-light">
                <i class="ri-close-line"></i>
            </button>
        </div>
        <div class="card-body">
            <form id="createThisForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="codeid" name="codeid">
                
                <!-- Basic Information -->
                <h5 class="text-primary mb-3">
                    <i class="ri-information-line me-1"></i> Basic Information
                </h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Package Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="image" id="image" accept="image/*">
                        <div id="imagePreview" class="mt-2"></div>
                        <small class="text-muted">Recommended: 800x600px, Max 2MB</small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-select" name="category" id="category" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $key => $category)
                                <option value="{{ $key }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Duration <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="duration" id="duration" 
                               placeholder="e.g., 7 days, 2 weeks" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Price Range</label>
                        <input type="text" class="form-control" name="price_range" id="price_range" 
                               placeholder="e.g., 5000-10000">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cities Count</label>
                        <input type="number" class="form-control" name="cities_count" id="cities_count" 
                               value="1" min="1">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="status" id="status" checked>
                            <label class="form-check-label" for="status">Active</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex gap-4 mt-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_popular" id="is_popular">
                                <label class="form-check-label" for="is_popular">
                                    <span class="badge bg-info">Popular</span>
                                </label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured">
                                <label class="form-check-label" for="is_featured">
                                    <span class="badge bg-warning">Featured</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ❌ REMOVED: The standalone Features Section is gone -->
                <!-- Features are now INSIDE each locale tab below -->

                <!-- Translatable Fields -->
                <hr>
                <h5 class="text-primary mb-3">
                    <i class="ri-translate-2 me-1"></i> Multilingual Content
                </h5>
                <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                    @foreach(config('translatable.locales') as $index => $locale)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" 
                               data-bs-toggle="tab" href="#tab-{{ $locale }}" role="tab">
                                {{ strtoupper($locale) }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach(config('translatable.locales') as $index => $locale)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" 
                             id="tab-{{ $locale }}" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Title ({{ strtoupper($locale) }}) <span class="text-danger">*</span></label>
                                    <input type="text" name="{{ $locale }}[title]" id="{{ $locale }}_title" 
                                           class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Subtitle ({{ strtoupper($locale) }})</label>
                                    <input type="text" name="{{ $locale }}[subtitle]" id="{{ $locale }}_subtitle" 
                                           class="form-control" placeholder="Native language title">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Description ({{ strtoupper($locale) }})</label>
                                    <textarea name="{{ $locale }}[description]" id="{{ $locale }}_description" 
                                              class="form-control" rows="3"></textarea>
                                </div>
                            </div>

                            <!-- ✅ NEW: Features Section PER LOCALE -->
                            <div class="features-section">
                                <h6 class="text-success mb-3">
                                    <i class="ri-list-check-2 me-1"></i> Package Features ({{ strtoupper($locale) }})
                                </h6>
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" id="featureInput_{{ $locale }}" class="form-control" 
                                                   placeholder="Type a feature in {{ strtoupper($locale) }} and press Enter">
                                            <button type="button" class="btn btn-success addFeatureBtn" data-locale="{{ $locale }}">
                                                <i class="ri-add-line"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="featureTags_{{ $locale }}" class="mb-3">
                                    <span class="text-muted">No features added yet</span>
                                </div>
                                <!-- Hidden inputs will be dynamically generated -->
                            </div>

                            <!-- SEO Fields -->
                            <div class="seo-section">
                                <h6 class="text-muted mb-3">
                                    <i class="ri-search-line me-1"></i> SEO Settings ({{ strtoupper($locale) }})
                                </h6>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Meta Title</label>
                                        <input type="text" name="{{ $locale }}[meta_title]" 
                                               id="{{ $locale }}_meta_title" class="form-control"
                                               placeholder="Leave empty to use package title"
                                               maxlength="60">
                                        <small class="text-muted">Recommended: 50-60 characters</small>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Meta Description</label>
                                        <textarea name="{{ $locale }}[meta_description]" 
                                                  id="{{ $locale }}_meta_description" class="form-control" 
                                                  rows="2" maxlength="160"
                                                  placeholder="Brief description for search engines"></textarea>
                                        <small class="text-muted">Recommended: 150-160 characters</small>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Meta Keywords</label>
                                        <input type="text" name="{{ $locale }}[meta_keywords]" 
                                               id="{{ $locale }}_meta_keywords" class="form-control"
                                               placeholder="keyword1, keyword2, keyword3">
                                        <small class="text-muted">Separate keywords with commas</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Global SEO Fields -->
                <hr>
                <h5 class="text-primary mb-3">
                    <i class="ri-global-line me-1"></i> Global SEO Settings
                </h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">OG Image (Open Graph)</label>
                        <input type="file" class="form-control" name="og_image" id="og_image" accept="image/*">
                        <div id="ogImagePreview" class="mt-2"></div>
                        <small class="text-muted">Used for social media sharing. Recommended: 1200x630px</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Canonical URL</label>
                        <input type="url" class="form-control" name="canonical_url" id="canonical_url" 
                               placeholder="https://example.com/package/slug">
                        <small class="text-muted">Prevents duplicate content issues</small>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer text-end">
            <button type="button" id="FormCloseBtnBottom" class="btn btn-light me-2">Cancel</button>
            <button type="button" id="addBtn" class="btn btn-primary">
                <span class="btn-text"><i class="ri-save-line me-1"></i> Save Package</span>
                <span class="btn-spinner d-none">
                    <span class="spinner-border spinner-border-sm" role="status"></span>
                    Saving...
                </span>
            </button>
        </div>
    </div>
</div>

<!-- DataTable -->
<div class="container-fluid" id="contentContainer">
    <div class="card">
        <div class="card-body">
            <table id="packageTable" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th width="50">Sl</th>
                        <th width="100">Image</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        
        // Initialize DataTable
        var table = $('#packageTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.medical_package.data') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'image', name: 'image', orderable: false, searchable: false },
                { data: 'category', name: 'category' },
                { data: 'title', name: 'title' },
                { data: 'price_range', name: 'price_range' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'desc']]
        });

        // ✅ Features Management — PER LOCALE
        const locales = @json(config('translatable.locales'));
        let featuresMap = {};
        locales.forEach(function(locale) {
            featuresMap[locale] = [];
        });

        function renderFeatures(locale) {
            let html = '';
            featuresMap[locale].forEach(function(feature, index) {
                html += `<span class="feature-tag">
                    ${escapeHtml(feature)}
                    <span class="remove-feature" data-locale="${locale}" data-index="${index}">&times;</span>
                </span>`;
            });
            if (featuresMap[locale].length === 0) {
                html = '<span class="text-muted">No features added yet</span>';
            }
            $(`#featureTags_${locale}`).html(html);
        }

        function escapeHtml(text) {
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        function addFeature(locale, text) {
            text = text.trim();
            if (text && !featuresMap[locale].includes(text)) {
                featuresMap[locale].push(text);
                renderFeatures(locale);
            }
            $(`#featureInput_${locale}`).val('').focus();
        }

        // Add feature via button click
        $(document).on('click', '.addFeatureBtn', function() {
            let locale = $(this).data('locale');
            addFeature(locale, $(`#featureInput_${locale}`).val());
        });

        // Add feature via Enter key
        $(document).on('keypress', '[id^="featureInput_"]', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                let locale = $(this).attr('id').replace('featureInput_', '');
                addFeature(locale, $(this).val());
            }
        });

        // Remove feature
        $(document).on('click', '.remove-feature', function() {
            let locale = $(this).data('locale');
            let index = $(this).data('index');
            featuresMap[locale].splice(index, 1);
            renderFeatures(locale);
        });

        // Image Preview
        $('#image').change(function() {
            previewImage(this, '#imagePreview');
        });

        $('#og_image').change(function() {
            previewImage(this, '#ogImagePreview');
        });

        function previewImage(input, previewSelector) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $(previewSelector).html(`
                        <div class="img-preview-container">
                            <img src="${e.target.result}" alt="Preview">
                            <button type="button" class="remove-img" onclick="removePreview('${previewSelector}', '${input.id}')">&times;</button>
                        </div>
                    `);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        window.removePreview = function(previewSelector, inputId) {
            $(previewSelector).html('');
            $(`#${inputId}`).val('');
        };

        // Spinner Functions
        function showSpinner() {
            $('#addBtn').prop('disabled', true);
            $('#addBtn .btn-text').addClass('d-none');
            $('#addBtn .btn-spinner').removeClass('d-none');
        }

        function hideSpinner() {
            $('#addBtn').prop('disabled', false);
            $('#addBtn .btn-text').removeClass('d-none');
            $('#addBtn .btn-spinner').addClass('d-none');
        }

        // Save or Update
        $("#addBtn").click(function() {
            let id = $("#codeid").val();
            let url = id 
                    ? "{{ route('admin.medical_package.update') }}" 
                    : "{{ route('admin.medical_package.store') }}";
            
            let form_data = new FormData($('#createThisForm')[0]);
            
            // ✅ Remove any existing features inputs from form
            form_data.delete('features');
            // Also remove any previously appended locale features
            locales.forEach(function(locale) {
                form_data.delete(`${locale}[features]`);
            });

            // ✅ Append features per locale as array elements
            locales.forEach(function(locale) {
                featuresMap[locale].forEach(function(feature) {
                    form_data.append(`${locale}[features][]`, feature);
                });
                // If no features, send empty marker so Laravel knows to clear them
                if (featuresMap[locale].length === 0) {
                    form_data.append(`${locale}[features][]`, '');
                }
            });

            showSpinner();

            $.ajax({
                url: url,
                type: "POST",
                data: form_data,
                contentType: false,
                processData: false,
                success: function(response) {
                    hideSpinner();
                    if (response.success) {
                        showToast('success', response.message);
                        resetForm();
                        $("#addThisFormContainer").slideUp();
                        $("#newBtnSection").show();
                        table.draw();
                    }
                },
                error: function(xhr) {
                    hideSpinner();
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        showToast('error', errorMsg);
                    } else {
                        showToast('error', xhr.responseJSON?.message || 'Something went wrong!');
                    }
                }
            });
        });

        // Edit Button Logic
        $('#contentContainer').on('click', '.editBtn', function() {
            let editUrl = $(this).data('edit-url');
            
            $.ajax({
                url: editUrl,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        populateEditForm(response.data);
                    }
                },
                error: function(xhr) {
                    showToast('error', 'Failed to load package data');
                }
            });
        });

        function populateEditForm(data) {
            // Reset features map first
            locales.forEach(function(locale) {
                featuresMap[locale] = [];
                renderFeatures(locale);
            });
            
            // Reset form fields
            $("#codeid").val('');
            $("#category").val('');
            $("#duration").val('');
            $("#price_range").val('');
            $("#cities_count").val(1);
            $("#is_popular").prop('checked', false);
            $("#is_featured").prop('checked', false);
            $("#status").prop('checked', true);
            $("#canonical_url").val('');
            $('#imagePreview').html('');
            $('#ogImagePreview').html('');
            $('input[type="file"]').val('');
            
            // Reset translation fields
            @foreach(config('translatable.locales') as $locale)
                $("#{{ $locale }}_title").val('');
                $("#{{ $locale }}_subtitle").val('');
                $("#{{ $locale }}_description").val('');
                $("#{{ $locale }}_meta_title").val('');
                $("#{{ $locale }}_meta_description").val('');
                $("#{{ $locale }}_meta_keywords").val('');
            @endforeach

            // Set basic fields
            $("#codeid").val(data.id || '');
            $("#category").val(data.category || '');
            $("#duration").val(data.duration || '');
            $("#price_range").val(data.price_range || '');
            $("#cities_count").val(data.cities_count || 1);
            $("#is_popular").prop('checked', data.is_popular == 1 || data.is_popular === true);
            $("#is_featured").prop('checked', data.is_featured == 1 || data.is_featured === true);
            $("#status").prop('checked', data.status == 1 || data.status === true);
            $("#canonical_url").val(data.canonical_url || '');

            // Show existing images
            if (data.image) {
                $('#imagePreview').html(`
                    <div class="img-preview-container">
                        <img src="${data.image_url || data.image}" alt="Current Image">
                    </div>
                `);
            }

            if (data.og_image) {
                $('#ogImagePreview').html(`
                    <div class="img-preview-container">
                        <img src="${data.og_image_url || data.og_image}" alt="Current OG Image">
                    </div>
                `);
            }

            // ✅ Populate Translations including Features
            if (data.translations && Array.isArray(data.translations)) {
                data.translations.forEach(function(t) {
                    if (t.locale) {
                        $(`#${t.locale}_title`).val(t.title || '');
                        $(`#${t.locale}_subtitle`).val(t.subtitle || '');
                        $(`#${t.locale}_description`).val(t.description || '');
                        $(`#${t.locale}_meta_title`).val(t.meta_title || '');
                        $(`#${t.locale}_meta_description`).val(t.meta_description || '');
                        $(`#${t.locale}_meta_keywords`).val(t.meta_keywords || '');
                        
                        // ✅ Populate Features per locale
                        if (t.features) {
                            let parsedFeatures = [];
                            if (typeof t.features === 'string') {
                                try {
                                    parsedFeatures = JSON.parse(t.features);
                                } catch(e) {
                                    parsedFeatures = [];
                                }
                            } else if (Array.isArray(t.features)) {
                                parsedFeatures = [...t.features];
                            }
                            // Filter out empty strings
                            parsedFeatures = parsedFeatures.filter(f => f && f.trim() !== '');
                            featuresMap[t.locale] = parsedFeatures;
                            renderFeatures(t.locale);
                        }
                    }
                });
            }

            // Show form
            $("#addThisFormContainer").slideDown();
            $("#newBtnSection").hide();
            $("#cardTitle").text('Edit Medical Package');
            
            $('html, body').animate({
                scrollTop: $("#addThisFormContainer").offset().top - 100
            }, 500);
        }

        // Toggle Form - New
        $("#newBtn").click(function() {
            resetForm();
            $("#addThisFormContainer").slideDown();
            $(this).closest('#newBtnSection').hide();
            $("#cardTitle").text('Add New Medical Package');
            
            $('html, body').animate({
                scrollTop: $("#addThisFormContainer").offset().top - 100
            }, 500);
        });

        // Close Form
        $("#FormCloseBtn, #FormCloseBtnBottom").click(function() {
            $("#addThisFormContainer").slideUp();
            $("#newBtnSection").show();
        });

        // Reset Form
        function resetForm() {
            $("#codeid").val('');
            $("#category").val('');
            $("#duration").val('');
            $("#price_range").val('');
            $("#cities_count").val(1);
            $("#is_popular").prop('checked', false);
            $("#is_featured").prop('checked', false);
            $("#status").prop('checked', true);
            $("#canonical_url").val('');
            $('input[type="file"]').val('');
            $('#imagePreview').html('');
            $('#ogImagePreview').html('');
            
            // ✅ Reset features map for all locales
            locales.forEach(function(locale) {
                featuresMap[locale] = [];
                renderFeatures(locale);
            });
            
            // Reset translation fields
            @foreach(config('translatable.locales') as $locale)
                $("#{{ $locale }}_title").val('');
                $("#{{ $locale }}_subtitle").val('');
                $("#{{ $locale }}_description").val('');
                $("#{{ $locale }}_meta_title").val('');
                $("#{{ $locale }}_meta_description").val('');
                $("#{{ $locale }}_meta_keywords").val('');
            @endforeach
        }

        // Toast Notification
        function showToast(type, message) {
            let icon = type === 'success' ? 'ri-check-line' : 'ri-error-warning-line';
            let bgColor = type === 'success' ? '#198754' : '#dc3545';
            
            let toast = $(`
                <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                    <div class="toast show" role="alert" style="border-left: 4px solid ${bgColor};">
                        <div class="toast-header">
                            <i class="${icon} me-2" style="color: ${bgColor};"></i>
                            <strong class="me-auto">${type === 'success' ? 'Success' : 'Error'}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                        </div>
                        <div class="toast-body">${message}</div>
                    </div>
                </div>
            `);
            
            $('body').append(toast);
            setTimeout(function() {
                toast.remove();
            }, 5000);
        }

        // Initial render for all locales
        locales.forEach(function(locale) {
            renderFeatures(locale);
        });
    });
</script>
@endsection