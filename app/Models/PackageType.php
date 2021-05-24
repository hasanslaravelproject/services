<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageType extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name','company_id'];

    protected $searchableFields = ['*'];

    protected $table = 'package_types';
    
    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}
