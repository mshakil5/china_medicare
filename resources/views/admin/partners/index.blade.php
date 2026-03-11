@extends('admin.pages.master')
@section('title', 'Our Partners')
@section('content')

<div class="container-fluid">
    <button type="button" class="btn btn-primary mb-3" id="newBtn">Add Partner Logo</button>

    <div id="addThisFormContainer" style="display: none;" class="card mb-4">
        <div class="card-body">
            <form id="createThisForm">
                @csrf
                <input type="hidden" id="codeid" name="codeid">
                <div class="row">
                    <div class="col-md-4">
                        <label>Logo Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Website Link (Optional)</label>
                        <input type="text" name="link" id="link" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" id="sort_order" class="form-control" value="0">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" id="addBtn" class="btn btn-success">Save</button>
                    <button type="button" id="FormCloseBtn" class="btn btn-light">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="partnerTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Image</th>
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
        var table = $('#partnerTable').DataTable({
            processing: true, serverSide: true,
            ajax: "{{ route('admin.partners') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'image', name: 'image' },
                { data: 'sort_order', name: 'sort_order' },
                { data: 'action', name: 'action' }
            ]
        });

        $("#addBtn").click(function() {
            let id = $("#codeid").val();
            let url = id ? "{{ url('/admin/partners-update') }}" : "{{ url('/admin/partners') }}";
            $.ajax({
                url: url, type: "POST", data: new FormData($('#createThisForm')[0]),
                contentType: false, processData: false,
                success: function(d) {
                    $("#addThisFormContainer").slideUp();
                    table.draw();
                }
            });
        });

        $('#contentContainer').on('click', '#EditBtn', function() {
            let id = $(this).attr('rid');
            $.get("/admin/partners/" + id + "/edit", function(data) {
                $("#codeid").val(data.id);
                $("#link").val(data.link);
                $("#sort_order").val(data.sort_order);
                $("#addThisFormContainer").slideDown();
            });
        });

        $("#newBtn").click(function() { 
            $('#createThisForm')[0].reset(); 
            $("#codeid").val(''); 
            $("#addThisFormContainer").slideDown(); 
        });
        $("#FormCloseBtn").click(function() { $("#addThisFormContainer").slideUp(); });
    });
</script>
@endsection