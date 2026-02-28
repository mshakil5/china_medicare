@extends('admin.pages.master')
@section('title', 'Why Choose Us')

@section('content')

<div class="container-fluid" id="newBtnSection">
    <button type="button" class="btn btn-primary mb-3" id="newBtn">
        Add New Item
    </button>
</div>

<div class="container-fluid" id="addThisFormContainer" style="display:none;">
    <div class="card">
        <div class="card-header">
            <h4 id="cardTitle">Add Why Choose Item</h4>
        </div>

        <div class="card-body">
            <form id="createThisForm">
                @csrf
                <input type="hidden" id="codeid" name="codeid">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Icon (FontAwesome class)</label>
                        <input type="text" name="icon" id="icon"
                               class="form-control"
                               placeholder="fas fa-hospital-alt">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Serial</label>
                        <input type="number" name="serial"
                               id="serial"
                               class="form-control"
                               value="0">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <hr>

                {{-- Translation Tabs --}}
                <ul class="nav nav-tabs mb-3">
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

                            <div class="mb-3">
                                <label>Title ({{ strtoupper($locale) }})</label>
                                <input type="text"
                                       name="{{ $locale }}[title]"
                                       id="{{ $locale }}_title"
                                       class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Description ({{ strtoupper($locale) }})</label>
                                <textarea name="{{ $locale }}[description]"
                                          id="{{ $locale }}_description"
                                          class="form-control"
                                          rows="3"></textarea>
                            </div>

                        </div>
                    @endforeach
                </div>

            </form>
        </div>

        <div class="card-footer text-end">
            <button type="button" id="addBtn" class="btn btn-primary">
                Save
            </button>
            <button type="button" id="FormCloseBtn" class="btn btn-light">
                Cancel
            </button>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <table id="whyChooseTable"
                   class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                <tr>
                    <th>Sl</th>
                    <th>Title</th>
                    <th>Icon</th>
                    <th>Serial</th>
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

    var table = $('#whyChooseTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.why_choose') }}",
        columns: [
            { data: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'title' },
            { data: 'icon' },
            { data: 'serial' },
            { data: 'status' },
            { data: 'action', orderable:false, searchable:false }
        ]
    });

    $("#addBtn").click(function () {

        let id = $("#codeid").val();
        let url = id
            ? "{{ route('admin.why_choose.update') }}"
            : "{{ route('admin.why_choose.store') }}";

        $.ajax({
            url: url,
            type: "POST",
            data: $('#createThisForm').serialize(),
            success: function (d) {
                showSuccess(d.message);
                $("#addThisFormContainer").slideUp();
                $("#newBtn").show();
                table.draw();
            }
        });
    });

    $('#whyChooseTable').on('click', '#EditBtn', function () {

        let id = $(this).attr('rid');

        $.get("/admin/why-choose/" + id + "/edit", function (data) {

            $("#codeid").val(data.id);
            $("#icon").val(data.icon);
            $("#serial").val(data.serial);
            $("#status").val(data.status);

            data.translations.forEach(function (t) {
                $("#" + t.locale + "_title").val(t.title);
                $("#" + t.locale + "_description").val(t.description);
            });

            $("#addThisFormContainer").slideDown();
            $("#newBtn").hide();
            $("#cardTitle").text('Edit Why Choose');
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