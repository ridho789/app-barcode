<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MarkingHeader;
use App\Models\MarkingDetail;
use App\Models\Customer;
use App\Models\Origin;
use App\Models\Shipper;
use App\Models\Unit;
use App\Models\Tracking;
use Illuminate\Support\Facades\Crypt;
use PDF;
use Picqer\Barcode\BarcodeGeneratorPNG;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Milon\Barcode\DNS1D;

class MarkingController extends Controller
{
    public function index() {
        $markings = MarkingHeader::withCount('markingDetails')->orderBy('date', 'desc')->orderBy('outer_marking')->paginate(50);
        $customers = Customer::orderBy('name')->get();
        $origins = Origin::orderBy('name')->get();
        $shippers = Shipper::orderBy('name')->get();
        return view('management.marking', compact('markings', 'customers', 'origins', 'shippers'));
    }

    public function create() {
        $customers = Customer::orderBy('name')->get();
        $origins = Origin::orderBy('name')->get();
        $shippers = Shipper::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();
        return view('management.generate_marking', [
            'customers' => $customers,
            'origins' => $origins,
            'shippers' => $shippers,
            'units' => $units,
            'markingHeader' => null,
            'markingDetails' => null
        ]);
    }

    public function store(Request $request) {
        $dataMain = [
            'outer_marking' => $request->code_mark,
            'date' => today(),
            'note' => $request->main_note,
        ];

        $markingHeader = MarkingHeader::create($dataMain);

        // Create data tracking
        $dataTracking = [
            'id_marking_header' => $markingHeader->id_marking_header,
            'id_user' => $request->user,
            'status' => 'Created',
        ];

        Tracking::create($dataTracking);

        foreach ($request->inner_marking as $index => $innerMarking) {
            $dataDetail = [
                'id_marking_header' => $markingHeader->id_marking_header,
                'inner_marking' => $innerMarking,
                'qty' => $request->qty[$index] ?? null,
                'id_unit' => $request->id_unit[$index] ?? null,
                'note' => $request->note[$index] ?? null,
            ];
            
            MarkingDetail::create($dataDetail);
        }

        $encryptedId = Crypt::encrypt($markingHeader->id_marking_header);
        return redirect("edit_marking/{$encryptedId}");
        // return redirect('markings');
    }

    public function edit($id) {
        $id = Crypt::decrypt($id);
        $markingHeader = MarkingHeader::where('id_marking_header', $id)->first();
        $markingDetails = MarkingDetail::where('id_marking_header', $id)->get();
        return view('management.generate_marking', [
            'markingHeader' => $markingHeader,
            'markingDetails' => $markingDetails,
            'customers' => Customer::orderBy('name')->get(),
            'origins' => Origin::orderBy('name')->get(),
            'shippers' => Shipper::orderBy('name')->get(),
            'units' => Unit::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request) {
        $markingHeader = MarkingHeader::find($request->id_marking_header);
        if ($markingHeader) {
            $markingHeader->outer_marking = $request->code_mark;
            $markingHeader->note = $request->main_note;
            $markingHeader->save();
        }

        foreach ($request->inner_marking as $index => $innerMarking) {
            if ($request->id_marking_detail[$index]) {
                $markingDetail = MarkingDetail::find($request->id_marking_detail[$index]);
                if ($markingDetail) {
                    $markingDetail->inner_marking = $innerMarking;
                    $markingDetail->qty = $request->qty[$index];
                    $markingDetail->id_unit = $request->id_unit[$index];
                    $markingDetail->note = $request->note[$index];
                    $markingDetail->save();
                }

            } else {
                if ($innerMarking) {
                    $dataDetail = [
                        'id_marking_header' => $request->id_marking_header,
                        'inner_marking' => $innerMarking,
                        'qty' => $request->qty[$index],
                        'id_unit' => $request->id_unit[$index],
                        'note' => $request->note[$index],
                    ];

                    MarkingDetail::create($dataDetail);
                }
            }
        }

        return redirect()->back();
    }

    public function delete($id) {
        $id = Crypt::decrypt($id);
        MarkingDetail::where('id_marking_header', $id)->delete();
        MarkingHeader::where('id_marking_header', $id)->delete();
        return redirect()->back();
    }

    public function print($id) {
        // Fetch marking header and details from the database
        $markingHeader = MarkingHeader::find($id);
        $markingDetails = MarkingDetail::where('id_marking_header', $id)->get();
        $units = Unit::all();
    
        // Generate barcode data combining marking header and details
        $barcodeData = 'B-' . (string) $markingHeader->id_marking_header;
        $individualBarcodes = [];

        foreach ($markingDetails as $detail) {
            $individualBarcodeData = 'B-' . (string) $detail->id_marking_detail;

            // Generate barcode in Code 128 format and add it to the array
            $individualBarcodes[] = (new DNS1D)->getBarcodePNG($individualBarcodeData, 'C128', '2', '50');
        }

        // Generate main barcode
        $mainBarcode = (new DNS1D)->getBarcodePNG($barcodeData, 'C128', '2', '50');
    
        $data = [
            'markingHeader' => $markingHeader,
            'markingDetails' => $markingDetails,
            'barcode' => $mainBarcode,
            'individualBarcodes' => $individualBarcodes,
            'units' => $units
        ];
    
        // Load the view and pass the data to it
        $pdf = PDF::loadView('report.report_marking', $data)->setPaper([0, 0, 297.637, 297.637], 'portrait') ; // 10.5 x 10.5 thermal size in points

        // Update to is printed and print count
        if ($markingHeader) {
            $markingHeader->is_printed = true;
            $markingHeader->printcount += 1;
            $markingHeader->save();
        }
    
        // Return PDF download or view
        return $pdf->stream('Data-Marking-' . $markingHeader->outer_marking . '-' . date('d M Y', strtotime($markingHeader->date)) . '.pdf');
    }

    // QrCode
    // public function print($id) {
    //     // Fetch marking header and details from the database
    //     $markingHeader = MarkingHeader::find($id);
    //     $markingDetails = MarkingDetail::where('id_marking_header', $id)->get();
    //     $units = Unit::all();

    //     // Generate barcode data combining marking header and details
    //     $barcodeData = "Header: " . $markingHeader->outer_marking . "\nDetails: ";
    //     $individualBarcodes = [];
    //     foreach ($markingDetails as $detail) {
    //         $individualBarcodeData = "Outer Marking: " . $markingHeader->outer_marking . "\nInner Marking: " . $detail->inner_marking;
    //         $individualBarcodes[] = base64_encode(QrCode::format('svg')->size(200)->generate($individualBarcodeData));
    //         $barcodeData .= $detail->inner_marking . ", ";
    //     }

    //     // Convert QR code to base64
    //     $barcode = base64_encode(QrCode::format('svg')->size(200)->generate($barcodeData));

    //     // $generator = new BarcodeGeneratorPNG();
    //     // $widthFactor = 2;
    //     // $height = 100;
    //     // $barcode = base64_encode($generator->getBarcode($barcodeData, $generator::TYPE_CODE_128, $widthFactor, $height));

    //     // Prepare data for the PDF
    //     $data = [
    //         'markingHeader' => $markingHeader,
    //         'markingDetails' => $markingDetails,
    //         'barcode' => $barcode,
    //         'individualBarcodes' => $individualBarcodes,
    //         'units' => $units
    //     ];

    //     // Load the view and pass the data to it
    //     $pdf = PDF::loadView('report.report_marking', $data)->setPaper([0, 0, 283, 425], 'portrait'); // 10x15 cm thermal size in points

    //     // Return PDF download or view
    //     return $pdf->stream('Data-Marking-' . $markingHeader->outer_marking . '-' . date('d M Y', strtotime($markingHeader->date)) . '.pdf');
    // }

    public function deleteDetail($id) {
        MarkingDetail::where('id_marking_detail', $id)->delete();
        return redirect()->back();
    }
}
