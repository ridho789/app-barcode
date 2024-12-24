<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modbus Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form div {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        pre {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            overflow-x: auto;
        }
    </style>
    <script>
        function updateForm() {
            var connectionType = document.getElementById("connection_type").value;
            if (connectionType == "tcp") {
                document.getElementById("tcp_settings").style.display = "block";
                document.getElementById("rtu_settings").style.display = "none";
            } else if (connectionType == "rtu") {
                document.getElementById("rtu_settings").style.display = "block";
                document.getElementById("tcp_settings").style.display = "none";
            }
        }
        window.onload = updateForm;
    </script>
</head>
<body>
    <div class="container">
        <h1>Modbus Reader</h1>
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- <pre>{{ var_dump($comPorts) }}</pre> -->
        <form action="{{ route('modbus.read') }}" method="POST">
            @csrf
            <div>
                <label for="connection_type">Connection Type:</label>
                <select id="connection_type" name="connection_type" required onchange="updateForm()">
                    <option value="tcp" {{ old('connection_type') == 'tcp' ? 'selected' : '' }}>TCP</option>
                    <option value="rtu" {{ old('connection_type') == 'rtu' ? 'selected' : '' }}>RTU</option>
                </select>
            </div>
            <div id="tcp_settings" style="display: none;">
                <div>
                    <label for="ip_address">IP Address:</label>
                    <input type="text" id="ip_address" name="ip_address" value="{{ old('ip_address') }}" required>
                </div>
                <div>
                    <label for="port">Port:</label>
                    <input type="number" id="port" name="port" value="{{ old('port') }}" required>
                </div>
            </div>
            <div id="rtu_settings" style="display: none;">
                <div>
                    <label for="device_address">Device Address:</label>
                    <input type="text" id="device_address" name="device_address" value="{{ old('device_address') }}" required>
                </div>
                <div>
                    <label for="serial_port">Serial Port (RTU):</label>
                    <input type="text" id="serial_port" name="serial_port" value="{{ old('serial_port') }}" required>
                </div>
                <div>
                    <label for="baud_rate">Baud Rate:</label>
                    <input type="number" id="baud_rate" name="baud_rate" value="{{ old('baud_rate') }}" required>
                </div>
                <div>
                    <label for="parity">Parity:</label>
                    <select id="parity" name="parity" required>
                        <option value="none" {{ old('parity') == 'none' ? 'selected' : '' }}>None</option>
                        <option value="even" {{ old('parity') == 'even' ? 'selected' : '' }}>Even</option>
                        <option value="odd" {{ old('parity') == 'odd' ? 'selected' : '' }}>Odd</option>
                    </select>
                </div>
            </div>
            <div>
                <label for="slave_id">Slave ID:</label>
                <input type="number" id="slave_id" name="slave_id" value="{{ old('slave_id') }}" required>
            </div>
            <div>
                <label for="start_address">Start Address:</label>
                <input type="number" id="start_address" name="start_address" value="{{ old('start_address') }}" required>
            </div>
            <div>
                <label for="register_count">Register Count:</label>
                <input type="number" id="register_count" name="register_count" value="{{ old('register_count') }}" required>
            </div>
            <div>
                <label for="com_port">COM Port (for RTU):</label>
                <select name="com_port" id="com_port">
                    <option value="">--Select COM Port--</option>
                    @foreach($comPorts as $port)
                        <option value="{{ $port }}">{{ $port }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit">Read Data</button>
        </form>
        @if($errors->any())
            <div class="error">
                <h4>Error:</h4>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</body>
</html>
