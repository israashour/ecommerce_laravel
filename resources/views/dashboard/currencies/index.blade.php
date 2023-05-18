@extends('layouts.dashboard')
@section('title', 'Currencies')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mt-2">Currencies Table</h3>
                <a href="{{ route('currencies.create') }}" class="btn btn-success float-right">Create New Currency</a>
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
                            <th>symbol</th>
                            <th>Active</th>
                            <th>Create Date</th>
                            <th>Updated Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($currencies as $currency)
                            <tr>
                                <td>{{ $currency->id }}</td>
                                <td>{{ $currency->name }}</td>
                                <td><img src="{{Storage::url('currencies/'.$currency->symbol)}}" alt="currency symbol" width="60" height="60"></td>
                                <td>{{ $currency->status ? 'active' : 'non active' }}</td>
                                <td>{{ $currency->created_at }}</td>
                                <td>{{ $currency->updated_at }}</td>
                                <td>
                                    <form action="{{ route('currencies.destroy', $currency->id) }}" method="POST">
                                        <div class="btn-group">
                                            <a href="{{ route('currencies.edit', $currency->id) }}" class="btn btn-info">edit</a>
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
                    {!! $currencies->links() !!}
                </ul>
            </div>

        </div>
        <!-- /.card -->
    </div>
@endsection
