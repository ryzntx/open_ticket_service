<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Ditutup</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #f9fafb;
            padding: 20px;
            color: #374151;
        }

        .card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 24px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .btn {
            display: inline-block;
            background-color: #2563eb;
            color: #ffffff;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
        }

        .btn:hover {
            background-color: #1d4ed8;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-top: 16px;
            margin-bottom: 8px;
            color: #111827;
        }

        .divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 16px 0;
        }

        .attachment-link {
            color: #2563eb;
            text-decoration: none;
        }

        .attachment-link:hover {
            text-decoration: underline;
        }

        .quote {
            border-left: 4px solid #e5e7eb;
            padding-left: 12px;
            color: #4b5563;
            font-style: italic;
            background-color: #f9fafb;
        }
    </style>
</head>

<body>
    <h3 style="text-align: center; margin-block: 2rem">{{ config('app.name') }}</h3>
    <div class="card">
        <h1 style="font-size: 22px; font-weight: bold;">Halo, {{ $ticket->sender_name }}</h1>
        <p>Tiket bantuan Anda dengan kode <strong>{{ $ticket->code }}</strong> telah <strong>DITUTUP</strong> oleh tim
            support kami.</p>

        <div class="section-title">Ringkasan Tiket:</div>
        <ul style="padding-left: 20px; margin: 0;">
            <li><strong>Kode Tiket:</strong> {{ $ticket->code }}</li>
            <li><strong>Subjek:</strong> {{ $ticket->title }}</li>
            <li><strong>Kategori:</strong> {{ $ticket->category->name }}</li>
            <li><strong>Status:</strong> {{ ucfirst($ticket->status) }}</li>
            <li><strong>Tanggal Dibuat:</strong> {{ $ticket->created_at->format('d M Y H:i') }}</li>
            <li><strong>Tanggal Ditutup:</strong> {{ now()->format('d M Y H:i') }}</li>
        </ul>

        <div class="divider"></div>

        <div class="section-title">Deskripsi Masalah:</div>
        <p style="white-space: pre-line;">{{ $ticket->description }}</p>

        @if (!empty($closingMessage))
            <div class="section-title">Pesan Penutup:</div>
            <div class="quote">
                {!! nl2br(e($closingMessage)) !!}
            </div>
        @endif

        <div style="margin-top: 24px;">
            <a href="{{ url('/ticket/check/' . $ticket->code) }}" class="btn">Lihat Detail Tiket</a>
        </div>

        <p style="margin-top: 24px; font-size: 14px; color: #6b7280;">
            Hormat kami,<br>
            <strong>Tim Layanan Bantuan</strong>
        </p>
    </div>
    <p style="text-align: center; margin-block: 20px; font-size: 13px">&copy; {{ date('Y') }}
        {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
</body>

</html>
