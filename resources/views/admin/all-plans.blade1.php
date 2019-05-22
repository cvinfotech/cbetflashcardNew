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
                                    <div class="questtions-label">All Plans</div>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#planAddModal" class="underline">Add Plan</a>
                                    <table class="table mt-3">
                                        <thead class="thead-theme">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Months</th>
                                            <th>Amount</th>
                                            <th>Description</th>
                                            <th>Created On</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($plans->count() > 0)
                                            @foreach($plans as $pk => $plan)
                                                <tr>
                                                    <td>{{ $pk + 1 }}</td>
                                                    <td>{{ $plan->plan }}</td>
                                                    <td>{{ $plan->months }} Months</td>
                                                    <td>{{ $plan->amount }}</td>
                                                    <td>{{ $plan->description }}</td>
                                                    <td>{{ $plan->created_at->format('d F, Y') }}</td>
                                                    <td>
                                                        {{--<a href="javascript:void(0)" class="delete-plan"
                                                           data-toggle="modal" data-plan_id="{{ $plan->id }}" data-plan="{{ $plan->plan }}" data-amount="{{ $plan->amount }}"
                                                           data-target="#planEditModal">
                                                            Edit
                                                        </a>&nbsp;--}}
                                                        <a href="javascript:void(0)" class="delete-plan text-danger"
                                                           data-toggle="modal" data-plan_id="{{ $plan->id }}"
                                                           data-target="#deletePlanModal">
                                                            Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5">
                                                    <div class="alert alert-danger" role="alert">
                                                        No Plan found
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
    <div class="modal fade" id="deletePlanModal" tabindex="-1" role="dialog" aria-labelledby="deletePlanModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            {!! Form::open(['route' => 'plan.delete', 'method' => 'DELETE']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePlanModalLable">Alert</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::hidden('plan_id', '', ['id' => 'delete_id']) !!}
                    Are you sure you want to delete this plan?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="modal fade" id="planAddModal" tabindex="-1" role="dialog" aria-labelledby="planAddModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['route' => 'plan.store']) !!}
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Add Plan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-4">
                        {!! Form::text('plan', '', ['required' => 'required', 'class' => 'form-control', 'id' => 'plan', 'placeholder' => 'Plan']) !!}
                        <i class="fas fa-chart-bar icon"></i>
                    </div>

                    <div class="md-form mb-4">
                        {!! Form::text('amount', '', ['required' => 'required', 'class' => 'form-control', 'id' => 'amount', 'placeholder' => 'Amount']) !!}
                        <i class="fas fa-dollar-sign"></i>
                    </div>

                    <div class="md-form mb-4">
                        {!! Form::select('months', ['1' => '1 Month', '3' => '3 Months', '6' => '6 Months', '12' => '12 Months'], '', ['required' => 'required', 'class' => 'form-control', 'id' => 'months', 'placeholder' => 'Select Months']) !!}
                        <i class="fas fa-caret-down icon"></i>
                    </div>
                    <div class="md-form mb-4">
                        {!! Form::textarea('description', '', ['required' => 'required', 'class' => 'md-textarea form-control', 'rows' => 3, 'id' => 'description', 'placeholder' => 'Plan Description']) !!}
                        <i class="fas fa-pencil icon"></i>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-default">Add Plan</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="planEditModal" tabindex="-1" role="dialog" aria-labelledby="planEditModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['route' => 'plan.update']) !!}
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Edit Plan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-5">
                        {!! Form::hidden('plan_id', '', ['required' => 'required', 'class' => 'form-control', 'id' => 'edit-plan-id', 'placeholder' => 'Plan']) !!}
                        {!! Form::text('plan', '', ['required' => 'required', 'class' => 'form-control', 'id' => 'edit-plan', 'placeholder' => 'Plan']) !!}
                        <i class="fas fa-chart-bar icon"></i>
                    </div>

                    <div class="md-form mb-4">
                        {!! Form::text('amount', '', ['required' => 'required', 'class' => 'form-control', 'id' => 'edit-amount', 'placeholder' => 'Amount']) !!}
                        <i class="fas fa-dollar-sign"></i>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-default">Update Plan</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $("#deletePlanModal").on('show.bs.modal', function (e) {
            var plan_id = $(e.relatedTarget).data('plan_id');
            $('#deletePlanModal input#delete_id').val(plan_id);
        });

        $("#planEditModal").on('show.bs.modal', function (e) {
            var plan_id = $(e.relatedTarget).data('plan_id');
            var plan = $(e.relatedTarget).data('plan');
            var amount = $(e.relatedTarget).data('amount');
            $('#planEditModal input#edit-plan-id').val(plan_id);
            $('#planEditModal input#edit-plan').val(plan);
            $('#planEditModal input#edit-amount').val(amount);
        });
    </script>
@endsection