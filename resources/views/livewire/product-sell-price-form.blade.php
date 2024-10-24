<div>

        <table class="table-bordered table-sm table">
            <thead>
            <tr>
                <th>Currency</th>
                <th>Price</th>
            </tr>

            </thead>
            <tbody>
            @foreach($currencies as $currency)
            <tr>
                <td>{{$currency->name}} ({{$currency->code}})</td>
                <td>{{\App\Models\ProductSellPrice::where('product_stock_id',$productStockId)->where('currency_id',$currency->id)->first()->sell_price??'Not Set Yet'}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div>
            <label for="currency_id">Currency:</label>
            <select wire:model="currency_id" id="currency_id" required>
                <option value="">Select Currency</option>
                @foreach ($currencies as $currency)
                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                @endforeach
            </select>
            @error('currency_id') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="sell_price">Sell Price:</label>
            <input type="number" step="0.01" wire:model="sell_price" id="sell_price" required>
            @error('sell_price') <span class="error">{{ $message }}</span> @enderror
        </div>

        <a class="btn btn-primary" wire:click="updateSellPriceData">Set Sell Price</a>

</div>
