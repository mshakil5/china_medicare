@extends('admin.pages.master')
@section('title', 'Contacts')
@section('content')

    <div class="container-fluid" id="contentContainer">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Contact Messages</h4>
            </div>
            <div class="card-body">
                <table id="contactTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Country</th>
                            <th>Attachment</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- View Details Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Contact Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> <span id="v_name"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Email:</strong> <span id="v_email"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Country:</strong> <span id="v_country"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Date:</strong> <span id="v_date"></span></p>
                        </div>
                    </div>
                    <hr>
                    <p><strong>Message:</strong></p>
                    <div class="border p-3 bg-light rounded" id="v_message"></div>
                    
                    <div id="v_file_container" class="mt-3 d-none">
                        <p><strong>Attachment:</strong></p>
                        <div id="v_file"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Preview Modal (Big Image Popup) -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 text-center">
                    <button type="button" class="btn btn-light btn-sm position-absolute top-0 end-0 m-2 z-3" data-bs-dismiss="modal"><i class="ri-close-line"></i></button>
                    <img id="bigImage" src="" class="img-fluid rounded shadow" alt="Preview">
                </div>
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

            var table = $('#contactTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('contacts.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'date', name: 'date' },
                    { data: 'full_name', name: 'full_name' },
                    { data: 'email', name: 'email' },
                    { data: 'country', name: 'country' },
                    { data: 'file', name: 'file', orderable: false, searchable: false },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            // Open Big Image Preview on thumbnail click
            $(document).on('click', '.img-preview', function() {
                var bigSrc = $(this).data('src');
                $('#bigImage').attr('src', bigSrc);
                $('#imagePreviewModal').modal('show');
            });

            // View Details
            $(document).on('click', '.viewBtn', function() {
                var id = $(this).data('id');
                $.get("{{ url('/admin/contacts') }}/" + id, {}, function(res) {
                    $('#v_name').text(res.full_name);
                    $('#v_email').text(res.email);
                    $('#v_country').text(res.country ?? 'N/A');
                    $('#v_date').text(res.formatted_date);
                    $('#v_message').text(res.message);
                    
                    // Handle file display in modal
                    if(res.file) {
                        $('#v_file_container').removeClass('d-none');
                        var ext = res.file.split('.').pop().toLowerCase();
                        var fileUrl = '/' + res.file;
                        
                        if(['jpg','jpeg','png','gif'].includes(ext)) {
                            $('#v_file').html('<img src="'+fileUrl+'" class="img-thumbnail" height="150">');
                        } else {
                            $('#v_file').html('<a href="'+fileUrl+'" target="_blank" class="btn btn-sm btn-primary"><i class="ri-download-line"></i> Download File</a>');
                        }
                    } else {
                        $('#v_file_container').addClass('d-none');
                    }

                    $('#viewModal').modal('show');
                });
            });

            // Toggle Status
            $(document).on('change', '.toggle-status', function() {
                let id = $(this).data('id');
                let status = $(this).prop('checked') ? 1 : 0;
                $.post("{{ route('contacts.toggleStatus') }}", {
                    id: id,
                    status: status
                }, function(res) {
                    showSuccess(res.message);
                    table.ajax.reload(null, false);
                }).fail(() => showError('Failed'));
            });
        });
    </script>
@endsection