<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinishedProductStock extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'quantity',
        'validity',
        'finished_product_stock_id',
        'production_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'finished_product_stocks';

    public function finishedProductStock()
    {
        return $this->belongsTo(FinishedProductStock::class);
    }

    public function finishedProductStocks()
    {
        return $this->hasMany(FinishedProductStock::class);
    }

    public function production()
    {
        return $this->belongsTo(Production::class);
    }
}
