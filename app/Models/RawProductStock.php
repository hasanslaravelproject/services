<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RawProductStock extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['quantity', 'expiry_date', 'ingredient_id'];

    protected $searchableFields = ['*'];

    protected $table = 'raw_product_stocks';

    protected $casts = [
        'expiry_date' => 'datetime',
    ];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
