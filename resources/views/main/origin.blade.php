@extends('layouts.user_type.auth')

@section('content')

<div>
    <!-- Modal - Create New Origin -->
    <div class="col-md-4">
        <div class="modal fade" id="modal-origin" tabindex="-1" role="dialog" aria-labelledby="modal-origin" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-left">
                                <p class="font-weight-bolder text-info text-gradient">New Origin Data</p>
                                <p style="margin-top: -10px;" class="mb-0 text-sm">Create new data with this form.</p>
                            </div>
                            <div class="card-body">
                                <form role="form text-left" action="{{ url('origin-store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <label>Origin</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="name" placeholder="Origin" aria-label="Name" 
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

    <!-- Modal - Edit Origin -->
    <div class="col-md-4">
        <div class="modal fade" id="modal-origin_edit" tabindex="-1" role="dialog" aria-labelledby="modal-origin_edit" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-left">
                                <p class="font-weight-bolder text-info text-gradient">Edit Origin Data</p>
                                <p style="margin-top: -10px;" class="mb-0 text-sm">Edit data with this form.</p>
                            </div>
                            <div class="card-body">
                                <form role="form text-left" action="{{ url('origin-update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="id" name="id">
                                    <label>Origin</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Origin" aria-label="Name" 
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
                            <!-- Teks lebih kecil saat di perangkat mobile -->
                            <h5 class="mb-0 d-none d-md-block">All Origins</h5>
                            <h6 class="mb-0 d-block d-md-none">All Origins</h6>
                        </div>
                        <!-- Tombol berubah menjadi ikon saja saat di perangkat mobile -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal-origin" 
                        class="btn bg-gradient-primary btn-sm mb-0 d-none d-md-inline-block" 
                        type="button">
                            New Origin
                        </a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal-origin"
                        class="btn bg-gradient-primary btn-sm mb-0 d-inline-block d-md-none" 
                        type="button">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
                @if (count($origins) > 0)
                <div class="card-body px-0 pt-0 pb-2">
                    <!-- Tampilan Tabel untuk Perangkat Ukuran Desktop -->
                    <div class="table-responsive p-0 d-none d-md-block">
                        <table class="table align-items-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($origins as $o)
                                <tr data-id="{{ $o->id_origin }}"
                                    data-name="{{ $o->name }}"
                                    data-code_mark="{{ $o->code_mark }}">
                                    <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}.</p></td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $o->name ?? '-' }}</p>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal-origin_edit" 
                                        class="mx-3 edit-button text-secondary font-weight-bold text-xs">
                                            Edit
                                        </a>
                                        <!-- <a href="#" 
                                        class="mx-3 delete-button text-secondary font-weight-bold text-xs">
                                            Delete
                                        </a> -->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Tampilan List untuk Perangkat Ukuran Mobile -->
                    <div class="list-group d-block d-md-none">
                        @foreach($origins as $o)
                        <div class="list-group-item" 
                            data-id="{{ $o->id_origin }}" 
                            data-name="{{ $o->name }}" 
                            data-code_mark="{{ $o->code_mark }}">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">No. {{ $loop->iteration }}</h6>
                                    <p class="mb-1"><strong>Name:</strong> 
                                        {{ $o->name }}
                                    </p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="#" class="mx-3 edit-button" data-bs-toggle="modal" data-bs-target="#modal-origin_edit">
                                        <i class="fas fa-user-edit text-secondary"></i>
                                    </a>
                                    <!-- <a href="#" class="mx-3 delete-button">
                                        <i class="far fa-trash-alt text-secondary"></i>
                                    </a> -->
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-5 d-flex justify-content-end">
                        <ul class="pagination pagination-sm pagination-gutter px-4">
                            <li class="page-item page-indicator {{ $origins->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $origins->previousPageUrl() }}" aria-label="Previous">
                                    <i class="fa fa-angle-left me-1"></i>
                                </a>
                            </li>

                            @for ($i = 1; $i <= $origins->lastPage(); $i++)
                                <li class="page-item {{ $origins->currentPage() == $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $origins->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            <li class="page-item page-indicator {{ $origins->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $origins->nextPageUrl() }}" aria-label="Next">
                                    <i class="fa fa-angle-right ms-1"></i>
                                </a>
                            </li>
                        </ul>
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

                // Deteksi elemen induk terdekat (baik untuk tabel maupun list group)
                var parentElement = this.closest("tr") || this.closest(".list-group-item");

                // Ambil atribut data dari elemen induk
                var id = parentElement.getAttribute("data-id");
                var name = parentElement.getAttribute("data-name");

                // Isi data ke dalam form modal
                document.getElementById("id").value = id;
                document.getElementById("name").value = name;
            });
        });
    });
</script>
@endsection