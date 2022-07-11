@extends('layouts.app')

@section('content')

<form class="mt-4 pt-2" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group first">
        <label for="username">Elektron manzil</label>
        <input type="text" class="form-control" id="username" name="email">

      </div>
      <div class="form-group last mb-4">
        <label for="password">Parol</label>
        <input type="password" class="form-control" id="password" name="password">
        
      </div>
      
      <div class="d-flex mb-5 align-items-center">
        <label class="control control--checkbox mb-0"><span class="caption">Eslab qolish</span>
          <input type="checkbox" checked="checked"/>
          <div class="control__indicator"></div>
        </label>
        <span class="ml-auto"><a href="/" class="forgot-pass">Parolni unutdingizmi?</a></span> 
      </div>

      <button type="submit" class="btn btn-block btn-primary"> Kirish </button>
</form>
@endsection
