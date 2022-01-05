@extends('layout/auth')

@section('form')
<form class="form-signin" action="/signup" method="POST">
  @csrf
  <img class="mb-4" src="icon.ico" alt="" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">Please {{$title}}</h1>
  <label for="inputName" class="sr-only">Username</label>
  <input type="text" id="inputName" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nick Name" required autofocus value="{{ old('name')}}">
  @error('name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
  @enderror
  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="email" id="inputEmail" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email address" required value="{{ old('email')}}">
   @error('email')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
  @enderror
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="inputPassword" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
  @error('password')
   <div class="invalid-feedback">
       {{ $message }}
   </div>
 @enderror
  <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
  <a href="/signin" class="w-100 d-flex justify-content-center" style="text-decoration: none;">
      <button class="btn btn-lg btn-success btn-block w-50 mt-2" type="button" style="font-size: 1rem">Sign in</button>
  </a>
</form>

@endsection
