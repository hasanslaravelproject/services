<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'price',
        'validity',
        'package_id',
        'category_id',
        'barcode',
    ];

    protected $searchableFields = ['*'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productions()
    {
        return $this->hasMany(Production::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
