<?php

namespace App\Http\Controllers;

use App\Mail\TicketCreated;
use App\Mail\TicketNotificationToAgent;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Sopamo\LaravelFilepond\Filepond;

class TicketController extends Controller
{
    public function create()
    {
        $categories = Category::all();

        return view('guests.tickets.create', compact('categories'));
    }

    public function store(Request $request, Filepond $filepond)
    {
        // dd($request->all());
        $request->validate([
            'sender_name' => 'required|string|max:255',
            'sender_email' => 'required|email',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'priority' => 'required|in:low,medium,high',
            // 'attachment' => 'nullable|file|max:2048',
        ]);

        // Validasi Turnstile captcha
        if (config('app.env') === 'production') {
            $request->validate([
                'cf-turnstile-response' => ['required', 'turnstile'],
            ]);
        } else {
            // Skip Turnstile validation in non-production environments
            $request->merge(['cf-turnstile-response' => '']);
        }

        // Generate kode tiket unik (ex: 2025080100500001)
        $codeTicket = Ticket::generateTicketCode($request->category_id);

        $ticket = Ticket::create([
            'code' => $codeTicket,
            'sender_name' => $request->sender_name,
            'sender_email' => $request->sender_email,
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'priority' => $request->priority,
        ]);

        // Upload file jika ada
        if ($request->has('attachment')) {
            $fileId = $request->attachment;
            $disk = config('filepond.temporary_files_disk');

            // Convert ID ke path file asli
            $path = $filepond->getPathFromServerId($fileId);

            $fullpath = Storage::disk($disk)->path($path);

            $fileName = 'attachments/'.$ticket->code.'-'.Str::slug($ticket->title).'-'.time().'.'.pathinfo($fullpath, PATHINFO_EXTENSION);

            // Pindahkan file ke storage/app/public/attachments
            $res = Storage::disk('public')->putFileAs('', $fullpath, $fileName);

            // $path = $request->file('attachment')->storePublicly('attachments');

            $ticket->attachments()->create([
                'file_path' => $fileName,
            ]);
        }

        // Kirim email ke pengguna
        Mail::to($ticket->sender_email)->send(new TicketCreated($ticket));

        // Kirim email ke agent
        /* $agents = User::where('role', 'agent')->get();

        foreach ($agents as $agent) {
            Mail::to($agent->email)->send(new TicketNotificationToAgent($ticket));
        } */

        // baru
        $agents = $ticket->category->agents; // Ambil agent yang handle kategori ini

        foreach ($agents as $agent) {
            Mail::to($agent->email)->send(new TicketNotificationToAgent($ticket, $agent->name));
        }

        return redirect()->route('ticket.create')->with('success', Lang::get('Ticket created successfully! Your Ticket Code: ').$ticket->code);
    }

    public function check($code)
    {
        $ticket = Ticket::with(['category', 'attachments', 'replies.user'])->where('code', $code)->first();

        if (! $ticket) {
            return back()->withErrors(['code' => Lang::get('Ticket code not found.')])->withInput();
        }

        return view('guests.tickets.result', compact('ticket'));
    }
}
