@extends('layouts.authapp')

@section('content')
<form class="form-signin" action="/login" method="POST">
                @csrf
                <h1 class="h2 font-weight-normal text-left font-weight-bold">Masuk</h1>
                <p class="pb-3 font-weight-normal text-left">Masuk ke akun anda</p>
                @error('email')
                  <small class="text-danger">{{$message}}</small>
                @enderror
                <div class="input-group mb-3">
                  <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" required autofocus>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-at"></span>
                    </div>
                  </div>
                </div>
                @error('password')
                  <small class="text-danger">{{$message}}</small>
                @enderror
                <div class="input-group mb-3">
                  <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required>
                  <div class="input-group-append show-password">
                    <div class="input-group-text">
                      <span class="fas fa-eye-slash" id="password-lock"></span>
                    </div>
                  </div>
                </div>
                <div class="checkbox mb-3">
                  <label>
                    <input type="checkbox" name="remember" value="on"> Remember me
                  </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block mb-3" type="submit">Masuk</button>
                @if (session('failed'))
                  <div class="text text-center text-danger mt-5">{{session('failed')}}</div>
              @endif
                <p class="font-weight-bold">Belum memiliki akun? <a href="{{ route('register') }}">Daftar sekarang.</a></p>
                <p class="mt-3 mb-3 text-muted">&copy; Data Pustaka Library</p>
              </form>
@endsection