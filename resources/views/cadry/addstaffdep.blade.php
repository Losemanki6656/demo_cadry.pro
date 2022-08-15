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
                    <div class="table-responsive">
                        <table class="table table-centered align-middle table-nowrap table-hover mb-0 table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <h6>{{ $department->name }}ga tegishli ish o'rinlari</h6>
                                    </th>
                                    <th class="text-center">Xodim ismi</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($depstaff as $ds)
                                    <tr>
                                        <td class="text-center">{{ $ds->staff->name }}</td>
                                        <td class="text-center">
                                            @if ($ds->status == true)
                                                {{ $ds->cadry->last_name }} {{ $ds->cadry->first_name }}
                                                {{ $ds->cadry->middle_name }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($ds->status == false && $ds->status_sv == false)
                                                <button class="btn btn-outline-success btn-sm"> Bo'sh </button>
                                            @elseif ($ds->status == false && $ds->status_sv == true)
                                                <button class="btn btn-outline-danger btn-sm" 
                                                @if ($ds->status == true)
                                                    disabled
                                                @endif> Ortiqcha </button>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i></button>
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
                            <h5 class="card-title me-2">Klassifikatordagi lavozim ko'rinishini tanlang</h5>
                            <select class="js-example-basic-single js-data-example-ajax" name="class_staff_id"
                                id="classifications" style="width: 100%" required>
                            </select>
                        </div>

                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <h5 class="card-title me-2">Xodimni tanlash (Majburiy emas)</h5> 
                            <select class="js-example-basic-single cadry" style="width: 100%" name="cadry_id">
                            </select>
                        </div>
                        <div class="mb-4">
                            <input class="form-check-input" type="checkbox" id="formCheck1" name="status_sv">
                              <label class="form-check-label" for="formCheck1">
                                Ortiqcha ish o'rni
                             </label>
                        </div>

                        <button class="btn btn-outline-primary" disabled style="width: 100%"> Saqlash </button>

                    </div>
                </form>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- END ROW -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            @if (\Session::has('msg'))
                @if (Session::get('msg') == 1)
                    Swal.fire({
                        title: "Muvaffaqqiyatli!",
                        text: "Yangi ish o'rni yaratildi!",
                        icon: "success",
                        showCancelButton: !0,
                        confirmButtonColor: "#1c84ee",
                        cancelButtonColor: "#fd625e",
                    });
                @endif
            @endif
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
