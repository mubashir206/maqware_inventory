@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Restaurant Information</h2>
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
        <a href="{{ route('restaurant.add') }}" class="btn btn-primary">Add Restaurant</a>
        {{-- <a href="{{ url('/restaurnat/user/add') }}" class="btn btn-primary">aurant User</a> --}}

    </div>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Actions</th> 
            </tr>
        </thead>
        <tbody>
            @foreach($restaurants as $key => $restaurant)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $restaurant->name }}</td>
                <td>{{ $restaurant->email }}</td>
                <td>{{ $restaurant->address }}</td>
                <td>{{ $restaurant->phone }}</td>
                <td>
                    <a href="{{ route('restaurant.delete', $restaurant->id) }}" onclick="return confirm('Are you want to delete this information')" title="Delete" class="btn btn-sm btn-danger">Delete</a>
                    <a href="{{ route('restaurant.user', $restaurant->id) }}" title="Users" class="btn btn-sm btn-info">Users</a>
                    <a href="{{ route('restaurant.item', $restaurant->id) }}" title="Items" class="btn btn-sm btn-secondary">Items</a>


                </td>
            </tr>
            @endforeach
            
        </tbody>
    </table>
</div>
@endsection