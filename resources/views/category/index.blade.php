<x-app-layout>
    <div class="container">

        <h2>Category (Add/Edit)</h2>

        @if(isset($error_message) && $error_message != '')
            <div class="alert alert-danger" role="alert">{{$error_message}}</div>
        @endif

        <form method="POST" action="{{ route('category.store') }}">
            @csrf
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{$category->name ?? ''}}" class="form-control" placeholder="name">
            </div>
            <div class="form-group">
                <label>Number</label>
                <input type="number" name="number" value="{{$category->number ?? ''}}" class="form-control" placeholder="number">
            </div>

            @if(isset($category->id))
            <input type="hidden" name="edit_id" value="{{$category->id}}">
            @endif

            <button type="submit" class="btn btn-default">Add/Edit</button>
            <button type="submit" name="search" value="1" class="btn btn-default pull-right">Search</button>
        </form>


        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                <tr>
                    <td>{{$row->name}}</td>
                    <td>{{$row->number}}</td>
                    <td>
                        <a href="{{route('category.edit',$row->id)}}" class="btn btn-info">Edit</a>
                        <form action="{{route('category.destroy',$row->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
