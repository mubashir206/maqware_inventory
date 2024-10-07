<table class="table table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Restaurant</th>
            <th>Item Type</th>
            <th>User</th>
        </tr>
    </thead>
    <tbody id="item-table-body">
        @foreach($itemshistory as $key => $history)
        <tr>
            <td>{{ $itemshistory->firstItem() + $key }}</td>
            <td>{{ $history->name }}</td>
            <td>{{ $history->description }}</td>
            <td>{{ $history->quantity }}</td>
            <td>{{ $history->restaurant->name }}</td>
            <td>{{ $history->itemType->name }}</td>
            <td>{{ $history->user->name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div id="pagination-links">
    {{ $itemshistory->appends(['query' => request('query'), 'restaurant' => request('restaurant')])->links() }}
</div>
