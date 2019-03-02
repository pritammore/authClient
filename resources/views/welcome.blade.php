<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>OAuth Client</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
  </head>
  <body class="bg-light">
    <div class="container">
  <div class="py-5 text-center">
    <h2>OAuth Client</h2>
    <p class="lead">Below is an example form built to test OAuth 2.0 Login/Logout functionality.</p>
  </div>
    
  <div class="row">
    <div class="col-md-12 order-md-1">
      <h4 class="mb-3">OAuth credentials and Login</h4>
      <form class="needs-validation" novalidate method="GET" action="{{ route('get.token') }}">
        @csrf
        <div class="row">
            <div class="mb-3">
              <p>Authorize URL : http://localhost:8000/oauth/authorize</p>
              <p>Token URL : http://localhost:8000/oauth/token</p>
            </div>
            <hr class="mb-4">
            <div class="col-md-6 mb-3">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Login Using OAuth 2.0</button>
            </div>
        </div>
      </form>
        @if( Session::has( 'success' ))
            <p class="alert alert-success">{{ Session::get( 'success' ) }}</p>
        @elseif( Session::has( 'warning' ))
            <p class="alert alert-danger">{{ Session::get( 'warning' ) }}</p>
        @endif
    </div>
  </div>
</div>
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
