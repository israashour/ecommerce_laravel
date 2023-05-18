@extends('layouts.dashboard')
@section('title', 'Products')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mt-2">Products Table</h3>
                <a href="{{ route('products.create') }}" class="btn btn-success float-right">Create New Product</a>
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
                            <th>Price</th>
                            <th>Active</th>
                            <th>Create Date</th>
                            <th>Updated Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->location }}</td>
                                <td><img src="{{Storage::url('products/'.$products->image)}}" alt="product image" width="60" height="60"></td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->status ? 'active' : 'non active' }}</td>
                                <td>{{ $product->created_at }}</td>
                                <td>{{ $product->updated_at }}</td>
                                <td>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                        <div class="btn-group">
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-info">edit</a>
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
                    {!! $products->links() !!}
                </ul>
            </div>

        </div>
        <!-- /.card -->
    </div>
@endsection
