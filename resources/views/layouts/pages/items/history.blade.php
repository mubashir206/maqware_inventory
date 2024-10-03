@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Items History</h2>
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
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Restaurant</th>
                <th>Item Type</th>
                <th>User</th>


            </tr>
        </thead>
        <tbody>
            @foreach($itemshistory as $key => $history)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $history->name }}</td>
                <td>{{ $history->description }}</td>
                <td>{{ $history->quantity }}</td>
                <td>{{ $history->restaurant->name }}</td>
                <td>{{ $history->itemType->name }}</td>
                <td>{{ $history->user->name }}</td>

            </tr>
            @endforeach
            
        </tbody>
    </table>
</div>
@endsection