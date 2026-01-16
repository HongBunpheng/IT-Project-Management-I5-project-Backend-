<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // GET /api/events
    public function index()
    {
        return Event::orderBy('date')->get();
    }

    // GET /api/events/group/{group_id}
    public function byGroup($group_id)
    {
        return Event::where('group_id', $group_id)
            ->orderBy('date')
            ->get();
    }

    // POST /api/events
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'group_id' => 'nullable|exists:groups,id',
            'type' => 'required|in:academic,exam,holiday,announcement',
        ]);

        return Event::create($data);
    }

    // PUT /api/events/{id}
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return $event;
    }

    // DELETE /api/events/{id}
    public function destroy($id)
    {
        Event::findOrFail($id)->delete();
        return response()->json(['message' => 'Event deleted']);
    }
}
