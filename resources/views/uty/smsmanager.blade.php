@extends('layouts.master')
@section('content')

    @if (\Session::has('msg'))
        @if (Session::get('msg') == 1)
        <div class="alert alert-success" id="success-alert">Succesfully!</div>
        @endif
    @endif

      <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Kadrlar</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Bosh menu</a></li>
                        <li class="breadcrumb-item active">Kadrlar</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header">
            <div class="card-body">
            
            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <form action="{{route('cadry')}}" method="get">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="datatable_length">
                                <label><input type="search" class="form-control form-control" placeholder="Search ..." name="search" value="{{request()->query('search')}}"></label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="datatable_filter" class="dataTables_filter">
                                <label>
                                    <a href="{{route('addworker')}}" type="button" class="btn btn-primary waves-effect btn-label waves-light">
                                        <i class="bx bx-plus label-icon"></i> Xodim qo'shish
                                    </a> 
                                    <a href="{{route('export_excel')}}" type="button" class="btn btn-success waves-effect btn-label waves-light">
                                        <i class="bx bxs-file label-icon"></i> Export</a>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>    
                                    <th class="text-center fw-bold" width="60px">No</th>
                                    <th class="text-center fw-bold" width="60px">Photo</th>
                                    <th class="text-center fw-bold">FIO</th>
                                    <th class="text-center fw-bold">Lavozimi</th>
                                    <th width="50px" class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($cadries))
                                    @foreach ($cadries as $key=>$item)
                                    <tr>
                                        <td class="text-center fw-bold">{{(($cadries->currentPage() * 10) - 10) + $loop->index + 1}}</td>
                                        <td class="text-center">
                                                <img class="rounded avatar" src="{{asset('storage/'.$item->photo)}}" height="40" width="40">
                                            </td>
                                        <td class="text-center fw-bold">{{$item->last_name}} {{$item->first_name}} {{$item->middle_name}}</td>
                                        <td class="text-center">{{$item->post_name}}</td>
                                        <td class="text-center"> 
                                             <input class="form-check-input ml-2" type="checkbox" style="zoom: 1.5" id="formCheck1">
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <form action="{{route('cadry')}}" method="get">
                                <div class="dataTables_length" id="datatable_length">
                                    <label><input type="number" class="form-control form-control" placeholder="Page ..." name="page" value="{{request()->query('page')}}"></label>
                                </div>
                             </form>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="datatable_filter" class="dataTables_filter">
                                <label>
                                    {{ $cadries->withQueryString()->links() }} 
                                </label>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
            </div>
    </div>

   

@endsection

@section('scripts')
@endsection