@extends('layouts.masterfull')
@section('content')
<div class="card-body position-relative">
    <div class="row flex-between-end">
    <div class="col-auto align-self-center">
        <h5>  Tables </h5>
    </div>
    <div class="col-auto align-self-center">
        <a href="{{route('addcadry')}}" class="btn btn-info me-1 mb-1" type="button">
            <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Add Worker
        </a>
    </div>
    </div>
</div>
<form action="{{ route('file-import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="col">                            
        <input class="form-control search-input fuzzy-search" type="file" placeholder="Department" name="file"/>                               
    </div>
    <div class="col">
        <button type="submit" class="btn btn-primary"> import</button>
    </div>
 </form>
@endsection