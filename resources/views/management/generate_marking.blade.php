@extends('layouts.user_type.auth')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0">
                <!-- Bagian header kosong -->
            </div>
            <div class="card-body px-4 pt-0 pb-3">
                @if ($markingHeader == null)
                <form role="form text-left" action="{{ url('marking-store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6">
                            <h5 class="font-weight-bolder d-inline-block mb-0">Main Marking</h5>
                        </div>
                        <div class="col-12 col-md-6 text-md-end">
                            <p class="font-weight-bolder text-sm mb-0">Date: {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <label>Customer</label>
                            @if (count($customers) > 0)
                                <select class="form-control form-select" name="id_customer">
                                    <option value="">Select customer</option>
                                    @foreach ($customers as $c)
                                        <option value="{{ $c->id_customer }}" data-code="{{ $c->code_mark }}"
                                            {{ old('id_customer') == $c->id_customer ? 'selected' : '' }}>{{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text" class="form-control" placeholder="No data" 
                                style="background-color: #fff !important;" disabled>
                            @endif
                        </div>
                        <div class="col-12 col-md-3">
                            <label>Code Mark</label>
                            <input class="form-control" type="text" name="code_mark" placeholder="Code Mark" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Note</label>
                            <input class="form-control" type="text" name="main_note" placeholder="Note">
                        </div>
                    </div>

                    <div class="table-responsive py-3 d-none d-md-block">
                        <p class="font-weight-bolder text-sm">List Inner Markings</p>
                        <table class="table table-bordered align-items-center mb-0" id="data-table">
                            <thead class="d-md-table-header-group">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Inner Markings</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qty</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Note</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="3.5%" class="align-middle text-center text-xs">1.</td>
                                    <td class="align-middle text-center">
                                        <input type="text" name="inner_marking[]" class="form-control inner_marking" required>
                                    </td>
                                    <td width="5%" class="align-middle text-center">
                                        <input type="number" min="1" name="qty[]" class="form-control qty">
                                    </td>
                                    <td width="7.5%" class="align-middle text-center">
                                        @if (count($units) > 0)
                                            <select class="form-control form-select" name="id_unit[]">
                                                <option value="">...</option>
                                                @foreach ($units as $u)
                                                    <option value="{{ $u->id_unit }}"
                                                        {{ old('id_unit') == $u->id_unit ? 'selected' : '' }}>{{ $u->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="text" class="form-control text-xxs" placeholder="No data" 
                                            style="background-color: #fff !important;" disabled>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <input type="text" name="note[]" class="form-control note">
                                    </td>
                                    <td width="5%" class="align-middle text-center">
                                        <button type="button" class="btn btn-danger delete-row" style="margin-bottom: 0;" disabled>
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- List version for mobile devices -->
                    <div class="d-block d-md-none">
                        <p class="font-weight-bolder text-sm mt-3">List Inner Markings</p>
                        <label>No. 1</label>
                        <ul class="list-group" id="inner-marking-list">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-12">
                                        <label>Inner Markings</label>
                                        <input type="text" name="inner_marking[]" class="form-control inner_marking" placeholder="Inner Markings" required>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-6">
                                        <label>Qty:</label>
                                        <input type="number" min="1" name="qty[]" class="form-control qty" placeholder="Quantity">
                                    </div>
                                    <div class="col-6">
                                        <label>Unit:</label>
                                        @if (count($units) > 0)
                                            <select class="form-control form-select" name="id_unit[]">
                                                <option value="">...</option>
                                                @foreach ($units as $u)
                                                    <option value="{{ $u->id_unit }}"
                                                        {{ old('id_unit') == $u->id_unit ? 'selected' : '' }}>{{ $u->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="text" class="form-control text-xxs" placeholder="No data" 
                                            style="background-color: #fff !important;" disabled>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-12">
                                        <label>Note:</label>
                                        <input type="text" name="note[]" class="form-control note" placeholder="Note">
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item text-center mt-3">
                                <button type="button" class="btn btn-danger delete-row" disabled>
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <span class="font-weight-bolder text-xs d-none d-md-inline">
                            To insert a new row in the column, please press the "<span class="text-danger">Enter</span>" key.
                        </span>
                        <span class="font-weight-bolder text-xs d-inline d-md-none">
                            Press "<span class="text-danger">Enter or @</span>" to add a row.
                        </span>
                    </div>
                    <div class="text-start mt-3">
                        <button type="submit" class="btn btn-primary btn-sm d-block d-md-inline">
                            Submit
                        </button>
                    </div>
                </form>
                @else
                <form role="form text-left" action="{{ url('marking-update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit-id" name="id_marking_header" value="{{ $markingHeader->id_marking_header }}">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6">
                            <h5 class="font-weight-bolder d-inline-block mb-0">Main Marking</h5>
                        </div>
                        <div class="col-12 col-md-6 text-md-end">
                            @if ($markingHeader->updated_at)
                            <p class="font-weight-bolder text-sm mb-0">Last Updated: {{ \Carbon\Carbon::parse($markingHeader->updated_at)->addHours(7)->format('d M Y H:i') }}</p>
                            @else
                            <p class="font-weight-bolder text-sm mb-0">Created at: {{ \Carbon\Carbon::parse($markingHeader->created_at)->addHours(7)->format('d M Y H:i') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <label>Customer</label>
                            @if (count($customers) > 0)
                                <select class="form-control form-select" name="id_customer">
                                    <option value="">Select customer</option>
                                    @foreach ($customers as $c)
                                        <option value="{{ $c->id_customer }}" data-code="{{ $c->code_mark }}"
                                            {{ old('id_customer') == $c->id_customer ? 'selected' : '' }}>{{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text" class="form-control" placeholder="No data" 
                                style="background-color: #fff !important;" disabled>
                            @endif
                        </div>
                        <div class="col-12 col-md-3">
                            <label>Code Mark</label>
                            <input class="form-control" type="text" name="code_mark" value="{{ $markingHeader->outer_marking }}" placeholder="Code Mark" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Note</label>
                            <input class="form-control" type="text" name="main_note" value="{{ $markingHeader->note }}" placeholder="Note">
                        </div>
                    </div>

                    <div class="table-responsive py-3">
                        <p class="font-weight-bolder text-sm">List Inner Markings</p>
                        <table class="table table-bordered align-items-center mb-0 d-none d-md-table" id="data-table">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Inner Markings</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qty</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Note</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($markingDetails as $index => $md)
                                <tr>
                                    <input type="hidden" id="edit-id_marking_detail" name="id_marking_detail[]" value="{{ $md->id_marking_detail }}">
                                    <td width="3.5%" class="align-middle text-center text-xs">{{ $index + 1 }}.</td>
                                    <td class="align-middle text-center">
                                        <input type="text" name="inner_marking[]" value="{{ $md->inner_marking }}" class="form-control inner_marking" required>
                                    </td>
                                    <td width="5%" class="align-middle text-center">
                                        <input type="number" min="1" name="qty[]" value="{{ $md->qty }}" class="form-control qty">
                                    </td>
                                    <td width="7.5%" class="align-middle text-center">
                                        @if (count($units) > 0)
                                            <select class="form-control form-select" name="id_unit[]">
                                                <option value="">...</option>
                                                @foreach ($units as $u)
                                                    <option value="{{ $u->id_unit }}" {{ old('id_unit', $md->id_unit) == $u->id_unit ? 'selected' : '' }}>{{ $u->name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="text" class="form-control text-xxs" placeholder="No data" style="background-color: #fff !important;" disabled>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <input type="text" name="note[]" value="{{ $md->note }}" class="form-control note">
                                    </td>
                                    <td width="5%" class="align-middle text-center">
                                        <button type="button" class="btn btn-danger delete-row" data-id="{{ $md->id_marking_detail }}" 
                                            style="margin-bottom: 0;" {{ $index === 0 ? 'disabled' : '' }}>
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- List version for mobile devices -->
                        @foreach($markingDetails as $index => $md)
                        <div class="d-block d-md-none mt-3">
                            <label>No. {{ $index + 1 }}</label>
                            <ul class="list-group">
                                <input type="hidden" id="edit-id_marking_detail" name="id_marking_detail[]" value="{{ $md->id_marking_detail }}">
                                <li class="list-group-item">
                                    <label>Inner Markings</label>
                                    <input type="text" name="inner_marking[]" class="form-control inner_marking" value="{{ $md->inner_marking }}" placeholder="Inner Markings" required>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Qty:</label>
                                            <input type="number" min="1" name="qty[]" value="{{ $md->qty }}" class="form-control qty" placeholder="Quantity">
                                        </div>
                                        <div class="col-6">
                                            <label>Unit:</label>
                                            @if (count($units) > 0)
                                                <select class="form-control form-select" name="id_unit[]">
                                                    <option value="">...</option>
                                                    @foreach ($units as $u)
                                                        <option value="{{ $u->id_unit }}" {{ old('id_unit', $md->id_unit) == $u->id_unit ? 'selected' : '' }}>{{ $u->name }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="text" class="form-control text-xxs" placeholder="No data" style="background-color: #fff !important;" disabled>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <label>Note:</label>
                                    <input type="text" name="note[]" value="{{ $md->note }}" class="form-control note" placeholder="Note">
                                </li>
                                <li class="list-group-item text-center mt-3">
                                    <button type="button" class="btn btn-danger delete-row-md" data-id="{{ $md->id_marking_detail }}" {{ $index === 0 ? 'disabled' : '' }}>
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>
                        @endforeach
                    </div>

                    <div>
                        <span class="font-weight-bolder text-xs d-none d-md-inline">
                            To insert a new row in the column, please press the "<span class="text-danger">Enter</span>" key.
                        </span>
                        <span class="font-weight-bolder text-xs d-inline d-md-none">
                            Press "<span class="text-danger">Enter or @</span>" to add a row.
                        </span>
                    </div>
                    <div class="text-start mt-3 d-flex flex-column flex-md-row">
                        <button type="submit" class="btn btn-primary btn-sm me-md-2">
                            Update
                        </button>
                        <button type="button" id="print-button" class="btn btn-secondary btn-sm" 
                            data-id="{{ $markingHeader->id_marking_header }}">
                            Print
                        </button>
                    </div>
                </form>

                <!-- Form tersembunyi untuk mengirim penghapusan -->
                <form id="delete-form-hidden" action="" method="GET" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>

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
            placeholder: 'Select',
        });
    }

    const printButton = document.getElementById('print-button');
    if (printButton) {
        printButton.addEventListener('click', function () {
            const markingHeaderId = this.getAttribute('data-id');
            if (markingHeaderId) {
                window.open(`/print-marking-details/${markingHeaderId}`, '_blank');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk menambahkan baris baru saat tekan Enter
        document.querySelector('#data-table').addEventListener('keydown', function(e) {
            if (e.target.tagName === 'INPUT') {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addNewRow();
                }

                if (e.key === '@') {
                    e.preventDefault();
                    addNewRow();
                }
            }
        });

        const customerSelect = document.querySelector('select[name="id_customer"]');
        const codeMarkInput = document.querySelector('input[name="code_mark"]');

        customerSelect.addEventListener('change', function() {
            const selectedOption = customerSelect.options[customerSelect.selectedIndex];
            const codeMark = selectedOption.getAttribute('data-code');
            codeMarkInput.value = codeMark || '';
        });

        // Fungsi untuk menambah baris baru
        function addNewRow() {
            var rowCount = document.querySelectorAll('#data-table tbody tr').length + 1;
            var newRow;

            // Cek apakah tampilan adalah mobile atau desktop
            if (isMobileView()) {
                newRow = document.createElement('div');
                newRow.classList.add('d-block', 'd-md-none');
                newRow.innerHTML = `
                    <p class="font-weight-bolder text-sm mt-3">List Inner Markings</p>
                    <label>No. ${rowCount}</label>
                    <ul class="list-group" id="inner-marking-list">
                        <input type="hidden" id="edit-id_marking_detail" name="id_marking_detail[]">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-12">
                                    <label>Inner Markings</label>
                                    <input type="text" name="inner_marking[]" class="form-control inner_marking" placeholder="Inner Markings" required>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-6">
                                    <label>Qty:</label>
                                    <input type="number" min="1" name="qty[]" class="form-control qty" placeholder="Quantity">
                                </div>
                                <div class="col-6">
                                    <label>Unit:</label>
                                    @if (count($units) > 0)
                                        <select class="form-control form-select" name="id_unit[]">
                                            <option value="">...</option>
                                            @foreach ($units as $u)
                                                <option value="{{ $u->id_unit }}"
                                                    {{ old('id_unit') == $u->id_unit ? 'selected' : '' }}>{{ $u->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="text" class="form-control text-xxs" placeholder="No data" 
                                        style="background-color: #fff !important;" disabled>
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-12">
                                    <label>Note:</label>
                                    <input type="text" name="note[]" class="form-control note" placeholder="Note">
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item text-center mt-3">
                            <button type="button" class="btn btn-danger delete-row-md">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </li>
                    </ul>
                `;
            } else {
                newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <input type="hidden" id="edit-id_marking_detail" name="id_marking_detail[]">
                    <td class="align-middle text-center text-xs">${rowCount}.</td>
                    <td class="align-middle text-center"><input type="text" name="inner_marking[]" class="form-control inner_marking" required></td>
                    <td class="align-middle text-center"><input type="number" min="1" name="qty[]" class="form-control qty"></td>
                    <td class="align-middle text-center">
                        @if (count($units) > 0)
                            <select class="form-control form-select" name="id_unit[]">
                                <option value="">...</option>
                                @foreach ($units as $u)
                                <option class="form-control" value="{{ $u->id_unit }}"
                                    {{ old('id_unit') == $u->id_unit ? 'selected' : '' }}>{{ $u->name }}
                                </option>
                                @endforeach
                            </select>
                        @else
                            <input type="text" class="form-control text-xxs" placeholder="No data" 
                            style="background-color: #fff !important;" disabled>
                        @endif
                    </td>
                    <td class="align-middle text-center"><input type="text" name="note[]" class="form-control note"></td>
                    <td class="align-middle text-center">
                        <button type="button" class="btn btn-danger delete-row" style="margin-bottom: 0;">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </td>
                `;
            }

            // Menambahkan baris baru ke tbody sesuai dengan tampilan
            if (isMobileView()) {
                document.querySelector('#data-table tbody').appendChild(newRow);
            } else {
                document.querySelector('#data-table tbody').appendChild(newRow);
            }

            updateRowNumbers();
        }

        function toggleInputs() {
            if (window.innerWidth >= 768) {
                // Tampilan Desktop
                document.querySelectorAll('.d-md-table .form-control, .d-md-table select, .d-md-table input[type="hidden"]').forEach(el => {
                    el.removeAttribute('disabled');
                });
                document.querySelectorAll('.d-md-none .form-control, .d-md-none select, .d-md-none input[type="hidden"]').forEach(el => {
                    el.setAttribute('disabled', 'disabled');
                    el.value = '';
                });
            } else {
                // Tampilan Mobile
                document.querySelectorAll('.d-md-none .form-control, .d-md-none select, .d-md-none input[type="hidden"]').forEach(el => {
                    el.removeAttribute('disabled');
                });
                document.querySelectorAll('.d-md-table .form-control, .d-md-table select, .d-md-table input[type="hidden"]').forEach(el => {
                    el.setAttribute('disabled', 'disabled');
                    el.value = '';
                });
            }
        }

        // Panggil fungsi saat halaman dimuat dan ketika ukuran layar berubah
        window.addEventListener('load', toggleInputs);
        window.addEventListener('resize', toggleInputs);

        // Fungsi untuk menghapus baris di tampilan desktop
        document.querySelectorAll('.delete-row').forEach(button => {
            button.addEventListener('click', function(e) {
                var idMarkingDetail = e.target.closest('button').getAttribute('data-id');

                if (idMarkingDetail) {
                    // Set form action URL dan submit
                    var deleteForm = document.getElementById('delete-form-hidden');
                    deleteForm.action = '/delete-marking-detail/' + idMarkingDetail;
                    deleteForm.submit();

                    // Hapus baris dari tampilan
                    row.remove();
                    updateRowNumbers();
                } else {
                    // Jika tidak ada id, hapus baris langsung dari tampilan
                    row.remove();
                    updateRowNumbers();
                }
            });
        });

        // Fungsi untuk menghapus item di tampilan mobile
        document.querySelectorAll('.delete-row-md').forEach(button => {
            button.addEventListener('click', function(e) {
                var idMarkingDetail = e.target.getAttribute('data-id');

                if (idMarkingDetail) {
                    // Set form action URL dan submit
                    var deleteForm = document.getElementById('delete-form-hidden');
                    deleteForm.action = '/delete-marking-detail/' + idMarkingDetail;
                    deleteForm.submit();

                    // Hapus item dari tampilan
                    var listGroup = e.target.closest.closest('.list-group');
                    if (listGroup) {
                        listGroup.remove();
                    }
                } else {
                    // Jika tidak ada id, hapus item langsung dari tampilan
                    var listGroup = e.target.closest.closest('.list-group');
                    if (listGroup) {
                        listGroup.remove();
                    }
                }
            });
        });

        function isMobileView() {
            return window.innerWidth < 768;
        }

        // Fungsi untuk memperbarui nomor baris
        function updateRowNumbers() {
            var rows = document.querySelectorAll('#data-table tbody tr');
            rows.forEach(function(row, index) {
                row.querySelector('td').textContent = (index + 1) + '.';
            });
        }

        // Update total saat jumlah atau harga berubah
        document.querySelector('#data-table').addEventListener('input', function(e) {
            if (e.target.classList.contains('jumlah') || e.target.classList.contains('harga')) {
                var row = e.target.closest('tr');
                var jumlah = parseFloat(row.querySelector('.jumlah').value) || 0;
                var harga = parseFloat(row.querySelector('.harga').value) || 0;
                var total = jumlah * harga;
                row.querySelector('.total').value = total;
            }
        });

        initializeSelect2('.select2');
    });
</script>
@endsection