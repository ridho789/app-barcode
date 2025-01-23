@extends('layouts.user_type.auth')

@section('content')

<div>
    @if (session('success'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success">
                <strong>Success:</strong> {{ session('success') }}
            </div>
        </div>
    </div>
    @endif

    @if (session('error'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger">
                <strong>Error:</strong> {{ session('error') }}
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-3">
                    <div class="d-flex justify-content-between">
                        <h5 class="mb-0">Configuration</h5>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ url('scale-read') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="port" class="form-label">Port Serial</label>
                            <select name="port" id="port" class="form-control" required>
                                <option value="" disabled selected>Select a port</option>
                                @if (count($ports) > 0)
                                    @foreach ($ports as $port)
                                        <option value="{{ $port }}">{{ $port }}</option>
                                    @endforeach
                                @else
                                    <option value="" disabled>No ports available</option>
                                @endif
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="baudrate" class="form-label">Baud Rate</label>
                            <select name="baudrate" id="baudrate" class="form-control" required>
                                <option value="" disabled selected>Select baud rate</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Read</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Data baudRates dari controller dalam bentuk JSON
    const baudRates = @json($baudRates);

    // Event listener untuk dropdown port
    document.getElementById('port').addEventListener('change', function () {
        const selectedPort = this.value; // Port yang dipilih
        const baudrateDropdown = document.getElementById('baudrate'); // Dropdown baud rate

        // Bersihkan isi dropdown baudrate
        baudrateDropdown.innerHTML = '';

        // Cek apakah port memiliki baud rate terkait
        if (baudRates[selectedPort]) {
            const option = document.createElement('option');
            option.value = baudRates[selectedPort];
            option.textContent = baudRates[selectedPort];
            baudrateDropdown.appendChild(option);
        } else {
            const option = document.createElement('option');
            option.value = '';
            option.textContent = 'No baud rate available';
            baudrateDropdown.appendChild(option);
        }
    });
</script>

@endsection