@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Items Information</h2>
      <!-- Restaurant Dropdown Filter -->
      <select id="restaurantFilter" class="form-select mb-3" style="width: 300px;" onchange="fetchItems()">
        <option value="">Select Restaurant</option>
        @foreach($restaurants as $restaurant)
            <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
        @endforeach
    </select>
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

        <!-- Search Bar -->
        <input type="text" id="myInput" class="form-control mb-3" placeholder="Search items..." style="width: 300px;" onkeyup="fetchItems()"> &nbsp;&nbsp;

        <a href="{{ route('item.history') }}" class="btn btn-primary ml-2">Item History</a>
        &nbsp;&nbsp;
        <a href="{{ route('item.addPage') }}" class="btn btn-primary ml-2">Add Item</a>
    </div>

    <!-- Items Cards -->
    <div class="row" id="items-cards">
        @include('layouts.pages.items.items-card', ['items' => $items])
    </div>

    <!-- Pagination -->
    <div id="pagination-links">
        {{ $items->links() }}
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- AJAX for Search, Filter, and Pagination -->
<script>
    function fetchItems(page = 1) {
        var query = document.getElementById('myInput').value;
        var restaurantFilter = document.getElementById('restaurantFilter').value;

        $.ajax({
            url: "{{ route('item') }}?page=" + page + "&query=" + query + "&restaurant_id=" + restaurantFilter,
            method: 'GET',
            success: function(data) {
                $('#items-cards').html(data.card_data);  // Update items cards
                $('#pagination-links').html(data.pagination);  // Update pagination
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
        fetchItems(page);
    });
</script>
@endsection
