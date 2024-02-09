<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'description',
        'amount',];
    protected $casts = [
        'transaction_date' => 'datetime',
    ];

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
