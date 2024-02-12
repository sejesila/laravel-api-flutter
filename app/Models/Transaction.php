<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'transaction_date',
        'description',
        'amount',
        'user_id'];
    protected $casts = [
        'transaction_date' => 'datetime',
    ];

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function setAmountAttribute($amount)
    {
        $this->attributes['amount'] = (int)$amount*100;

    }
    public function setTransactionDateAttribute($transactionDate)
    {
        $this->attributes['transaction_date'] = Carbon::createFromFormat('m/d/Y', $transactionDate)->format('Y-m-d');
    }
}
