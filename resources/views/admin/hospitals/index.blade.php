@extends('admin.pages.master')
@section('title', 'Partner Hospitals')
@section('content')

<div class="container-fluid" id="newBtnSection">
    <button type="button" class="btn btn-primary mb-3" id="newBtn">Add New Hospital</button>
</div>

<div class="container-fluid" id="addThisFormContainer" style="display: none;">
    <div class="card">
        <div class="card-header"><h4 id="cardTitle">Add Hospital</h4></div>
        <div class="card-body">
            <form id="createThisForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="codeid" name="codeid">
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Hospital Image</label>
                        <input type="file" class="form-control" name="image" id="image">
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
                                    <label>Hospital Name ({{ strtoupper($locale) }})</label>
                                    <input type="text" name="{{ $locale }}[name]" id="{{ $locale }}_name" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Specialty/Dept ({{ strtoupper($locale) }})</label>
                                    <input type="text" name="{{ $locale }}[specialty]" id="{{ $locale }}_specialty" class="form-control" placeholder="e.g. Cardiology & Oncology">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
        <div class="card-footer text-end">
            <button type="button" id="addBtn" class="btn btn-primary">Save Hospital</button>
            <button type="button" id="FormCloseBtn" class="btn btn-light">Cancel</button>
        </div>
    </div>
</div>

<div class="container-fluid" id="contentContainer">
    <div class="card">
        <div class="card-body">
            <table id="hospitalTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Image</th>
                        <th>Name</th>
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
        var table = $('#hospitalTable').DataTable({
            processing: true, serverSide: true,
            ajax: "{{ route('admin.hospitals') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'image', name: 'image' },
                { data: 'name', name: 'name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $("#addBtn").click(function() {
            let id = $("#codeid").val();
            let url = id ? "{{ url('/admin/hospitals-update') }}" : "{{ url('/admin/hospitals') }}";
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
                error: function(xhr) { showError("Required fields are missing"); }
            });
        });

        $('#contentContainer').on('click', '#EditBtn', function() {
            let id = $(this).attr('rid');
            $.get("/admin/hospitals/" + id + "/edit", function(data) {
                $("#codeid").val(data.id);
                data.translations.forEach(function(t) {
                    $(`#${t.locale}_name`).val(t.name);
                    $(`#${t.locale}_specialty`).val(t.specialty);
                });
                $("#addThisFormContainer").slideDown();
                $("#newBtn").hide();
                $("#cardTitle").text('Edit Hospital');
            });
        });

        $("#newBtn").click(function() {
            $('#createThisForm')[0].reset();
            $("#codeid").val('');
            $("#addThisFormContainer").slideDown();
            $(this).hide();
            $("#cardTitle").text('Add Hospital');
        });
        
        $("#FormCloseBtn").click(function() {
            $("#addThisFormContainer").slideUp();
            $("#newBtn").show();
        });
    });
</script>
@endsection