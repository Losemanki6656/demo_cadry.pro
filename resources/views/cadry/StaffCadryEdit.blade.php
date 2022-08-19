@extends('layouts.master')
@section('content')
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
        <div class="col-xl-6">
            <div class="card">
                <form action="{{ route('successEditStaffCadry', ['id' => $item->id]) }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="fw-bold text-primary">FIO:</label>
                            <h5>{{ $item->cadry->last_name }} {{ $item->cadry->first_name }} {{ $item->cadry->middle_name }}
                            </h5>
                            <input type="hidden" name="cadr" id="cadr" value="{{ $item->cadry_id }}">
                        </div>
                        <div class="mb-4">
                            <label class="fw-bold text-primary">Bo'linma:</label>
                            <h5>{{ $item->department->name }}</h5>
                        </div>
                        <div class="mb-4">
                            <label class="fw-bold text-primary">Lavozimi:</label>
                            <h5>{{ $item->staff_full }}</h5>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold text-primary">Stavka</label>
                            <h5>{{ $item->stavka }}</h5>
                        </div>

                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <label class="fw-bold text-primary">Bo'linmani tanlang</label>
                            <select class="js-example-basic-single department" name="department_id" id="department_id"
                                style="width: 100%" required>
                                <option value="{{ $item->department_id }}">{{ $item->department->name }}</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold text-primary">Lavozimni tanlang</label>
                            <select name="staff_id" id="staff_id" style="width: 100%" class="js-example-basic-single staff"
                                required>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id }}" @if ($item->department_staff_id == $staff->id) selected @endif>
                                        {{ $staff->id }} - {{ $staff->staff_full }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <div class="row">
                                <div class="col">
                                    <span class="fw-bold text-primary">Stavka</span>
                                    <input type="number" name="st_1" value="{{ $item->stavka }}" class="form-control"
                                        step="0.01">
                                </div>
                                <div class="col">
                                    <span class="fw-bold text-primary">Faoliyat turi</span>
                                    <select name="staff_status" id="staff_status" class="form-select">
                                        <option value="0" @if ($item->staff_status == false) selected @endif>Asosiy
                                        </option>
                                        <option value="1" @if ($item->staff_status == true) selected @endif>O'rindosh
                                        </option>
                                    </select>
                                </div>
                                <div class="col">
                                    <span class="fw-bold text-primary">Lavozim sanasi</span>
                                    <input type="date" name="staff_date" value="{{ $item->staff_date }}"
                                        class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <input class="form-check-input" type="checkbox" id="careerCheck" onclick="CareerFunc()"
                                name="careerCheck">
                            <label class="form-check-label" for="careerCheck">
                                Xodim mehnat faoliyatiga yangi lavozim nomi qo'shilsinmi ?!
                            </label>
                        </div>

                        <div class="mb-4" id="carSt" style="display: none">
                            <label class="fw-bold text-primary">Mehnat faoliyatidagi qaysi lavozim yakunlanishini
                                ko'rsating</label>
                            <select name="career" id="career" style="width: 100%" class="career">
                            </select>
                        </div>

                        <button class="btn btn-outline-primary" type="submit" style="width: 100%"> O'zgartirish
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function CareerFunc() {
                if ($('#careerCheck').is(':checked')) {
                    var x = document.getElementById("carSt");
                    x.style.display = "block";
                    let cadry_id = $('#cadr').val();
                    $.ajax({
                        url: '{{ route('loadCareer') }}',
                        type: 'GET',
                        dataType: 'json',
                        cache: false,
                        data: {
                            cadry_id: cadry_id
                        },
                        success: function(data) {
                            var len = 0;
                            if (data != null) {
                                len = data.length;
                            }

                            if (len > 0) {
                                $("#career").empty();
                                for (var i = 0; i < len; i++) {
                                    console.log(len);
                                    var id = data[i].id;
                                    var date1 = data[i].date1;
                                    var date2 = data[i].date2;
                                    var name = data[i].staff;
                                    var option = "<option value='" + id + "'>" + date1 + " - " + date2 + " - " +
                                        name +
                                        "</option>";
                                    $("#career").append(option);
                                }
                            } else {
                                $("#career").empty();
                                var option = "<option value=''>" + "Bo'sh ish o'rni mavjud emas!" + "</option>";
                                $("#career").append(option);
                            }
                        }
                    });
                } else {
                    var x = document.getElementById("carSt");
                    x.style.display = "none";
                }
            }
        </script>
        <script>
            $('#department_id').change(function(e) {
                let department_id = $('#department_id').val();
                $.ajax({
                    url: '{{ route('loadVacan') }}',
                    type: 'GET',
                    dataType: 'json',
                    cache: false,
                    data: {
                        department_id: department_id
                    },
                    success: function(data) {
                        var len = 0;
                        if (data != null) {
                            len = data.length;
                        }

                        if (len > 0) {
                            $("#staff_id").empty();
                            for (var i = 0; i < len; i++) {
                                console.log(len);
                                var id = data[i].id;
                                var name = data[i].staff_full;
                                var option = "<option value='" + id + "'>" + id + " - " + name +
                                    "</option>";
                                $("#staff_id").append(option);
                            }
                        } else {
                            $("#staff_id").empty();
                            var option = "<option value=''>" + "Bo'sh ish o'rni mavjud emas!" + "</option>";
                            $("#staff_id").append(option);
                        }
                    }
                });
            })
        </script>
    @endpush
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var msg = '{{ Session::get('msg') }}';
            var exist = '{{ Session::has('msg') }}';
            if (exist) {
                if (msg == 2) {
                    Swal.fire({
                        title: "Amalga oshirilmadi",
                        text: "Xodimning stavkasi amaldagi bo'sh lavozim stavkasiga to'gri kelmadi!",
                        icon: "warning",
                        confirmButtonColor: "#1c84ee"
                    });
                } else if (msg == 1) {
                    Swal.fire({
                        title: "Good!",
                        text: "Xodim lavozimi o'zgartirildi",
                        icon: "success",
                        confirmButtonColor: "#1c84ee",
                    }).then(function() {
                        location.reload();
                    });
                }
            }

        });
    </script>
    <script>
        $('.staff').select2();
        $('.career').select2();
    </script>
    <script>
        $('.department').select2({
            ajax: {
                url: '{{ route('loadDepartment') }}',
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
                                text: item.name,
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
            placeholder: "Bo'linmani tanlang",
            minimumInputLength: 1,
        });
    </script>
@endsection
