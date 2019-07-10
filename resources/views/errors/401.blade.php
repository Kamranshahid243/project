@extends("layouts.auth-layout")
@section('title') 401 @stop
@section("content")

    <div class="error-page">
        <h2 class="headline text-red">@yield('title')</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> Oops! You might have lost your way.</h3>

            <p>
                You are not authorized to be here.
                You may <a href="/">return to dashboard</a>
            </p>

        </div>
    </div><!-- /.error-page -->

@endsection