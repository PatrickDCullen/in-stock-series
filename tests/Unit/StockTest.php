<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Models\Stock;
// use PHPUnit\Framework\TestCase;
use App\Clients\Client;
use App\Models\Retailer;
use App\Clients\StockStatus;
use App\Clients\ClientException;
use Facades\App\Clients\ClientFactory;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_throws_an_exception_if_a_client_is_not_found_when_tracking()
    {
        $this->seed(RetailerWithProductSeeder::class);

        Retailer::first()->update(['name' => 'Foo Retailer']);

        $this->expectException(ClientException::class);

        Stock::first()->track();
    }

    /** @test */
    public function it_updates_local_stock_status_after_being_tracked()
    {
        $this->seed(RetailerWithProductSeeder::class);

        $this->mockClientRequest($available = true, $price = 9900);

        $stock = tap(Stock::first())->track();

        $this->assertTrue($stock->in_stock);
        $this->assertEquals(9900, $stock->price);
    }
}

