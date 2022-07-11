@extends('layouts.master')

@section('content')
    <link href="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Mehnat ta'tili</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">{{ __('messages.menu') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.xodimlar') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    <div class="checkout-tabs  animate__animated animate__fadeInLeft">
        <div class="row">
            <div class="col-xl-12">

                <div class="nav nav-pills flex-column flex-sm-row nav-justified" id="v-pills-tab" role="tablist"
                    aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-shipping-tab" data-bs-toggle="pill" href="#v-pills-shipping"
                        role="tab" aria-controls="v-pills-shipping" aria-selected="true">
                        <i class="bx bxs-briefcase d-block check-nav-icon mt-4 mb-2"></i>
                        <p class="fw-bold mb-4">Mehnat ta'tili</p>
                    </a>
                    <a class="nav-link" id="v-pills-payment-tab" data-bs-toggle="pill" href="#v-pills-payment"
                        role="tab" aria-controls="v-pills-payment" aria-selected="false" disabled>
                        <i class="bx bx-money d-block check-nav-icon mt-4 mb-2"></i>
                        <p class="fw-bold mb-4">Disable</p>
                    </a>
                    <a class="nav-link" id="v-pills-confir-tab" data-bs-toggle="pill" href="#v-pills-confir"
                        role="tab" aria-controls="v-pills-confir" aria-selected="false" disabled>
                        <i class="bx bx-badge-check d-block check-nav-icon mt-4 mb-2"></i>
                        <p class="fw-bold mb-4">Disable</p>
                    </a>
                </div>


                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-shipping" role="tabpanel"
                        aria-labelledby="v-pills-shipping-tab">

                        <div class="row">
                            <div class="col-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">{{ $cadry->last_name }} {{ $cadry->first_name }}
                                            {{ $cadry->middle_name }}</h4>
                                        <p class="card-title-desc mb-4">{{ $cadry->post_name }}</p>
                                        <table>
                                            <thead>
                                                <th width="170px">
                                                    Lavozim uchun
                                                </th>
                                                <th width="170px">
                                                    Staj uchun
                                                </th>
                                                <th width="170px">
                                                    Ta'til periodi
                                                </th>
                                                <th width="170px">
                                                    Ta'tilga chiqish sanasi
                                                </th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="me-3" style="width: 120px;">
                                                            <input type="text" value="02" name="demo_vertical">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="me-3" style="width: 120px;">
                                                            <input type="text" value="02" name="demo_vertical">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="date" style="width: 140px;" name="" value="{{now()->format('Y-m-d')}}" class="form-control" id="">
                                                    </td>
                                                    <td>
                                                        <input type="date" style="width: 140px;" name="" value="{{now()->format('Y-m-d')}}" class="form-control" id="">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table> <br>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                                    <input type="checkbox" class="form-check-input" id="cust1">
                                                    <label class="form-check-label" for="cust1">Yoshga to'lmaganlik</label>
                                                </div>
                                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                                    <input type="checkbox" class="form-check-input" id="cust2">
                                                    <label class="form-check-label" for="cust2"> 2 - guruh nogironimi
                                                        ?</label>
                                                </div>
                                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                                    <input type="checkbox" class="form-check-input" id="cust3">
                                                    <label class="form-check-label" for="cust3"> Og'ir mehnat sharoitidami
                                                        ?</label>
                                                </div>
                                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                                    <input type="checkbox" class="form-check-input" id="cust7">
                                                    <label class="form-check-label" for="cust7"> Nogiron farzandlari bormi
                                                        ?</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                                    <input type="checkbox" class="form-check-input" id="cust4">
                                                    <label class="form-check-label" for="cust4"> 12 yoshga to'lmagan
                                                        farzandlari bormi ?</label>
                                                </div>
                                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                                    <input type="checkbox" class="form-check-input" id="cust5">
                                                    <label class="form-check-label" for="cust5"> Donorlar ro'yxatiga a'zomi
                                                        ?</label>
                                                </div>
                                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                                    <input type="checkbox" class="form-check-input" id="cust6">
                                                    <label class="form-check-label" for="cust6"> Qo'shimcha 30 kun
                                                         </label>
                                                </div>
                                            </div>
                                        </div> <br>
                                        <table>
                                            <thead>
                                                <th width="170px">
                                                    Iqlim uchun
                                                </th>
                                                <th width="170px">
                                                    Qolgan kunlari
                                                </th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="me-3" style="width: 120px;">
                                                            <input type="text" value="0" name="demo_vertical">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="me-3" style="width: 120px;">
                                                            <input type="text" value="0" name="demo_vertical">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <span class="mb-0 text-center"><span class="fw-bold">0</span> kun</span> <br>
                                            <span class="ms-3"><i class="far fa-calendar-alt text-primary me-1"></i> 15/09/2021 dan</span>
                                            <span class="ms-3"><i class="far fa-calendar-alt text-primary me-1"></i> 15/09/2021 gacha</span>
                                        </div> <br> <br>
                                        <h6 class="text-center"> Buyruqni yuborish</h6>
                                        <select name="" id="sel_user" class="form-select">
                                            <option value="">Username</option>
                                        </select> <br> <br>
                                        <button class="btn btn-primary" style="width: 100%">
                                            <i class="bx bx-send font-size-16 align-middle me-2"></i> Yuborish</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="v-pills-payment" role="tabpanel" aria-labelledby="v-pills-payment-tab">
                        <div>
                            <h4 class="card-title">Payment Information</h4>
                            <p class="card-title-desc mb-4">Fill all information below</p>


                        </div>
                    </div>

                    <div class="tab-pane fade" id="v-pills-confir" role="tabpanel" aria-labelledby="v-pills-confir-tab">
                        <div class="card shadow-none border mb-0">
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/ecommerce-cart.init.js') }}"></script>
@endsection
