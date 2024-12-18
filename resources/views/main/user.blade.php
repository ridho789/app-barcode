@extends('layouts.user_type.auth')

@section('content')

<div>
    <!-- Modal - Create New User -->
    <div class="col-md-4">
        <div class="modal fade" id="modal-user" tabindex="-1" role="dialog" aria-labelledby="modal-user" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-left">
                                <p class="font-weight-bolder text-info text-gradient">New User Data</p>
                                <p style="margin-top: -10px;" class="mb-0 text-sm">Create new data with this form.</p>
                            </div>
                            <div class="card-body">
                                <form role="form text-left" action="{{ url('user-store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <label>Name</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="name" placeholder="Name" aria-label="Name" 
                                        oninput="this.value = this.value.toUpperCase()" value="{{ old('name') }}" 
                                        aria-describedby="name-addon" required>
                                    </div>
                                    <label>Email</label>
                                    <div class="input-group mb-3">
                                        <input type="email" class="form-control" name="email" placeholder="Email" aria-label="Email" 
                                        value="{{ old('email') }}" aria-describedby="email-addon" required>
                                    </div>
                                    <div>
                                        @error('email')
										<p class="text-danger text-xs">{{ $message }}</p>
										@enderror
                                    </div>
                                    <label>Password</label>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Password" 
                                        aria-describedby="password-addon" required>
                                    </div>
                                    <div>
                                        @error('password')
										<p class="text-danger text-xs">{{ $message }}</p>
										@enderror
                                    </div>
                                    <label>Location</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="location" placeholder="Location" aria-label="Location" 
                                        oninput="this.value = this.value.toUpperCase()" value="{{ old('location') }}" 
                                        aria-describedby="location-addon" required>
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

    <!-- Modal - Edit user -->
    <div class="col-md-4">
        <div class="modal fade" id="modal-user_edit" tabindex="-1" role="dialog" aria-labelledby="modal-user_edit" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-left">
                                <p class="font-weight-bolder text-info text-gradient">Edit user Data</p>
                                <p style="margin-top: -10px;" class="mb-0 text-sm">Edit data with this form.</p>
                            </div>
                            <div class="card-body">
                                <form role="form text-left" action="{{ url('user-update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="id" name="id">
                                    <label>Name</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" aria-label="Name" 
                                        oninput="this.value = this.value.toUpperCase()" aria-describedby="name-addon" required>
                                    </div>
                                    <label>Email</label>
                                    <div class="input-group mb-3">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" aria-label="Email" 
                                        aria-describedby="email-addon" required>
                                        
                                    </div>
                                    <div>
                                        @error('email')
										<p class="text-danger text-xs">{{ $message }}</p>
										@enderror
                                    </div>
                                    <label>Change Password (<span class="text-info">Optional</span>)</label>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" aria-label="Password" 
                                        aria-describedby="password-addon">
                                    </div>
                                    <div>
                                        @error('password')
										<p class="text-danger text-xs">{{ $message }}</p>
										@enderror
                                    </div>
                                    <label>Location</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="location" id="location" placeholder="Location" aria-label="Location" 
                                        oninput="this.value = this.value.toUpperCase()" value="{{ old('location') }}" 
                                        aria-describedby="location-addon" required>
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
                            <h5 class="mb-0 d-none d-md-block">All users</h5>
                            <h6 class="mb-0 d-block d-md-none">All users</h6>
                        </div>
                        <!-- Tombol berubah menjadi ikon saja saat di perangkat mobile -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal-user" 
                        class="btn bg-gradient-primary btn-sm mb-0 d-none d-md-inline-block" 
                        type="button">
                            New user
                        </a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal-user"
                        class="btn bg-gradient-primary btn-sm mb-0 d-inline-block d-md-none" 
                        type="button">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
                @if (count($users) > 0)
                <div class="card-body px-0 pt-0 pb-2">
                    <!-- Tampilan Tabel untuk Perangkat Ukuran Desktop -->
                    <div class="table-responsive p-0 d-none d-md-block">
                        <table class="table align-items-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Password</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Location</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $u)
                                <tr data-id="{{ $u->id }}"
                                    data-name="{{ $u->name }}"
                                    data-email="{{ $u->email }}"
                                    data-password="{{ $u->password }}"
                                    data-location="{{ $u->location }}">
                                    <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}.</p></td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $u->name ?? '-' }}</p>
                                    </td>
                                    <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $u->email }}</p></td>
                                    <td class="text-center">
                                        <!-- Display only the first 20 characters of the password and add the eye icon -->
                                        <span id="password-text-{{ $u->id }}">
                                            {{ substr($u->password, 0, 20) }}{{ strlen($u->password) > 20 ? '...' : '' }}
                                        </span>
                                        <!-- Eye Icon to toggle visibility of the password -->
                                        <a href="#" class="mx-2" id="toggle-password-{{ $u->id }}" onclick="togglePassword('{{ $u->id }}')">
                                            <i class="fas fa-eye-slash" id="eye-icon-{{ $u->id }}"></i>
                                        </a>
                                        <!-- Full password (hidden initially) -->
                                        <span id="password-full-{{ $u->id }}" style="display: none;">
                                            {{ $u->password }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $u->location ?? '-' }}</p>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal-user_edit" 
                                        class="mx-3 edit-button text-secondary font-weight-bold text-xs">
                                            Edit
                                        </a>
                                        <a href="#" 
                                        class="mx-3 delete-button text-secondary font-weight-bold text-xs">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Tampilan List untuk Perangkat Ukuran Mobile -->
                    <div class="list-group d-block d-md-none">
                        @foreach($users as $u)
                        <div class="list-group-item" 
                            data-id="{{ $u->id }}" 
                            data-name="{{ $u->name }}" 
                            data-email="{{ $u->email }}"
                            data-location="{{ $u->location }}">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">No. {{ $loop->iteration }}</h6>
                                    <p class="mb-1"><strong>Name:</strong> 
                                        {{ $u->name }}
                                    </p>
                                    <p class="mb-1"><strong>Email:</strong> {{ $u->email }}</p>
                                    <p class="mb-1"><strong>Password:</strong> 
                                        <!-- Display only the first 20 characters of the encrypted password -->
                                        <span id="password-text-{{ $u->id }}">
                                            {{ substr($u->password, 0, 20) }}{{ strlen($u->password) > 20 ? '...' : '' }}
                                        </span>
                                        <!-- Eye Icon to toggle visibility of the password -->
                                        <a href="#" class="mx-2" id="toggle-password-{{ $u->id }}" onclick="togglePassword('{{ $u->id }}')">
                                            <i class="fas fa-eye-slash" id="eye-icon-{{ $u->id }}"></i>
                                        </a>
                                        <!-- Full password (hidden initially) -->
                                        <span id="password-full-{{ $u->id }}" style="display: none;">
                                            {{ $u->password }}
                                        </span>
                                    </p>
                                    <p class="mb-1"><strong>Location:</strong> 
                                        {{ $u->location ?? '-' }}
                                    </p>
                                    <div class="d-flex justify-content-start mt-3">
                                        <a href="#" class="mx-1 edit-button" data-bs-toggle="modal" data-bs-target="#modal-user_edit">
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a>
                                        <a href="#" class="mx-4 delete-button">
                                            <i class="far fa-trash-alt text-secondary"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-5 d-flex justify-content-end">
                        <ul class="pagination pagination-sm pagination-gutter px-4">
                            <li class="page-item page-indicator {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Previous">
                                    <i class="fa fa-angle-left me-1"></i>
                                </a>
                            </li>

                            @for ($i = 1; $i <= $users->lastPage(); $i++)
                                <li class="page-item {{ $users->currentPage() == $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            <li class="page-item page-indicator {{ $users->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Next">
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
    function togglePassword(userId) {
        var passwordText = document.getElementById('password-text-' + userId);
        var passwordFull = document.getElementById('password-full-' + userId);
        var eyeIcon = document.getElementById('eye-icon-' + userId);

        // Toggle between encrypted password and full password
        if (passwordFull.style.display === 'none') {
            passwordFull.style.display = 'inline';
            passwordText.style.display = 'none';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        } else {
            passwordFull.style.display = 'none';
            passwordText.style.display = 'inline';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        }
    }

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
                var email = parentElement.getAttribute("data-email");
                var password = parentElement.getAttribute("data-password");
                var location = parentElement.getAttribute("data-location");

                // Isi data ke dalam form modal
                document.getElementById("id").value = id;
                document.getElementById("name").value = name;
                document.getElementById("email").value = email;
                document.getElementById("location").value = location;
            });
        });
    });
</script>
@endsection