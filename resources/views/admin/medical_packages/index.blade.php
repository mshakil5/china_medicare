@extends('admin.pages.master')
@section('title', 'Medical Packages')
@section('content')

<div class="container-fluid" id="newBtnSection">
    <button type="button" class="btn btn-primary mb-3" id="newBtn">Add New Package</button>
</div>

<div class="container-fluid" id="addThisFormContainer" style="display: none;">
    <div class="card">
        <div class="card-header"><h4 id="cardTitle">Add New Medical Package</h4></div>
        <div class="card-body">
            <form id="createThisForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="codeid" name="codeid">
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Package Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Category</label>
                        <select class="form-control" name="category" id="category">
                            <option value="Surgery">Surgery</option>
                            <option value="Treatment">Treatment</option>
                            <option value="Checkup">Checkup</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Duration (e.g., 18 days)</label>
                        <input type="text" class="form-control" name="duration" id="duration" placeholder="18 days">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Price Range</label>
                        <input type="text" class="form-control" name="price_range" id="price_range" placeholder="$18,000 - $30,000">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Cities Count</label>
                        <input type="number" class="form-control" name="cities_count" id="cities_count" value="1">
                    </div>
                    <div class="col-md-4 mb-3 d-flex align-items-end gap-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_popular" id="is_popular">
                            <label class="form-check-label" for="is_popular">Popular Tag</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured">
                            <label class="form-check-label" for="is_featured">Featured Tag</label>
                        </div>
                    </div>
                </div>

                <hr>
                <h5>Package Features (Bullet Points)</h5>
                <div id="feature-container" class="mb-3">
                    <div class="input-group mb-2">
                        <input type="text" name="features[]" class="form-control" placeholder="Enter a feature...">
                        <button type="button" class="btn btn-success add-feature-btn"><i class="ri-add-line"></i></button>
                    </div>
                </div>

                <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                    @foreach(config('translatable.locales') as $index => $locale)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" data-bs-toggle="tab" href="#tab-{{ $locale }}" role="tab">
                                {{ strtoupper($locale) }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach(config('translatable.locales') as $index => $locale)
                        <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="tab-{{ $locale }}" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Title ({{ strtoupper($locale) }})</label>
                                    <input type="text" name="{{ $locale }}[title]" id="{{ $locale }}_title" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Subtitle / Native Title ({{ strtoupper($locale) }})</label>
                                    <input type="text" name="{{ $locale }}[subtitle]" id="{{ $locale }}_subtitle" class="form-control" placeholder="e.g. 骨科关节置换套餐">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Short Description ({{ strtoupper($locale) }})</label>
                                    <textarea name="{{ $locale }}[description]" id="{{ $locale }}_description" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
        <div class="card-footer text-end">
            <button type="button" id="addBtn" class="btn btn-primary">Save Package</button>
            <button type="button" id="FormCloseBtn" class="btn btn-light">Cancel</button>
        </div>
    </div>
</div>

<div class="container-fluid" id="contentContainer">
    <div class="card">
        <div class="card-body">
            <table id="packageTable" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Price</th>
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
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#packageTable').DataTable({
            processing: true, serverSide: true,
            ajax: "{{ route('admin.medical_sections') }}", // Ensure this route name matches yours
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'category', name: 'category' },
                { data: 'title', name: 'title' },
                { data: 'price_range', name: 'price_range' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Add Dynamic Feature Input
        $(document).on('click', '.add-feature-btn', function() {
            let html = `
                <div class="input-group mb-2">
                    <input type="text" name="features[]" class="form-control" placeholder="Enter a feature...">
                    <button type="button" class="btn btn-danger remove-feature-btn"><i class="ri-delete-bin-line"></i></button>
                </div>`;
            $('#feature-container').append(html);
        });

        // Remove Dynamic Feature Input
        $(document).on('click', '.remove-feature-btn', function() {
            $(this).closest('.input-group').remove();
        });

        // Save or Update
        $("#addBtn").click(function() {
            let id = $("#codeid").val();
            let url = id 
                    ? "{{ route('admin.medical_sections.update') }}" 
                    : "{{ route('admin.medical_sections') }}";
            let form_data = new FormData($('#createThisForm')[0]);

            $.ajax({
                url: url, type: "POST", data: form_data,
                contentType: false, processData: false,
                success: function(d) {
                    showSuccess(d.message);
                    $("#addThisFormContainer").slideUp();
                    $("#newBtn").show();
                    table.draw();
                },
                error: function(xhr) { showError(xhr.responseJSON.message); }
            });
        });

        // Edit Button Logic
        $('#contentContainer').on('click', '#EditBtn', function() {
            let id = $(this).attr('rid');
            $.get("/admin/medical-packages/" + id + "/edit", function(data) {
                $("#codeid").val(data.id);
                $("#category").val(data.category);
                $("#duration").val(data.duration);
                $("#price_range").val(data.price_range);
                $("#cities_count").val(data.cities_count);
                $("#is_popular").prop('checked', data.is_popular);
                $("#is_featured").prop('checked', data.is_featured);

                // Populate Features
                $('#feature-container').html(''); // Clear first
                if(data.features && data.features.length > 0) {
                    data.features.forEach((feature, index) => {
                        let btnClass = index === 0 ? 'btn-success add-feature-btn' : 'btn-danger remove-feature-btn';
                        let icon = index === 0 ? 'ri-add-line' : 'ri-delete-bin-line';
                        $('#feature-container').append(`
                            <div class="input-group mb-2">
                                <input type="text" name="features[]" class="form-control" value="${feature}">
                                <button type="button" class="btn ${btnClass}"><i class="${icon}"></i></button>
                            </div>
                        `);
                    });
                } else {
                    $('#feature-container').append(`
                        <div class="input-group mb-2">
                            <input type="text" name="features[]" class="form-control">
                            <button type="button" class="btn btn-success add-feature-btn"><i class="ri-add-line"></i></button>
                        </div>
                    `);
                }

                // Translations
                data.translations.forEach(function(t) {
                    $(`#${t.locale}_title`).val(t.title);
                    $(`#${t.locale}_subtitle`).val(t.subtitle);
                    $(`#${t.locale}_description`).val(t.description);
                });

                $("#addThisFormContainer").slideDown();
                $("#newBtn").hide();
                $("#cardTitle").text('Edit Medical Package');
            });
        });

        // Toggle Form
        $("#newBtn").click(function() {
            $('#createThisForm')[0].reset();
            $("#codeid").val('');
            $('#feature-container').html(`
                <div class="input-group mb-2">
                    <input type="text" name="features[]" class="form-control" placeholder="Enter a feature...">
                    <button type="button" class="btn btn-success add-feature-btn"><i class="ri-add-line"></i></button>
                </div>
            `);
            $("#addThisFormContainer").slideDown();
            $(this).hide();
        });

        $("#FormCloseBtn").click(function() {
            $("#addThisFormContainer").slideUp();
            $("#newBtn").show();
        });
    });
</script>
@endsection