@extends('admin.pages.master')
@section('title', 'Hero Sections')
@section('content')

<div class="container-fluid" id="newBtnSection">
    <button type="button" class="btn btn-primary mb-3" id="newBtn">Add Hero Section</button>
</div>

<div class="container-fluid" id="addThisFormContainer" style="display: none;">
    <div class="card">
        <div class="card-header"><h4 id="cardTitle">Add Hero Content</h4></div>
        <div class="card-body">
            <form id="createThisForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="codeid" name="codeid">
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Hero Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                        <div id="imagePreview" class="mt-2"></div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Button 1 URL</label>
                        <input type="text" class="form-control" name="btn1_url" id="btn1_url" placeholder="/hospitals">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Video URL</label>
                        <input type="text" class="form-control" name="video_url" id="video_url" placeholder="https://youtube.com/...">
                    </div>
                </div>

                <hr><h5>Stats Section (The 50+, 10K+ part)</h5>
                <div class="row mb-3">
                    <div class="col-md-4"><input type="text" name="stat1_val" id="stat1_val" class="form-control" placeholder="50+"> <input type="text" name="stat1_lbl" id="stat1_lbl" class="form-control mt-1" placeholder="Partners"></div>
                    <div class="col-md-4"><input type="text" name="stat2_val" id="stat2_val" class="form-control" placeholder="10K+"> <input type="text" name="stat2_lbl" id="stat2_lbl" class="form-control mt-1" placeholder="Patients"></div>
                    <div class="col-md-4"><input type="text" name="stat3_val" id="stat3_val" class="form-control" placeholder="98%"> <input type="text" name="stat3_lbl" id="stat3_lbl" class="form-control mt-1" placeholder="Satisfied"></div>
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
                                    <label>Badge ({{ strtoupper($locale) }})</label>
                                    <input type="text" name="{{ $locale }}[badge]" id="{{ $locale }}_badge" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Hero Title ({{ strtoupper($locale) }})</label>
                                    <input type="text" name="{{ $locale }}[title]" id="{{ $locale }}_title" class="form-control">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Description ({{ strtoupper($locale) }})</label>
                                    <textarea name="{{ $locale }}[description]" id="{{ $locale }}_description" class="form-control"></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Button Text ({{ strtoupper($locale) }})</label>
                                    <input type="text" name="{{ $locale }}[btn1_text]" id="{{ $locale }}_btn1_text" class="form-control">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
        <div class="card-footer text-end">
            <button type="button" id="addBtn" class="btn btn-primary">Save Hero Section</button>
            <button type="button" id="FormCloseBtn" class="btn btn-light">Cancel</button>
        </div>
    </div>
</div>

<div class="container-fluid" id="contentContainer">
    <div class="card">
        <div class="card-body">
            <table id="heroTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Image</th>
                        <th>Title</th>
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
        var table = $('#heroTable').DataTable({
            processing: true, serverSide: true,
            ajax: "{{ route('admin.hero_sections') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'image', name: 'image' },
                { data: 'title', name: 'title' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $("#addBtn").click(function() {
            let id = $("#codeid").val();
            let url = id ? "{{ url('/admin/hero-sections-update') }}" : "{{ url('/admin/hero-sections') }}";
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

        $('#contentContainer').on('click', '#EditBtn', function() {
            let id = $(this).attr('rid');
            $.get("/admin/hero-sections/" + id + "/edit", function(data) {
                $("#codeid").val(data.id);
                $("#btn1_url").val(data.btn1_url);
                $("#video_url").val(data.video_url);

                // Populate Stats
                if(data.stats) {
                    $("#stat1_val").val(data.stats[0].value); $("#stat1_lbl").val(data.stats[0].label);
                    $("#stat2_val").val(data.stats[1].value); $("#stat2_lbl").val(data.stats[1].label);
                    $("#stat3_val").val(data.stats[2].value); $("#stat3_lbl").val(data.stats[2].label);
                }

                data.translations.forEach(function(t) {
                    $(`#${t.locale}_title`).val(t.title);
                    $(`#${t.locale}_badge`).val(t.badge);
                    $(`#${t.locale}_description`).val(t.description);
                    $(`#${t.locale}_btn1_text`).val(t.btn1_text);
                });

                $("#addThisFormContainer").slideDown();
                $("#newBtn").hide();
                $("#cardTitle").text('Edit Hero Section');
            });
        });

        $("#newBtn").click(function() {
            $('#createThisForm')[0].reset();
            $("#codeid").val('');
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