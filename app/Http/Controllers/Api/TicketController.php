<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\TicketCreated;
use App\Mail\TicketNotificationToAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
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
            ], [
                'cf-turnstile-response.required' => Lang::get('Please complete the Turnstile captcha.'),
                'cf-turnstile-response.turnstile' => Lang::get('Turnstile validation failed. Please try again.'),
            ]);
        } else {
            // Skip Turnstile validation in non-production environments
            $request->merge(['cf-turnstile-response' => '']);
        }

        try {
            // Generate kode tiket unik (ex: 2025080100500001)
            $codeTicket = \App\Models\Ticket::generateTicketCode($request->category_id);

            // Create a new ticket
            $ticket = \App\Models\Ticket::create([
                'code' => $codeTicket,
                'sender_name' => $validatedData['sender_name'],
                'sender_email' => $validatedData['sender_email'],
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'category_id' => $validatedData['category_id'],
                'priority' => $validatedData['priority'],
            ]);

            // Upload attachment if provided from filepond
            if ($request->has('attachment')) {
                $fileId = $request->attachment;

                // check if attachment has "/tmp/" indicating it's a php temporary file
                if (strpos($fileId, '/tmp/') !== false) {
                    // Upload attachment if provided not from filepond
                    if ($request->hasFile('attachment')) {
                        $attachment = $request->file('attachment');

                        $fileName = $ticket->code . '-' . Str::slug($ticket->title) . '-' . time() . '.' . $attachment->getClientOriginalExtension();

                        // Store the attachment to public disk
                        // This will save the file to storage/app/public/attachments
                        $attachmentPath = $attachment->storeAs('attachments', $fileName, 'public');
                    }
                } else {
                    $filepond = app(\Sopamo\LaravelFilepond\Filepond::class);
                    $disk = config('filepond.temporary_files_disk');

                    // Convert ID ke path file asli
                    $path = $filepond->getPathFromServerId($fileId);

                    $fullpath = Storage::disk($disk)->path($path);

                    $fileName = 'attachments/' . $ticket->code . '-' . Str::slug($ticket->title) . '-' . time() . '.' . pathinfo($fullpath, PATHINFO_EXTENSION);

                    // Pindahkan file ke storage/app/public/attachments
                    $attachmentPath = Storage::disk('public')->putFileAs('', $fullpath, $fileName);
                }

                // Store the attachment in the database
                $ticket->attachments()->create([
                    'file_path' => $attachmentPath,
                ]);
            }

            // Send notification emails when in production
            if (config('app.env') === 'production') {
                // Send notification email to the user
                Mail::to($ticket->sender_email)->send(new TicketCreated($ticket));

                // Notify agents about the new ticket
                $agents = $ticket->category->agents;
                foreach ($agents as $agent) {
                    Mail::to($agent->email)->send(new TicketNotificationToAgent($ticket, $agent->name));
                }
            }
        } catch (\Exception $e) {
            // Handle any errors that occur during ticket creation
            Log::error('Ticket creation failed: ' . $e->getMessage(), [
                'request' => $request->all(),
                'exception' => $e,
            ]);
            return response()->json(['error' => 'Gagal mengirim tiket: ' . $e->getMessage()], 500);
        }

        // Return a response
        return response()->json(['message' => 'Tiket berhasil dikirim!.', 'ticket_code' => $ticket->code], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
}
