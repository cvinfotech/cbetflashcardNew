@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="row">
                        @include('layouts.side-menu')
                        <div class="col-md-9 py-4 pl-lg-0">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="dashboard_stats text-center">
                                        <div class="stat_label">REGISTERED USER</div>
                                        <div class="stat_count">{{ $users_count }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="dashboard_stats text-center">
                                        <div class="stat_label">MONTHLY PROFITS</div>
                                        <div class="stat_count">${{ $monthly_transcation }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="dashboard_stats text-center">
                                        <div class="stat_label">TOTAL FLASH CARDS</div>
                                        <div class="stat_count">{{ $cards_count }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5">

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
                                    <div class="questtions-label">QUESTIONS</div>
                                    {!! Form::open(['method' => 'get']) !!}
                                        <div class="row top-filters">
                                            <div class="col-md-2">
                                                <a href="{{ route('card.add') }}" class="add-card underline">Add Card</a>
                                            </div>
                                            <div class="offset-3"></div>
                                            <div class="col-md-4">
                                                <div class="md-form m-0">
                                                    {!! Form::text('search_card', $search_card, ['class' => 'form-control', 'id' => 'search_card', 'placeholder' => 'Search Question']) !!}
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

                                    <table class="table mt-3">
                                        <thead class="thead-theme">
                                        <tr>
                                            <th>Card Number</th>
                                            <th>Category</th>
                                            <th>Question</th>
                                            <th>Question Image</th>
                                            <th>Answer</th>
                                            <th>Answer Image</th>
                                            <th>Added by</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($cards as $key_card => $card)
                                            <tr>
                                                <td>{{ $key_card + 1 }}</td>
                                                <td>{{ getCategory($card->cat_id) }}</td>
                                                <td>{{ $card->question }}</td>
                                                <td>{!! !empty($card->image_question) ? '<img src="'.asset('uploads/'.$card->image_question).'" height="70">' : '' !!}</td>
                                                <td>{!! $card->answer !!}</td>
                                                <td>{!! !empty($card->image_answer) ? '<img src="'.asset('uploads/'.$card->image_answer).'" height="70">' : '' !!}</td>
                                                <td>{{ $card->user_name ? $card->user_name : 'Admin' }}</td>
                                                <td>
                                                    <a href="{{ route('card.edit', $card->id) }}">
                                                        Edit
                                                    </a>
                                                    <a href="javascript:void(0)" class="delete-card" data-toggle="modal"
                                                       data-card_id="{{ $card->id }}" data-target="#deleteCardModal">
                                                        Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteCardModal" tabindex="-1" role="dialog" aria-labelledby="deleteCardModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            {!! Form::open(['route' => 'card.delete', 'method' => 'DELETE']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCardModalLable">Alert</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::hidden('card_id', '', ['id' => 'delete_id']) !!}
                    Are you sure you want to delete this card?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $("#deleteCardModal").on('show.bs.modal', function (e) {
            var card_id = $(e.relatedTarget).data('card_id');
            $('#deleteCardModal input#delete_id').val(card_id);
        });
    </script>
@endsection