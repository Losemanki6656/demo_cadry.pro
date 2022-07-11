@extends('layouts.masterfull')
@section('content')

    @if (\Session::has('msg'))  
        @if (Session::get('msg') == 1)
        <div class="alert alert-success" id="success-alert">A simple success alert—check it out!</div>
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
                            <li class="breadcrumb-item active">Yuborilgan xatlar
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
                            <input type="search" class="form-control" placeholder="Ismi va mavzusi bo'yicha" aria-label="Amount">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button"><i class="feather icon-search"></i></button>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="card-header-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addtask">
                        <i class="feather icon-plus-circle"></i> Yangi yuborish
                    </button>
                    <!-- Modal -->
                    <div class="modal fade text-left" id="addtask" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary white">
                                    <h5 class="modal-title" id="myModalLabel160">Menu</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{route('submit_file')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <h6><label>Foydalanuvchini tanlang:</label></h6>
                                            <select class="select2 js-example-programmatic form-control" name="user_id">
                                                    @foreach ($users as $user)
                                                        <option value={{$user->id}}>{{$user->name}}   
                                                        </option>
                                                    @endforeach
                                            </select>
                                        </div>                                           
                                        <div class="form-group">
                                            <h6><label>Topshiriqni kiriting:</label></h6>
                                            <input class="form-control" type="text" name="topic" placeholder="Topic:">
                                        </div>
                                        <div class="form-group">
                                            <h6><label>Faylni belgilang:</label></h6>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="file_path" id="inputGroupFile01">
                                                <label class="custom-file-label" for="inputGroupFile01">Faylni yuklash</label>
                                             </div>     
                                        </div> 
                                        <div class="form-group">
                                            <h6><label>Topshiriq sanasini kiriting:</label></h6>
                                            <input class="form-control" type="date" name="term">
                                        </div>     
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" type="submit"> <i class="feather icon-send"></i> Yuborish </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>            
                </div>
            </div>
        <div class="card-content">
            <div class="table-responsive mt-1">
                <table class="table table-hover-animation mb-0">
                    <thead class="bg-light">
                    <tr class="text-800 bg-200">
                        <th>Kimga</th>
                        <th>Mavzu</th>
                        <th width = "160">Status </th>
                        <th width = "150">Info</th>
                        <th width = "200">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($sendfiles as $task)
                            <tr>
                                <td>
                                    <h6>
                                        <img class="media-object rounded-circle" src="{{asset($task->recorganization->photo)}}" alt="Avatar" height="30" width="30">
                                            {{$task->user->name}} 
                                    </h6>
                                </td>
                                <td><h6>{{$task->topic}}</h6></td>
                                    <td>
                                        @if ($task->rec_status == 0)
                                            <span class="badge bg-secondary"><span class="feather icon-eye-off" data-fa-transform="shrink-2"></span></span>                                                                   
                                        @else
                                            @if ($task->task_status == 0)
                                                <span class="badge bg-primary"><span class="feather icon-refresh-cw" data-fa-transform="shrink-2"></span></span>
                                            @else
                                                <span class="badge bg-success"><span class="feather icon-check-circle" data-fa-transform="shrink-2"></span></span>
                                            @endif
                                            
                                        @endif
                                        @if ($task->term > now())
                                            @if ($task->term->diffInDays() + 1 > 5)
                                                <span class="badge bg-success"> {{$task->term->diffInDays() + 1}} kun qoldi</span>
                                            @else
                                                <span class="badge bg-warning"> {{$task->term->diffInDays() + 1}} kun qoldi</span>
                                            @endif        
                                        @else
                                            <span class="badge bg-danger">Tugagan</span>
                                        @endif    
                                    </td>
                                    <td>
                                        <span class="badge bg-dark">{{$task->term->format('d-m-Y')}} gacha</span>       
                                    </td>
                                    <td>
                                        <a type="button" href="{{asset($task->file_path)}}" class="btn btn-icon btn-flat-info btn-sm" download="{{$task->topic}}" target="_blank" title="Faylni yuklash">
                                            <i class="feather icon-download"></i>
                                        </a>
                                        <button type="button" class="btn btn-icon btn-flat-dark btn-sm" data-toggle="modal" data-target="#edmodal{{$task->id}}">
                                            <i class="feather icon-edit"></i></button>
                                        <button type="button" class="btn btn-icon btn-flat-success btn-sm" data-toggle="modal" data-target="#sucmodal{{$task->id}}">
                                            <i class="feather icon-check-circle"></i></button>
                                        <button type="button" class="btn btn-icon btn-flat-primary btn-sm" data-toggle="modal" data-target="#shamodal{{$task->id}}">
                                            <i class="feather icon-share-2"></i></button>                             
                                        <button type="button" class="btn btn-icon btn-flat-danger btn-sm" data-toggle="modal" data-target="#delmodal{{$task->id}}">
                                            <i class="feather icon-trash"></i></button> 
                                    </td>

                                    <div class="modal fade text-left" id="edmodal{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-dark white">
                                                        <h5 class="modal-title" id="myModalLabel160">Taxrirlash</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{route('edit_file_task')}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                                <input type="hidden" name="editfileid" value="{{$task->id}}">
                                                                <div class="form-group">
                                                                    <h6><label>Foydalanuvchini belgilang:</label></h6>
                                                                    <select class="select2 js-example-programmatic form-control" name="usereditid" required>
                                                                        @foreach ($users as $user)
                                                                            @if ($task->recipient_id == $user->id)
                                                                                <option selected value={{$user->id}}>{{$user->name}}</option>
                                                                            @else
                                                                                <option value={{$user->id}}>{{$user->name}}</option>
                                                                            @endif             
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <h6><label>Mavzuni kiriting:</label></h6>
                                                                    <input class="form-control" name="topicedit" value="{{$task->topic}}" placeholder="Task:" required>
                                                                </div>   
                                                                <div class="form-group">
                                                                    <h6><label>Faylni belgilang:</label></h6>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" name="file_path_edit" id="inputGroupFile" required>
                                                                        <label class="custom-file-label" for="inputGroupFile">Faylni yuklash</label>
                                                                    </div>  
                                                                </div>   
                                                                <div class="form-group">
                                                                    <h6><label>Xat sanasini kiriting:</label></h6>
                                                                    <input class="form-control" type="date" value="{{$task->term->format('Y-m-d')}}" name="editdateid" required>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-dark" type="submit">Edit </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                    </div>

                                    <div class="modal fade text-left" id="shamodal{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary white">
                                                    <h5 class="modal-title" id="myModalLabel160">Yuborish</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>                      
                                                <form action="{{route('share_file_task')}}" method="get">
                                                    @csrf
                                                    <div class="modal-body">
                                                            <div class="form-group">
                                                                <h6><label>Foydalanvchini tanlang:</label></h6>
                                                                <select class="select2 js-example-programmatic form-control" name="usshareselect" required>
                                                                    <option value="">Kimga ?</option>
                                                                    @foreach ($users as $user)
                                                                            <option value={{$user->id}}>{{$user->name}}</option>                                                        
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <input type="hidden" name="usshareid" value="{{$task->id}}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary" type="submit"><i class="feather icon-send"></i> Yuborish</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade text-left" id="sucmodal{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-success white">
                                                    <h5 class="modal-title" id="myModalLabel160">Yakunlash</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>                             
                                                <form action="{{route('succ_file')}}" method="get">
                                                    @csrf
                                                    <div class="modal-body">
                                                            <div class="form-group">
                                                                Bajarilganlikni tasdiqlamoqchimisiz?
                                                            </div>
                                                            <input type="hidden" name="sucfileid" value="{{$task->id}}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-success" type="submit"><i class="feather icon-check-circle"></i> Xa, Bajarildi</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade text-left" id="delmodal{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger white">
                                                    <h5 class="modal-title" id="myModalLabel160">Yuborish</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>     
                                                <form action="{{route('del_file')}}" method="get">
                                                    @csrf
                                                    <div class="modal-body">
                                                            <div class="form-group">
                                                                Ushbu faylni o'chirmoqchimisiz ?
                                                            </div>
                                                            <input type="hidden" name="delfileid" value="{{$task->id}}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-danger" type="submit"><i class="feather icon-trash"></i> Xa, o'chirish</button>
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
