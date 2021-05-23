<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ingredient extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'image', 'measure_unit_id'];

    protected $searchableFields = ['*'];

    public function measureUnit()
    {
        return $this->belongsTo(MeasureUnit::class);
    }

    public function rawProductStocks()
    {
        return $this->hasMany(RawProductStock::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
