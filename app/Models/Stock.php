<?php

namespace App\Models;

use App\UseCases\TrackStock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock';

    // following variable is for type casting.
    // In this example, mysql doesn't have a real boolean type
    // so it returns 0 or 1 when you really want true or false
    protected $casts = [
        'in_stock' => 'boolean',
    ];

    public function track()
    {
        TrackStock::dispatch($this);
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
