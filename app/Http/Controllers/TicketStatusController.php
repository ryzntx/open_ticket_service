<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class TicketStatusController extends Controller
{
    public function index()
    {
        return view('guests.tickets.check');
    }

    public function check(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        // Validasi Turnstile captcha
        if (config('app.env') === 'production') {
            $request->validate([
                'cf-turnstile-response' => ['required', 'turnstile'],
            ], [
                'cf-turnstile-response.required' => Lang::get('Please complete the Turnstile captcha.'),
                'cf-turnstile-response.turnstile' => Lang::get('Turnstile validation failed. Please try again.'),
            ]);
        } else {
            // Skip Turnstile validation in non-production environments
            $request->merge(['cf-turnstile-response' => '']);
        }

        $ticket = Ticket::with(['category', 'attachments', 'replies.user'])->where('code', $request->code)->first();

        if (! $ticket) {
            return back()->withErrors(['code' => Lang::get('Ticket code not found.')])->withInput();
        }

        return view('guests.tickets.result', compact('ticket'));
    }
}
