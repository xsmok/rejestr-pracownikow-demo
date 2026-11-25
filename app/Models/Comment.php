<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['content', 'created_by'])]
class Comment extends Model
{
    /**
     * Day the comment refers to.
     *
     * @return BelongsTo<WorkDay, $this>
     */
    public function workDay(): BelongsTo
    {
        return $this->belongsTo(WorkDay::class);
    }

    /**
     * Person who wrote the comment.
     *
     * @return BelongsTo<User, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
