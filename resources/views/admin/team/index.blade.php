@extends('admin.pages.master')
@section('title', 'Medical Team')
@section('content')

<div class="container-fluid">
    <button type="button" class="btn btn-primary mb-3" id="newBtn">Add Team Member</button>

    <div id="addThisFormContainer" style="display: none;" class="card mb-4">
        <div class="card-header"><h5 id="formTitle">Add Member</h5></div>
        <div class="card-body">
            <form id="createThisForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="codeid" name="codeid">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Full Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Dr. Sarah Johnson">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Designation / Education</label>
                        <input type="text" name="designation" id="designation" class="form-control" placeholder="MD, Harvard Medical School">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Specialty (Badge Text)</label>
                        <input type="text" name="specialty" id="specialty" class="form-control" placeholder="Neurology">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Member Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>LinkedIn Link</label>
                        <input type="text" name="linkedin" id="linkedin" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Email Address</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Sort Order</label>
                        <input type="number" name="order" id="order" class="form-control" value="0">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="button" id="addBtn" class="btn btn-success">Save Member</button>
                    <button type="button" id="FormCloseBtn" class="btn btn-light">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="teamTable" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Designation</th>
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
    $(document).ready(function() {
        var table = $('#teamTable').DataTable({
            processing: true, serverSide: true,
            ajax: "{{ route('admin.team') }}",
            columns: [
                    { 
                        data: 'DT_RowIndex', 
                        name: 'DT_RowIndex', 
                        orderable: false, 
                        searchable: false 
                    },
                    { 
                        data: 'image', 
                        name: 'image', 
                        orderable: false, 
                        searchable: false 
                    },
                    { data: 'name', name: 'name' },
                    { data: 'designation', name: 'designation' },
                    { data: 'order', name: 'order' }, // This column exists in DB, so it's sortable
                    { 
                        data: 'action', 
                        name: 'action', 
                        orderable: false, 
                        searchable: false 
                    }
                ],
                order: [[4, 'asc']] // Optional: Tell DataTable to sort by the 'order' column by default (index 4)
        });

        $("#addBtn").click(function() {
            let id = $("#codeid").val();
            let url = id ? "{{ url('/admin/team-update') }}" : "{{ url('/admin/team') }}";
            let formData = new FormData($('#createThisForm')[0]);

            $.ajax({
                url: url, type: "POST", data: formData,
                contentType: false, processData: false,
                success: function(d) {
                    showSuccess(d.message);
                    $("#addThisFormContainer").slideUp();
                    $("#newBtn").show();
                    table.draw();
                },
                error: function(xhr) { showError("Something went wrong"); }
            });
        });

        $('body').on('click', '#EditBtn', function() {
            let id = $(this).attr('rid');
            $.get("/admin/team/" + id + "/edit", function(data) {
                $("#codeid").val(data.id);
                $("#name").val(data.name);
                $("#designation").val(data.designation);
                $("#specialty").val(data.specialty);
                $("#linkedin").val(data.linkedin);
                $("#email").val(data.email);
                $("#order").val(data.order);
                $("#formTitle").text("Edit Member");
                $("#addThisFormContainer").slideDown();
                $("#newBtn").hide();
            });
        });

        $("#newBtn").click(function() { 
            $('#createThisForm')[0].reset(); 
            $("#codeid").val(''); 
            $("#formTitle").text("Add Member");
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