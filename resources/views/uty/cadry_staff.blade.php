@extends('layouts.master')
@section('content')

    @if (\Session::has('msg'))
        @if (Session::get('msg') == 1)
        <div class="alert alert-success" id="success-alert">Succesfully!</div>
        @endif
    @endif

      <!-- start page title -->
      <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{$staff_name}} lavozimidagi xodimlar</h4>

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
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>    
                                    <th class="text-center fw-bold" width="80px">No</th>
                                    <th class="text-center fw-bold" width="100px">Photo</th>
                                    <th class="text-center fw-bold">FIO</th>
                                    <th class="text-center fw-bold">Lavozimi</th>
                                    <th class="text-center fw-bold" width="80px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($cadries))
                                    @foreach ($cadries as $key=>$item)
                                    <tr>
                                        <td class="text-center">{{(($cadries->currentPage() * 10) - 10) + $loop->index + 1}}</td>
                                        <td class="text-center"> <img class="rounded avatar" src="{{asset('storage/'.$item->photo)}}" height="40" width="40"></td>
                                        <td class="text-center">{{$item->last_name}} {{$item->first_name}} {{$item->middle_name}}</td>
                                        <td class="text-center">{{$item->post_name}}</td>
                                        <td class="text-center"> 
                                            <a type="button" href="{{route('word_export',['id' => $item->id])}}" class="btn btn-soft-primary">
                                                <i class="bx bx-download font-size-16 align-middle"></i></a>    
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