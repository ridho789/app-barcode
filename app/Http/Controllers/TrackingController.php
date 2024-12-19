<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracking;
use App\Models\MarkingHeader;
use App\Models\User;

class TrackingController extends Controller
{
    public function index() {
        $trackings = Tracking::orderBy('created_at', 'desc')->get();
        $markingHeader = MarkingHeader::pluck('outer_marking', 'id_marking_header');
        $userName = User::pluck('name', 'id');
        return view('management.tracking', compact('trackings', 'markingHeader', 'userName'));
    }

    public function in(Request $request) {
        // Membersihkan dan memproses input barcode
        $processedBarcode = preg_replace('/[^0-9\n]/', '', $request->barcodeIn);
        $processedBarcode = array_filter(array_map('trim', explode("\n", $processedBarcode)));
    
        // Temukan user berdasarkan ID
        $user = User::find($request->user);
    
        if ($user) {
            // Cari ID yang ada di tabel Tracking
            $existingIds = Tracking::whereIn('id_marking_header', $processedBarcode)->pluck('id_marking_header')->toArray();
    
            // Temukan ID yang tidak ditemukan
            $missingIds = array_diff($processedBarcode, $existingIds);
    
            // Update status untuk ID yang ditemukan
            if (!empty($existingIds)) {
                Tracking::whereIn('id_marking_header', $existingIds)->update([
                    'status' => 'BARANG MASUK - ' . $user->location,
                    'id_user' => $request->user
                ]);
            }
    
            // Catat log error jika ada ID yang tidak ditemukan
            $logErrors = [];
            if (!empty($missingIds)) {
                foreach ($missingIds as $missingId) {
                    $logErrors[] = 'Barcode B-' . $missingId . ', not found in system.';
                }
            }
    
            return redirect('trackings')->with([
                'logErrors' => $logErrors,
            ]);

        } else {
            return redirect('trackings')->with('error', 'User not found');
        }
    }    

    public function out(Request $request) {
        $processedBarcode = preg_replace('/[^0-9\n]/', '', $request->barcodeOut);
        $processedBarcode = array_filter(array_map('trim', explode("\n", $processedBarcode)));

        // Temukan user berdasarkan ID
        $user = User::find($request->user);
        
        if ($user) {
            // Cari ID yang ada di tabel Tracking
            $existingIds = Tracking::whereIn('id_marking_header', $processedBarcode)->pluck('id_marking_header')->toArray();
    
            // Temukan ID yang tidak ditemukan
            $missingIds = array_diff($processedBarcode, $existingIds);
    
            // Update status untuk ID yang ditemukan
            if (!empty($existingIds)) {
                Tracking::whereIn('id_marking_header', $existingIds)->update([
                    'status' => 'BARANG KELUAR - ' . $user->location,
                    'id_user' => $request->user
                ]);
            }
    
            // Catat log error jika ada ID yang tidak ditemukan
            $logErrors = [];
            if (!empty($missingIds)) {
                foreach ($missingIds as $missingId) {
                    $logErrors[] = 'Barcode B-' . $missingId . ', not found in system.';
                }
            }
    
            return redirect('trackings')->with([
                'logErrors' => $logErrors,
            ]);

        } else {
            return redirect('trackings')->with('error', 'User not found');
        }
    }
}
