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
        <a href="{{ route('restaurant.user.addPage', $id) }}" class="btn btn-primary">Add Restaurant User</a>
    </div>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Restaurant</th>
                <th>User</th>
                <th>Role</th>
                <th>Action</th> 
            </tr>
        </thead>
        <tbody>
            @foreach($restUser as $key => $restUsers)
            <tr>
              <td>{{ $key +1 }}</td>
              <td>{{ $restUsers->restaurant->name }}</td>
              <td>{{ $restUsers->user->name }}</td>
              <td>
                @if ($restUsers->is_manager == 1)
                    Manager
                    @else
                    User
                @endif
              </td>
                <td>
                    <a href="{{ route('restaurant.user.delete', $restUsers->id) }}" onclick="return confirm('Are you want to delete this information')" title="Delete" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
            
            @endforeach
            
        </tbody>
    </table>
</div>
@endsection