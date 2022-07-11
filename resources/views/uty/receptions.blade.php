@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Taklif va Murojatlar</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Exodim</a></li>
                    <li class="breadcrumb-item active">Taklif va Murojatlar</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->


<div class="row">
    <div class="col-lg-12">

        <div class="text-center mb-4">
            <ul class="nav nav-pills card justify-content-center d-inline-block shadow py-1 px-2" id="pills-tab" role="tablist">
                <li class="nav-item d-inline-block">
                    <a class="nav-link px-3 rounded active monthly" id="Monthly" data-bs-toggle="pill" href="#month" role="tab" aria-controls="Month" aria-selected="true">Takliflar</a>
                </li>
                <li class="nav-item d-inline-block">
                    <a class="nav-link px-3 rounded arxive" id="Arxive" data-bs-toggle="pill" href="#arxiv" role="tab" aria-controls="Arxiv" aria-selected="false">Qabul qilinganlar <span
                                class="badge bg-primary rounded text-white"> Arxiv </span></a>
                </li>
                <li class="nav-item d-inline-block">
                    <a class="nav-link px-3 rounded yearly" id="Yearly" data-bs-toggle="pill" href="#year" role="tab" aria-controls="Year" aria-selected="false">Murojatlar <span
                                class="badge bg-success rounded text-white"> Anonim </span></a>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade active show" id="month" role="tabpanel" aria-labelledby="monthly">
                
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h5 class="card-title">Takliflar <span class="text-muted fw-normal ms-2">(0)</span></h5>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                @foreach ($receptions as $item)
                                    @if ($item->status_read == false && $item->user_id != 1)
                                        <tr>
                                            <td width="100px">
                                                <div class="avatar-md me-4">
                                                    <img src="{{asset($item->user->userorganization->photo)}}" class="img-fluid rounded-circle" alt="">
                                                </div>
                                            </td>
                                            <td  width="300px"><a href="" class="text-body fw-bold">{{$item->user->userorganization->organization->name}}</a> </td>
                                            <td class="text-center">{{$item->text_rec}}</td>
                                            <td class="text-center" width="120px">
                                                <div class="text-end">
                                                    <ul class="mb-1 ps-0">
                                                        <li class="bx bx-star text-warning"></li>
                                                        <li class="bx bx-star text-warning"></li>
                                                        <li class="bx bx-star text-warning"></li>
                                                        <li class="bx bx-star text-warning"></li>
                                                        <li class="bx bx-star text-warning"></li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td width="150px" class="text-center">
                                            
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#infos{{$item->id}}" class="btn btn-warning btn-sm btn-rounded">
                                                        Javobni ko'rish
                                                    </button>
                                            </td>
                                        </tr>
                                    
                                    @endif
                                    <div class="modal fade" id="infos{{$item->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Ma'lumotlarni ko'chirish</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <p>
                                                                @if (count($item->resultreception))
                                                                     {{$item->resultreception[0]->rec_text}}
                                                                @endif
                                                            </p>
                                                        </div>      
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row my-5">
                    <div class="col-xl-12">
                        <div class="text-center">
                            <h4 class="card-title font-size-18">Taklif yuborish</h4>
                        <p class="card-title-desc mb-4 pb-2">Exodim dasturini rivojlantirish va qulaylashtirish maqsadida takliflar.
                        </p>
                        </div>
                
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" action="{{route('send_receptions')}}">
                                            @csrf
                                            <div class="row">
                                                    <div class="mb-3">
                                                        <label for="productname">Taklif matni</label>
                                                        <textarea class="form-control" cols="30" rows="5" name="text_rec"></textarea>
                                                    </div>
                
                                            </div>
                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Yuborish</button>
                                            </div>
                                        </form>
                
                                    </div>
                                </div>
                            </div>
                        </div>
                
                
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="arxiv" role="tabpanel" aria-labelledby="arxive">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h5 class="card-title">Takliflar <span class="text-muted fw-normal ms-2">(0)</span></h5>
                        </div>
                    </div>

                    <div class="col-md-6">

                    </div>
                </div>

                <div class="row">
                    <div class="">
                        <div class="table">
                            <table class="table align-middle">
                                <tbody>
                                    @foreach ($receptions as $item)
                                        @if ($item->status_read == true && $item->user_id != 1)
                                            <tr>
                                                <td width="100px">
                                                    <div class="avatar-md me-4">
                                                        <img src="{{asset($item->user->userorganization->photo)}}" class="img-fluid rounded-circle" alt="">
                                                    </div>
                                                </td>
                                                <td  width="300px"><a href="" class="text-body fw-bold">{{$item->user->userorganization->organization->name}}</a> </td>
                                                <td class="text-center">{{$item->text_rec}}</td>
                                                <td class="text-center" width="120px">
                                                    <div class="text-end">
                                                        <ul class="mb-1 ps-0">
                                                            <li class="bx bxs-star text-warning"></li>
                                                            <li class="bx bxs-star text-warning"></li>
                                                            <li class="bx bxs-star text-warning"></li>
                                                            <li class="bx bxs-star text-warning"></li>
                                                            <li class="bx bxs-star text-warning"></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td width="150px" class="text-center">
                                                        <button  type="button" class="btn btn-warning btn-sm btn-rounded">
                                                            Javobni ko'rish
                                                        </button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="year" role="tabpanel" aria-labelledby="yearly">
               
            </div>
        </div>
        <!-- end tab content -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->





@endsection

@section('scripts')
<script>
    $(document).ready(function() {
            @if (\Session::has('msg'))
                @if (Session::get('msg') == 1)
                    alertify.success("Taklif muvaffaqqiyatli yuborildi!");
                @endif
            @endif
        });
</script>

@endsection
