@extends('layouts.master')


@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif


<div class="card-body position-relative">
    <div class="row flex-between-end">
    <div class="col-auto align-self-center">
        <h5>  Users Management </h5>
    </div>
    <div class="col-auto align-self-center">
        <a href="{{ route('users.create') }}" class="btn btn-info me-1 mb-1" type="button">
            <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Add User
        </a>
    </div>
    </div>
</div>


<div class="card mb-3">
    <div class="card-header border-bottom">
        <div class="row flex-between-end">
        <div class="col-auto align-self-center">
            <select class="form-select form-select-sm">
                <option value="1">10</option>
                <option value="2">50</option>
                <option value="3">100</option>
            </select>
        </div>
        <div class="col-auto align-self-center">
            <input class="form-control search-input fuzzy-search" type="search" placeholder="Search..." aria-label="Search" />
        </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive scrollbar">
        <table class="table mb-0 fs--1 border-200 table-borderless">
            <thead class="bg-light">
            <tr class="text-800 bg-200">
                <th class="text-nowrap" width="180">No</th>
                <th class="text-center text-nowrap">Name</th>
                <th class="text-center text-nowrap">Email </th>
                <th class="text-center text-nowrap">Roles</th>
                <th class="text-center text-nowrap">Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $user)
                    <tr class="border-bottom border-200">
                        
                        <td >
                            {{ ++$i }}
                        </td>
                        <td class="text-center">
                            {{ $user->name }}
                        </td>
                        <td class="text-center">
                            {{ $user->email }}
                        </td>
                        <td class="text-center">
                            @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                    <label class="badge badge rounded-pill d-block p-2 badge-soft-primary">{{ $v }}</label>
                                @endforeach
                            @endif
                        </td>
                            <td class="text-center">
                                <div>
                                    <a href="{{ route('users.edit',$user->id) }}" class="btn btn-outline-secondary me-1 mb-1" type="button"> Edit
                                    </a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-outline-danger me-1 mb-1']) !!} 
                                    {!! Form::close() !!}
                                </div>  
                            </td>
                        

                        
                    </tr>  
                @endforeach         
            </tbody>
        </table>
        </div>
    </div>
</div>

{!! $data->render() !!}


@endsection


