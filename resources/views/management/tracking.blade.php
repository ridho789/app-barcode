@extends('layouts.user_type.auth')
@section('content')
<!-- Modal Scan IN -->
<div class="modal fade" id="modal-scanIn" tabindex="-1" role="dialog" aria-labelledby="modal-scanIn" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <p class="font-weight-bolder text-primary text-gradient">Barcode Scan IN</p>
                        <p style="margin-top: -10px;" class="mb-0 text-sm">Update status data with this form.</p>
                    </div>
                    <div class="card-body">
                        <form role="form text-left" action="{{ url('tracking-in') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="user" name="user" value="{{ auth()->user()->id }}">
                            <label>Barcode</label>
                            <div class="input-group mb-3">
                                <textarea type="text" rows="10" class="form-control" name="barcodeIn" placeholder="Enter Barcode Scan IN" aria-label="Barcode Scan IN" 
                                oninput="this.value = this.value.toUpperCase()"></textarea>
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

<!-- Modal Scan OUT -->
<div class="modal fade" id="modal-scanOut" tabindex="-1" role="dialog" aria-labelledby="modal-scanOut" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <p class="font-weight-bolder text-info text-gradient">Barcode Scan OUT</p>
                        <p style="margin-top: -10px;" class="mb-0 text-sm">Update status data with this form.</p>
                    </div>
                    <div class="card-body">
                        <form role="form text-left" action="{{ url('tracking-out') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="user" name="user" value="{{ auth()->user()->id }}">
                            <label>Barcode</label>
                            <div class="input-group mb-3">
                                <textarea type="text" rows="10" class="form-control" name="barcodeOut" placeholder="Enter Barcode Scan Out" aria-label="Barcode Scan OUT" 
                                oninput="this.value = this.value.toUpperCase()"></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-round bg-gradient-secondary btn-lg w-100 mt-4 mb-0">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card h-100 p-3">
            <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('../assets/img/ivancik.jpg');">
                <span class="mask bg-gradient-dark"></span>
                <div class="card-body position-relative z-index-1 d-flex flex-column h-75 p-3">
                    <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;" data-bs-toggle="modal" data-bs-target="#modal-scanIn">
                        <h5 class="text-white font-weight-bolder mb-2 pt-2">SCAN IN</h5>
                        <p class="text-white">Ready to get started? Click this to begin scanning barcodes of incoming items!</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100 p-3">
            <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('../assets/img/ivancik.jpg');">
                <span class="mask bg-gradient-dark"></span>
                <div class="card-body position-relative z-index-1 d-flex flex-column h-75 p-3">
                    <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;" data-bs-toggle="modal" data-bs-target="#modal-scanOut">
                        <h5 class="text-white font-weight-bolder mb-2 pt-2">SCAN OUT</h5>
                        <p class="text-white">Ready to get started? Click this to begin scanning barcodes of outcoming items!</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session()->has('logErrors') && !empty(session('logErrors')))
<div class="row">
    <div class="col-md-12 mt-4" style="max-height: 350px; overflow-y: auto;">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-sm text-danger">Error Log</h5>
                @if(is_array(session('logErrors')))
                @foreach(session('logErrors') as $logError)
                <ul>
                    <li>{{ $logError }}</li>
                </ul>
                @endforeach
                @else
                {{ session('logErrors') }}
                @endif
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header pb-3">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <!-- Teks lebih kecil saat di perangkat mobile -->
                        <h6 class="mb-0 d-none d-md-block">List Data Trackings</h6>
                        <h6 class="mb-0 d-block d-md-none">List Data Trackings</h6>
                    </div>
                </div>
            </div>
            @if (count($trackings) > 0)
            <div class="card-body px-0 pt-0 pb-2">
                <!-- Tampilan Tabel untuk Perangkat Ukuran Desktop -->
                <div class="table-responsive p-0 d-none d-md-block">
                    <table id="datatables" class="table align-items-center mb-3">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Outer Marking</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Updated at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trackings as $t)
                            <tr>
                                <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}.</p></td>
                                <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $markingHeader[$t->id_marking_header] }}</p></td>
                                <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $userName[$t->id_user] }}</p></td>
                                <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $t->status }}</p></td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($t->updated_at)->addHours(7)->format('d M Y H:i') }}</p>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Tampilan List untuk Perangkat Ukuran Mobile -->
                <div class="list-group d-block d-md-none">
                    @foreach($trackings as $t)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="mb-1">No. {{ $loop->iteration }}</h6>
                                <p class="mb-1"><strong>Outer Marking:</strong> {{ $markingHeader[$t->id_marking_header] }}</p>
                                <p class="mb-1"><strong>User:</strong> {{ $userName[$t->id_user] }}</p>
                                <p class="mb-1"><strong>Updated at:</strong> {{ \Carbon\Carbon::parse($t->updated_at)->addHours(7)->format('d M Y H:i') }}</p>
                                <p class="mb-1"><strong>Status:</strong> {{ $t->status ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-5 d-flex d-md-none justify-content-end">
                    <ul class="pagination pagination-sm pagination-gutter px-4">
                        <li class="page-item page-indicator {{ $trackings->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $trackings->previousPageUrl() }}" aria-label="Previous">
                                <i class="fa fa-angle-left me-1"></i>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $trackings->lastPage(); $i++)
                            <li class="page-item {{ $trackings->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $trackings->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li class="page-item page-indicator {{ $trackings->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $trackings->nextPageUrl() }}" aria-label="Next">
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
<script>
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
</script>
@endsection