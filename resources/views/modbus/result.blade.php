<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modbus Result</title>
</head>
<body>
    <h1>Modbus Read Result</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Register</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $value)
                <tr>
                    <td>{{ $index }}</td>
                    <td>{{ $value }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('modbus.form') }}">Back to Form</a>
</body>
</html>
