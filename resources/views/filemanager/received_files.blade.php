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
                <thead class="bg-light">
                <tr class="text-800 bg-200">
                    <th>Kimdan</th>
                    <th>Mavzu</th>
                    <th width = "150">Status</th>
                    <th width = "150">Info</th>
                    <th width = "200">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($sendfiles as $task)
                        <tr>
                            <td >
                                <h6>
                                    <img class="media-object rounded-circle" src="{{asset($task->sendorganization->photo)}}" alt="Avatar" height="30" width="30">
                                        {{$task->userrec->name}} 
                                </h6>
                            </td>
                            <td><h6>{{$task->topic}}</h6></td>                            
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
                                    <a type="button" href="{{asset($task->file_path)}}" class="btn btn-icon btn-flat-info btn-sm" download="{{$task->topic}}" target="_blank" title="Faylni yuklash">
                                        <i class="feather icon-download"></i>
                                    </a>
                                    <button type="button" class="btn btn-icon btn-flat-primary btn-sm" data-toggle="modal" data-target="#shamodal{{$task->id}}">
                                        <i class="feather icon-share-2"></i></button> 
                                     @if ($task->task_status == 0)
                                        <button type="button" class="btn btn-icon btn-flat-success btn-sm" data-toggle="modal" data-target="#sucmodal{{$task->id}}">
                                            <i class="feather icon-check-circle"></i></button> 
                                     @endif
                                </td>

                                <div class="modal fade text-left" id="shamodal{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary white">
                                                <h5 class="modal-title" id="myModalLabel160">Yuborish</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                
                                            <form action="{{route('share_rec_file')}}" method="get">
                                                @csrf
                                                <div class="modal-body">
                                                        <div class="form-group">
                                                            <h6><label>Foydalanuvchini tanlang:</label></h6>
                                                            <select class="select2 js-example-programmatic form-control" name="usshareselect" required>
                                                                <option value="">Share Select User</option>
                                                                @foreach ($users as $user)
                                                                         <option value={{$user->id}}>{{$user->name}}</option>                                                        
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <h6><label>Mavzuni kiriting:</label></h6>
                                                            <input type="text" class="form-control" name="topic" value="{{$task->topic}}" required>
                                                        </div>                                                       
                                                        <div class="form-group">
                                                            <h6><label>Xat sanasini kiriting:</label></h6>
                                                            <input type="date" class="form-control" name="dateshare" value="{{$task->term->format('Y-m-d')}}" required>
                                                        </div>
                                                        <input type="hidden" name="file_path_share" value="{{$task->file_path}}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-primary" type="submit"><i class="feather icon-send"></i> Share</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade text-left" id="sucmodal{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success white">
                                                <h5 class="modal-title" id="myModalLabel160">Bajarishni tasdiqlash</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                
                                            <form action="{{route('rec_suc_file')}}" method="get">
                                                @csrf
                                                <div class="modal-body">
                                                        <div class="form-group">
                                                           <h5> Bajarishni tasdiqlamoqchimisiz ? </h5>
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
   <script>
       function openfile(id) {
        let s = $("#file-input"+id).val();
        window.open(s);
        }
   </script>
@endsection