@extends('admin.pages.master')
@section('title', 'Medical Services')

@section('content')

<div class="container-fluid" id="newBtnSection">
    <button type="button" class="btn btn-primary mb-3" id="newBtn">
        Add New Service
    </button>
</div>

<div class="container-fluid" id="addThisFormContainer" style="display: none;">
    <div class="card">
        <div class="card-header">
            <h4 id="cardTitle">Add New Medical Service</h4>
        </div>

        <div class="card-body">
            <form id="createThisForm">
                @csrf
                <input type="hidden" id="codeid" name="codeid">

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Icon (FontAwesome class)</label>
                        <input type="text" name="icon" id="icon" class="form-control"
                               placeholder="fa-stethoscope">
                        <small class="text-muted">Example: fa-plane, fa-hotel</small>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Color</label>
                        <select name="color" id="color" class="form-control">
                            <option value="teal">Teal</option>
                            <option value="blue">Blue</option>
                            <option value="orange">Orange</option>
                            <option value="green">Green</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Display Order</label>
                        <input type="number" name="order" id="order"
                               class="form-control" value="0">
                    </div>
                </div>

                <hr>

                {{-- Translation Tabs --}}
                <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3">
                    @foreach(config('translatable.locales') as $index => $locale)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}"
                               data-bs-toggle="tab"
                               href="#tab-{{ $locale }}">
                                {{ strtoupper($locale) }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach(config('translatable.locales') as $index => $locale)
                        <div class="tab-pane {{ $index == 0 ? 'active' : '' }}"
                             id="tab-{{ $locale }}">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Title ({{ strtoupper($locale) }})</label>
                                    <input type="text"
                                           name="{{ $locale }}[title]"
                                           id="{{ $locale }}_title"
                                           class="form-control">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Description ({{ strtoupper($locale) }})</label>
                                    <textarea name="{{ $locale }}[description]"
                                              id="{{ $locale }}_description"
                                              class="form-control"
                                              rows="2"></textarea>
                                </div>

                                <div class="col-md-12">
                                    <label>Features ({{ strtoupper($locale) }})</label>
                                    <div id="feature-container-{{ $locale }}">
                                        <div class="input-group mb-2">
                                            <input type="text"
                                                   name="{{ $locale }}[features][]"
                                                   class="form-control"
                                                   placeholder="Enter feature...">
                                            <button type="button"
                                                    class="btn btn-success add-feature-btn"
                                                    data-locale="{{ $locale }}">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    @endforeach
                </div>

            </form>
        </div>

        <div class="card-footer text-end">
            <button type="button" id="addBtn" class="btn btn-primary">
                Save Service
            </button>
            <button type="button" id="FormCloseBtn" class="btn btn-light">
                Cancel
            </button>
        </div>
    </div>
</div>

<div class="container-fluid" id="contentContainer">
    <div class="card">
        <div class="card-body">
            <table id="serviceTable"
                   class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                <tr>
                    <th>Sl</th>
                    <th>Title</th>
                    <th>Icon</th>
                    <th>Color</th>
                    <th>Order</th>
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
$(document).ready(function () {

    var table = $('#serviceTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.medical_services') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'title' },
            { data: 'icon' },
            { data: 'color' },
            { data: 'order' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    // Add Feature
    $(document).on('click', '.add-feature-btn', function () {
        let locale = $(this).data('locale');

        let html = `
            <div class="input-group mb-2">
                <input type="text"
                    name="${locale}[features][]"
                    class="form-control"
                    placeholder="Enter feature...">
                <button type="button"
                    class="btn btn-danger remove-feature-btn">-</button>
            </div>`;

        $('#feature-container-' + locale).append(html);
    });

    // Remove Feature
    $(document).on('click', '.remove-feature-btn', function () {
        $(this).closest('.input-group').remove();
    });

    // Save / Update
    $("#addBtn").click(function () {
        let id = $("#codeid").val();
        let url = id
            ? "{{ route('admin.medical_services.update') }}"
            : "{{ route('admin.medical_services.store') }}";

        $.ajax({
            url: url,
            type: "POST",
            data: $('#createThisForm').serialize(),
            success: function (d) {
                showSuccess(d.message);
                $("#addThisFormContainer").slideUp();
                $("#newBtn").show();
                table.draw();
            },
            error: function (xhr) {
                showError(xhr.responseJSON.message);
            }
        });
    });

    // Edit
    $('#contentContainer').on('click', '#EditBtn', function () {
        let id = $(this).attr('rid');

        $.get("/admin/medical-services/" + id + "/edit", function (data) {

            $("#codeid").val(data.id);
            $("#icon").val(data.icon);
            $("#color").val(data.color);
            $("#order").val(data.order);

            data.translations.forEach(function (t) {
                $("#" + t.locale + "_title").val(t.title);
                $("#" + t.locale + "_description").val(t.description);

                let container = $('#feature-container-' + t.locale);
                container.html('');

                if (t.features) {
                    t.features.forEach(function (feature, index) {
                        let btnClass = index === 0
                            ? 'btn-success add-feature-btn'
                            : 'btn-danger remove-feature-btn';

                        let btnText = index === 0 ? '+' : '-';

                        container.append(`
                            <div class="input-group mb-2">
                                <input type="text"
                                    name="${t.locale}[features][]"
                                    value="${feature}"
                                    class="form-control">
                                <button type="button"
                                    class="btn ${btnClass}"
                                    data-locale="${t.locale}">
                                    ${btnText}
                                </button>
                            </div>
                        `);
                    });
                }
            });

            $("#addThisFormContainer").slideDown();
            $("#newBtn").hide();
            $("#cardTitle").text('Edit Medical Service');
        });
    });

    $("#newBtn").click(function () {
        $('#createThisForm')[0].reset();
        $("#codeid").val('');
        $("#addThisFormContainer").slideDown();
        $(this).hide();
    });

    $("#FormCloseBtn").click(function () {
        $("#addThisFormContainer").slideUp();
        $("#newBtn").show();
    });

});
</script>
@endsection