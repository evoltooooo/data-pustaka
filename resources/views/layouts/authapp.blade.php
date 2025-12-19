 <!DOCTYPE html>
 <html>
 <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Library</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    @include('layouts.partials.style')

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slideshowauth.css') }}" rel="stylesheet">
  </head>

  <body>
    <div class="bg-image"></div>
    <div class="container container-fluid d-flex align-items-center justify-content-center">
      <div class="card w-75 shadow-lg">
        <div class="row">
          <div class="col-sm-6">
            <div class="fadein">
                <div class="slide">
                    <img src="{{ asset('images/calgary2.jpg') }}">
                    <p class="caption">Data Pustaka Library</p>
                </div>

                <div class="slide">
                    <img src="{{ asset('images/calgary3.jpg') }}">
                    <p class="caption">Data Pustaka Library</p>
                </div>

                <div class="slide">
                    <img src="{{ asset('images/calgary4.jpg') }}">
                    <p class="caption">Data Pustaka Library</p>
                </div>
            </div>
          </div>
          <div class="card-body login-card-body">
            <div class="col-sm-12 d-flex justify-content-center align-items-center" style="height: 70vh">
              @yield('content')
            </div>
            </div> 
          </div>
        </div>
      </div>
      <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script> 
    <script>
      $('.show-password').on('click', function(){
        if($('#inputPassword').attr('type') == 'password'){
          $('#inputPassword').attr('type' , 'text');
          $('#password-lock').attr('class' , 'fas fa-eye');
        } else {
          $('#inputPassword').attr('type' , 'password');
          $('#password-lock').attr('class' , 'fas fa-eye-slash');
        }
      })
      $('.show-password_confirmation').on('click', function(){
        if($('#password_confirmation').attr('type') == 'password'){
          $('#password_confirmation').attr('type' , 'text');
          $('#password_confirmation-lock').attr('class' , 'fas fa-eye');
        } else {
          $('#password_confirmation').attr('type' , 'password');
          $('#password_confirmation-lock').attr('class' , 'fas fa-eye-slash');
        }
      })
      
    </script>
    <script>
     $(function () {
    let slides = $('.fadein .slide');
    let index = 0;

    slides.eq(0).addClass('active');

    setInterval(function () {
        slides.eq(index).removeClass('active');
        index = (index + 1) % slides.length;
        slides.eq(index).addClass('active');
    }, 5000);
});
</script>
  </body>
</html>