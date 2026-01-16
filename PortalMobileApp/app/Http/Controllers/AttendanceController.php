<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\QrCode as QrCodeModel;
use App\Models\User;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * @OA\Post(
     *   path="/api/attendance/check-in",
     *   tags={"Attendance"},
     *   summary="Check in using QR code",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"user_id","qr_code"},
     *       @OA\Property(property="user_id", type="integer", example=25),
     *       @OA\Property(property="qr_code", type="string", example="uuid-string")
     *     )
     *   ),
     *   @OA\Response(response=201, description="Checked in"),
     *   @OA\Response(response=403, description="Invalid or expired QR"),
     *   @OA\Response(response=409, description="Already checked in")
     * )
     */
    public function checkIn(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'qr_code' => 'required|string',
        ]);

        // A) QR exists & active
        $qr = QrCodeModel::where('code', $data['qr_code'])
            ->where('is_active', true)
            ->first();

        if (!$qr) {
            return response()->json(['message' => 'Invalid QR'], 403);
        }

        // B) Time window valid
        $now = Carbon::now()->format('H:i');
        if ($now < $qr->valid_from || $now > $qr->valid_until) {
            return response()->json(['message' => 'QR expired'], 403);
        }

        // C) User belongs to timetable group
        $user = User::findOrFail($data['user_id']);
        $timetable = $qr->timetable; // assumes relation exists

        if ((int)$user->group_id !== (int)$timetable->group_id) {
            return response()->json(['message' => 'Wrong class'], 403);
        }

        // D) Prevent duplicate check-in (per day)
        $today = Carbon::today()->toDateString();
        $exists = Attendance::where('user_id', $user->id)
            ->where('timetable_id', $timetable->id)
            ->where('date', $today)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Already checked in'], 409);
        }

        // E) Determine status (simple late rule example)
        $status = ($now > $timetable->start_time) ? 'late' : 'present';

        // F) Create attendance
        $attendance = Attendance::create([
            'user_id' => $user->id,
            'timetable_id' => $timetable->id,
            'qr_code_id' => $qr->id,
            'date' => $today,
            'check_in_time' => Carbon::now()->format('H:i'),
            'status' => $status,
        ]);

        return response()->json($attendance, 201);
    }

    /**
     *
     */
    public function byTimetable($id)
    {
        return Attendance::with('user')
            ->where('timetable_id', $id)
            ->orderBy('check_in_time')
            ->get();
    }

    public function myAttendance($id)
    {
        return Attendance::with('timetable')
            ->where('user_id', $id)
            ->orderBy('date', 'desc')
            ->get();
    }
}
