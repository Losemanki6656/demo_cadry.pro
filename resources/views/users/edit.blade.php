@extends('layouts.masterfull')


@section('content')

<div class="card-body position-relative">
    <div class="row flex-between-end">
        <div class="col-auto align-self-center">
            <h5> Edit User</h5>
        </div>
    </div>
</div>


@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif



{!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
<div class="row flex-between-end">
    <div class="container">
        <div class="col-3">
            <div class="mb-3">
                <label for="lastname"> Fullname: </label>  {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
            </div>
            <div class="mb-3">
                <label for="firstname"> Email: </label> {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}           
            </div>
            <div class="mb-3">
                <label for="middlename"> Password: </label>  {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}    
            </div>
            <div class="mb-3">
                <label for="birhtdate"> Confirm Password: </label>  {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}             
            </div>
            <div class="mb-3">
                <label for="birhtdate"> Role: </label>     {!! Form::select('roles[]', $roles,[], array('class' => 'form-select form-control','select')) !!}           
            </div>
            <div class="mb-3">
                <a href="{{ route('users.index') }}" class="btn btn-secondary" type="button">Back </a>  
                <button type="submit" class="btn btn-success">Submit</button>       
            </div>       
        </div>
    </div>
</div>
{!! Form::close() !!}

@endsection