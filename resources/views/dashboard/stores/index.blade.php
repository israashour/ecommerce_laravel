@extends('layouts.dashboard')
@section('title', 'Stores')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mt-2">Stores Table</h3>
                <a href="{{ route('stores.create') }}" class="btn btn-success float-right">Create New Store</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Location</th>
                            <th>Image</th>
                            <th>Active</th>
                            <th>Create Date</th>
                            <th>Updated Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stores as $store)
                            <tr>
                                <td>{{ $store->id }}</td>
                                <td>{{ $store->name }}</td>
                                <td>{{ $store->description }}</td>
                                <td>{{ $store->location }}</td>
                                <td><img src="{{Storage::url('stores/'.$stores->image)}}" alt="store image" width="60" height="60"></td>
                                <td>{{ $store->is_active ? 'active' : 'non active' }}</td>
                                <td>{{ $store->created_at }}</td>
                                <td>{{ $store->updated_at }}</td>
                                <td>
                                    <form action="{{ route('stores.destroy', $store->id) }}" method="POST">
                                        <div class="btn-group">
                                            <a href="{{ route('stores.edit', $store->id) }}" class="btn btn-info">edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">delete</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
            <!-- /.card-body -->
            {{-- <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <li class="page-item"><a class="page-link" href="#">«</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                </ul>
            </div> --}}
            <div class="card-footer" >
                <ul class="pagination pagination-sm m-0 float-right">
                    {!! $stores->links() !!}
                </ul>
            </div>

        </div>
        <!-- /.card -->
    </div>
@endsection
