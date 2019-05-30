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
                                    <div class="questtions-label">Test Questions</div>
                                        {!! Form::open(['method' => 'get']) !!}
                                        <div class="row top-filters">
                                            <div class="col-md-2">
                                                <a href="{{ route('add.test-question') }}" class="text-underline">Add Question</a>
                                            </div>
                                            <div class="offset-3"></div>
                                            <div class="col-md-4">
                                                <div class="md-form m-0">
                                                    {!! Form::text('search_ques', $search_ques, ['class' => 'form-control', 'id' => 'search_ques', 'placeholder' => 'Search Question']) !!}
                                                    <i class="fas fa-search"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn  m-0 btn-outline-theme btn-rounded btn-block waves-effect z-depth-0"
                                                        type="submit">Search
                                                </button>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}

                                    <table class="table test-questions mt-3">
                                        <thead class="thead-theme">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Question</th>
                                            <th>Category</th>
                                            <th>Created On</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($online_tests->count())
                                        @foreach($online_tests as $key_ques =>  $question)
                                        <tr>
                                            <td data-title="S.No">{{ $key_ques+1 }}</td>
                                            <td data-title="Question">{{ $question->question }}</td>
                                            <td data-title="Category">{{ getCategory($question->cat_id) }}</td>
                                            <td data-title="Created On">{{ $question->created_at->format('d F, Y') }}</td>
                                            <td data-title="Actions">
                                                <a href="{{ route('edit.test-question', $question->id) }}">Edit</a>
                                                <a href="javascript:void(0)" class="delete-question text-danger" data-toggle="modal" data-question_id="{{ $question->id }}" data-target="#deleteQuesModal">
                                                    Delete
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                            @else
                                            <tr>
                                                <td colspan="4">
                                                    <div class="alert alert-danger" role="alert">
                                                        No Test Questions.
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                        {!! $online_tests->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteQuesModal" tabindex="-1" role="dialog" aria-labelledby="deleteQuesModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            {!! Form::open(['route' => 'delete.test-question', 'method' => 'DELETE']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteQuesModalLable">Alert</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::hidden('question_id', '', ['id' => 'delete_id']) !!}
                    Are you sure you want to delete this question?
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
        $("#deleteQuesModal").on('show.bs.modal', function(e){
            var question_id = $(e.relatedTarget).data('question_id');
            $('#deleteQuesModal input#delete_id').val(question_id);
        });
    </script>
    @endsection