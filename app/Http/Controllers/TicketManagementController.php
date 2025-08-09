<?php

namespace App\Http\Controllers;

use App\Mail\TicketReplied;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TicketManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = \App\Models\Category::all();

        $user = request()->user();
        $query = Ticket::with('category');

        if ($user->role !== 'admin') {
            $query->whereIn('category_id', $user->categories->pluck('id')->toArray());
        }

        // search by code or title
        if (request()->has('search') && request()->input('search') !== '') {
            $search = request()->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', '%'.$search.'%')
                    ->orWhere('title', 'like', '%'.$search.'%');
            });
        }

        // Apply filters if any
        if (request()->has('status') && request()->input('status') !== 'all' && request()->input('status') !== '') {
            $query->where('status', request()->input('status'));
        }
        if (request()->has('category_id') && request()->input('category_id') !== 'all' && request()->input('category_id') !== '') {
            $query->where('category_id', request()->input('category_id'));
        }
        if (request()->has('start_date') && request()->has('end_date') && request()->input('start_date') && request()->input('end_date')) {
            $query->whereBetween('created_at', [request()->input('start_date'), request()->input('end_date')]);
        }

        $tickets = $query->latest()->paginate(request()->input('per_page', 5));
        $tickets->appends(request()->except('page')); // Preserve query parameters for pagination

        return view('admins.tickets.index', compact('tickets', 'categories'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = Ticket::with(['category', 'attachments', 'replies.user'])->findOrFail($id);

        return view('admins.tickets.show', compact('ticket'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function reply(Request $request, string $id)
    {
        $validate = $request->validate([
            'message' => 'required|string',
        ]);

        $ticket = Ticket::findOrFail($id);

        try {
            $reply = TicketReply::create([
                'ticket_id' => $id,
                'user_id' => auth()->user()->id,
                'message' => $request->message,
            ]);

            $ticket->update(['status' => 'in_progress']); // Update ticket status to in_progress

            // Notify the user via email
            Mail::to($ticket->sender_email)->send(new TicketReplied($ticket, $reply->message));
        } catch (\Exception $e) {
            Log::error('Message creation failed: '.$e->getMessage());

            return redirect()->back()->with('error', Lang::get('Failed to send reply. Please try again.'));
        }

        return redirect()->route('admin.tickets.show', $id)->with('success', Lang::get('Reply sent successfully.'));
    }

    public function changeStatus(Request $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);

        $status = $ticket->status == 'open' ? 'in_progress' : ($ticket->status == 'in_progress' ? 'closed' : 'open');

        try {
            $ticket->update(['status' => $status, 'closed_at' => now()]);
        } catch (\Exception $e) {
            Log::error('Status update failed: '.$e->getMessage());

            return redirect()->back()->with('error', Lang::get('Failed to update ticket status. Please try again.'));
        }

        return redirect()->back()->with('success', Lang::get('Ticket status updated successfully to ').$status);
    }
}
