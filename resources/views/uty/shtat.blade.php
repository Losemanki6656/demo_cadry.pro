@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{$organization->name}}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Bosh menu</a></li>
                    <li class="breadcrumb-item active">Shtat bo'yicha</li>
                </ol>
            </div>

        </div>
    </div>
</div>

        <div class="card">
            <div class="card-body">
                     
                <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <form action="{{route('shtat')}}" method="get">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_length" id="datatable_length">
                                    <label><input type="search" class="form-control form-control" placeholder="Search ..." name="search" value="{{request()->query('search')}}"></label>
                                    <input type="hidden" name="organization_id" value="{{$organization->id}}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive mt-1">
                    <table class="table table-bordered mt-1">
                        <thead class="thead-dark">
                            <tr>
                                <th class="fw-bold">Shtat lavozimi</th>
                                <th class="fw-bold">Toifasi</th>
                                <th class="fw-bold">Soni</th>
                                <th class="fw-bold">Amalda</th>
                                <th class="fw-bold text-center" width="80px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($staffs))
                                @foreach ($staffs as $staf)
                                <tr>
                                    <td>{{$staf->name}}</td>
                                    <td>{{$staf->category->name ?? ''}}</td>
                                    <td><h6>{{$staf->staff_count}}</h6></td>
                                    <td><h6>{{$staf->cadries->count()}}</h6></td>
                                    <td class="text-center">  
                                        <a type="button" href="{{route('cadry_staff_organ',['id' => $staf->id])}}" class="btn btn-soft-primary waves-effect" 
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Xodimlarni ko'rish">
                                            <i class="bx bx-user font-size-16 align-middle"></i>
                                        </a> 
                                    </td>
                                </tr>
                                @endforeach
                            @endif                                               
                        </tbody>
                    </table>
                </div>
                <div style="margin-top: 10px;margin-left: 50px">
                    {{ $staffs->withQueryString()->links() }}
                </div> 
            </div>
        </div>
              
@endsection

@section('scripts')
@endsection
