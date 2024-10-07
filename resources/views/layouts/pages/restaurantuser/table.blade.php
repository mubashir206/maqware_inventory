<table class="table table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Restaurant</th>
            <th>User</th>
            <th>Role</th>
            <th>Action</th> 
        </tr>
    </thead>
    <tbody>
        @foreach($restUser as $key => $restUsers)
        <tr>
            <td>{{ $restUser->firstItem() + $key }}</td>
            <td>{{ $restUsers->restaurant->name }}</td>
            <td>{{ $restUsers->user->name }}</td>
            <td>
                @if ($restUsers->is_manager == 1)
                    Manager
                @else
                    User
                @endif
            </td>
            <td>
                <a href="{{ route('restaurant.user.delete', $restUsers->id) }}" onclick="return confirm('Are you sure you want to delete this user?')" class="btn btn-sm btn-danger">Delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div>
    {{ $restUser->appends(['query' => request('query'), 'restaurant' => request('restaurant')])->links() }}
</div>
