@extends('admin.pages.master')
@section('title', 'Blog Management')
@section('content')

<div class="container-fluid" id="newBtnSection">
    <button type="button" class="btn btn-primary mb-3" id="newBtn">Add New Blog Post</button>
</div>

<div class="container-fluid" id="addThisFormContainer" style="display: none;">
    <div class="card">
        <div class="card-header"><h4 id="cardTitle">Add New Blog</h4></div>
        <div class="card-body">
            <form id="createThisForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="codeid" name="codeid">
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Featured Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Read Time (e.g., 5 min read)</label>
                        <input type="text" class="form-control" name="read_time" id="read_time" placeholder="5 min read">
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
                                <div class="col-md-8 mb-3">
                                    <label>Blog Title ({{ strtoupper($locale) }})</label>
                                    <input type="text" name="{{ $locale }}[title]" id="{{ $locale }}_title" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Tags ({{ strtoupper($locale) }})</label>
                                    <input type="text" name="{{ $locale }}[tags]" id="{{ $locale }}_tags" class="form-control" placeholder="Tag1, Tag2">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Short Summary ({{ strtoupper($locale) }})</label>
                                    <textarea name="{{ $locale }}[summary]" id="{{ $locale }}_summary" class="form-control" rows="2"></textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Full Description ({{ strtoupper($locale) }})</label>
                                    <textarea name="{{ $locale }}[description]" id="{{ $locale }}_description" class="form-control ckeditor" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
        <div class="card-footer text-end">
            <button type="button" id="addBtn" class="btn btn-primary">Save Blog Post</button>
            <button type="button" id="FormCloseBtn" class="btn btn-light">Cancel</button>
        </div>
    </div>
</div>

<div class="container-fluid" id="contentContainer">
    <div class="card">
        <div class="card-body">
            <table id="blogTable" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Image</th>
                        <th>Title (EN)</th>
                        <th>Read Time</th>
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
        var table = $('#blogTable').DataTable({
            processing: true, serverSide: true,
            ajax: "{{ route('admin.blogs') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'image', name: 'image', render: function(data) {
                    return `<img src="/${data}" width="50" class="img-thumbnail">`;
                }},
                { data: 'title', name: 'title' },
                { data: 'read_time', name: 'read_time' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Save or Update logic
        $("#addBtn").click(function() {
            let id = $("#codeid").val();
            let url = id ? "{{ url('/admin/blogs-update') }}" : "{{ route('admin.blogs') }}";
            let form_data = new FormData($('#createThisForm')[0]);

            $.ajax({
                url: url, type: "POST", data: form_data,
                contentType: false, processData: false,
                success: function(d) {
                    Swal.fire('Success', d.message, 'success');
                    $("#addThisFormContainer").slideUp();
                    $("#newBtn").show();
                    table.draw();
                },
                error: function(xhr) { alert("Something went wrong"); }
            });
        });

        // Edit Button
        $('#contentContainer').on('click', '#EditBtn', function() {
            let id = $(this).attr('rid');
            $.get("/admin/blogs/" + id + "/edit", function(data) {
                $("#codeid").val(data.id);
                $("#read_time").val(data.read_time);

                // Populate Translations
                data.translations.forEach(function(t) {
                    $(`#${t.locale}_title`).val(t.title);
                    $(`#${t.locale}_tags`).val(t.tags);
                    $(`#${t.locale}_summary`).val(t.summary);
                    $(`#${t.locale}_description`).val(t.description);
                });

                $("#addThisFormContainer").slideDown();
                $("#newBtn").hide();
                $("#cardTitle").text('Edit Blog Post');
            });
        });

        // Form Toggles
        $("#newBtn").click(function() {
            $('#createThisForm')[0].reset();
            $("#codeid").val('');
            $("#addThisFormContainer").slideDown();
            $(this).hide();
            $("#cardTitle").text('Add New Blog');
        });

        $("#FormCloseBtn").click(function() {
            $("#addThisFormContainer").slideUp();
            $("#newBtn").show();
        });
    });
</script>
@endsection