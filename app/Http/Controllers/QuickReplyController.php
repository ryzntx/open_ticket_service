<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuickReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quick_replies = \App\Models\QuickReply::paginate(10);
        return view('admins.quick-replies.index', compact('quick_replies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        \App\Models\QuickReply::create($request->only('title', 'message'));

        return redirect()->route('admin.quick-replies.index')->with('success', __('Quick reply created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // return to json
        $quickReply = \App\Models\QuickReply::findOrFail($id);

        // return as json
        $quickReply = [
            'title' => $quickReply->title,
            'message' => $quickReply->message,
        ];

        return response()->json($quickReply);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $quickReply = \App\Models\QuickReply::findOrFail($id);
        $quickReply->update($request->only('title', 'message'));

        return redirect()->route('admin.quick-replies.index')->with('success', __('Quick reply updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quickReply = \App\Models\QuickReply::findOrFail($id);
        $quickReply->delete();

        return redirect()->route('admin.quick-replies.index')->with('success', __('Quick reply deleted successfully.'));
    }
}
