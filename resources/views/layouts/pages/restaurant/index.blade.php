@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Restaurant Information</h2>

   <!-- Restaurant Dropdown Filter -->
        <select id="restaurantFilter" class="form-select mb-3" style="width: 300px;" onchange="fetchRestaurants()">
            <option value="">Select Restaurant</option>
            @foreach($allRestaurants as $restaurant)
                <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
            @endforeach
        </select>

    <div class="d-flex justify-content-end mb-2">
        <input type="text" id="myInput" class="form-control mb-3" placeholder="Search restaurants..." style="width: 300px;" onkeyup="fetchRestaurants()"> &nbsp;&nbsp;


        <a href="{{ route('restaurant.add') }}" class="btn btn-primary ml-2">Add Restaurant</a>
    </div>

    <!-- Restaurants Table -->
    <div id="restaurants-table">
        @include('layouts.pages.restaurant.restaurant-table', ['restaurants' => $restaurants])
    </div>

    <div id="pagination-links">
        {{ $restaurants->links() }}
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- AJAX for Search, Filter, and Pagination -->
<script>
    function fetchRestaurants(page = 1) {
        var query = document.getElementById('myInput').value;
        var restaurantFilter = document.getElementById('restaurantFilter').value;  // Get selected restaurant filter

        $.ajax({
            url: "{{ route('restaurant.search') }}?page=" + page + "&query=" + query + "&restaurant_id=" + restaurantFilter,
            method: 'GET',
            success: function(data) {
                $('#restaurants-table').html(data.table_data);
                $('#pagination-links').html(data.pagination);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", error);
            }
        });
    }

    // Handle pagination click with AJAX
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        fetchRestaurants(page);
    });
</script>
@endsection
