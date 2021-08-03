<?php

namespace App\Jobs;

use App\Models\Country;
use App\Models\Exchange;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExchangeToDbJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $currencies = Exchange::query()->pluck('currency');

        foreach ($currencies as $code) {
            if ($code == 'UAH') continue;
            Exchange::query()->where('currency', $code)->update(['value' => (float)$this->getCurrency($code)]);
        }

    }

    public static function getCurrency($code)
    {
        $cur = simplexml_load_file('https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?valcode=' . $code);
        return $cur->currency->rate;
    }

}

