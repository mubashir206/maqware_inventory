@extends('layouts.app');
@section('content')
<div class="container mt-5">
    <div class="row">
<div class="col-6 offset-2">
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
    <form action="{{ route('restaurant.user.store') }}" method="POST">
        @csrf  
        <div class="form-group">
            <label for="restaurant_id">Select Restaurant</label>
            <select class="form-control" id="restaurant_id" name="restaurant_id" required>
                {{-- <option value="">-- Select Restaurant --</option> --}}
                @foreach($restaurants as $restaurant)
                    <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="user_id">Select User</label>
            <select class="form-control" id="user_id" name="user_id" required>
                <option value="">-- Select User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="is_manager" name="is_manager" value="1">
            <label class="form-check-label" for="is_manager">Is Manager ?</label>
        </div>
        
        <button type="submit" class="btn btn-success mt-2">Submit</button>
    </form>
</div>
</div>
</div>
@endsection