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
        <div class="col-xl-4">
            <!-- card -->
            <div class="card">
                <!-- card body -->
                <form action="{{ route('addCadryToDepartmentStaff', ['id' => $depstaff->id]) }}" method="post">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="department_id" value="{{ request('id') }}">
                        <div class="mb-4">
                            <label> Belgilangan Lavozim</label>
                            <h6>{{ $depstaff->staff->name }}</h6>
                        </div>

                        <div class="mb-4">
                            <label>Lavozim to'liq nomi</label>
                            <h6>{{ $depstaff->staff_full }}</h6>
                        </div>

                        <div class="mb-4">
                            <label>Klassifikatordagi lavozim ko'rinishi</label>
                            <h6>{{ $depstaff->classification->name_uz ?? '' }}</h6>
                        </div>

                        <div class="mb-4">
                            <label>Stavka</label>
                            <h6>{{ $depstaff->stavka }} -
                                @if ($depstaff->stavka > $depstaff->cadry->sum('stavka'))
                                    <button class="btn btn-outline-success" disabled>Bo'sh ish o'rni -
                                        {{ $depstaff->stavka - $depstaff->cadry->sum('stavka') }}</button>
                                @else
                                    <button class="btn btn-outline-danger" disabled>Bo'sh ish o'rni mavjud emas</button>
                                @endif
                        </div>

                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <h5 class="card-title me-2">Xodimni tanlang</h5>
                            <select class="js-example-basic-single cadry" name="cadry_id" style="width: 100%" required>f
                            </select>
                        </div>
                        <div class="mb-4">
                            <div class="row">
                                <div class="col">
                                    <h5> Ish faoliyati turi </h5>
                                    <select name="staff_status" class="form-select">
                                        <option value="0">Asosiy
                                        </option>
                                        <option value="1">O'rindosh
                                        </option>
                                    </select>
                                </div>
                                <div class="col">
                                    <h5> Lavozim sanasi</h5>
                                    <input type="date" name="staff_date" class="form-control" required>
                                </div>
                                <div class="col">
                                    <h5 class="card-title me-2">Stavka</h5>
                                    <input type="number" name="st_1" value="1" class="form-control" step="0.01">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <input class="form-check-input" type="checkbox" id="careerCheck" name="careerCheck">
                            <label class="form-check-label" for="careerCheck">
                                Xodim mehnat faoliyatiga yangi lavozim nomi qo'shilsinmi ?!
                            </label>
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
        $(document).ready(function() {
            @if (\Session::has('msg'))
                @if (Session::get('msg') == 1)
                    Swal.fire({
                        title: "Xatolik",
                        text: "Ushbu xodimda asosiy ish faoliyati mavjud!",
                        icon: "warning",
                        confirmButtonColor: "#1c84ee"
                    });
                @endif
            @endif
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
@endsection
