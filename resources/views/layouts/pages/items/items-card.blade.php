@foreach ($items as $key => $item)
    <div class="col-md-4">
        <div class="card mb-4">
            <img class="card-img-top" src="{{ asset('task/' . $item->image) }}" alt="Item Image" style="width: 354px; height:300px;">
            <div class="card-body">
                <h5 class="card-title"><strong>Name:</strong> {{ $item->name }}</h5>
                <p class="card-text">
                    <strong>Description:</strong> {{ $item->description }}<br>
                    <strong>Quantity:</strong> {{ $item->quantity }}<br>
                    <strong>Restaurant:</strong> {{ $item->restaurant->name }}<br>
                </p>
                <a href="{{ route('item.edit', $item->id) }}" title="Edit" class="btn btn-sm btn-secondary">Edit</a>
                <a href="{{ route('item.delete', $item->id) }}" title="Delete" onclick="return confirm('Are you sure want to delete this information!')" class="btn btn-sm btn-danger">Delete</a>
            </div>
        </div>
    </div>
@endforeach
