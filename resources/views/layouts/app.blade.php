
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('login-page/fonts/icomoon/style.css')}}">

    <link rel="stylesheet" href="{{asset('login-page/css/owl.carousel.min.css')}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('login-page/css/bootstrap.min.css')}}">
    
    <!-- Style -->
    <link rel="stylesheet" href="{{asset('login-page/css/style.css')}}">

    <title>E-xodim</title>
  </head>
  <body>

  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="{{asset('login-page/login.svg')}}" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
              <h3>Kirish</h3>
              <p class="mb-4">Xush kelibsiz! Login va parolni kiriting!</p>
            </div>
                    @yield('content')
            </div>
          </div>
          
        </div>
        
      </div>
    </div>
  </div>
  
    <script src="{{asset('login-page/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('login-page/js/popper.min.js')}}"></script>
    <script src="{{asset('login-page/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('login-page/js/main.js')}}"></script>
  </body>
</html>