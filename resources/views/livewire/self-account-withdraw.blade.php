<form wire:submit.prevent="submit" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <input type="" wire:model="account_id">

        <div class="col-md-12">
            <div class="form-group">
                <label for="amount">Amount</label>
                <input wire:model="amount" id="amount" name="amount" type="number" class="form-control" placeholder="Enter amount">
                @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="details">Notes</label>
                <textarea wire:model="notes" id="details" class="form-control"></textarea>
                @error('notes') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="photo">Select photo</label>
                <input wire:model="photo" type="file" class="form-control" id="photo-withdraw">
                @error('photo') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            @if ($photo)
                <div class="form-group mb-2">
                    <img src="{{ $photo->temporaryUrl() }}" alt="Selected Image" id="selected-image-withdraw">
                </div>
            @endif
        </div>
    </div>

    @can('withdraws.create')
        <button class="btn btn-success float-right" type="submit">Create</button>
    @endcan
</form>
