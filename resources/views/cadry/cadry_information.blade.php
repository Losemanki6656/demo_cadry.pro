@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">Ma'lumotlarni taxrirlash</h4>
        <div class="flex-shrink-0">
            <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('cadry_edit',['id' => $cadry->id])}}" role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                        <span class="d-none d-sm-block">Shaxsiy ma'lumotlari</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('cadry_information',['id' => $cadry->id])}}" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block">Ma'lumoti</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('cadry_career',['id' => $cadry->id])}}" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block">Mehnat faoliyati</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('cadry_realy',['id' => $cadry->id])}}" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                        <span class="d-none d-sm-block">Yaqin qarindoshlari</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('cadry_other',['id' => $cadry->id])}}" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block"> Qo'shimcha ma'lumotlar</span>
                    </a>
                </li>
            </ul>
        </div>
    </div><!-- end card header -->

    <div class="card-body">

        <!-- Tab panes -->
        <div class="tab-content text-muted">
            <div class="tab-pane" id="home2" role="tabpanel">
            </div>
            <div class="tab-pane active" id="profile2" role="tabpanel">
                <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="datatable_length">
                                <h5>Ma'lumotlari</h5>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="datatable_filter" class="dataTables_filter">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addinscadry"><i class="fa fa-plus"></i> Qo'shish</button>
                            </div>
                            <div class="modal fade" id="addinscadry" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ma'lumot qo'shish</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{route('add_ins_cadry',['id' => $cadry->id])}}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col">
                                                            <label>Qachondan:</label>
                                                            <input class="form-control infodate" type="text"
                                                                name="date1" required>
                                                        </div>
                                                        <div class="col">
                                                            <h6><label>Qachongacha:</label></h6>
                                                            <input class="form-control infodate" type="text"
                                                                name="date2" required>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="mb-3">
                                                    <label>Tamomlagan bilim yurti:</label>
                                                    <select class="form-select" onchange="selins(this)" id="inssel">
                                                        <option value="">-- Tanlash --</option>
                                                        @foreach ($institut as $ins)
                                                        <option value="{{$ins->name}}">{{$ins->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label>Tamomlagan bilim yurti:</label>
                                                    <textarea class="form-control" name="institut" id="ins" cols="30"
                                                        rows="2" required></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Yo'nalishi:</label>
                                                    <textarea class="form-control" name="speciality" id="" cols="30"
                                                        rows="2" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary" type="submit"> <i
                                                        class="fas fa-save"></i> Saqlash </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive table-bordered mt-2 mb-2">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th class="text-center fw-bold">Qachondan</th>
                                <th class="text-center fw-bold">Qachongacha</th>
                                <th class="text-center fw-bold">Bilim yurti nomi</th>
                                <th class="text-center fw-bold">Mutaxassisligi</th>
                                <th class="text-center fw-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($infoeducations as $infoeducation)
                            <tr>
                                <th class="text-center">{{$infoeducation->date1}}</th>
                                <td class="text-center">{{$infoeducation->date2}}</td>
                                <td class="text-center">{{$infoeducation->institut}}</td>
                                <td class="text-center">{{$infoeducation->speciality}}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-soft-secondary waves-effect"
                                        data-bs-toggle="modal" data-bs-target="#editinscadry{{$infoeducation->id}}">
                                        <i class="bx bx-edit font-size-16 align-middle"></i>
                                    </button>
                                    <button type="button" class="btn btn-soft-danger waves-effect"
                                        data-bs-toggle="modal" data-bs-target="#deleteinscadry{{$infoeducation->id}}">
                                        <i class="bx bx-trash font-size-16 align-middle"></i>
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="editinscadry{{$infoeducation->id}}" tabindex="-1" role="dialog"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ma'lumotni taxrirlash</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{route('cadry_info_edit',['id' => $infoeducation->id])}}"
                                            method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col">
                                                            <label>Qachondan:</label>
                                                            <input class="form-control infodate" type="text"
                                                                name="date1" value="{{$infoeducation->date1}}">
                                                        </div>
                                                        <div class="col">
                                                            <h6><label>Qachongacha:</label>
                                                                <input class="form-control infodate" type="text"
                                                                    name="date2" value="{{$infoeducation->date2}}">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="mb-3">
                                                    <label>Tamomlagan bilim yurti:</label>
                                                    <textarea class="form-control" name="institut" id="" cols="30"
                                                        rows="2">{{$infoeducation->institut}}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Yo'nalishi:</label>
                                                    <textarea class="form-control" name="speciality" id="" cols="30"
                                                        rows="2">{{$infoeducation->speciality}}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-dark" type="submit"> <i class="fas fa-edit"></i>
                                                    Taxrirlash </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="deleteinscadry{{$infoeducation->id}}" tabindex="-1"
                                role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ma'lumotni o'chirish</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{route('cadry_info_delete',['id' => $infoeducation->id])}}"
                                            method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <h6><label>Malumotlarni o'chirmoqchmisiz ?</label></h6>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-danger" type="submit"> <i
                                                        class="fas fa-trash"></i> Xa, O'chirish</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @endforeach

                        </tbody>
                    </table>
                </div>
                <form action="{{route('edit_cadry_us',['cadry' => $cadry->id])}}" method="post">
                    @csrf
                    <div class="row mt-1">
                        <div class="col-12">
                            <div class="table-responsive border rounded px-1 ">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Ma'lumoti</th>
                                            <th>Ilmiy darajasi:</th>
                                            <th>Ilmiy unvoni</th>
                                            <th>Millati</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-select" name="education_id" required>
                                                    @foreach ($info as $inf)
                                                    <option value="{{$inf->id}}" @if($inf->id == $cadry->education_id)
                                                        selected @endif>{{$inf->name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select" name="academictitle_id" required>
                                                    @foreach ($academictitle as $academictitl)
                                                    <option value="{{$academictitl->id}}" @if($academictitl->id ==
                                                        $cadry->academictitle_id) selected
                                                        @endif>{{$academictitl->name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select" name="academicdegree_id" required>
                                                    @foreach ($academicdegree as $academicdegr)
                                                    <option value="{{$academicdegr->id}}" @if($academicdegr->id ==
                                                        $cadry->academicdegree_id) selected
                                                        @endif>{{$academicdegr->name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                <select class="form-select" name="nationality_id" required>
                                                    @foreach ($naties as $natie)
                                                    <option value="{{$natie->id}}" @if($natie->id ==
                                                        $cadry->nationality_id) selected @endif>{{$natie->name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-12">
                            <div class="table-responsive border rounded px-1">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Chet tillari</th>
                                            <th>Partiyaviyligi</th>
                                            <th>Xarbiy unvoni</th>
                                            <th>Saylangan organlarga a'zoligi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="js-example-basic-multiple" name="language[]" multiple="multiple" style="width: 100%">
                                                    @foreach ($langues as $language)
                                                    <option value="{{$language->id}}" @if(in_array($language->id,
                                                        explode(',',$cadry->language) )) selected @endif>
                                                        {{$language->name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select" name="party_id" required>
                                                    @foreach ($parties as $party)
                                                    <option value="{{$party->id}}" @if($party->id == $cadry->party_id)
                                                        selected @endif>{{$party->name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    value="{{$cadry->military_rank}}" name="military_rank">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="{{$cadry->deputy}}"
                                                    name="deputy">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12 mt-1 d-flex flex-sm-row flex-column justify-content-end">
                                <button type="submit" class="btn btn-success mr-sm-1 mb-1 mb-sm-0"><i
                                        class="fa fa-save"></i> Saqlash</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="tab-pane" id="messages2" role="tabpanel">
            </div>
        </div>
    </div>
</div>


<div class="card">                                      
    <div class="card-body">
        <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_length" id="datatable_length">
                        <h5>Xorijda ta'lim olganlar</h5>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div id="datatable_filter" class="dataTables_filter">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addmed"><i class="fas fa-plus"></i> Qo'shish</button>
                    </div>
                    <div class="modal fade" id="addmed" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ma'lumot qo'shish</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{route('add_abroad_cadry',['id' => $cadry->id])}}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label>Qachondan:</label>
                                                    <input type="text" class="form-control" name="date1" required>   
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label>Qachongacha:</label>
                                                    <input type="text" class="form-control" name="date2" required>   
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label>Ta'lum muassasasi nomi:</label></h6>
                                            <input type="text" class="form-control" name="institute" required>   
                                        </div>    
                                        <div class="mb-3">
                                            <label>Yo'nalishi:</label>
                                            <input type="text" class="form-control" name="direction" required>   
                                        </div>   
                                        <div class="mb-3">
                                            <label>Mablag'lashtirish:</label>
                                            <select name="type_abroad" class="form-select">
                                                @foreach ($abroadnames as $abr)
                                                    <option value="{{$abr->id}}"> {{$abr->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>   
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" type="submit"> <i class="feather icon-save"></i> Saqlash </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Qachondan</th>
                        <th>Qachongacha</th>
                        <th>Ta'lim muassasasi</th>   
                        <th>Yo'nalishi</th>
                        <th>Mablag'lashtirish</th>                                                          
                    </tr>
                </thead>
                <tbody>
                    @foreach ($abroads as $abroad)
                    <tr>
                        <th>{{$abroad->date1}}</th>
                        <td >{{$abroad->date2}}</td>
                        <th>{{$abroad->institute}}</th>
                        <td >{{$abroad->direction}}</td>
                        <td >{{$abroad->typeabroad->name}}</td>
                        <td width="180">
                            <button type="button" class="btn btn-soft-secondary waves-effect"
                                data-bs-toggle="modal" data-bs-target="#editmed{{$abroad->id}}">
                                <i class="bx bx-edit font-size-16 align-middle"></i>
                            </button>
                            <button type="button" class="btn btn-soft-danger waves-effect"
                                data-bs-toggle="modal" data-bs-target="#deletemed{{$abroad->id}}">
                                <i class="bx bx-trash font-size-16 align-middle"></i>
                            </button> 
                        </td>
                    </tr>
                    <div class="modal fade" id="editmed{{$abroad->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ma'lumotni taxrirlash</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{route('edit_abroad_cadry',['id' => $abroad->id])}}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label>Qachondan:</label>
                                                    <input type="text" class="form-control" name="date1" value="{{$abroad->date1}}" required>   
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label>Qachongacha:</label>
                                                    <input type="text" class="form-control" name="date2" value="{{$abroad->date2}}" required>   
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label>Ta'lum muassasasi nomi:</label></h6>
                                            <input type="text" class="form-control" name="institute" value="{{$abroad->institute}}" required>   
                                        </div>    
                                        <div class="mb-3">
                                            <label>Yo'nalishi:</label>
                                            <input type="text" class="form-control" name="direction" value="{{$abroad->direction}}" required>   
                                        </div>   
                                        <div class="mb-3">
                                            <label>Mablag'lashtirish:</label>
                                            <select name="type_abroad" class="form-select">
                                                @foreach ($abroadnames as $abr)
                                                    <option value="{{$abr->id}}" @if ($abroad->type_abroad == $abr->id)
                                                        selected
                                                    @endif> {{$abr->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>   
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" type="submit"> <i class="fas fa-save"></i> Saqlash </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deletemed{{$abroad->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ma'lumotni taxrirlash</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{route('delete_abroad_cadry',['id' => $abroad->id])}}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Malumotni o'chirishni xoxlaysizmi ?</label>
                                        </div>    
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-danger" type="submit"> <i class="fas fa-trash"></i> Xa, O'chirish </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                </tbody>
            </table>

        </div>
    </div>
</div>

<div class="card">                                      
    <div class="card-body">
        <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_length" id="datatable_length">
                        <h5>Akademiyani o'qiganlar</h5>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div id="datatable_filter" class="dataTables_filter">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addacademic"><i class="fas fa-plus"></i> Qo'shish</button>
                    </div>
                    <div class="modal fade" id="addacademic" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ma'lumot qo'shish</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{route('add_academic_cadry',['id' => $cadry->id])}}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label>Qachondan:</label>
                                                    <input type="text" class="form-control" name="date1" required>   
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label>Qachongacha:</label>
                                                    <input type="text" class="form-control" name="date2" required>   
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label>Akademiya nomi</label>
                                            <select name="institute" class="form-select">
                                                @foreach ($academicnames as $academic)
                                                    <option value="{{$academic->id}}"> {{$academic->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>   
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" type="submit"> <i class="feather icon-save"></i> Saqlash </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Qachondan</th>
                        <th>Qachongacha</th>
                        <th>Akademiya nomi</th>      
                        <th>Action</th>                                                     
                    </tr>
                </thead>
                <tbody>
                    @foreach ($academics as $acs)
                    <tr>
                        <th>{{$acs->date1}}</th>
                        <td >{{$acs->date2}}</td>
                        <th>{{$acs->academicname->name}}</th>
                        <td width="180">
                            <button type="button" class="btn btn-soft-secondary waves-effect"
                                data-bs-toggle="modal" data-bs-target="#editacs{{$acs->id}}">
                                <i class="bx bx-edit font-size-16 align-middle"></i>
                            </button>
                            <button type="button" class="btn btn-soft-danger waves-effect"
                                data-bs-toggle="modal" data-bs-target="#deleteacs{{$acs->id}}">
                                <i class="bx bx-trash font-size-16 align-middle"></i>
                            </button> 
                        </td>
                    </tr>
                    <div class="modal fade" id="editacs{{$acs->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ma'lumotni taxrirlash</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{route('edit_academic_cadry',['id' => $acs->id])}}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label>Qachondan:</label>
                                                    <input type="text" class="form-control" name="date1" value="{{$acs->date1}}" required>   
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label>Qachongacha:</label>
                                                    <input type="text" class="form-control" name="date2" value="{{$acs->date2}}" required>   
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label>Akademiya nomi</label>
                                            <select name="institute" class="form-select">
                                                @foreach ($academicnames as $academic)
                                                    <option value="{{$academic->id}}" @if ($acs->institute == $academic->id)
                                                        selected
                                                    @endif> {{$academic->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>  
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" type="submit"> <i class="fas fa-save"></i> Saqlash </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteacs{{$acs->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ma'lumotni o'chirish</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{route('delete_academic_cadry',['id' => $acs->id])}}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Malumotni o'chirishni xoxlaysizmi ?</label>
                                        </div>    
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-danger" type="submit"> <i class="fas fa-trash"></i> Xa, O'chirish </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('input[type="checkbox"]').click(function () {
            if ($(this).prop("checked") == true) {
                var date2career = document.getElementById('date2_career');
                date2career.value = '';
                date2career.disabled = true;
            }
            else if ($(this).prop("checked") == false) {
                date2career.value = '';
                date2career.disabled = false;
            }
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $('.phone').inputmask('(99)-999-99-99');
    });

    $(document).ready(function () {
        $('.infodate').inputmask('9999');
    });

    $(document).ready(function () {
        $('.infodate2').inputmask('9999');
    });

    $(document).ready(function () {
        $('.passport').inputmask('AA 9999999');
    });



</script>

<script>
    function selins(sel) {
        var s = sel.value;
        var a = document.getElementById('ins')
        a.value = s;
    }
</script>

<script>
    $('.js-example-basic-multiple').select2();
</script>

@endsection