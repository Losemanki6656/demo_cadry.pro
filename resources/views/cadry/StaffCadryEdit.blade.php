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
        <div class="col-xl-4">
            <div class="card">
                <form action="{{ route('successEditStaffCadry', ['id' => $item->id]) }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="mb-4">
                            <label>FIO:</label>
                            <h5>{{ $item->cadry->last_name }} {{ $item->cadry->first_name }} {{ $item->cadry->middle_name }}
                            </h5>
                        </div>
                        <div class="mb-4">
                            <label>Bo'linma:</label>
                            <h5>{{ $item->department->name }}</h5>
                        </div>
                        <div class="mb-4">
                            <label>Lavozimi:</label>
                            <h5>{{ $item->staff_full }}</h5>
                        </div>

                        <div class="mb-4">
                            <label>Stavka</label>
                            <h5>{{ $item->stavka }}</h5>
                        </div>

                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <label>Bo'linmani tanlang</label>
                            <select class="js-example-basic-single department" name="department_id" id="department_id"
                                style="width: 100%" required>
                                <option value="{{ $item->department_id }}">{{ $item->department->name }}</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label>Lavozimni tanlang</label>
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
                                    <span>Stavka</span>
                                    <input type="number" name="st_1" value="{{ $item->stavka }}" class="form-control"
                                        step="0.01">
                                </div>
                                <div class="col">
                                    <span>Faoliyat turi</span>
                                    <select name="staff_status" id="staff_status" class="form-select">
                                        <option value="0" @if ($item->staff_status == false) selected @endif>Asosiy
                                        </option>
                                        <option value="1" @if ($item->staff_status == true) selected @endif>O'rindosh
                                        </option>
                                    </select>
                                </div>
                                <div class="col">
                                    <span>Lavozim sanasi</span>
                                    <input type="date" name="staff_date" value="{{ $item->staff_date }}"
                                        class="form-control" required>
                                </div>
                            </div>
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

            function myFilter() {
                let department_id = $('#department_id').val();
                let url = '{{ route('cadry') }}';

                window.location.href = `${url}?
            department_id=${department_id}&`;
            }
        </script>
    @endpush
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            @if (\Session::has('msg'))
                @if (Session::get('msg') == 2)
                    Swal.fire({
                        title: "Amalga oshirilmadi",
                        text: "Xodimning stavkasi amaldagi bo'sh lavozim stavkasiga to'gri kelmadi!",
                        icon: "warning",
                        confirmButtonColor: "#1c84ee"
                    });
                @else
                    Swal.fire({
                        title: "Good!",
                        text: "Xodim lavozimi o'zgartirildi",
                        icon: "success",
                        confirmButtonColor: "#1c84ee",
                    }).then(function() {
                        location.reload();
                    });
                @endif
            @endif
        });
    </script>
    <script>
        $('.staff').select2();
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
