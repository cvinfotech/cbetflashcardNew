@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="row">
                        @include('layouts.side-menu')
                        <div class="col-md-9 py-4 pl-lg-0">
                            <div class="mt-0">
                                <div class="col-md-12">
                                    @if (session('success'))
                                        <div class="alert alert-success" role="alert">
                                            {{ __(session('success')) }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ __(session('error')) }}
                                        </div>
                                    @endif
                                    <div class="questtions-label">All Categories</div>
                                        <a href="{{ route('category.add') }}" class="text-underline">Add Category</a>
                                    <table class="table mt-3">
                                        <thead class="thead-theme">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Category</th>
                                            <th>Count</th>
                                            <th>Created On</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($all_category as $key_cat =>  $category)
                                        <tr>
                                            <td data-title="S.No">{{ $key_cat+1 }}</td>
                                            <td data-title="Category">{{ $category->name }}</td>
                                            <td data-title="Count">{{ count($category->Cards) }}</td>
                                            <td data-title="Created On">{{ $category->created_at->format('d F, Y') }}</td>
                                            <td data-title="Actions">
                                                <a href="{{ route('category.edit', $category->id) }}">Edit</a>
                                                @if(count($category->Cards) <= 0)
                                                <a href="javascript:void(0)" class="delete-category text-danger" data-toggle="modal" data-category_id="{{ $category->id }}" data-target="#deleteCateogryModal">
                                                    Delete
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                        {!! $all_category->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteCateogryModal" tabindex="-1" role="dialog" aria-labelledby="deleteCateogryModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            {!! Form::open(['route' => 'category.delete', 'method' => 'DELETE']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCateogryModalLable">Alert</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::hidden('category_id', '', ['id' => 'delete_id']) !!}
                    Are you sure you want to delete this category?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $("#deleteCateogryModal").on('show.bs.modal', function(e){
            var category_id = $(e.relatedTarget).data('category_id');
            $('#deleteCateogryModal input#delete_id').val(category_id);
        });
    </script>
    @endsection