<?php

namespace App\Http\Controllers;

use App\Models\StickyNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StickyNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $menuId = $request->query('menu_id');
        $companyId = $request->query('company_id');

        $notes = StickyNote::where('user_id', Auth::id())
            ->where('menu_id', $menuId)
            ->where(function ($query) use ($companyId) {
                $query->where('company_id', $companyId)
                      ->orWhereNull('company_id');
            })
            ->get();

        return response()->json([
            'success' => true,
            'notes' => $notes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:sys_menus,id',
            'company_id' => 'nullable|exists:sys_companies,id',
            'content' => 'nullable|string',
            'color' => 'required|string|in:yellow,blue,green,pink,purple,orange',
            'position_x' => 'required|integer',
            'position_y' => 'required|integer',
            'width' => 'required|integer',
            'height' => 'required|integer',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['z_index'] = StickyNote::where('user_id', Auth::id())->max('z_index') + 1;

        $note = StickyNote::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Sticky note created successfully',
            'note' => $note
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $note = StickyNote::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'content' => 'nullable|string',
            'color' => 'sometimes|string|in:yellow,blue,green,pink,purple,orange',
            'position_x' => 'sometimes|integer',
            'position_y' => 'sometimes|integer',
            'width' => 'sometimes|integer',
            'height' => 'sometimes|integer',
            'z_index' => 'sometimes|integer',
            'is_minimized' => 'sometimes|boolean',
            'is_pinned' => 'sometimes|boolean',
        ]);

        $note->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Sticky note updated successfully',
            'note' => $note
        ]);
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy($id)
    {
        $note = StickyNote::where('user_id', Auth::id())->findOrFail($id);
        $note->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sticky note moved to trash'
        ]);
    }

    /**
     * Restore a soft deleted note.
     */
    public function restore($id)
    {
        $note = StickyNote::onlyTrashed()
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $note->restore();

        return response()->json([
            'success' => true,
            'message' => 'Sticky note restored',
            'note' => $note
        ]);
    }

    /**
     * Bulk update positions and z-indexes.
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'notes' => 'required|array',
            'notes.*.id' => 'required|exists:sys_sticky_notes,id',
            'notes.*.position_x' => 'sometimes|integer',
            'notes.*.position_y' => 'sometimes|integer',
            'notes.*.z_index' => 'sometimes|integer',
        ]);

        foreach ($validated['notes'] as $noteData) {
            $note = StickyNote::where('user_id', Auth::id())->find($noteData['id']);
            if ($note) {
                $note->update(array_intersect_key($noteData, array_flip(['position_x', 'position_y', 'z_index'])));
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Notes updated successfully'
        ]);
    }
}
