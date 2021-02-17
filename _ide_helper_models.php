<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\History
 *
 * @method static \Illuminate\Database\Eloquent\Builder|History newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|History newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|History query()
 */
	class History extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stock[] $stock
 * @property-read int|null $stock_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Retailer
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stock[] $stock
 * @property-read int|null $stock_count
 * @method static \Illuminate\Database\Eloquent\Builder|Retailer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Retailer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Retailer query()
 */
	class Retailer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Stock
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\History[] $history
 * @property-read int|null $history_count
 * @property-read \App\Models\Retailer $retailer
 * @method static \Illuminate\Database\Eloquent\Builder|Stock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock query()
 */
	class Stock extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 */
	class User extends \Eloquent {}
}

