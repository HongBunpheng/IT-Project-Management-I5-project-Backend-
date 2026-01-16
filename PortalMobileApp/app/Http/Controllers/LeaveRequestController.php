<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeaveRequestController extends Controller
{
    /**
     * POST /api/leave-requests
     * Create leave request (multipart/form-data)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'reason' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'documents' => 'nullable|array',
            'documents.*' => 'file|max:5120', // 5MB per file
        ]);

        $filePaths = [];

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('leave-documents', 'public');
                $filePaths[] = $path;
            }
        }

        $leave = LeaveRequest::create([
            'user_id' => $data['user_id'],
            'reason' => $data['reason'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'documents' => $filePaths,
        ]);

        return response()->json($leave, 201);
    }

    /**
     * GET /api/leave-requests/user/{id}
     * Student views own leave requests
     */
    public function byStudent($id)
    {
        return LeaveRequest::where('user_id', $id)
            ->with('approver')
            ->get();
    }

    /**
     * GET /api/leave-requests/group/{group_id}
     * Teacher views leave requests in group
     */
    public function byGroup($group_id)
    {
        return LeaveRequest::whereHas('user', function ($q) use ($group_id) {
            $q->where('group_id', $group_id);
        })
            ->with('user')
            ->get();
    }

    /**
     * PUT /api/leave-requests/{id}/approve
     */
    public function approve($id, Request $request)
    {
        $leave = LeaveRequest::findOrFail($id);

        $leave->update([
            'status' => 'approved',
            'approved_by' => $request->user()->id ?? null, // auth later
        ]);

        return $leave;
    }

    /**
     * PUT /api/leave-requests/{id}/reject
     */
    public function reject($id, Request $request)
    {
        $leave = LeaveRequest::findOrFail($id);

        $leave->update([
            'status' => 'rejected',
            'approved_by' => $request->user()->id ?? null,
        ]);

        return $leave;
    }

    /**
     * GET /api/leave-requests/{id}
     * View single leave request
     */
    public function show($id)
    {
        return LeaveRequest::with(['user', 'approver'])->findOrFail($id);
    }
}
