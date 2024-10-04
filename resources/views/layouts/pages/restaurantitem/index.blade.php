@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4">Restaurant Items</h2>
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
        {{-- <a href="{{ route('restaurant.item.addPage', $id) }}" class="btn btn-primary">Add Restaurant item</a> --}}

    </div>
    <div class="row">
        <div class="col-6 offset-2">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Items</th>
                        <th>Quantity</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $key => $restitem)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $restitem->name }}</td>
                        <td>{{ $restitem->quantity }}</td>
                        {{-- <td>
                            <a href="{{ route('restaurant.item.delete', $restitem->id ) }}" onclick="return confirm('Are you want to delete this information')" title="Delete" class="btn btn-sm btn-danger">Delete</a>
                        </td> --}}
                    </tr>
                    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection