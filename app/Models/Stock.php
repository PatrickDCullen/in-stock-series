<?php

namespace App\Models;

use App\Clients\Target;
use App\Clients\BestBuy;
use App\Events\NowInStock;
use Illuminate\Support\Str;
use App\Clients\ClientException;
use Illuminate\Support\Facades\Http;
use Facades\App\Clients\ClientFactory;
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

    public function track($callback = null)
    {
        $status = $this->retailer->client()
            ->checkAvailability($this);

        if (! $this->in_stock && $status->available) {
            event(new NowInStock($this));
        }

        $this->update([
            'in_stock' => $status->available,
            'price' => $status->price,
        ]);

        $callback && $callback($this);
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
