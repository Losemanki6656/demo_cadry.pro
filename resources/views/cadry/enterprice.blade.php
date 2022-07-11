@extends('layouts.master')
@section('content')

    @if (\Session::has('msg'))
        @if (Session::get('msg') == 1)
        <div class="alert alert-success" id="success-alert">Succesfully!</div>
        @endif
    @endif

    <div class="card-body position-relative">
        <div class="row flex-between-end">
        <div class="col-auto align-self-center">
            <h5> Organizations Table</h5>
        </div>
        <div class="col-auto align-self-center">
            <a href="{{route('addcadry')}}" class="btn btn-info me-1 mb-1" type="button">
                <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Add Organization
            </a>
        </div>
        </div>
    </div>

    
    <div class="card mb-3">
        <div class="card-header border-bottom">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <div class="row">
                        
                        <div class=" col">
                            <label>Organizations:</label>
                                <select class="form-select form-select-sm">
                                    @foreach ($organizations as $organization)
                                        <option value={{$organization->id}}>{{$organization->name}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                
            </div>
            </div>
        </div>
    
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
            <table class="table mb-0 fs--1 border-200 table-borderless">
                <thead class="bg-light">
                <tr class="text-800 bg-200">
                    <th class="text-nowrap" width="180">No</th>
                    <th class="text-center text-nowrap">Organization Name</th>
                    <th class="text-center text-nowrap">Enterprice Name</th>
                    <th class="text-center text-nowrap">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($enterprices as $orgs)
                    <tr>
                        <td>
                            {{$loop->index + 1}}
                        </td>
                        <td class="text-center">
                            {{$orgs->railway->name}}
                        </td>
                        <td class="text-center">
                            {{$orgs->name}}
                        </td>
                        <td class="text-center">
                            <button class="btn p-0 ms-2" type="button"  data-bs-placement="top" title="Edit" data-bs-toggle="modal" data-bs-target="#editmodal{{$orgs->id}}">
                                <span class="text-500 fas fa-edit"></span>
                            </button>
                            <button class="btn p-0 ms-2" type="button" data-bs-placement="top" title="Delete" data-bs-toggle="modal" data-bs-target="#deletemodal{{$orgs->id}}">
                                    <span class="text-500 fas fa-trash-alt"></span>
                            </button>                     
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>

   

@endsection

@section('scripts')

@endsection