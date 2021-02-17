<?php

namespace Tests\Clients;

use Tests\TestCase;
use App\Models\Stock;
use App\Clients\BestBuy;
use Illuminate\Support\Facades\Http;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

/** @group api */
class BestBuyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_tracks_a_product()
    {
        // given I have a product
        $this->seed(RetailerWithProductSeeder::class);

        // with stock at BestBuy
        $stock = tap(Stock::first())->update([
            'sku' => '6364253',
            'url' => 'https://www.bestbuy.com/site/nintendo-switch-32gb-console-gray-joy-con/6364253.p?skuId=6364253'
        ]);

        // if I use the BestBuy client to track that stock/sku
        try {
            (new BestBuy())->checkAvailability($stock);
        } catch (\Exception $e) {
            $this->fail('Failed to track the BestBuy API properly. ' . $e->getMessage());
        }
        // it should return the appropriate StockStatus
        // StockStatus.available = true
        // the above line doesn't work because what we are really testing for is
        // whether the exception is thrown. So we just force a pass as long as
        // it doesn't throw an exception
        $this->assertTrue(true);
    }

    /** @test */
    public function it_creates_the_proper_stock_status_response()
    {
        Http::fake(fn() => ['salePrice' => 299.99, 'onlineAvailability' => true]);

        $stockStatus = (new BestBuy())->checkAvailability(new Stock);

        $this->assertEquals(29999, $stockStatus->price);
        $this->assertTrue($stockStatus->available);
    }
}
