<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'parent_id', 'status', 'title',
        'description', 'due_date'];

    public function children(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id', 'id');
    }
}
