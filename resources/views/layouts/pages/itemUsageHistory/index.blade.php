@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Item Usage History</h2>
    <div class="d-flex justify-content-start mb-2">
        <!-- Restaurant Filter Dropdown -->
        <select class="form-select" id="restaurantFilter" name="restaurant" style="width: 300px;" onchange="fetchItemUsageHistory()">
            <option value="">Select a Restaurant</option>
            @foreach($restaurants as $restaurant)
                <option value="{{ $restaurant->id }}" {{ $restaurantFilter == $restaurant->id ? 'selected' : '' }}>
                    {{ $restaurant->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="d-flex justify-content-end mb-2">
       
        &nbsp;&nbsp;
        <input type="text" id="myInput" class="form-control" placeholder="Search ..." style="width: 300px;" onkeyup="fetchItemUsageHistory()">
        &nbsp;&nbsp; 
        <a href="{{ route('itemUsage.addPage') }}" class="btn btn-primary">Add Usage</a>
    </div>

    <div id="item-usage-history-table">
        @include('layouts.pages.itemUsageHistory.table', ['itemUsageHistorys' => $itemUsageHistorys])
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- AJAX for search and pagination -->
<script>
    function fetchItemUsageHistory(page = 1) {
        var query = document.getElementById('myInput').value;
        var restaurant = document.getElementById('restaurantFilter').value;

        $.ajax({
            url: "{{ route('itemUsage') }}?page=" + page + "&query=" + query + "&restaurant=" + restaurant,
            method: 'GET',
            success: function(data) {
                $('#item-usage-history-table').html(data.table_data); 
                $('#pagination-links').html(data.pagination);  
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", error);
            }
        });
    }

    
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1]; 
        fetchItemUsageHistory(page);
    });
</script>
@endsection
