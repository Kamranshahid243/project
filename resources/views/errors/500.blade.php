@extends("layouts.auth-layout")
@section('title') 500 @endsection
@section("content")

    <div class="error-page">
        <h2 class="headline text-red">500</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> Oops! Something went wrong.</h3>

            <p>We are sorry for the inconvenience.</p>

            <p>
                Try refreshing the page or
                <a href="/">return to dashboard</a>
            </p>

        </div>
    </div><!-- /.error-page -->

@endsection