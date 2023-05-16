<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comments extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id', 'post_id', 'comment_content'
    ];

    /**
     * Get the comentator  that owns the Comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comentator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
