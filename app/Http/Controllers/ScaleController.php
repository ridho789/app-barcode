<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hyperthese\PhpSerial\PhpSerial;

class ScaleController extends Controller
{
    public function index()
    {
        // Mendapatkan daftar port serial yang tersedia (Windows)
        $ports = [];
        $baudRates = [];
        
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Windows: Mendapatkan COM port dari registry
            $output = shell_exec('mode');
            if ($output) {
                preg_match_all('/COM[0-9]+/', $output, $matches);
                $ports = $matches[0];

                // Mendapatkan rincian baud rate untuk masing-masing COM port
                foreach ($ports as $port) {
                    $portOutput = shell_exec("mode $port");
                    if ($portOutput) {
                        if (preg_match('/\bBaud:\s+(\d+)/i', $portOutput, $baudMatch)) {
                            $baudRates[$port] = $baudMatch[1];
                        } else {
                            $baudRates[$port] = 'Unknown'; // Jika tidak ada baud rate ditemukan
                        }
                    } else {
                        $baudRates[$port] = 'Unavailable'; // Jika mode gagal untuk port tertentu
                    }
                }
                
            } else {
                $ports = []; // Tidak ada port ditemukan
                $baudRates = [];
            }
        }

        // Kirim port dan baud rate ke view
        return view('scale.read', compact('ports', 'baudRates'));
    }

    public function read(Request $request)
    {
        // Validasi input
        $request->validate([
            'port' => 'required|string',
            'baudrate' => 'required|integer',
        ]);

        // Ambil konfigurasi dari form
        $port = $request->port; // Contoh: COM3 (Windows) atau /dev/ttyUSB0 (Linux/MacOS)
        $baudRate = $request->baudrate;

        try {
            // Inisialisasi serial port
            $serial = new PhpSerial();
            $serial->deviceSet($port); // Atur port serial
            $serial->confBaudRate($baudRate); // Atur baud rate
            $serial->confParity("none");
            $serial->confStopBits(1);

            // Buka koneksi serial
            $serial->deviceOpen();

            // Baca data dari timbangan
            $data = $serial->readPort();
            $serial->deviceClose();

            return back()->with('success', "Berat diterima: $data kg");
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membaca data: ' . $e->getMessage());
        }
    }
}