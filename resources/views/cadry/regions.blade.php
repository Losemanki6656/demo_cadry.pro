@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ __('messages.regions') }}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">{{ __('messages.menu') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('messages.regions') }}</li>
                </ol>
            </div>

        </div>
    </div>
</div>


   <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
        
                    <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <form action="{{route('regions')}}" method="get">
                                    <div class="dataTables_length" id="datatable_length">
                                        <label><input type="search" class="form-control form-control" placeholder="{{ __('messages.search') }} ..." name="search" value="{{request()->query('search')}}"></label>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_filter">
                                    <label>
                                        <button type="button" class="btn btn-primary w-sm waves-effect waves-ligh" 
                                        data-bs-toggle="modal" data-bs-target="#addcity">
                                            <i class="bx bx-plus font-size-16 align-middle me-2"></i> Tuman qo'shish
                                        </button> 
                                    </label>
                                </div>
                                <div class="modal fade" id="addcity" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tuman qo'shish</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{route('add_city')}}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <h6><label>Viloyatni tanlang:</label></h6>
                                                        <select class="form-select" name="region_id">
                                                                @foreach ($regions as $region)
                                                                    <option value={{$region->id}}>{{$region->name}}   
                                                                         <span class="fw-bold"></span>
                                                                    </option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <h6><label>Tuman,Shahar nomini kiriting:</label></h6>
                                                        <input class="form-control" type="text" name="name">
                                                    </div>      
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-primary" type="submit"> <i class="feather icon-send"></i> Qo'shish </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>  
        
                </div>
            
                
                <div class="card-body">
        
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>    
                                    <th width="80px" class="text-center">No</th>
                                    <th width="300px" class="fw-bold">Viloyat</th>
                                    <th width="300px" class="fw-bold">Tuman,Shaxar</th>
                                    <th width="" class="fw-bold">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($cities as $city)
                                    <tr>
                                        <td class="fw-bold text-center" >{{(($cities->currentPage() * 10) - 10) + $loop->index + 1}}</td>
                                        <td>{{$city->region->name}}</td>                            
                                        <td>{{$city->name}}</td>
                                        <td>
                                            <span data-toggle="modal" data-target="#del">
                                                <button type="button" data-toggle="tooltip" data-placement="bottom" title="Taxrirlash"
                                                    class="btn btn-icon btn-flat-dark btn-sm" >
                                                       <i class="feather icon-edit"></i>
                                                   </button>     
                                            </span>
                                            <span data-toggle="modal" data-target="#del">
                                                <button type="button" data-toggle="tooltip" data-placement="bottom" title="O'chirish"
                                                    class="btn btn-icon btn-flat-danger btn-sm" >
                                                       <i class="feather icon-trash"></i>
                                                   </button>     
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">             
                        <ul class="pagination mb-0">
                            {{ $cities->withQueryString()->links() }}
                        </ul> 
                    </div>
        
                </div>
            </div>
        </div>
   </div>

   

@endsection

@section('scripts')
<script>$('.js-example-basic-single').select2();</script>
@endsection