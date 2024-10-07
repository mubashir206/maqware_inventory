<table class="table table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Items</th>
            <th>User</th>
            <th>Restaurant</th>
            <th>Quantity Used</th>
            <th>Stock Before</th>
            <th>Stock After</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($usageHistorys as $key => $usageHistory)
        <tr>
            <td>{{ $usageHistorys->firstItem() + $key }}</td>
            <td>{{ $usageHistory->item->name ?? 'N/A' }}</td>
            <td>{{ $usageHistory->user->name ?? 'N/A' }}</td>
            <td>{{ $usageHistory->restaurant->name ?? 'N/A' }}</td>
            <td>{{ $usageHistory->quantity_used }}</td>
            <td>{{ $usageHistory->stock_before }}</td>
            <td>{{ $usageHistory->stock_after }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div>
    {{ $usageHistorys->appends(['query' => request('query'), 'restaurant' => request('restaurant')])->links() }}
</div>
