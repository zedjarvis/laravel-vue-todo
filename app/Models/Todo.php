<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
      'text',
      'done',
    ];

    protected $attributes = [
      'done' => false,
    ];

    public function user(): BelongsTo
    {
      return $this->belongsTo(User::class);
    }
}
