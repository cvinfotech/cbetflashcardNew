<div class="col-md-3 pr-lg-0">
    <ul class="side-nav list-group">
        @if(isset(Auth::user()->user_type) && Auth::user()->user_type == 'admin')
            <li class="list-group-item py-4">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="list-group-item py-4">
                <a href="{{ route('plans.all') }}">Plan Setting</a>
            </li>
            <li class="list-group-item py-4">
                <a href="{{ route('users.all') }}">All Users</a>
            </li>
            <li class="list-group-item py-4">
                <a href="{{ route('category.all') }}">All Categories</a>
            </li>
            <li class="list-group-item py-4">
                <a href="{{ route('card.add') }}">Add Card</a>
            </li>
            <li class="list-group-item py-4">
                <a href="{{ route('admin.account') }}">Account</a>
            </li>
        @elseif(Route::currentRouteName() == 'payments' || Route::currentRouteName() == 'account.setting')
            @if(Auth::user()->plan != 'free')
            <li class="list-group-item py-4">
                <a href="{{ route('payments') }}">Payment Info</a>
            </li>
            @endif
            <li class="list-group-item py-4">
                <a href="{{ route('account.setting') }}">Account Setting</a>
            </li>
            <li class="list-group-item py-4 cancel-account-li">
                <a href="javascript:void(0)" class="cancel-account" data-toggle="modal" data-target="#deleteProfileModal">Cancel Account</a>
            </li>
        @else
            <li class="list-group-item py-4">
                <a href="{{ route('home') }}">Topic</a>
                <form method="get" action="{{ route('home') }}">
                <select name="topic_cat" class="topic_cat" onchange="this.form.submit()">
                    <option value="">All</option>
                    @foreach(getCategories() as $key_cat => $category)
                        <option value="{{ $key_cat }}" {{ isset($topic_cat) && $key_cat == $topic_cat ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                </form>
            </li>
            <li class="list-group-item py-4">
                <a href="{{ route('favorite.all') }}">Favorites ({{ favoriteCount() }})</a>
            </li>
            <li class="list-group-item py-4">
                <a href="{{ route('custom.cards') }}">Custom Cards ({{ customCardCount() }})</a>
                <a class="small" href="{{ route('custom.card.add') }}">Add custom card</a>
            </li>
            <li class="list-group-item py-4">
                <a href="javascript:void(0)" id="spotted-on-test">Spotted on test</a>
            </li>
        @endif
    </ul>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteProfileModal" tabindex="-1" role="dialog" aria-labelledby="deleteProfileModal"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        {!! Form::open(['route' => 'account.delete', 'method' => 'DELETE']) !!}
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProfileModalLable">Alert</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to cancel your account?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Yes</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="spottedModal" tabindex="-1" role="dialog" aria-labelledby="spottedModal"
     aria-hidden="true">

    <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
    <div class="modal-dialog modal-dialog-centered " role="document">


        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="spottedModalLongTitle">Alert</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                There are no questions currently spotted on the test.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

