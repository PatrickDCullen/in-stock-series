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

        $this->recordHistory();
    }

    protected function recordHistory(): void
    {
        $this->history()->create([
            'price' => $this->price,
            'in_stock' => $this->in_stock,
            'product_id' => $this->product_id,
        ]);
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function history()
    {
        return $this->hasMany(History::class);
    }
}
