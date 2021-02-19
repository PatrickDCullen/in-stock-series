<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Stock;
use App\Models\History;
use App\Models\Product;
use App\Clients\StockStatus;
use Facades\App\Clients\ClientFactory;
use Illuminate\Support\Facades\Http;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductHistoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_records_history_each_time_stock_is_tracked()
    {
        // given I have stock at a retailer
        $this->seed(RetailerWithProductSeeder::class);

        $this->mockClientRequest($available = true, $price = 9900);

        $product = tap(Product::first(), function($product) {
            $this->assertCount(0, $product->history);
            $product->track();
            $this->assertCount(1, $product->refresh()->history);
        });

        $history = $product->history->first();
        $this->assertEquals($price, $history->price);
        $this->assertEquals($available, $history->in_stock);
        $this->assertEquals($product->id, $history->product_id);
        $this->assertEquals($product->stock[0]->id, $history->stock_id);
    }
}
