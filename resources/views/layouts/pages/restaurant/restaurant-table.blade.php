<table class="table table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Actions</th> 
        </tr>
    </thead>
    <tbody>
        @foreach($restaurants as $key => $restaurant)
        <tr>
            <td>{{ $restaurants->firstItem() + $key }}</td>
            <td>{{ $restaurant->name }}</td>
            <td>{{ $restaurant->email }}</td>
            <td>{{ $restaurant->address }}</td>
            <td>{{ $restaurant->phone }}</td>
            <td>
                <a href="{{ route('restaurant.delete', $restaurant->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
                <a href="{{ route('restaurant.user', $restaurant->id) }}" class="btn btn-sm btn-info">Users</a>
                <a href="{{ route('restaurant.item', $restaurant->id) }}" class="btn btn-sm btn-secondary">Items</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
