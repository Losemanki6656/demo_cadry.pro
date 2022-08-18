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
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="">
                        <table class="table table-centered align-middle table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center fw-bold" width="30px">#</th>
                                    <th class="text-center fw-bold" style="max-width: 300px">
                                        {{ $department->name }}ga tegishli ish o'rinlari
                                    </th>
                                    <th class="text-center fw-bold">Stavka</th>
                                    <th class="text-center fw-bold">Mavjud xodimlar</th>
                                    <th class="text-center fw-bold" width="110px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($depstaff as $ds)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td style="max-width: 300px" class="text-center">{{ $ds->staff->name }}</td>
                                        <td class="text-center fw-bold">{{ $ds->stavka }}</td>
                                        <td class="text-center fw-bold">
                                            @if ($ds->cadry->sum('stavka') < $ds->stavka)
                                                @if ($ds->status == false)
                                                    <a href="{{ route('department_cadry_add', ['id' => $ds->id]) }}"
                                                        class="btn btn-outline-success btn-sm">
                                                        Bo'sh ish o'rni - {{ $ds->stavka - $ds->cadry->sum('stavka') }} </a>
                                                @else
                                                    <a href="{{ route('department_cadry_add', ['id' => $ds->id]) }}"
                                                        class="btn btn-outline-danger btn-sm">
                                                        Xodim qo'shish - {{ $ds->stavka - $ds->cadry->sum('stavka') }} </a>
                                                @endif
                                            @elseif($ds->cadry->sum('stavka') > $ds->stavka)
                                                <span class="text-danger fw-bold">{{ $ds->cadry->sum('stavka') }}</span>
                                            @else
                                                {{ $ds->stavka }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a type="button" href="{{ route('department_staffs', ['id' => $ds->id]) }}"
                                                class="btn btn-primary btn-sm"> <i class="fa fa-eye"></i></a>
                                            <a type="button" href="{{ route('editCadryStaff', ['id' => $ds->id]) }}"
                                                class="btn btn-secondary btn-sm"> <i class="fa fa-edit"></i></a>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="deleteFunc({{ $ds->id }})"> <i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-xl-4">
            <!-- card -->
            <div class="card">
                <!-- card body -->
                <form action="{{ route('stafftoDepartment') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="department_id" value="{{ request('id') }}">
                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <h5 class="card-title me-2">Lavozimni biriktirish</h5>
                            <select class="staff_id js-example-basic-single" name="staff_id" required>
                                <option value="">-- Lavozimni tanlang --</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <h5 class="card-title me-2">Lavozim to'liq nomi</h5>
                            <textarea name="staff_full" class="form-control"></textarea>
                        </div>

                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <h5 class="card-title me-2">Klassifikatordagi lavozim ko'rinishini tanlang</h5>
                            <select class="js-example-basic-single js-data-example-ajax" name="class_staff_id"
                                id="classifications" style="width: 100%">
                            </select>
                        </div>
                        <div class="mb-4">
                            <h5 class="card-title me-2">Stavka</h5>
                            <input type="number" value="1" class="form-control" name="st_1" step="0.01">
                        </div>
                        <button class="btn btn-outline-primary" style="width: 100%"> Saqlash </button>

                    </div>
                </form>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
@endsection

@section('scripts')
    <script>
        function deleteFunc(id) {
            Swal.fire({
                text: "Ushbu ish o'rnini o'chirishni xoxlaysizmi",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Xa, bajarish!",
                cancelButtonText: "Yo'q, qaytish!",
                confirmButtonClass: "btn btn-success mt-2",
                cancelButtonClass: "btn btn-danger ms-2 mt-2",
                buttonsStyling: !1,
            }).then(function(e) {
                if (e.value) {

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('deleteDepStaff') }}",
                        data: {
                            "id": id,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Success!",
                                text: "Ish o'rni o'chirildi",
                                icon: "success",
                                confirmButtonColor: "#1c84ee",
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error: function(response) {
                            Swal.fire({
                                title: "Error",
                                text: "Ushbu lavozimga biriktirilgan xodimlar mavjud :)",
                                icon: "error",
                                confirmButtonColor: "#1c84ee",
                            });
                        }
                    });

                } else {
                    e.dismiss;
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            var msg = '{{ Session::get('msg') }}';
            var exist = '{{ Session::has('msg') }}';
            if (exist) {
                if (msg == 1) {
                    Swal.fire({
                        title: "Good!",
                        text: "Muvaffaqqiyatli bajarildi!",
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
        $('.staff_id').select2();
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
        $('.js-data-example-ajax').select2({
            ajax: {
                url: '{{ route('loadClassification') }}',
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
                                text: item.code_staff + '-' + item.name_uz,
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
            placeholder: 'Lavozim nomini kiriting',
            minimumInputLength: 1,
        });
    </script>
@endsection
