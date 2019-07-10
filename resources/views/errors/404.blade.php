@extends("layouts.auth-layout")
@section('title') 404 @stop
@section("content")

    <div class="error-page">
        <h2 class="headline text-red">404</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> Oops! You might have lost your way.</h3>

            <p>
                The page you are looking for could not be found.
                You may <a href="/">return to dashboard</a>
            </p>

        </div>
    </div><!-- /.error-page -->

@endsection