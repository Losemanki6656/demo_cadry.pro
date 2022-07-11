    @extends('layouts.masterfull')

    @section('content')
    
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
                                <form action="{{route('send_task')}}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <h6><label>Foydalanuvchini tanlang:</label></h6>
                                            <select class="select2 js-example-programmatic form-control" name="user_id">
                                                    @foreach ($users as $user)
                                                        <option value={{$user->id}}>{{$user->name}}   
                                                             <span class="fw-bold"></span>
                                                        </option>
                                                    @endforeach
                                            </select>
                                        </div>                                           
                                        <div class="form-group">
                                            <h6><label>Topshiriqni kiriting:</label></h6>
                                            <textarea class="form-control" name="task_text" placeholder="Topshiriq" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <h6><label>Topshiriq sanasini kiriting:</label></h6>
                                            <input class="form-control" type="date" id="date_1" name="date_1">
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
                        <thead>
                          <tr>
                            <th>Kimga</th>
                            <th>Mavzu</th>
                            <th style="min-width: 160px; width: 160px">Status</th>
                            <th>Sana</th>
                            <th style="min-width: 200px; width: 200px">Action</th>
                          </tr>
                        </thead>
                        <tbody>                                      
                            @foreach ($tasks as $task)
                                <tr> 
                                    <td> 
                                        <h6>
                                        <img class="media-object rounded-circle" src="{{asset($task->recorganization->photo)}}" alt="Avatar" height="30" width="30">
                                            {{$task->user->name}} 
                                        </h6>
                                    </td>
                                    <td ><h6>{{$task->task_text}}</h6></td>
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
                                        <button type="button" class="btn btn-icon btn-flat-dark btn-sm" data-toggle="modal" data-target="#edmodal{{$task->id}}">
                                            <i class="feather icon-edit"></i></button>
                                        <button type="button" class="btn btn-icon btn-flat-success btn-sm" data-toggle="modal" data-target="#succmodal{{$task->id}}">
                                            <i class="feather icon-check-circle"></i></button>
                                        <button type="button" class="btn btn-icon btn-flat-primary btn-sm" data-toggle="modal" data-target="#shamodal{{$task->id}}">
                                            <i class="feather icon-share-2"></i></button>                             
                                        <button type="button" class="btn btn-icon btn-flat-danger btn-sm" data-toggle="modal" data-target="#delmodal{{$task->id}}">
                                            <i class="feather icon-trash"></i></button>
                                            
                                            {{--<button type="button" class="btn btn-icon btn-flat-danger btn-del btn-sm"  data-id="{{$task->id}}">
                                                <i class="feather icon-trash"></i></button>--}}
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
                                                <form action="{{route('edit_simp_task')}}" method="get">
                                                    @csrf
                                                    <div class="modal-body">
                                                            <input type="hidden" name="tasksimpid" value="{{$task->id}}">
                                                            <div class="form-group">
                                                                <h6><label>Topshiriqni kiriting:</label></h6>
                                                                <textarea class="form-control" name="tasksimptext" placeholder="Task:" required>{{$task->task_text}}</textarea>
                                                            </div>      
                                                            <div class="form-group">
                                                                <h6><label>Topshiriqni sanasini kiriting:</label></h6>
                                                                <input class="form-control" type="date" value="{{$task->term->format('Y-m-d')}}" name="tasksimpterm"  required>
                                                            </div>      
                                                    </div>                                               
                                                    <div class="modal-footer">
                                                        <button class="btn btn-dark" type="submit"><i class="feather icon-edit"></i> Taxrirlash</button>
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
                                    
                                                <form action="{{route('share_simp_task')}}" method="get">
                                                    @csrf
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <h6><label>Foydalanuvchini tanlang:</label></h6>
                                                                <select class="select2 js-example-programmatic form-control" name="usersharesimpid" required>
                                                                    @foreach ($users as $user)
                                                                            <option value={{$user->id}}>{{$user->name}}</option>                                                        
                                                                    @endforeach
                                                                </select>
                                                                <input type="hidden" name="tasksharesimptext" value="{{$task->task_text}}">
                                                                <input type="hidden" name="tasksharesimpdate" value="{{$task->term}}">
                                                            </div>
                                                            
                                                        </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary" type="submit"><i class="feather icon-send"></i> Yuborish</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade text-left" id="succmodal{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-success white">
                                                    <h5 class="modal-title" id="myModalLabel160">Yakunlash</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('success_simp_task')}}" method="get">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            Bajarilganligini tasdiqlash?
                                                        </div>
                                                        <input type="hidden" name="sucsimpid" value="{{$task->id}}">  
                                                    </div>                       
                                                    <div class="modal-footer">
                                                        <button class="btn btn-success" type="submit"> <i class="feather icon-check-circle"></i> Bajarildi</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade text-left" id="delmodal{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger white">
                                                    <h5 class="modal-title" id="myModalLabel160">O'chrirsh</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('delete_simp_task')}}" method="get">
                                                    @csrf
                                                    <div class="modal-body">
                                                            <div class="form-group">
                                                                Topshiriqni o'chirish?
                                                            </div>
                                                            <input type="hidden" name="deletesimpid" value="{{$task->id}}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-danger" type="submit"><i class="feather icon-trash"></i> O'chirish</button>
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
    
    @push('scripts')


    <script>
        $(document).ready(function() {
            toastr.options.timeOut = 10000;
            @if (\Session::has('error'))
                toastr.error('{{ Session::get('error') }}');
            @elseif(\Session::has('success'))
                toastr.success('{{ Session::get('success') }}');
            @endif

            $('.btn-del').click(function () {
                let id = $(this).data('id');
                
                Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        confirmButtonClass: 'btn btn-primary',
                        cancelButtonClass: 'btn btn-danger ml-1',
                        buttonsStyling: false,
                    }).then(function (result) {
                        let url = '{{route('delete_simp_task')}}';

                        $.get(`${url}?deletesimpid=${id}`, function (data) {
                            
                            Swal.fire(
                            {
                                type: "success",
                                title: 'Deleted!',
                                text: 'Your file has been deleted.',
                                confirmButtonClass: 'btn btn-success',
                            }).then(function () {window.location.reload()})
                    })
                })
            })
        });

        
    </script>
    @endpush 

