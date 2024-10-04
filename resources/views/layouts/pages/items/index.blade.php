@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Items Information</h2>
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
        <a href="{{ route('item.history') }}" class="btn btn-primary">Item History</a>
          &nbsp;&nbsp;
        <a href="{{ route('item.addPage') }}" class="btn btn-primary">Add Item</a>
    
    </div>
    <div class="row">
      @foreach ($items as $key=> $item)
        <div class="col-md-4">
            
          <div class="card mb-4">
            <img class="card-img-top" src="{{ asset('task/' . $item->image) }}" alt="Item Image" style="width: 354px; height:300px;">
            <div class="card-body">
              <h5 class="card-title"> <strong>Name: </strong> {{ $item->name }}</h5>
              <p class="card-text">
                <strong>Description: </strong> {{ $item->description }}<br>
                <strong>Quantity: </strong> {{ $item->quantity }} <br>
                <strong>Restaurant: </strong> {{ $item->restaurant->name }} <br>

              </p>
              <a href="{{ route('item.edit', $item->id) }}" title="Edit" class="btn btn-sm btn-secondary">Edit</a>
              <a href="{{ route('item.delete', $item->id) }}" title="Delete" onclick="return confirm('Are you sure want to delete this information !')" class="btn btn-sm btn-danger">Delete</a>
            </div>
          </div>
        </div> 
        @endforeach
      </div> 
      
</div>
@endsection