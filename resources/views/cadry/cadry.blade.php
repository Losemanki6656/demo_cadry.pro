@extends('layouts.master')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.xodimlar') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">{{ __('messages.menu') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.xodimlar') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('cadry') }}" method="get" id="myfilter">
                @csrf
                <div class="dataTables_wrapper dt-bootstrap4 no-footer mb-2">
                    <div class="row mb-2">

                        <div class="col-12 col-sm-6 col-lg-2">
                            <label class="mb-0">FIO</label>
                            <input type="search" id="name_se" class="form-control" placeholder="Search ..."
                                value="{{ request('name_se') }}" name="name_se">
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2">
                            <label class="mb-0"> Lavozimi</label>
                            <select class="js-example-basic-single staff" style="width: 100%" id="staff_se"
                                name="staff_se">
                                @if (request('staff_se'))
                                    <option value="{{ request('staff_se') }}"> {{ $cadries[0]->staff->name }}
                                    </option>
                                @endif
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2">
                            <label class="mb-0"> Ma'lumoti </label>
                            <select class="form-select" style="width: 100%" id="education_se" name="education_se">
                                <option value="">--Barchasi--</option>
                                <option value="1" @if (1 == request('education_se')) selected @endif>Oliy</option>
                                <option value="3" @if (3 == request('education_se')) selected @endif>O'rta-maxsus
                                </option>
                                <option value="4" @if (4 == request('education_se')) selected @endif>O'rta</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2">
                            <label class="mb-0"> Viloyati</label>
                            <select class="js-example-basic-single region" style="width: 100%" id="region_se"
                                name="region_se">
                                @if (request('region_se'))
                                    <option value="{{ $cadries[0]->birth_region->name }}">
                                        {{ $cadries[0]->birth_region->name }}
                                    </option>
                                @endif
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2">
                            <label class="mb-0"> Yoshi</label>
                            <div class="input-daterange input-group" data-provide="datepicker">
                                <input type="number" class="form-control" placeholder="Start Date" id="start_se"
                                    name="start_se" value="{{ request('start_se') }}" />
                                <input type="number" class="form-control" placeholder="End Date" id="end_se"
                                    name="end_se" value="{{ request('end_se') }}" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2">
                            <label class="mb-0"> Bo'limlar</label>
                            <select class="js-example-basic-single department" style="width: 100%" id="department_se"
                                name="department_se">
                                @if (request('department_se'))
                                    <option value="{{ request('department_se') }}"> {{ $cadries[0]->department->name }}
                                    </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-lg-2">
                            <label class="mb-0"> Jinsi</label>
                            <select class="form-select" style="width: 100%" id="sex_se" name="sex_se">
                                <option value="">--Barchasi--</option>
                                <option value="true" @if ('true' == request('sex_se')) selected @endif>Erkak</option>
                                <option value="false" @if ('false' == request('sex_se')) selected @endif>Ayol</option>
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
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2">
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2">
                            <label class="mb-0"> </label>
                            <a onclick="exportToExcel()" type="button"
                                class="btn btn-success waves-effect btn-label waves-light" style="width: 100%"><i
                                    class="bx bxs-file label-icon"></i> Excelga yuklab olish</a>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2">
                            <label class="mb-0"> </label>
                            <a href="{{ route('addworker') }}" type="button"
                                class="btn btn-primary waves-effect btn-label waves-light" style="width: 100%"><i
                                    class="bx bx-plus label-icon"></i> Xodim qo'shish</a>
                        </div>

                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped animate__animated animate__fadeIn table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center fw-bold" width="60px">{{ __('messages.no') }}</th>
                                    <th class="text-center fw-bold" width="60px">{{ __('messages.photo') }}</th>
                                    <th class="text-center fw-bold" width="350px">{{ __('messages.fio') }}</th>
                                    <th class="text-center fw-bold">{{ __('messages.staff') }}</th>
                                    <th width="130px" class="text-center fw-bold">{{ __('messages.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($cadries))
                                    @foreach ($cadries as $key => $item)
                                        <tr>
                                            <td class="text-center fw-bold align-middle">
                                                @if ($item->vacation->count())
                                                    @if ($item->vacation[0]->date1 <= now() && now() <= $item->vacation[0]->date2)
                                                        <div class="bg-warning bg-gradient p-2"></div>
                                                    @else
                                                        {{ $cadries->currentPage() * 10 - 10 + $loop->index + 1 }}
                                                    @endif
                                                @else
                                                    {{ $cadries->currentPage() * 10 - 10 + $loop->index + 1 }}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ asset('storage/' . $item->photo) }}" class="image-popup-desc"
                                                    data-title="{{ $item->last_name }} {{ $item->first_name }} {{ $item->middle_name }}"
                                                    data-description="{{ $item->post_name }}">
                                                    <img class="rounded avatar"
                                                        src="{{ asset('storage/' . $item->photo) }}" height="40"
                                                        width="40">
                                                </a>

                                            </td>
                                            <td class="text-center align-middle fw-bold"><a
                                                    href="{{ route('cadry_edit', ['id' => $item->id]) }}"
                                                    class="text-dark"> {{ $item->last_name }} {{ $item->first_name }}
                                                    {{ $item->middle_name }}</a></td>
                                            <td class="text-center align-middle">{{ $item->post_name }}</td>
                                            <td class="text-center align-middle">
                                                <a type="button" href="{{ route('word_export', ['id' => $item->id]) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="bx bxs-file-doc"></i> Yuklab olish</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        @if (count($cadries) > 9)
                            <form action="{{ route('cadry') }}" method="get">
                                <div class="dataTables_length" id="datatable_length">
                                    <label><input type="number" class="form-control form-control"
                                            placeholder="{{ __('messages.page') }} ..." name="page"
                                            value="{{ request()->query('page') }}"></label>
                                </div>
                            </form>
                        @endif
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
    @push('scripts')
        <script>
            function myFilter() {
                var form = document.getElementById("myfilter");
                form.submit();
            }
            $('#name_se').keyup(function(e) {
                if (e.keyCode == 13) {
                    myFilter();
                }
            })
            $('#staff_se').change(function(e) {
                myFilter();
            })
            $('#education_se').change(function(e) {
                myFilter();
            })
            $('#region_se').change(function(e) {
                myFilter();
            })
            $('#department_se').change(function(e) {
                myFilter();
            })
            $('#sex_se').change(function(e) {
                myFilter();
            })
        </script>
    @endpush
    <table>
        <tbody>
            <tr>
                <td style="width: 90px;">
                    <span>Mehnat ta'tili</span>
                </td>
                <td style="width: 50px;">
                    <div class="bg-warning bg-gradient p-2"></div>
                </td>
                <td style="width: 30px;"></td>
                <td style="width: 135px;">
                    <span>Bola parvarish ta'tili</span>
                </td>
                <td style="width: 50px;">
                    <div class="bg-primary p-2"></div>
                </td>
                <td style="width: 30px;"></td>
                <td style="width: 130px;">
                    <span>Kasanachi xodimlar</span>
                </td>
                <td style="width: 50px;">
                    <div class="bg-info p-2"></div>
                </td>
            </tr>
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        function exportToExcel() {
            let name_se = $('#name_se').val();
            let staff_se = document.getElementById("staff_se").value;
            let education_se = $('#education_se').val();
            let region_se = document.getElementById("region_se").value;
            let start_se = $('#start_se').val();
            let end_se = $('#end_se').val();
            let sex_se = $('#sex_se').val();
            let vacation_se = $('#vacation_se').val();

            let dep_id = document.getElementById("department_se").value;

            let url = '{{ route('export_excel') }}';
            window.location.href = `${url}?
                                        name_se=${name_se}&
                                        staff_se=${staff_se}&
                                        education_se=${education_se}&
                                        region_se=${region_se}&
                                        start_se=${start_se}&
                                        end_se=${end_se}&
                                        sex_se=${sex_se}&
                                        vacation_se=${vacation_se}&
                                        dep_id=${dep_id}&`;
        }
    </script>
    <script>
        $('.region').select2({
            ajax: {
                url: '{{ route('loadRegion') }}',
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
            placeholder: "Viloyatni belgilang",
            minimumInputLength: 1,
        });
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
            placeholder: "Bo'limni belgilang",
            minimumInputLength: 1,
        });
    </script>
    <script>
        $('.staff').select2({
            ajax: {
                url: '{{ route('loadStaff') }}',
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
            placeholder: 'Lavozimni belgilang',
            minimumInputLength: 1,
        });
    </script>
    <script>
        $(document).ready(function() {
            var msg = '{{ Session::get('msg') }}';
            var exist = '{{ Session::has('msg') }}';
            if (exist) {
                if (msg == 1) {
                    Swal.fire({
                        title: "Good!",
                        text: "Ta'tilga chiqarish muvaffaqqiyatli amalga oshirildi!",
                        icon: "success",
                        confirmButtonColor: "#1c84ee",
                    }).then(function() {
                        location.reload();
                    });
                }
                if (msg == 5) {
                    Swal.fire({
                        title: "Good!",
                        text: "Xodim arxivdan muvafaqqiyatli ko'chirildi!",
                        icon: "success",
                        confirmButtonColor: "#1c84ee",
                    }).then(function() {
                        location.reload();
                    });
                }
            }

        });
    </script>
@endsection
