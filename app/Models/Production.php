<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Production extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'date',
        'validity',
        'image',
        'quanity',
        'price',
        'order_id',
        'product_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function finishedProductStocks()
    {
        return $this->hasMany(FinishedProductStock::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
