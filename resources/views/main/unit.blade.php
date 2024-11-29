@extends('layouts.user_type.auth')

@section('content')

<div>
    <!-- Modal - Create New Unit -->
    <div class="col-md-4">
        <div class="modal fade" id="modal-unit" tabindex="-1" role="dialog" aria-labelledby="modal-unit" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-left">
                                <p class="font-weight-bolder text-info text-gradient">New Unit Data</p>
                                <p style="margin-top: -10px;" class="mb-0 text-sm">Create new data with this form.</p>
                            </div>
                            <div class="card-body">
                                <form role="form text-left" action="{{ url('unit-store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <label>Unit</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="name" placeholder="unit" aria-label="Name" 
                                        oninput="this.value = this.value.toUpperCase()" aria-describedby="name-addon" required>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-round bg-gradient-primary btn-lg w-100 mt-4 mb-0">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal - Edit unit -->
    <div class="col-md-4">
        <div class="modal fade" id="modal-unit_edit" tabindex="-1" role="dialog" aria-labelledby="modal-unit_edit" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-left">
                                <p class="font-weight-bolder text-info text-gradient">Edit Unit Data</p>
                                <p style="margin-top: -10px;" class="mb-0 text-sm">Edit data with this form.</p>
                            </div>
                            <div class="card-body">
                                <form role="form text-left" action="{{ url('unit-update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="id" name="id">
                                    <label>Unit</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="unit" aria-label="Name" 
                                        oninput="this.value = this.value.toUpperCase()" aria-describedby="name-addon" required>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-round bg-gradient-secondary btn-lg w-100 mt-4 mb-0">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session()->has('logErrors'))
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-body">
                    <h5 class="card-title text-sm text-danger">Error Log</h5>
                    <span class="text-sm">{{ session('logErrors') }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-3">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Units</h5>
                        </div>
                        <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button" data-bs-toggle="modal" data-bs-target="#modal-unit">
                            +&nbsp; New Unit
                        </a>
                    </div>
                </div>
                @if (count($units) > 0)
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No.
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Unit
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($units as $s)
                                <tr data-id="{{ $s->id_unit }}"
                                    data-name="{{ $s->name }}"
                                    data-code_mark="{{ $s->code_mark }}">
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}.</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $s->name }}</p>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="mx-3 edit-button" data-bs-toggle="modal" data-bs-target="#modal-unit_edit" 
                                            data-bs-toggle="tooltip" data-bs-original-title="Edit user">
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="card-body px-0 pt-3 pb-3">
                    <div class="d-flex justify-content-center mt-3">
                        <span class="text-xs mb-3"><i>No available data to display..</i></span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editButtons = document.querySelectorAll(".edit-button");
        editButtons.forEach(function(button) {
            button.addEventListener("click", function(event) {
                event.preventDefault();

                var row = this.closest("tr");
                var id = row.getAttribute("data-id");
                var name = row.getAttribute("data-name");
                var code_mark = row.getAttribute("data-code_mark");

                // Mengisi data ke dalam formulir
                document.getElementById("id").value = id;
                document.getElementById("name").value = name;
                document.getElementById("code_mark").value = code_mark;
            });
        });
    });
</script>
@endsection