<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of published events.
     */
    public function index()
    {
        return Event::where('status', 'published')->get();
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:music,sports,theater,conference',
            'date' => 'required|date|after:today',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'image_url' => 'nullable|url',
            'ticket_price' => 'required|numeric|min:0',
            'available_tickets' => 'required|integer|min:1',
            'seating_plan' => 'nullable|array',
        ]);

        $event = Event::create([
            'user_id' => auth()->id(),
            ...$validated,
            'status' => 'draft',
        ]);

        return response()->json($event, 201);
    }

    /**
     * Display the specified event.
     */
    public function show(string $id)
    {
        return Event::findOrFail($id);
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        // Check if user is the owner
        if ($event->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'category' => 'sometimes|in:music,sports,theater,conference',
            'date' => 'sometimes|date|after:today',
            'time' => 'sometimes',
            'location' => 'sometimes|string|max:255',
            'address' => 'nullable|string|max:255',
            'image_url' => 'nullable|url',
            'ticket_price' => 'sometimes|numeric|min:0',
            'available_tickets' => 'sometimes|integer|min:1',
            'seating_plan' => 'nullable|array',
            'status' => 'sometimes|in:draft,published,cancelled',
        ]);

        $event->update($validated);

        return response()->json($event);
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);

        // Check if user is the owner
        if ($event->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $event->delete();

        return response()->json(null, 204);
    }

    /**
     * Get events created by the authenticated user.
     */
    public function myEvents()
    {
        return Event::where('user_id', auth()->id())->get();
    }
}
