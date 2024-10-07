@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Items History</h2>

    <!-- Restaurant Dropdown -->
    <div class="dropdown mb-3">
        <select class="form-select" id="restaurantFilter" name="restaurant" aria-label="Filter by Restaurant" style="width: 300px;" onchange="fetchItems()">
            <option value="">Select a Restaurant</option>
            @foreach($restaurants as $restaurant)
                <option value="{{ $restaurant->id }}" {{ $restaurantFilter == $restaurant->id ? 'selected' : '' }}>
                    {{ $restaurant->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Search Input -->
    <div class="d-flex justify-content-end mb-2">
        <input type="text" id="myInput" class="form-control mb-3" placeholder="Search items..." style="width: 300px;" onkeyup="fetchItems()">
    </div>

    <!-- Items Table -->
    <div id="items-table">
        @include('layouts.pages.items.historysearch', ['itemshistory' => $itemshistory])
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- AJAX and JS for search, filter, and pagination -->
<script>
    function fetchItems(page = 1) {
        var query = document.getElementById('myInput').value;
        var restaurant = document.getElementById('restaurantFilter').value;

        $.ajax({
            url: "{{ route('item.history') }}?page=" + page + "&query=" + query + "&restaurant=" + restaurant,
            method: 'GET',
            success: function(data) {
                $('#items-table').html(data.table_data); // Update table data
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", error); 
            }
        });
    }

    // Handle pagination click with AJAX
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1]; // Extract the page number
        fetchItems(page);
    });
</script>
@endsection
