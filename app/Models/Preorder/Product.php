<?php

namespace App\Models\Preorder;

use App\Models\Category;
use App\Models\Country;
use App\Models\Exchange;
use App\Models\Goodsgroup;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'goodsgroup_id',
        'category_id',
        'country_id',
        'photo',
        'ready_or_not',
        'delivery',
        'season',
        'date_start_sale',
        'price',
        'comment',
        'rating',
        'votes_count',
        'rating_total',
        'channel',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gg()
    {
        return $this->belongsTo(Goodsgroup::class, 'goodsgroup_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class, 'product_id')->with('user')->orderBy('created_at', 'DESC');
    }

    public function reserve()
    {
        return $this->hasMany(Reserve::class, 'product_id');
    }

    public function owner()
    {
        return $this->user_id == Auth::user()->id;
    }

    public function selfprice()
    {
        $persent = SelfPrice::query()
            ->where('gg', $this->gg->alias)
            ->where('delivery', $this->delivery)
            ->where('country', $this->country->name)
            ->where('season', $this->season)
            ->value('value');

        return round($this->price + ($this->price / 100 * $persent));
    }

    public function sellprice()
    {
        $exchange = Exchange::query()->where('currency', $this->country->currency)->value('value');

        if (Auth::user()->can_see_all_prices()) {
            $prices = array();
            $query = SellPrice::query()->toBase()
                ->where('gg', $this->gg->alias)
                ->where('country', $this->country->name)
                ->where('season', $this->season)
                ->get(['channel', 'value']);

            foreach ($query as $q) {
                $prices[$q->channel] = round(($this->price + ($this->price * $q->value / 100)) * $exchange, 1);
            }
            return $prices;
        } else {
            $query = SellPrice::query()->toBase()
                ->where('gg', $this->gg->alias)
                ->where('country', $this->country->name)
                ->where('season', $this->season)
                ->where('channel', Auth::user()->role)
                ->value('value');
            return round(($this->price + ($this->price * $query / 100)) * $exchange, 1);
        }
    }

}
