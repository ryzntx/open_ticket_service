<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ticket extends Model
{
    protected $fillable = [
        'code',
        'title',
        'description',
        'category_id',
        'priority',
        'status',
        'sender_name',
        'sender_email',
        'closed_at',
    ];

    protected function casts()
    {
        return [
            'closed_at' => 'datetime',
        ];
    }

    public static function generateTicketCode($categoryId)
    {
        $date = now(); // gunakan Carbon instance
        $prefix = $date->format('Ymd').str_pad($categoryId, 3, '0', STR_PAD_LEFT);

        return DB::transaction(function () use ($prefix) {
            // Lock data untuk mencegah race condition
            $lastTicket = self::where('code', 'like', $prefix.'%')
                ->lockForUpdate()
                ->orderByDesc('code')
                ->first();

            $lastNumber = 0;
            if ($lastTicket) {
                $lastNumber = (int) substr($lastTicket->code, -5);
            }

            $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

            return $prefix.$nextNumber;
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
