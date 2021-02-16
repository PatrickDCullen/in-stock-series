<?php

namespace App\Models;

use App\Clients\Target;
use App\Clients\BestBuy;
use Illuminate\Support\Str;
use Facades\App\Clients\ClientFactory;
use App\Clients\ClientException;
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
        $status = $this->retailer->client()
            ->checkAvailability($this);

        $this->update([
            'in_stock' => $status->available,
            'price' => $status->price,
        ]);

    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }
}
