<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'status', 'service_id'];

    protected $searchableFields = ['*'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
