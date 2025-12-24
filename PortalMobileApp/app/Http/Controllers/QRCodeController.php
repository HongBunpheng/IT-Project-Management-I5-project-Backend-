<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;
use App\Models\QrCode as QrCodeModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    /**
     * @OA\Post(
     *   path="/api/qrcode/generate",
     *   tags={"QR"},
     *   summary="Generate QR code for a timetable",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"timetable_id","valid_from","valid_until"},
     *       @OA\Property(property="timetable_id", type="integer", example=1),
     *       @OA\Property(property="valid_from", type="string", example="08:00"),
     *       @OA\Property(property="valid_until", type="string", example="09:30")
     *     )
     *   ),
     *   @OA\Response(response=201, description="QR generated")
     * )
     */
    public function generate(Request $request)
    {
        $data = $request->validate([
            'timetable_id' => 'required|exists:timetables,id',
            'valid_from'   => 'required',
            'valid_until'  => 'required',
        ]);

        $qr = QrCodeModel::create([
            'code' => Str::uuid(),
            'timetable_id' => $data['timetable_id'],
            'valid_from' => $data['valid_from'],
            'valid_until' => $data['valid_until'],
        ]);

        return response()->json($qr, 201);
    }

    /**
     * @OA\Get(
     *   path="/api/qrcode/{id}",
     *   tags={"QR"},
     *   summary="Get QR code detail",
     *   @OA\Parameter(
     *     name="id", in="path", required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=200, description="QR detail")
     * )
     */
    public function show($id)
    {
        return QrCodeModel::with('timetable')->findOrFail($id);
    }

    public function downloadQrImage($id)
    {
        $qr = QrCodeModel::findOrFail($id);

        $svg = QrCodeGenerator::format('svg')
            ->size(300)
            ->generate($qr->code);

        return response($svg)
            ->header('Content-Type', 'image/svg+xml')
            ->header(
                'Content-Disposition',
                'attachment; filename="qrcode_' . $qr->id . '.svg"'
            );
    }
}
