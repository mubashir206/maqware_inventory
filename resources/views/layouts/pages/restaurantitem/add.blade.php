@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="d-flex justify-content-end mb-2">
            <div>
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
    
        </div>
        <div class="col-6 offset-3">
    <h2>Add Restaurant Item</h2>
    <br>
    <form action="{{ route('restaurant.item.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="restaurant_id">Select Restaurant</label>
            <select class="form-control" id="restaurant_id" name="restaurant_id" required>
                @foreach($restaurants as $restaurant)
                    <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="item_id">Select Item</label>
            <select class="form-control" id="item_id" name="item_id" required>
                <option value="">Please select the item ...</option>
                @foreach($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
            <br>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
</div>
</div>

@endsection