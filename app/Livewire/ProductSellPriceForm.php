<?php

namespace App\Livewire;

use App\Models\Currency;
use App\Models\ProductSellPrice;
use Livewire\Component;

class ProductSellPriceForm extends Component
{
    public $productStockId;
    public $currencyId;
    public $sellPrice;

    public $currencies;
    public $productSellPrices;

    public function mount($productStockId)
    {
        $this->productStockId = $productStockId;
        $this->currencies = Currency::where('status', true)->get();
        $this->productSellPrices = ProductSellPrice::where('product_stock_id', $this->productStockId)->first();
    }

    public function updateSellPriceData()
    {
        dd(1);
        $this->validate([
            'currency_id' => 'required|exists:currencies,id',
            'sell_price' => 'required|numeric|min:0',
        ]);

        ProductSellPrice::updateOrCreate(
            [
                'product_stock_id' => $this->productStockId,
                'currency_id' => $this->currency_id,
            ],
            ['sell_price' => $this->sell_price]
        );

        $this->reset(['currencyId', 'sellPrice']);
        $this->render();
    }

    public function render()
    {
        return view('livewire.product-sell-price-form');
    }
}
