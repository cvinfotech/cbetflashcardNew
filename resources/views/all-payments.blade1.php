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
                                    <div class="questtions-label">Payment</div>
                                    <div class="second-label mt-4">Paypal Agreement</div>
                                    <div class="agreement_txt">{{ Auth::user()->agreement_id ? Auth::user()->agreement_id : 'xxxxxxx' }}. <a href="{{ route('paypal.redirect') }}" class="text-underline">(Update)</a></div>
                                    <div class="second-label mt-4">Payment History</div>
                                    <table class="table mt-3">
                                        <thead class="thead-theme">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Date</th>
                                            <th>Agreement ID</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($payments->count() > 0)
                                        @foreach($payments as $keyP => $payment)
                                        <tr>
                                            <td>{{ $keyP+1 }}</td>
                                            <td>{{ $payment->created_at->format('d F, Y') }}</td>
                                            <td>{{ $payment->agreement_id }}</td>
                                            <td>${{ $payment->amount }}</td>
                                            <td>{{ $payment->status }}</td>
                                        </tr>
                                        @endforeach
                                            @else
                                            <tr>
                                                <td colspan="5">

                                                    <div class="alert alert-danger" role="alert">
                                                        No Payment History
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
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
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            {!! Form::open(['route' => 'user.delete', 'method' => 'DELETE']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLable">Alert</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::hidden('user_id', '', ['id' => 'delete_id']) !!}
                    Are you sure you want to delete this user?
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
        $("#deleteUserModal").on('show.bs.modal', function(e){
            var user_id = $(e.relatedTarget).data('user_id');
            $('#deleteUserModal input#delete_id').val(user_id);
        });
    </script>
    @endsection