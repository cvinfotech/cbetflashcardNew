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
                                    <div class="questtions-label">Practice exam score history ({{ $test_results->total() }})</div>
                                    <div class="sub-title">Only your completed practice exam results will be displayed here.</div>
                                        <div class="line-graph">
                                            <canvas id="pastResults" style="max-width: 100%;"></canvas>
                                        </div>
                                    <table class="table mt-3">
                                        <thead class="thead-theme">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Questions Answered</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Report Card</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($test_results->count() > 0)
                                        @foreach($test_results as $test_key => $test)
                                        <tr>
                                            <td data-title="S.No">{{ $test_key + 1 }}</td>
                                            <td data-title="Questions Answered">{{ $test->getCorrectQues->count().'/'.$test->question_num }}</td>
                                            <td data-title="Status">{{ ucfirst($test->result) }}</td>
                                            <td data-title="Date">{{ $test->created_at->format('d F, Y') }}</td>
                                            <td data-title="Report Card"><a href="{{ route('report.card', $test->test_id) }}">View</a> </td>
                                        </tr>
                                        @endforeach

                                            @else
                                            <tr>
                                                <td colspan="4">

                                                    <div class="alert alert-danger" role="alert">
                                                        No Test
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                        {!! $test_results->links() !!}
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
            {!! Form::open(['route' => 'user.cancel', 'method' => 'POST']) !!}
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

        var labels = [];
        var data = [];

        @foreach($line_graph as $line)
            labels.push('{{ $line->test_date }}');
            data.push('{{ $line->correct }}');
        @endforeach

        var ctxL = document.getElementById("pastResults").getContext('2d');
        var myLineChart = new Chart(ctxL, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: "Questions Answered",
                    data: data,
                    backgroundColor: [
                        'rgba(77, 204, 189, .2)',
                    ],
                    borderColor: [
                        'rgba(96, 193, 182, .7)',
                    ],
                    borderWidth: 2
                }
                ]
            },
            options: {
                responsive: true
            }
        });

    </script>
    @endsection