@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="d-flex justify-content-end mb-2">
            @if(Session::has('error'))
                <div class="text-danger" role="alert">
                    {{ Session::get('error') }}
                </div>
            @endif
            @if(Session::has('success'))
                <div class="text-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
        </div>
        <h2>Update The Item :</h1>
        <div class="col-6 offset-3 p-2">
        <form action="{{ route('item.update', $items->id) }}" method="POST" class="p-2" enctype="multipart/form-data">
        @csrf 

        <div class="form-group mt-2">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter item name" required value="{{ $items->name }}">
        </div>

        <div class="form-group mt-2">
            <label for="description">Description</label>
            <input class="form-control" id="description" name="description" placeholder="Enter item description" required value="{{ $items->description }}"></input>
        </div>

        <div class="form-group mt-2">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity" required value="{{ $items->quantity }}" min="1">
        </div>

        {{-- <div class="form-group mt-2">
            <label for="image">Item Image</label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div> --}}

        <div class="form-group mt-2">
            <label for="item_type_id">Item Type</label>
            <select class="form-control" id="item_type_id" name="item_type_id" required> 
                <option value=""> Select Item type </option>
                @foreach($itemtypes as $itemtype)
                    <option value="{{ $itemtype->id }}" 
                        {{ old('item_type_id', $items->item_type_id) == $itemtype->id ? 'selected' : '' }}>
                        {{ $itemtype->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group mt-2">
            <label for="restaurant_id">Restaurant</label>
            <select class="form-control" id="restaurant_id" name="restaurant_id" required>
                <option value=""> Select Restaurant </option>
                @foreach($restaurants as $restaurant)
                    <option value="{{ $restaurant->id }}" 
                        {{ old('restaurant_id', $items->restaurant_id) == $restaurant->id ? 'selected' : '' }}>
                        {{ $restaurant->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Submit</button>
    </form>
</div>
</div>
</div>

<script>
      const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.value.length > 100) {
                this.value = this.value.substring(0, 100);
            }
        });
    });
</script>

@endsection