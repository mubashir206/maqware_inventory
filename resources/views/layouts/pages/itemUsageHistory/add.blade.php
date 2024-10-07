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
        <h2>Add The Item Usage  History:</h1>
        <div class="col-6 offset-3 p-2">
        <form action="{{ route('itemUsage.store') }}" method="POST" class="p-2">
        @csrf 

        <div class="form-group mt-2">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity" required min="1">
        </div>

        <div class="form-group mt-2">
            <label for="item_id">Item</label>
            <select class="form-control" id="item_id" name="item_id" required> 
                <option value=""> Select Item </option>
                @foreach($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
                
            </select>
        </div>

        <div class="form-group mt-2">
            <label for="restaurant_id">Restaurant</label>
            <select class="form-control" id="restaurant_id" name="restaurant_id" required>
                <option value=""> Select Restaurant </option>
                @foreach($restaurants as $restaurant)
                    <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                @endforeach
                
            </select>
        </div>

        <div class="form-group mt-2">
            <label for="user_id">Buyer User</label>
            <select class="form-control" id="buyer_user_id" name="buyer_user_id">
                <option value="">Select User</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
             
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Save</button>
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