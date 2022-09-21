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
            <div class="card" id="dis">
                @if ($status == false)
                    <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-0"
                        role="alert">
                        <i class="mdi mdi-alert-circle-outline label-icon"></i><strong>Info</strong> - Ushbuu bo'lim Exodim dasturi
                        1C dasturi bilan bo'glangan korxonalarda ishlaydi!
                    </div>
                @endif
                <form action="{{ route('addVacation1C') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="d-flex flex-wrap align-items-center mb-4">
                                    <label class="fw-bold text-primary">Xodimni kiriting</label>
                                    <select class="kadr" name="cadrySeach" id="cadrySeach" style="width: 100%" required>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <label class="fw-bold text-primary">Prikaz raqamini kiriting</label>
                                <input type="text" class="form-control" name="pr_number">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12 col-xl-4 col-xxl-2 col-lg-4 col-md-4 col-sm-6">
                                <div class="me-3">
                                    <label class="fw-bold"> Asosiy kun</label>
                                    <input type="number" value="15" name="main_day" id="main_day"
                                        class="demo_vertical">
                                </div>
                            </div>
                            <div class="col-12 col-xl-4 col-xxl-2 col-lg-4 col-md-4 col-sm-6">
                                <div class="me-3">
                                    <label class="fw-bold"> Lavozim uchun</label>
                                    <input type="number" value="0" name="for_staff" id="for_staff"
                                        class="demo_vertical">
                                </div>
                            </div>
                            <div class="col-12 col-xl-4 col-xxl-2 col-lg-4 col-md-4 col-sm-6">
                                <div class="me-3">
                                    <label class="fw-bold"> Staj uchun</label>
                                    <input type="number" value="0" name="for_experience" id="for_experience"
                                        class="demo_vertical">
                                </div>
                            </div>
                            <div class="col-12 col-xl-4 col-xxl-2 col-lg-4 col-md-4 col-sm-6">
                                <div class="me-3">
                                    <label class="fw-bold"> Iqlim uchun</label>
                                    <input type="number" value="0" name="for_climate" id="for_climate"
                                        class="demo_vertical">
                                </div>
                            </div>
                            <div class="col-12 col-xl-4 col-xxl-2 col-lg-4 col-md-4 col-sm-6">
                                <div class="me-3">
                                    <label class="fw-bold"> Qolgan kunlari</label>
                                    <input type="number" value="0" name="for_other" id="for_other"
                                        class="demo_vertical">
                                </div>
                            </div>
                            <div class="col-12 col-xl-4 col-xxl-2 col-lg-4 col-md-4 col-sm-6">
                                <div class="me-3">
                                    <label class="fw-bold"> Og'ir mehnat sh.</label>
                                    <input type="number" value="0" name="for_hardwork" id="for_hardwork"
                                        class="demo_vertical">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" class="form-check-input" name="underage" id="underage">
                                    <label class="form-check-label" for="cust1">Yoshga
                                        to'lmaganlik</label>
                                </div>
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" class="form-check-input" name="invalid" id="invalid">
                                    <label class="form-check-label" for="cust2"> 2 - guruh nogironimi
                                        ?</label>
                                </div>
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" class="form-check-input" name="invalid_child"
                                        id="invalid_child">
                                    <label class="form-check-label" for="cust7"> Nogiron
                                        farzandlari bormi
                                        ?</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" class="form-check-input" name="childrens" id="childrens">
                                    <label class="form-check-label" for="cust4"> 12 yoshga
                                        to'lmagan
                                        farzandlari bormi ?</label>
                                </div>
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" class="form-check-input" name="donor" id="donor">
                                    <label class="form-check-label" for="cust5"> Donorlar
                                        ro'yxatiga a'zomi
                                        ?</label>
                                </div>
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" class="form-check-input" name="more" id="more">
                                    <label class="form-check-label" for="cust5"> Marosimlar uchun </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col"></div>
                            <div class="col-4">
                                <label class="fw-bold"> Ta'til periodi</label>
                                <input type="date" name="period1" value="{{ now()->format('Y-m-d') }}"
                                    class="form-control" id="period1">
                            </div>
                            <div class="col-4">
                                <label class="fw-bold"> Ta'tilga chiqish sanasi</label>
                                <input type="date" name="date1_1c" value="{{ now()->format('Y-m-d') }}"
                                    class="form-control" id="date1_1c">
                            </div>
                            <div class="col"></div>
                        </div>
                        <button type="button" onclick="resultVacation()" class="btn btn-outline-primary mb-4"
                            style="width: 100%"> Xisoblash</button>
                        <div class="row mb-4">
                            <div class="col">
                            </div>
                            <div class="col">
                                <label class="fw-bold"> Qachongacha</label>
                                <input type="date" class="form-control" value="" id="date2_1c"
                                    name="date2_1c" required>
                            </div>
                            <div class="col">
                                <label class="fw-bold"> Umumiy ta'til kuni</label>
                                <input type="text" value="15" name="all_day" id="all_day"
                                    class="demo_vertical" required>
                            </div>
                            <div class="col"></div>
                        </div>
                        <input type="hidden" name="period2" id="period2">
                        <button type="submit" class="btn btn-outline-success" style="width: 100%"> Yuborish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    var status = {!! $status !!};
    if(status == false)
    $("#dis").find("*").prop('disabled', true);
</script>
    <script>
        function resultVacation() {
            var holidays_back = {!! $holidays !!};
            var holidays = [];
            holidays_back.forEach(hols);

            function hols(item, index) {
                holidays[index] = item.holiday_date;
            }

            if ($('#main_day').val() == '') var mainday = 0;
            else
                var mainday = parseInt($('#main_day').val());

            if ($('#for_staff').val() == '') var for_staff = 0;
            else
                var for_staff = parseInt($('#for_staff').val());

            if ($('#for_experience').val() == '') var for_experience = 0;
            else
                var for_experience = parseInt($('#for_experience').val());

            if ($('#for_climate').val() == '') var for_climate = 0;
            else
                var for_climate = parseInt($('#for_climate').val());

            if ($('#for_other').val() == '') var for_other = 0;
            else
                var for_other = parseInt($('#for_other').val());

            if ($('#for_hardwork').val() == '') var for_hardwork = 0;
            else
                var for_hardwork = parseInt($('#for_hardwork').val());

            var underage = $("#underage").is(":checked");
            var invalid = $("#invalid").is(":checked");
            var invalid_child = $("#invalid_child").is(":checked");
            var childrens = $("#childrens").is(":checked");
            var donor = $("#donor").is(":checked");
            var more = $("#more").is(":checked");
            var date1_1c = $('#date1_1c').val();
            var period1 = $('#period1').val();
            var allday = 0;

            const dateperiod = new Date(period1);
            dateperiod.setYear(dateperiod.getFullYear() + 1);
            $('#period2').val(date_format(dateperiod));

            if (invalid_child == true) invalid_child_day = 3;
            else invalid_child_day = 0;
            if (childrens == true) childrens_day = 3;
            else childrens_day = 0;
            if (donor == true) donor_day = 2;
            else donor_day = 0;
            if (more == true) more_day = 3;
            else more_day = 0;

            const date = new Date(date1_1c);

            if (underage == true || invalid == true) {
                allday = for_staff + for_climate + for_experience + for_hardwork + for_other + more_day + donor_day + childrens_day +
                    invalid_child_day;
                date.setDate(date.getDate() + 30);
                c = allday + 30;
            } else {
                allday = mainday + for_climate + for_staff + for_experience + for_hardwork + for_other + more_day + donor_day +
                    childrens_day + invalid_child_day;
                c = allday;
            }

            for (let i = 1; i <= allday - 1; i++) {

                for (let j = 0; j <= holidays.length; j++) {
                    if (date_format(date) == holidays[j]) date.setDate(date.getDate() + 1);
                }

                if (date.getDay() == 0) date.setDate(date.getDate() + 1);

                date.setDate(date.getDate() + 1);
            }

            $('#date2_1c').val(date_format(date));
            $('#all_day').val(c);

            function date_format(dateformat) {
                if (dateformat.getMonth() + 1 < 10) moth = '' + 0 + (dateformat.getMonth() + 1);
                else moth = (dateformat.getMonth() + 1);
                if (dateformat.getDate() < 10) day = '' + 0 + (dateformat.getDate());
                else day = (dateformat.getDate());
                return dateformat.getFullYear() + '-' + moth + '-' + day;
            }
        }
    </script>
    <script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script>
        $(".demo_vertical").TouchSpin({
            verticalbuttons: !0
        });
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
