<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'number',
        'delivery_date',
        'quantity',
        'status',
        'product_id',
        'user_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'delivery_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
