@extends('layouts.user_type.auth')

@section('content')
<div>
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
                            <h5 class="mb-0 d-none d-md-block">Data Markings</h5>
                            <h6 class="mb-0 d-block d-md-none">Data Markings</h6>
                        </div>
                        <!-- Tombol berubah menjadi ikon saja saat di perangkat mobile -->
                        <a href="{{ url('create_marking') }}" 
                        class="btn bg-gradient-primary btn-sm mb-0 d-none d-md-inline-block" 
                        type="button">
                            Create Marking
                        </a>
                        <a href="{{ url('create_marking') }}" 
                        class="btn bg-gradient-primary btn-sm mb-0 d-inline-block d-md-none" 
                        type="button">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
                @if (count($markings) > 0)
                <div class="card-body px-0 pt-0 pb-2">
                    <!-- Tampilan Tabel untuk Perangkat Ukuran Desktop -->
                    <div class="table-responsive p-0 d-none d-md-block">
                        <table id="datatables" class="table align-items-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Outer Marking</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qty Koli</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Note</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($markings as $m)
                                <tr>
                                    <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}.</p></td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $m->date ? \Carbon\Carbon::createFromFormat('Y-m-d', $m->date)->format('d M Y') : '-' }}</p>
                                    </td>
                                    <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $m->outer_marking }}</p></td>
                                    <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $m->marking_details_count }}</p></td>
                                    <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $m->note ?? '-' }}</p></td>
                                    <td class="text-center">
                                        <a href="{{ url('edit_marking', ['id' => Crypt::encrypt($m->id_marking_header)]) }}" class="mx-3 edit-button text-secondary font-weight-bold text-xs">
                                            Edit
                                        </a>
                                        <a href="{{ url('delete_marking', ['id' => Crypt::encrypt($m->id_marking_header)]) }}" class="mx-3 delete-button text-secondary font-weight-bold text-xs">
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
                        @foreach($markings as $m)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">No. {{ $loop->iteration }}</h6>
                                    <p class="mb-1"><strong>Date:</strong> 
                                        {{ $m->date ? \Carbon\Carbon::createFromFormat('Y-m-d', $m->date)->format('d M Y') : '-' }}
                                    </p>
                                    <p class="mb-1"><strong>Outer Marking:</strong> {{ $m->outer_marking }}</p>
                                    <p class="mb-1"><strong>Qty Koli:</strong> {{ $m->marking_details_count }}</p>
                                    <p class="mb-1"><strong>Note:</strong> {{ $m->note ?? '-' }}</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="{{ url('edit_marking', ['id' => Crypt::encrypt($m->id_marking_header)]) }}" class="mx-3 edit-button">
                                        <i class="fas fa-user-edit text-secondary"></i>
                                    </a>
                                    <a href="{{ url('delete_marking', ['id' => Crypt::encrypt($m->id_marking_header)]) }}" class="mx-3 delete-button">
                                        <i class="far fa-trash-alt text-secondary"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-5 d-flex d-md-none justify-content-end">
                        <ul class="pagination pagination-sm pagination-gutter px-4">
                            <li class="page-item page-indicator {{ $markings->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $markings->previousPageUrl() }}" aria-label="Previous">
                                    <i class="fa fa-angle-left me-1"></i>
                                </a>
                            </li>

                            @for ($i = 1; $i <= $markings->lastPage(); $i++)
                                <li class="page-item {{ $markings->currentPage() == $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $markings->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            <li class="page-item page-indicator {{ $markings->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $markings->nextPageUrl() }}" aria-label="Next">
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
    // Fungsi untuk menginisialisasi Select2
    function initializeSelect2(element) {
        $(element).select2({
            width: '100%',
            dropdownParent: $('#modal-marking'),
            placeholder: 'Select',
        });
    }

    $(document).ready(function() {
        var table = $('#datatables').DataTable({
            "language": {
                "lengthMenu": "Show _MENU_ entries",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "<i class='fa fa-angle-right ms-1'></i>",
                    "previous": "<i class='fa fa-angle-left ms-1'></i>"
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        initializeSelect2('.select2');
    });
</script>
@endsection