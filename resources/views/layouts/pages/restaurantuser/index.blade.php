@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Restaurant Information</h2>

    <!-- Dropdown for filtering by restaurant -->
    <div class="dropdown mb-3">
        <select class="form-select" id="restaurantFilter" name="restaurant" aria-label="Filter by Restaurant" style="width: 300px;" onchange="fetchRestaurantUsers()">
            <option value="">All Restaurants</option>
            @foreach($restaurants as $restaurant)
                <option value="{{ $restaurant->id }}" {{ $selectedRestaurant == $restaurant->id ? 'selected' : '' }}>
                    {{ $restaurant->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Search input -->
    <div class="d-flex justify-content-end mb-2">
        <input type="text" id="myInput" class="form-control mb-3" placeholder="Search users..." style="width: 300px;" onkeyup="fetchRestaurantUsers()">
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
       &nbsp; &nbsp; <a href="{{ route('restaurant.user.addPage', $id) }}" class="btn btn-primary">Add Restaurant User</a>
    </div>

    <!-- Restaurant User Table -->
    <div id="restaurant-user-table">
        @include('layouts.pages.restaurantuser.table', ['restUser' => $restUser])
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- AJAX for search, filter, and pagination -->
<script>
    function fetchRestaurantUsers(page = 1) {
        var query = document.getElementById('myInput').value;
        var restaurant = document.getElementById('restaurantFilter').value;

        $.ajax({
            url: "{{ route('restaurant.user', $id) }}?page=" + page + "&query=" + query + "&restaurant=" + restaurant,
            method: 'GET',
            success: function(data) {
                $('#restaurant-user-table').html(data.table_data);  // Update table data
                $('.pagination').html(data.pagination);  // Update pagination links
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", error);
            }
        });
    }

    // Handle pagination click with AJAX
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];  // Extract the page number
        fetchRestaurantUsers(page);
    });
</script>
@endsection
