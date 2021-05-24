<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'price',
        'validity',
        'status',
        'description',
        'company_id',
        'package_type_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'validity' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function packageType()
    {
        return $this->belongsTo(PackageType::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
