<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\NowInStock;
use App\Notifications\ImportantStockUpdate;

class SendStockUpdateNotification
{
    /**
     * Handle the event.
     *
     * @param  NowInStock  $event
     * @return void
     */
    public function handle(NowInStock $event)
    {
        User::first()->notify(New ImportantStockUpdate($event->stock));
    }
}
