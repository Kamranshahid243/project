@extends("layouts.master")
@section('title') User Profile @stop
@section('content')
    <div class="row" ng-controller="MainController">
        <div class="col-md-3">
            <div class="box box-primary" show-loader="state.loadingUser">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{Auth::user()->photo}}"
                         alt="User profile picture">

                    <h3 class="profile-username text-center">@{{ user.name }}</h3>
                    <p class="text-muted text-center">@{{ user.role.role }}</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Name</b>
                            <a class="pull-right">
                                <n-editable type="text" name="name"
                                            value="user.name"
                                            url="/user/@{{user.id}}"
                                ></n-editable>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>Email</b>
                            <a class="pull-right">
                                @{{ user.email }}
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>Role</b> <a class="pull-right">@{{ user.role.role }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Member since</b> <a class="pull-right">@{{ user.created_at | nvdDate:'mediumDate' }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @include('user.profile-tabs')
        <toaster-container></toaster-container>
    </div>
@endsection
@include('user.user-profile-ng-app')