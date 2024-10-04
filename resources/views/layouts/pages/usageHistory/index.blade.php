@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4">Usage Histories </h2>
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
    <div class="row">
        <div class="col-9 offset-2">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Items</th>
                        <th>User</th>
                        <th>Restaurant</th> 
                        <th>Quantity Used</th> 
                        <th>Stock Before</th> 
                        <th>Stock After</th> 

                    </tr>
                </thead>
                <tbody>
                  @foreach ($usageHistorys as $key => $usageHistory)
                 
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $usageHistory->item->name }}</td>
                        <td>{{ $usageHistory->user->name }}</td>
                        <td>{{ $usageHistory->restaurant->name }}</td>
                        <td>{{ $usageHistory->quantity_used }}</td>
                        <td>{{ $usageHistory->stock_before }}</td>
                        <td>{{ $usageHistory->stock_after }}</td>
                    </tr>   
                        
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection