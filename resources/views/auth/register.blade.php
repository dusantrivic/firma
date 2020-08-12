@extends('layouts.app')
@section('content')

    <form method="post" class="text-center form-signin" action="{{route('user.register')}}">
        @csrf

  <h1 class="h3 mb-3 font-weight-normal">Please register</h1>
  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="email" name="email" id="inputEmail" style="margin-bottom: 10px" class="form-control" placeholder="Email address"  >
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
  <label for="inputPassword" class="sr-only">Password Confirm</label>
  <input type="password" name="password_confirmation" id="inputPassword" class="form-control" placeholder="Password" required>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
  <p class="mt-5 mb-3 text-muted">&copy; 2020-2022</p>
</form>

@endsection
