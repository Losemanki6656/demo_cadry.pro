@extends('layouts.master')
@section('content')
    <link href="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Lavozimlar</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Bo'limlar</a></li>
                        <li class="breadcrumb-item active">Lavozimlar</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <form action="{{ route('addVacation') }}" method="post">
                    @csrf
                    <div class="card-body">

                        <div class="mb-4">
                            <label class="fw-bold text-primary">Ta'til turini tanlang</label>
                            <select class="form-select" name="status_vacation" id="status_vacation" required>
                                <option value="0">Mehnat ta'tili</option>
                                <option value="1">Bola parvarish ta'tili</option>
                            </select>
                        </div>

                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <label class="fw-bold text-primary">Xodimni kiriting</label>
                            <select class="js-example-basic-single cadry" name="cadry_id" id="cadry_id" style="width: 100%"
                                required>
                            </select>
                        </div>
                        <div class="mb-4">
                            <div class="row">
                                <div class="col">
                                    <span class="fw-bold text-primary">Qachondan</span>
                                    <input type="date" name="date1" id="date1" class="form-control" required>
                                </div>
                                <div class="col">
                                    <span class="fw-bold text-primary">Qachongacha</span>
                                    <input type="date" name="date2" id="date2" class="form-control">
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-success" type="submit" style="width: 100%"> Saqlash
                        </button>

                    </div>
                </form>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <form action="{{ route('addVacation') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <label class="fw-bold text-primary">Xodimni kiriting</label>
                            <select class="kadr" name="cadrySeach" id="cadrySeach" style="width: 100%" required>
                            </select>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12 col-xl-4 col-xxl-2 col-lg-4 col-md-4 col-sm-6">
                                <div class="me-3">
                                    <label class="fw-bold"> Asosiy kun</label>
                                    <input type="text" value="15" name="demo_vertical" class="demo_vertical">
                                </div>
                            </div>
                            <div class="col-12 col-xl-4 col-xxl-2 col-lg-4 col-md-4 col-sm-6">
                                <div class="me-3">
                                    <label class="fw-bold"> Lavozim uchun</label>
                                    <input type="text" value="0" name="demo_vertical" class="demo_vertical">
                                </div>
                            </div>
                            <div class="col-12 col-xl-4 col-xxl-2 col-lg-4 col-md-4 col-sm-6">
                                <div class="me-3">
                                    <label class="fw-bold"> Staj uchun</label>
                                    <input type="text" value="0" name="demo_vertical" class="demo_vertical">
                                </div>
                            </div>
                            <div class="col-12 col-xl-4 col-xxl-2 col-lg-4 col-md-4 col-sm-6">
                                <div class="me-3">
                                    <label class="fw-bold"> Iqlim uchun</label>
                                    <input type="text" value="0" name="demo_vertical" class="demo_vertical">
                                </div>
                            </div>
                            <div class="col-12 col-xl-4 col-xxl-2 col-lg-4 col-md-4 col-sm-6">
                                <div class="me-3">
                                    <label class="fw-bold"> Qolgan kunlari</label>
                                    <input type="text" value="0" name="demo_vertical" class="demo_vertical">
                                </div>
                            </div>
                            <div class="col-12 col-xl-4 col-xxl-2 col-lg-4 col-md-4 col-sm-6">
                                <div class="me-3">
                                    <label class="fw-bold"> Og'ir mehnat sh.</label>
                                    <input type="text" value="0" name="demo_vertical" class="demo_vertical">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" class="form-check-input" id="cust1">
                                    <label class="form-check-label" for="cust1">Yoshga
                                        to'lmaganlik</label>
                                </div>
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" class="form-check-input" id="cust2">
                                    <label class="form-check-label" for="cust2"> 2 - guruh nogironimi
                                        ?</label>
                                </div>
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" class="form-check-input" id="cust7">
                                    <label class="form-check-label" for="cust7"> Nogiron
                                        farzandlari bormi
                                        ?</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" class="form-check-input" id="cust4">
                                    <label class="form-check-label" for="cust4"> 12 yoshga
                                        to'lmagan
                                        farzandlari bormi ?</label>
                                </div>
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" class="form-check-input" id="cust5">
                                    <label class="form-check-label" for="cust5"> Donorlar
                                        ro'yxatiga a'zomi
                                        ?</label>
                                </div>
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" class="form-check-input" id="cust6">
                                    <label class="form-check-label" for="cust6"> Qo'shimcha 30 kun
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col"></div>
                            <div class="col">
                                <label class="fw-bold"> Ta'til periodi</label>
                                <input type="date" name=""
                                    value="{{ now()->format('Y-m-d') }}" class="form-control" id="">
                            </div>
                            <div class="col">
                                <label class="fw-bold"> Ta'tilga chiqish sanasi</label>
                                <input type="date" name=""
                                    value="{{ now()->format('Y-m-d') }}" class="form-control" id="">
                            </div>
                            <div class="col"></div>
                        </div>
                        <button type="button" class="btn btn-outline-primary mb-4" style="width: 100%"> Xisoblash</button>
                        <div class="row mb-4">
                            <div class="col">
                            </div>
                            <div class="col">
                                <label class="fw-bold"> Qachongacha</label>
                                <input type="date" class="form-control" value="">
                            </div>
                            <div class="col">
                                <label class="fw-bold"> Umumiy ta'til kuni</label>
                                <input type="text" value="15" name="demo_vertical" class="demo_vertical">
                            </div>
                            <div class="col"></div>
                        </div>
                        <button type="button" class="btn btn-outline-success" style="width: 100%"> Yuborish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script>
        $(".demo_vertical").TouchSpin({
            verticalbuttons: !0
        });
    </script>
    <script>
       
    </script>
    <script>
        $(document).ready(function() {
            var msg = '{{ Session::get('msg') }}';
            var exist = '{{ Session::has('msg') }}';
            if (exist) {
                if (msg == 2) {
                    Swal.fire({
                        title: "Amalga oshirilmadi",
                        text: "Xodimning jinsi ta'til turiga to'g'ri kelmaydi!",
                        icon: "warning",
                        confirmButtonColor: "#1c84ee"
                    }).then(function() {
                        location.reload();
                    });
                }
            }

        });
    </script>
    <script>
        $('.cadry').select2({
            ajax: {
                url: '{{ route('loadCadry') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.last_name + ' ' + item.first_name + ' ' + item.middle_name,
                                id: item.id
                            }
                        }),
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Xodim ismini kiriting',
            minimumInputLength: 1,
        });
    </script>
    <script>
        $('.kadr').select2({
            ajax: {
                url: '{{ route('loadCadry') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.last_name + ' ' + item.first_name + ' ' + item.middle_name,
                                id: item.id
                            }
                        }),
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Xodim ismini kiriting',
            minimumInputLength: 1,
        });
    </script>
@endsection
