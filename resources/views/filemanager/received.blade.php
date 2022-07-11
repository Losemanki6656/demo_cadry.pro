@extends('layouts.masterfull')
@section('content')

    @if (\Session::has('msg'))
        @if (Session::get('msg') == 1)
        <div class="alert alert-success" id="success-alert">Succesfully!</div>
        @endif
    @endif

  
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Xabarlar</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Xabarlar
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body"> 
        <div class="card">
            <div class="card-header">
                <div class="col-md-3 col-6">
                    <fieldset>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Ismi va mavzusi bo'yicha" aria-label="Amount">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button"><i class="feather icon-search"></i></button>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="card-content">
                <div class="table-responsive mt-1">
                    <table class="table table-hover-animation mb-0">
                        <thead>
                        <tr>
                            <th>Kimdan</th>
                            <th>Mavzu</th>
                            <th>Status</th>
                            <th>Term</th>
                            <th width = "120">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td> 
                                        <h6>
                                        <img class="media-object rounded-circle" src="{{asset($task->sendorganization->photo)}}" alt="Avatar" height="30" width="30">
                                            {{$task->userrec->name}} 
                                        </h6>
                                    </td>
                                    <td>{{$task->task_text}}</td>

                                        <td>
                                            @if ($task->term > now())
                                                @if ($task->term->diffInDays() + 1 > 5)
                                                     <span class="badge bg-success"> {{$task->term->diffInDays() + 1}} kun qoldi</span>
                                                @else
                                                    <span class="badge bg-warning"> {{$task->term->diffInDays() + 1}} kun qoldi</span>
                                                @endif
                                            @else
                                                     <span class="badge bg-danger">Muddat tugagan</span>
                                            @endif
                                        </td>
                                        <td>
                                             <span class="badge bg-dark"> {{$task->term->format('d-m-Y')}} gacha</span>         
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-flat-primary btn-sm" data-toggle="modal" data-target="#sharesimpmodal{{$task->id}}">
                                                <i class="feather icon-share-2"></i></button> 
                                             @if ($task->task_status == 0)
                                                <button type="button" class="btn btn-icon btn-flat-success btn-sm" data-toggle="modal" data-target="#sucmodal{{$task->id}}">
                                                    <i class="feather icon-check-circle"></i></button> 
                                             @endif         
                                        </td>


                                    
                                        <div class="modal fade text-left" id="sharesimpmodal{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary white">
                                                        <h5 class="modal-title" id="myModalLabel160">Yuborish</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                        
                                                    <form action="{{route('share_simp_rec_task')}}" method="get">
                                                        @csrf
                                                        <div class="modal-body">
                                                                <div class="form-group">
                                                                    <h6><label>Foydalanuvchini tanlang:</label></h6>
                                                                    <select class="select2 js-example-programmatic form-control" name="usersimpshareid" required>
                                                                        <option value="">Kimga</option>
                                                                        @foreach ($users as $user)
                                                                                <option value={{$user->id}}>{{$user->name}}</option>                                                        
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <h6><label> Topshiriq mavzusini o'zgartirish:</label></h6>
                                                                    <textarea type="text" name="tasksimptext" class="form-control" placeholder="Topic:" required>{{$task->task_text}}</textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <h6><label>Topshiriq sanasini o'zgartirish:</label></h6>
                                                                    <input type="date" name="termsimpdate" class="form-control" required>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-primary" type="submit">Share</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade text-left" id="sucmodal{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary white">
                                                        <h5 class="modal-title" id="myModalLabel160">Bajarildi</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                        
                                                    <form action="{{route('success_rec_simp_task')}}" method="get">
                                                        @csrf
                                                        <div class="modal-body">
                                                                <div class="mb-3">
                                                                    Bajarilganligini tasdiqlash?
                                                                </div>
                                                                <input type="hidden" name="sucrecsimpid" value="{{$task->id}}">                                                              
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-success" type="submit">Bajarildi</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div> 
                                    
                                </tr>  
                            @endforeach         
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

   

@endsection

@section('scripts')

@endsection