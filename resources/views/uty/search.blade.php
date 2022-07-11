@extends('layouts.master')

@section('content')

<div class="card ">
    <div class="card-header">
        <div class="card-body">
            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <form action="{{route('cadry_search')}}" method="get">
                                <label>Jami: <span class="fw-bold text-success">  {{$countcadries}} </span> ta
                                        <input type="search" class="form-control form-control-sm" placeholder="Familiya ..." name="last_name" value="{{request()->query('last_name')}}">
                                    </label>
                                    <label>
                                        <input type="search" class="form-control form-control-sm" placeholder="Ismi ..." name="first_name" value="{{request()->query('first_name')}}">
                                    </label>
                                    <label>
                                        <input type="search" class="form-control form-control-sm" placeholder="Otasining ismi ..." name="middle_name" value="{{request()->query('middle_name')}}">
                                    </label>
                                    <label>
                                       <button type="submit" class="btn btn-primary btn-sm"> <i class="fas fa-search"></i> </button>
                                    </label>
                            </form>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="datatable_filter" class="dataTables_filter">
                                <label>
                                    <a type="button" class="btn btn-success waves-effect btn-label waves-light" data-bs-toggle="modal" data-bs-target="#sendmessage">
                                        <i class="bx bx-send label-icon"></i> Send sms
                                    </a> 
                                </label>
                            </div>
                        </div>
                       
                    </div>
                    <div class="modal fade" id="sendmessage" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Sms Yuborish</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('success_message')}}" id="success_message" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Kimlarga:</label>
                                            <select name="select_sms" class="form-select">
                                                <option value="1">Belgilab yuborish</option>
                                                <option value="1">Erkaklarga</option>
                                                <option value="1">Ayollarga</option>
                                                <option value="1">Tug'ilgan kunlarga</option>
                                            </select>
                                        </div>                                         
                                        <div class="mb-3">
                                            <label>Sms Text:</label>
                                            <textarea class="form-control" type="text" name="comment"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" type="submit"> <i class="bx bx-send font-size-16 align-middle me-2"></i> Yuborish</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-sm animate__animated animate__pulse">
                            <thead>
                                <tr>    
                                    <th class="text-center" width="60px">#</th>
                                    <th width="60px" class="text-center">Photo</th>
                                    <th class="text-center fw-bold">FIO</th>
                                    <th class="text-center fw-bold">Korxona</th>
                                    <th class="text-center fw-bold">Lavozimi</th>
                                    <th class="text-center fw-bold" width="80">Action</th>
                                    <th class="text-center fw-bold" width="80">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($cadries))
                                    @foreach ($cadries as $key=>$item)
                                    <tr>
                                        <td class="text-center align-middle">{{(($cadries->currentPage() * 10) - 10) + $loop->index + 1}}</td>
                                        <td class="text-center">
                                            <a href="{{asset('storage/'.$item->photo)}}" class="image-popup-desc" 
                                                data-title="{{$item->last_name}} {{$item->first_name}} {{$item->middle_name}}" data-description="{{$item->post_name}}">
                                                <img class="rounded avatar" src="{{asset('storage/'.$item->photo)}}" height="40" width="40"> 
                                            </a>
                                        </td>
                                        <td class="text-center fw-bold align-middle">{{$item->last_name}} {{$item->first_name}} {{$item->middle_name}}</td>
                                        <td class="text-center fw-bold align-middle">{{$item->organization->name}}</td>
                                        <td class="text-center align-middle">{{$item->post_name}}</td>
                                        <td class="text-center"> 
                                            <a type="button" href="{{route('word_export',['id' => $item->id])}}" 
                                                class="btn btn-soft-primary waves-effect waves-light"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Yuklab olish">
                                                <i class="bx bxs-file-doc font-size-16 align-middle"></i></a>    
                                        </td>
                                        <td class="text-center"> 
                                            <input class="form-check-input ml-2" name="cadries[{{$item->id}}]" type="checkbox" style="zoom: 1.5" form="success_message">
                                       </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <form action="{{route('cadry_search')}}" method="get">
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
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
            @if (\Session::has('msg'))
                @if (Session::get('msg') == 'Request is received')
                    alertify.success("Send Sms Successfully!");
                @endif
            @endif
        });
</script>
@endsection