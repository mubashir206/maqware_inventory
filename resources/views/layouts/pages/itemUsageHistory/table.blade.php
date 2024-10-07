<table class="table table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Buyer</th>
            <th>Restaurants</th>
            <th>Items</th>
            <th>Seller</th>
            <th>Quantity</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($itemUsageHistorys as $key => $itemUsageHistory)
        <tr>
            <td>{{ $itemUsageHistorys->firstItem() + $key }}</td>
            <td>{{ $itemUsageHistory->buyerUser->name }}</td>
            <td>{{ $itemUsageHistory->restaurant->name }}</td>
            <td>{{ $itemUsageHistory->item->name }}</td>
            <td>{{ $itemUsageHistory->sellerUser->name }}</td>
            <td>{{ $itemUsageHistory->quantity }}</td>
            <td>{{ $itemUsageHistory->created_at->format('Y-m-d') }}</td>
            <td>
                <a href="{{ route('itemUsage.edit', $itemUsageHistory->id) }}" title="Edit" class="btn btn-secondary">Edit</a>
                <a href="{{ route('itemUsage.delete', $itemUsageHistory->id) }}" onclick="return confirm('Are you sure want to delete this information')" title="Delete" class="btn btn-danger">Delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div id="pagination-links">
    {{ $itemUsageHistorys->appends(['query' => request('query'), 'restaurant' => request('restaurant')])->links() }}
</div>
