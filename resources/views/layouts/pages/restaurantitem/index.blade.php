@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Restaurant Items</h2>
    <div class="d-flex justify-content-end mb-2">
        <input type="text" id="myInput" class="form-control mb-3" placeholder="Search items..." style="width: 300px;" onkeyup="fetchItems()">
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

    <!-- Restaurant Items Table -->
    <div id="restaurant-item-table">
        @include('layouts.pages.restaurantitem.table', ['items' => $items])
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- AJAX for search and pagination -->
<script>
    function fetchItems(page = 1) {
        var query = document.getElementById('myInput').value;

        $.ajax({
            url: "{{ route('restaurant.item', $id) }}?page=" + page + "&query=" + query,
            method: 'GET',
            success: function(data) {
                $('#restaurant-item-table').html(data.table_data);  // Update table data
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
        fetchItems(page);
    });
</script>
@endsection
