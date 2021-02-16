<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
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

        if ($this->retailer->name === 'Best Buy') {
            // Hit an API endpoint for the associated retailer
            // Fetch the up-to-date details for the item
            $results = Http::get('http://foo.test')->json();

            // And then refresh the current stock record.
            $this->update([
                'in_stock' => $results['available'],
                'price' => $results['price'],
            ]);
        }


    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }
}
