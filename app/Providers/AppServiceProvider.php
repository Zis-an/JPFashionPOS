<?php

namespace App\Providers;

use App\Models\Currency;
use App\Models\Production;
use App\Models\RawMaterialPurchase;
use App\Observers\CurrencyObserver;
use App\Observers\ProductionObserver;
use App\Observers\RawMaterialPurchaseObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        RawMaterialPurchase::observe(RawMaterialPurchaseObserver::class);
        Currency::observe(CurrencyObserver::class);
        Production::observe(ProductionObserver::class);
    }
}
