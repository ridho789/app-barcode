<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ModbusTcpClient\Network\BinaryStreamConnection;
use ModbusTcpClient\Packet\ModbusFunction\ReadHoldingRegistersRequest;
use ModbusTcpClient\Packet\ResponseFactory;
use ModbusTcpClient\Exception\ModbusException;
use Illuminate\Support\Facades\Log;

class ModbusController extends Controller
{
    public function showForm()
    {
        try {
            $comPorts = $this->getAvailableComPorts();
        } catch (\Exception $e) {
            Log::error('Error detecting COM ports: ' . $e->getMessage());
            $comPorts = [];
        }
        return view('modbus.form', compact('comPorts'));
    }

    private function getAvailableComPorts()
    {
        $comPorts = [];
        try {
            if (stripos(PHP_OS, 'win') === 0) {
                exec('mode', $output, $resultCode);
                if ($resultCode !== 0) {
                    throw new \Exception('Failed to execute "mode" command on Windows.');
                }
                Log::info('Windows COM port output: ', $output);
                foreach ($output as $line) {
                    if (preg_match('/^Status for device (COM\d+|LPT\d+):/', $line, $matches)) {
                        $comPorts[] = $matches[1];
                    }
                }
            } else {
                exec('ls /dev/tty*', $output, $resultCode);
                if ($resultCode !== 0) {
                    throw new \Exception('Failed to list COM ports on Linux.');
                }
                foreach ($output as $line) {
                    if (preg_match('/\/dev\/tty[A-Za-z0-9]+/', $line)) {
                        $comPorts[] = $line;
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error detecting COM ports: ' . $e->getMessage());
            throw $e;
        }

        Log::info('Detected COM ports: ', $comPorts);
        return $comPorts;
    }

    public function debugComPorts()
    {
        try {
            $comPorts = $this->getAvailableComPorts();
            return response()->json(['com_ports' => $comPorts], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function readData(Request $request)
    {
        $validated = $request->validate([
            'device_address' => 'required|string',
            'port' => 'nullable|integer',
            'slave_id' => 'required|integer|min:1',
            'start_address' => 'required|integer|min:0',
            'register_count' => 'required|integer|min:1',
            'connection_type' => 'required|in:tcp,rtu',
            'com_port' => 'nullable|string',
        ]);

        $deviceAddress = $validated['device_address'];
        $slaveId = $validated['slave_id'];
        $startAddress = $validated['start_address'];
        $registerCount = $validated['register_count'];
        $connectionType = $validated['connection_type'];
        $port = $validated['port'] ?? 502;
        $comPort = $validated['com_port'] ?? null;

        try {
            // Initialize Modbus connection
            $modbus = $this->initializeConnection($connectionType, $deviceAddress, $port, $comPort);

            // Send Modbus request
            $request = new ReadHoldingRegistersRequest($startAddress, $registerCount, $slaveId);
            $binaryData = $modbus->connect()->sendAndReceive($request);

            // Parse response
            $response = ResponseFactory::parseResponseOrThrow($binaryData);
            $result = $this->parseResponseData($response);

            return view('modbus.result', ['data' => $result]);
        } catch (ModbusException $e) {
            Log::error('Modbus error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Modbus error: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            Log::error('Unexpected error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Unexpected error: ' . $e->getMessage()]);
        }
    }

    private function initializeConnection($type, $address, $port, $comPort)
    {
        if ($type === 'tcp') {
            return BinaryStreamConnection::getBuilder()
                ->setHost($address)
                ->setPort($port)
                ->build();
        } elseif ($type === 'rtu') {
            if (!$comPort) {
                throw new \Exception('COM port is required for RTU connection.');
            }
            return BinaryStreamConnection::getBuilder()
                ->setUri($comPort)
                ->build();
        } else {
            throw new \Exception('Unsupported connection type.');
        }
    }

    private function parseResponseData($response)
    {
        $data = $response->getData(); // Assuming `getData()` is part of the ModbusTcpClient response
        $result = [];
        foreach ($data as $item) {
            try {
                $result[] = unpack('n', $item)[1];
            } catch (\Exception $e) {
                Log::error('Error unpacking response data: ' . $e->getMessage());
                $result[] = null;
            }
        }
        return $result;
    }
}