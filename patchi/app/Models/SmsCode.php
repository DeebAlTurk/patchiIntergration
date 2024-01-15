<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'orders_id',
        'code',
        'valid_till',
    ];
    protected $casts=[
        'valid_till' => 'datetime'
    ];
    public static function createViaOrder(Orders $order){
            return self::create(
                [
                    'orders_id'=>$order->id,
                    'code'=>\Str::random(6),
                    'valid_till'=>now()->addDay(),
                ]
            );
    }

    /**
     * Scope a query to only include active SMS Codes.
     */
    public function scopeActive(Builder $query): void
    {
        $query->whereDate('valid_till','>',now());
    }
    /**
     * Scope a query to only include Expired SMS Codes.
     */
    public function scopeExpired(Builder $query): void
    {
        $query->whereDate('valid_till','<',now());
    }

    public function orders(): BelongsTo
    {
        return $this->belongsTo(Orders::class);
    }
}
