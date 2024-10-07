<table class="table table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Items</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $key => $restitem)
        <tr>
            <td>{{ $items->firstItem() + $key }}</td>
            <td>{{ $restitem->name }}</td>
            <td>{{ $restitem->quantity }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div>
    {{ $items->appends(['query' => request('query')])->links() }}
</div>
