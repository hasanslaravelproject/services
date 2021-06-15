<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['date'];

    protected $searchableFields = ['*'];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
