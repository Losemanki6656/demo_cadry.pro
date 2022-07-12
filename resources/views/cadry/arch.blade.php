@extends('layouts.master')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Mexnat faoliyati yakunlangan xodimlar</h4>

                <div class="page-title-right">
                    <a href="{{ route('export_excel_arhive') }}" type="button"
                    class="btn btn-success waves-effect btn-label waves-light"><i
                        class="bx bxs-file label-icon"></i> Export</a>
                </div>

            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer mb-2">
                <form action="{{ route('archive_cadry') }}" method="get">
                    <div class="row mb-2">
                        <div class="col-12 col-sm-6 col-lg-2">
                            <label class="mb-0">FIO</label>
                            <input type="search" id="name_se" class="form-control form-control" placeholder="Search ..." value="{{request('name_se')}}"
                                name="name_se" value="{{ request()->query('search') }}">
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2">
                            <label class="mb-0"> Lavozimi</label>
                            <select class="js-example-basic-single" style="width: 100%" id="staff_se" name="staff_se">
                                <option value="">--Barchasi--</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{$staff->id}}"> {{$staff->name}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2">
                            <label class="mb-0"> Ma'lumoti</label>
                            <select class="form-select" style="width: 100%" id="education_se" name="education_se">
                                <option value="">--Barchasi--</option>
                                <option value="1">Oliy</option>
                                <option value="3">O'rta-maxsus</option>
                                <option value="4">O'rta</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2" >
                            <label class="mb-0"> Viloyati</label>
                            <select class="js-example-basic-single" style="width: 100%" id="region_se" name="region_se">
                                <option value=""> --Barchasi-- </option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}"> {{$region->name}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2">
                            <label class="mb-0"> Yoshi</label>
                            <div class="input-daterange input-group" data-provide="datepicker">
                                <input type="number" class="form-control" placeholder="Start Date" id="start_se" name="start_se" value="0" />
                                <input type="number" class="form-control" placeholder="End Date" id="end_se" name="end_se" value="100"/>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2" >
                            <label class="mb-0"> Bo'limlar</label>
                            <select class="js-example-basic-single" style="width: 100%" id="department_se" name="department_se">
                                <option value=""> --Barchasi-- </option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"> {{$department->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-lg-2">
                            <label class="mb-0"> Jinsi</label>
                            <select class="form-select" style="width: 100%" id="sex_se" name="sex_se">
                                <option value="">--Barchasi--</option>
                                <option value="1">Erkak</option>
                                <option value="0">Ayol</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2">
                            <label class="mb-0"> Ta'til</label>
                            <select class="form-select" style="width: 100%" id="vacation_se" name="vacation_se">
                                <option value="">--Barchasi--</option>
                                <option value="1">Bs</option>
                                <option value="0">Mehnat ta'tili</option>
                                <option value="0">Bola parvarishi</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2">
                            <label class="mb-0"> </label>
                            <a href="{{ route('export_excel_arhive') }}" type="button"
                            class="btn btn-success waves-effect btn-label waves-light" style="width: 100%"><i
                                class="bx bxs-file label-icon"></i> Export</a>
                        </div>
                        
                    </div>
                </form>
            </div>
            @push('scripts')
                <script>
                    $('#name_se').keyup(function(e) {
                        if(e.keyCode == 13)
                        {
                            let name_se = $('#name_se').val();
                            let staff_se = $('#staff_se').val();
                            let education_se = $('#education_se').val();
                            let region_se = $('#region_se').val();
                            let start_se = $('#start_se').val();
                            let end_se = $('#end_se').val();
                            let department_se = $('#department_se').val();
                            let sex_se = $('#sex_se').val();
                            let vacation_se = $('#vacation_se').val();

                            let url = '{{ route('archive_cadry') }}';
                                window.location.href = `${url}?
                                name_se=${name_se}&
                                staff_se=${staff_se}&
                                education_se=${education_se}&
                                region_se=${region_se}&
                                start_se=${start_se}&
                                end_se=${end_se}&
                                department_se=${department_se}&
                                sex_se=${sex_se}&
                                vacation_se=${vacation_se}&`;
                        }
                    })
                </script>
            @endpush

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm ">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center fw-bold">No</th>
                                    <th class="text-center fw-bold">Photo</th>
                                    <th class="text-center fw-bold">FIO</th>
                                    <th class="text-center fw-bold">Lavozimi</th>
                                    <th width="210" class="text-center fw-bold">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($cadries))
                                    @foreach ($cadries as $key => $item)
                                        <tr>
                                            <td class="text-center">
                                                {{ $cadries->currentPage() * 10 - 10 + $loop->index + 1 }}</td>
                                            <td class="text-center"><img class="rounded avatar"
                                                    src="{{ asset('storage/' . $item->photo) }}" height="40"
                                                    width="40"></td>
                                            <td class="text-center">{{ $item->last_name }} {{ $item->first_name }}
                                                {{ $item->middle_name }}</td>
                                            <td class="text-center">{{ $item->post_name }}</td>
                                            <td class="text-center">
                                                <a type="button"
                                                    href="{{ route('demo_to_cadry', ['id' => $item->id]) }}"
                                                    class="btn btn-soft-dark" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title="Malumotlarni qaytarish">
                                                    <i class="bx bx-check-shield font-size-16 align-middle"></i></a>
                                                <a type="button"
                                                    href="{{ route('word_export_demo', ['id' => $item->id]) }}"
                                                    class="btn btn-soft-primary" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title="Yuklab olish">
                                                    <i class="bx bxs-file-doc font-size-16 align-middle"></i></a>
                                                <span data-bs-toggle="modal" data-bs-target="#send{{ $item->id }}">
                                                    <button type="button" class="btn btn-soft-success"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        title="Malumotlarni ko'chirish">
                                                        <i class="bx bx-send font-size-16 align-middle"></i>
                                                    </button>
                                                </span>
                                                <a type="button"
                                                    href="{{ route('demo_to_delete', ['id' => $item->id]) }}"
                                                    class="btn btn-soft-danger" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title="Malumotlarni o'chirish">
                                                    <i class=" bx bx-trash-alt font-size-16 align-middle"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <form action="{{ route('cadry') }}" method="get">
                            <div class="dataTables_length" id="datatable_length">
                                <label><input type="number" class="form-control form-control" placeholder="Page ..."
                                        name="page" value="{{ request()->query('page') }}"></label>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div id="datatable_filter" class="dataTables_filter">
                            <label>
                                {{ $cadries->withQueryString()->links() }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            @if (\Session::has('msg'))
                @if (Session::get('msg') == 1)
                    alertify.success("O'chirildi!");
                @endif
            @endif
        });
    </script>
    <script>
        $('.js-example-basic-single').select2();
    </script>
@endsection
