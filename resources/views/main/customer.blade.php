@extends('layouts.user_type.auth')

@section('content')

<div>
    <!-- Modal - Create New Customer -->
    <div class="col-md-4">
        <div class="modal fade" id="modal-customer" tabindex="-1" role="dialog" aria-labelledby="modal-customer" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-left">
                                <p class="font-weight-bolder text-info text-gradient">New Customer Data</p>
                                <p style="margin-top: -10px;" class="mb-0 text-sm">Create new data with this form.</p>
                            </div>
                            <div class="card-body">
                                <form role="form text-left" action="{{ url('customer-store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <label>Name</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="name" placeholder="Name" aria-label="Name" 
                                        oninput="this.value = this.value.toUpperCase()" aria-describedby="name-addon" required>
                                    </div>
                                    <label>Code Marking</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="code_mark" placeholder="Code Marking" aria-label="Code Marking" 
                                        oninput="this.value = this.value.toUpperCase()" aria-describedby="Code Marking-addon">
                                    </div>
                                    <label>Address (<span class="text-info text-gradient">Opsional</span>)</label>
                                    <div class="input-group mb-3">
                                        <textarea class="form-control" name="address" placeholder="Address" aria-label="With textarea"></textarea>
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

    <!-- Modal - Edit Customer -->
    <div class="col-md-4">
        <div class="modal fade" id="modal-customer_edit" tabindex="-1" role="dialog" aria-labelledby="modal-customer_edit" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-left">
                                <p class="font-weight-bolder text-info text-gradient">Edit Customer Data</p>
                                <p style="margin-top: -10px;" class="mb-0 text-sm">Edit data with this form.</p>
                            </div>
                            <div class="card-body">
                                <form role="form text-left" action="{{ url('customer-update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="id" name="id">
                                    <label>Name</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" aria-label="Name" 
                                        oninput="this.value = this.value.toUpperCase()" aria-describedby="name-addon" required>
                                    </div>
                                    <label>Code Marking</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="code_mark" id="code_mark" placeholder="Code Marking" aria-label="Code Marking" 
                                        oninput="this.value = this.value.toUpperCase()" aria-describedby="Code Marking-addon">
                                    </div>
                                    <label>Address (<span class="text-info text-gradient">Optional</span>)</label>
                                    <div class="input-group mb-3">
                                        <textarea class="form-control" name="address" id="address" placeholder="Address" aria-label="With textarea"></textarea>
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
                            <h5 class="mb-0">All Customers</h5>
                        </div>
                        <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button" data-bs-toggle="modal" data-bs-target="#modal-customer">
                            +&nbsp; New Customer
                        </a>
                    </div>
                </div>
                @if (count($customers) > 0)
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table id="table-dataTable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No.
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Code Marking
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Address
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $c)
                                <tr data-id="{{ $c->id_customer }}"
                                    data-name="{{ $c->name }}"
                                    data-code_mark="{{ $c->code_mark }}"
                                    data-address="{{ $c->address }}">
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}.</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $c->name }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $c->code_mark ?? '-' }}</p>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $c->address ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="mx-3 edit-button" data-bs-toggle="modal" data-bs-target="#modal-customer_edit" 
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
        // const tableData = $('#table-dataTable').DataTable({
        //     columnDefs: [
        //         { targets: [0], orderable: false }
        //     ]
        // });

        var editButtons = document.querySelectorAll(".edit-button");
        editButtons.forEach(function(button) {
            button.addEventListener("click", function(event) {
                event.preventDefault();

                var row = this.closest("tr");
                var id = row.getAttribute("data-id");
                var name = row.getAttribute("data-name");
                var code_mark = row.getAttribute("data-code_mark");
                var address = row.getAttribute("data-address");

                // Mengisi data ke dalam formulir
                document.getElementById("id").value = id;
                document.getElementById("name").value = name;
                document.getElementById("code_mark").value = code_mark;
                document.getElementById("address").value = address;
            });
        });
    });
</script>
@endsection