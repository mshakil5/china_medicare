@extends('admin.pages.master')
@section('title', 'Gallery Management')

@section('content')

<div class="container-fluid" id="newBtnSection">
    <button type="button" class="btn btn-primary mb-3" id="newBtn">
        <i class="fas fa-plus me-1"></i> Add New Gallery Item
    </button>
</div>

{{-- ADD / EDIT FORM --}}
<div class="container-fluid" id="addThisFormContainer" style="display: none;">
    <div class="card">
        <div class="card-header"><h4 id="cardTitle">Add New Gallery Item</h4></div>
        <div class="card-body">
            <form id="createThisForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="codeid" name="codeid">

                <div class="row">
                    {{-- Type --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                        <select class="form-select" name="type" id="type" required>
                            <option value="image">Image</option>
                            <option value="video">Upload Video</option>
                            <option value="youtube">YouTube Link</option>
                        </select>
                    </div>

                    {{-- Title --}}
                    <div class="col-md-5 mb-3">
                        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" id="title"
                               placeholder="e.g. Beijing United Hospital" required>
                    </div>

                    {{-- Subtitle --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Subtitle / Location</label>
                        <input type="text" class="form-control" name="subtitle" id="subtitle"
                               placeholder="e.g. Cardiology Wing">
                    </div>

                    {{-- ✅ YouTube Link (Hidden by default) --}}
                    <div class="col-md-7 mb-3" id="linkWrap" style="display:none;">
                        <label class="form-label fw-semibold">
                            YouTube Video Link <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fab fa-youtube text-danger"></i></span>
                            <input type="url" class="form-control" name="video_link" id="video_link"
                                   placeholder="https://www.youtube.com/watch?v=xxxxx or short link">
                        </div>
                        <div class="form-text">Paste the full YouTube URL. The thumbnail will be fetched automatically.</div>
                    </div>

                    {{-- File Upload (Hidden when YouTube is selected) --}}
                    <div class="col-md-7 mb-3" id="fileWrap">
                        <label class="form-label fw-semibold" id="fileLabel">
                            Image File <span class="text-danger">*</span>
                        </label>
                        <input type="file" class="form-control" name="file" id="file"
                               accept="image/*">
                        <div class="form-text" id="fileHint">Accepted: JPG, PNG, GIF, WEBP</div>
                        <div id="currentFileWrap" class="mt-2" style="display:none;">
                            <small class="text-muted">Current file:</small><br>
                            <img id="currentFilePreview" src="" width="80" class="img-thumbnail mt-1">
                        </div>
                    </div>

                    {{-- Thumbnail (Only for uploaded video) --}}
                    <div class="col-md-4 mb-3" id="thumbnailWrap">
                        <label class="form-label fw-semibold">
                            Thumbnail / Poster Image <span class="text-danger">*</span>
                        </label>
                        <input type="file" class="form-control" name="thumbnail" id="thumbnail"
                               accept="image/*">
                        <div class="form-text">Poster shown before video plays</div>
                        <div id="currentThumbWrap" class="mt-2" style="display:none;">
                            <small class="text-muted">Current thumbnail:</small><br>
                            <img id="currentThumbPreview" src="" width="80" class="img-thumbnail mt-1">
                        </div>
                    </div>

                    {{-- Sort Order --}}
                    <div class="col-md-2 mb-3">
                        <label class="form-label fw-semibold">Sort Order</label>
                        <input type="number" class="form-control" name="sort_order" id="sort_order"
                               value="0" min="0">
                    </div>

                    {{-- Status --}}
                    <div class="col-md-1 mb-3 d-flex align-items-center">
                        <div>
                            <label class="form-label fw-semibold d-block">Active</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="status" id="status" checked>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer text-end">
            <button type="button" id="addBtn" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Save Item
            </button>
            <button type="button" id="FormCloseBtn" class="btn btn-light ms-2">Cancel</button>
        </div>
    </div>
</div>

{{-- DATA TABLE --}}
<div class="container-fluid" id="contentContainer">
    <div class="card">
        <div class="card-body">
            <table id="galleryTable" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Preview</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Sort</th>
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
 $(document).ready(function () {

    var table = $('#galleryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.galleries') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, width: '40px' },
            { data: 'preview',    name: 'preview',    orderable: false, searchable: false },
            { data: 'title',      name: 'title' },
            { data: 'subtitle',   name: 'subtitle' },
            { data: 'sort_order', name: 'sort_order', width: '60px' },
            { data: 'status',     name: 'status',     orderable: false, searchable: false },
            { data: 'action',     name: 'action',     orderable: false, searchable: false }
        ]
    });

    // ── Toggle fields based on type ──────────────────────
    function toggleFields() {
        var type = $('#type').val();
        
        // Hide all conditional fields first
        $('#fileWrap, #thumbnailWrap, #linkWrap').hide();
        
        // Remove required attributes to prevent HTML5 blocking submission
        $('#file, #thumbnail, #video_link').prop('required', false);

        if (type === 'image') {
            $('#fileWrap').show();
            $('#file').prop('required', true);
            $('#fileLabel').html('Image File <span class="text-danger">*</span>');
            $('#fileHint').text('Accepted: JPG, PNG, GIF, WEBP');
            $('#file').attr('accept', 'image/*');
        } 
        else if (type === 'video') {
            $('#fileWrap').show();
            $('#thumbnailWrap').show();
            $('#file').prop('required', true);
            $('#thumbnail').prop('required', true);
            $('#fileLabel').html('Video File <span class="text-danger">*</span>');
            $('#fileHint').text('Accepted: MP4, MOV, AVI, MKV (max 50MB)');
            $('#file').attr('accept', 'video/*');
        } 
        else if (type === 'youtube') {
            $('#linkWrap').show();
            $('#video_link').prop('required', true);
        }
    }

    $('#type').on('change', toggleFields);
    toggleFields(); // run on load

    // ── Save / Update ─────────────────────────────────────
    $('#addBtn').click(function () {
        var id  = $('#codeid').val();
        var url = id ? "{{ url('/admin/galleries-update') }}" : "{{ route('admin.galleries') }}";
        var fd  = new FormData($('#createThisForm')[0]);

        $.ajax({
            url: url, type: 'POST', data: fd,
            contentType: false, processData: false,
            success: function (d) {
                Swal.fire('Success', d.message, 'success');
                $('#addThisFormContainer').slideUp();
                $('#newBtn').show();
                table.draw();
            },
            error: function (xhr) {
                var errors = xhr.responseJSON?.errors;
                if (errors) {
                    var msg = Object.values(errors).flat().join('<br>');
                    Swal.fire('Validation Error', msg, 'error');
                } else {
                    Swal.fire('Error', 'Something went wrong.', 'error');
                }
            }
        });
    });

    // ── Edit ─────────────────────────────────────────────
    $('#contentContainer').on('click', '#EditBtn', function () {
        var id = $(this).attr('rid');
        $.get('/admin/galleries/' + id + '/edit', function (data) {
            $('#codeid').val(data.id);
            $('#type').val(data.type).trigger('change'); // Trigger change to show/hide fields
            $('#title').val(data.title);
            $('#subtitle').val(data.subtitle);
            $('#sort_order').val(data.sort_order);
            $('#status').prop('checked', data.status == 1);
            $('#video_link').val(data.video_link || '');

            // Show current file preview
            if (data.preview_image) {
                $('#currentFilePreview').attr('src', '/' + data.preview_image);
                $('#currentFileWrap').show();
            } else {
                $('#currentFileWrap').hide();
            }

            // Show current thumbnail preview
            if (data.thumbnail) {
                $('#currentThumbPreview').attr('src', '/' + data.thumbnail);
                $('#currentThumbWrap').show();
            } else {
                $('#currentThumbWrap').hide();
            }

            $('#addThisFormContainer').slideDown();
            $('#newBtn').hide();
            $('#cardTitle').text('Edit Gallery Item');
        });
    });

    // ── New button ────────────────────────────────────────
    $('#newBtn').click(function () {
        $('#createThisForm')[0].reset();
        $('#codeid').val('');
        $('#currentFileWrap, #currentThumbWrap').hide();
        toggleFields();
        $('#addThisFormContainer').slideDown();
        $(this).hide();
        $('#cardTitle').text('Add New Gallery Item');
    });

    // ── Cancel ────────────────────────────────────────────
    $('#FormCloseBtn').click(function () {
        $('#addThisFormContainer').slideUp();
        $('#newBtn').show();
    });

});
</script>
@endsection