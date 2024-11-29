<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Marking Details PDF</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 15px; }
        .header { text-align: center; margin-bottom: 10px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #000; padding: 5px; text-align: center; }
        .barcode { margin-top: 20px; }
    </style>
</head>
<body>

    <div class="header">
        <h1 style="color: red;">{{ $markingHeader->outer_marking }}</h1>
        <p style="margin-top: -15px;">Main Marking</p>
    </div>

    @php
        $outerMarking = $markingHeader->outer_marking;
        $outerMarkingCount = strlen($outerMarking);

        $marginOuterBarcode = $outerMarkingCount >= 3 ? '35px' : '52.5px';
    @endphp

    <!-- {!! $barcode !!} -->
    <div style="text-align: justify;">
        <img src="data:image/png;base64,{{ $barcode }}" style="display: block; margin: 0 auto; width: 100%; height: auto;">
    </div>

    <div class="header">
        <p>Created on: {{ $markingHeader->date ? \Carbon\Carbon::createFromFormat('Y-m-d', $markingHeader->date)->format('d M Y') : '-' }}</p>
    </div>

    @foreach($markingDetails as $index => $detail)

        <div style="page-break-after: always;"></div>
        <div class="header">
            <h1>{{ $markingHeader->outer_marking }}</h1>
            <p style="margin-top: -15px;">Inner Marking: {{ $detail->inner_marking }}</p>
        </div>

        <!-- {!! $individualBarcodes[$index] !!} -->
        <div style="text-align: justify;">
            <img src="data:image/png;base64,{{ $individualBarcodes[$index] }}" style="display: block; margin: 0 auto; width: 100%; height: auto;">
        </div>

        <div class="header">
            <p>Created on: {{ $markingHeader->date ? \Carbon\Carbon::createFromFormat('Y-m-d', $markingHeader->date)->format('d M Y') : '-' }}</p>
        </div>
    @endforeach

</body>
</html>
