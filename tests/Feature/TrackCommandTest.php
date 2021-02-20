<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Clients\StockStatus;
use Facades\App\Clients\ClientFactory;
use App\Notifications\ImportantStockUpdate;
use Illuminate\Support\Facades\Notification;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();

        $this->seed(RetailerWithProductSeeder::class);
    }

    /** @test */
    function it_tracks_product_stock()
    {
        $this->assertFalse(Product::first()->inStock());

        $this->mockClientRequest();

        $this->artisan('track')
            ->expectsOutput('All done!');

        $this->assertTrue(Product::first()->inStock());
    }
}
