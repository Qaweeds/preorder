<?php

namespace App\Models\Preorder;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTime extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['value'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public static function dataForSetup()
    {
        $country = self::query()->toBase()->join('countries', 'country_id', '=', 'id')
            ->distinct()->get(['country_id', 'name'])->toArray();
        $delivery = self::query()->distinct()->pluck('delivery')->toArray();

        return compact('country', 'delivery');
    }
}
