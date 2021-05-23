<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'status'];

    protected $searchableFields = ['*'];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
