@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Usage Histories</h2>

    <div class="dropdown mb-3">
        <select class="form-select" id="restaurantFilter" name="restaurant" aria-label="Filter by Restaurant" style="width: 300px;" onchange="fetchUsageHistories()">
            <option value="">Select a Restaurant</option>
            @foreach($restaurants as $restaurant)
                <option value="{{ $restaurant->id }}" {{ request('restaurant') == $restaurant->id ? 'selected' : '' }}>
                    {{ $restaurant->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="d-flex justify-content-end mb-2">
        <input type="text" id="myInput" class="form-control mb-3" placeholder="Search usage histories..." style="width: 300px;" onkeyup="fetchUsageHistories()">
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

    <!-- Usage History Table -->
    <div id="usage-history-table">
        @include('layouts.pages.usageHistory.table', ['usageHistorys' => $usageHistorys])
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- AJAX for search and pagination -->
<script>
    function fetchUsageHistories(page = 1) {
        var query = document.getElementById('myInput').value;
        var restaurant = document.getElementById('restaurantFilter').value;

        $.ajax({
            url: "{{ route('item.reduce') }}?page=" + page + "&query=" + query + "&restaurant=" + restaurant,
            method: 'GET',
            success: function(data) {
                $('#usage-history-table').html(data.table_data);  // Update table data
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
        fetchUsageHistories(page);
    });
</script>

@endsection
