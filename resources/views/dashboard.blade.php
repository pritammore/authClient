<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>OAuth Client</title>
    <!-- Bootstrap core CSS -->
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
    <!-- Custom styles for this template -->
    <!-- <link href="assets/css/form-validation.css" rel="stylesheet"> -->
  </head>
  <body class="bg-light">
    <div class="container">
    
    <nav class="navbar navbar-dark bg-primary justify-content-between">
      <a class="navbar-brand text-white">OAuth Client</a>
      <form class="form-inline">
        <a class="btn btn-danger" href="{{ url('/logout') }}"> logout </a>
      </form>
    </nav>
    <hr>
  <div class="jumbotron jumbotron-fluid">
  <div class="container text-center">
    <h1 class="display-4">OAuth Client {{ $username }}</h1>
    <p class="lead">Logged in successfully</p>
  </div>
</div>
  <div class="row">
    <div class="col-md-12 order-md-1">
      <h4 class="mb-3">Verify User Details</h4>
            <div class="mb-3">
                <form method="POST" action="{{ action('UserController@validateEmail') }}">
                  @csrf
                    <label for="email">Email</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="email" name="email" placeholder="EMAIL ADDRESS" required>
                      <div class="invalid-feedback" style="width: 100%;">
                        Your email address is required.
                      </div>
                    </div>
                    <br>
                  <div class="col-md-2">
                      <button class="btn btn-primary btn-lg btn-block " type="submit">Verify</button>
                  </div>
                </form>
                
                @if( Session::has( 'success' ))
                    <hr><p class="alert alert-success">{{ Session::get( 'success' ) }}</p>
                @elseif( Session::has( 'warning' ))
                    <hr><p class="alert alert-danger">{{ Session::get( 'warning' ) }}</p>
                @endif
            </div>
    </div>
  </div>
</div>
<script src="{{ asset('js/app.js') }}" defer></script>
</html>
