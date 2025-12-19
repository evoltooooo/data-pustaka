@extends('layouts.authapp')

@section('content')
<form class="form-signin" action="/register" method="POST" enctype="multipart/form-data">
                @csrf
                <h1 class="h2 text-left font-weight-bold">Daftar</h1>
                <p class="pb-2 font-weight-normal text-left">Selamat datang di Perpus!</p>
                <div class="input-group mb-3">
                  <input type="text" id="inputName" class="form-control" placeholder="Username" name="name" required autofocus>
                  <div class="input-group-append">
                    <div class="input-group-text">
                    </div>
                  </div>
                </div>
                @error('name')
                  <small class="text-danger">{{$message}}</small>
                @enderror
                <div class="input-group mb-3">
                  <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-at"></span>
                    </div>
                  </div>
                </div>
                @error('email')
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
                @error('password')
                  <small class="text-danger">{{$message}}</small>
                @enderror
                <div class="input-group mb-3 pb-3">
                  <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="Confirmation Password" required>
                  <div class="input-group-append show-password_confirmation">
                    <div class="input-group-text">
                      <span class="fas fa-eye-slash" id="password_confirmation-lock"></span>
                    </div>
                  </div>
                </div>
                @error('password_confirmation')
                  <small class="text-danger">{{$message}}</small>
                @enderror
                <button class="btn btn-lg btn-primary btn-block mb-3" type="submit">Daftar</button>
                @if (session('failed'))
                  <div class="text text-center text-danger mt-5">{{session('failed')}}</div>
              @endif
                <p class="font-weight-bold">Sudah memiliki akun? <a href="{{ route('login') }}">Masuk sekarang.</a></p>
                <p class="mt-3 mb-3 text-muted">&copy; Data Pustaka Library</p>
              </form>
@endsection