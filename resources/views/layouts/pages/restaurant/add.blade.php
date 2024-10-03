@extends('layouts.app')
@section('content')
<div class="container mt-5">
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
    <h2 class="mb-4">Add New Restaurant</h2>
    <div class="row">
        <div class="col-6 content-center offset-2">
    <form action="{{ route('restaurant.store') }}" method="POST">
        @csrf  
        <div class="form-group">
            <label for="name">Restaurant Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter restaurant name" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter restaurant email" required>
        </div>
        
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Enter restaurant address" required>
        </div>
        
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter restaurant phone number" required>
        </div>
        
        <button type="submit" class="btn btn-success mt-2">Submit</button>
    </form>
</div>
</div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const alertMessages = document.querySelectorAll('.text-danger, .text-success');
        if (alertMessages.length) {
            setTimeout(function() {
                alertMessages.forEach(alert => {
                    alert.style.display = 'none';
                });
            }, 2000);
        }
    });
</script>
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