<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpModbus\ModbusMaster;
use PhpModbus\ModbusException;
use Illuminate\Support\Facades\Log;

class ModbusController extends Controller
{
    public function showForm() {
        $comPorts = $this->getAvailableComPorts();
        return view('modbus.form', compact('comPorts'));
    }

    private function getAvailableComPorts() {
        $comPorts = [];
        if (stripos(PHP_OS, 'win') === 0) {
            exec('mode', $output);
            Log::info('Windows COM port output: ', $output);
            foreach ($output as $line) {
                if (preg_match('/^Status for device (COM\d+|LPT\d+):/', $line, $matches)) {
                    $comPorts[] = $matches[1];
                }
            }
        } else {
            exec('ls /dev/tty*', $output);
            foreach ($output as $line) {
                if (preg_match('/\/dev\/tty[A-Za-z0-9]+/', $line)) {
                    $comPorts[] = $line;
                }
            }
        }
        Log::info('Detected COM ports: ', $comPorts);
        return $comPorts;
    }

    public function debugComPorts() {
        $comPorts = $this->getAvailableComPorts();
        dd($comPorts);
    }

    public function readData(Request $request) {
        $validated = $request->validate([
            'device_address' => 'required|string',
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
        $comPort = $validated['com_port'] ?? null;

        try {
            if ($connectionType == 'tcp') {
                $modbus = new ModbusMaster($deviceAddress, 'tcp');
            } else {
                if (!$comPort) {
                    throw new \Exception('COM port is required for RTU connection.');
                }
                $modbus = new ModbusMaster($comPort, 'rtu');
                $modbus->setBaudRate(9600);
                $modbus->setParity(ModbusMaster::PARITY_NONE);
                $modbus->setDataBits(8);
                $modbus->setStopBits(1);
            }

            $data = $modbus->readMultipleRegisters($slaveId, $startAddress, $registerCount);
            return view('modbus.result', ['data' => $data]);
        } catch (ModbusException $e) {
            return back()->withErrors(['error' => 'Modbus error: ' . $e->getMessage()]);
        }
    }
}
