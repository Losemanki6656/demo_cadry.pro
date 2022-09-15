@extends('layouts.master')
@section('content')

    <div class="card animate__animated animate__pulse">
        <div class="card-body p-2">
            <form method="get" action="{{ route('shtat') }}">
                @csrf
                <div class="row mb-2">
                    <div class="col-12 col-sm-6 col-lg-3">
                        <label for="users-list-role mb-0">
                            <h6 class="mb-0">Katta korxonalar - {{ $railways->count() }} ta</h6>
                        </label>
                        <select id="railway_select" style="width: 100%" class="js-example-basic-single" name="railway_id">
                            <option value="">--Barchasi--</option>
                            @foreach ($railways as $railway)
                                @if ($railway->id == request('railway_id'))
                                    <option value={{ $railway->id }} selected>{{ $railway->name }}</option>
                                @else
                                    <option value={{ $railway->id }}>{{ $railway->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <label for="users-list-status">
                            <h6 class="mb-0">Korxonalar - {{ $organizations->count() }} ta</h6>
                        </label>
                        <select id="org_select" style="width: 100%" class="js-example-basic-single" name="organization_id"
                            required>
                            <option value="">--Barchasi--</option>
                            @foreach ($organizations as $organization)
                                @if ($organization->id == request('org_id'))
                                    <option value={{ $organization->id }} selected>{{ $organization->name }}</option>
                                @else
                                    <option value={{ $organization->id }}>{{ $organization->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-3">
                        <label for="users-list-verified">
                            <h6 class="mb-0">Bo'limlar va bekatlar - {{ $departments->count() }} ta</h6>
                        </label>
                        <select id="dep_select" style="width: 100%" class="js-example-basic-single" name="usersharesimpid">
                            <option value="">--Barchasi--</option>
                            @foreach ($departments as $department)
                                @if ($department->id == request('dep_id'))
                                    <option value={{ $department->id }} selected>{{ $department->name }}</option>
                                @else
                                    <option value={{ $department->id }}>{{ $department->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-12 col-sm-6 col-lg-3">
                            <label for="users-list-verified">
                                <h6 class="mb-0">FIO</h6>
                            </label>
                            <input type="search" id="name_se" class="form-control" placeholder="Search ..."
                                value="{{ request('name_se') }}" name="name_se">
                        
                    </div>
                </div>
                <div class="row mb-2">
                    
                    <div class="col-12 col-sm-6 col-lg-2">
                        <label class="mb-0"> Lavozimi</label>
                        <select class="js-example-basic-single" style="width: 100%" id="staff_se" name="staff_se">
                            <option value="">--Barchasi--</option>
                            @foreach ($staffs as $staff)
                                <option value="{{ $staff->id }}" @if ($staff->id == request('staff_se')) selected @endif>
                                    {{ $staff->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-2">
                        <label class="mb-0"> Ma'lumoti</label>
                        <select class="form-select" style="width: 100%" id="education_se" name="education_se">
                            <option value="">--Barchasi--</option>
                            <option value="1" @if (1 == request('education_se')) selected @endif>Oliy</option>
                            <option value="3" @if (3 == request('education_se')) selected @endif>O'rta-maxsus</option>
                            <option value="4" @if (4 == request('education_se')) selected @endif>O'rta</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-2">
                        <label class="mb-0"> Viloyati</label>
                        <select class="js-example-basic-single" style="width: 100%" id="region_se" name="region_se">
                            <option value=""> --Barchasi-- </option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}" @if ($region->id == request('region_se')) selected @endif>
                                    {{ $region->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-2">
                        <label class="mb-0"> Yoshi</label>
                        <div class="input-daterange input-group" data-provide="datepicker">
                            <input type="number" class="form-control" placeholder="Start Date" id="start_se"
                                name="start_se" value="{{request('start_se')}}" />
                            <input type="number" class="form-control" placeholder="End Date" id="end_se" name="end_se"
                                value="{{request('end_se')}}" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-2">
                        <label class="mb-0"> Jinsi</label>
                        <select class="form-select" style="width: 100%" id="sex_se" name="sex_se">
                            <option value="">--Barchasi--</option>
                            <option value = "true"  @if ("true" == request('sex_se')) selected @endif>Erkak</option>
                            <option value = "false"  @if ("false" == request('sex_se')) selected @endif>Ayol</option>
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
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 col-lg-2">
                    </div>
                    <div class="col-12 col-sm-6 col-lg-2">
                    </div>
                    <div class="col-12 col-sm-6 col-lg-2">
                    </div>
                    <div class="col-12 col-sm-6 col-lg-2">
                    </div>
                    <div class="col-12 col-sm-6 col-lg-2">
                    </div>
                    <div class="col-12 col-sm-6 col-lg-2">
                        <label class="mb-0"> </label>
                        <a href="{{ route('export_excel') }}" type="button"
                            class="btn btn-success waves-effect btn-label waves-light" style="width: 100%"><i
                                class="bx bxs-file label-icon"></i> Export</a>
                    </div>

                </div>
                @push('scripts')
                        <script>
                            function myFilter() {
                                let name_se = $('#name_se').val();
                                let staff_se = $('#staff_se').val();
                                let education_se = $('#education_se').val();
                                let region_se = $('#region_se').val();
                                let start_se = $('#start_se').val();
                                let end_se = $('#end_se').val();
                                let sex_se = $('#sex_se').val();
                                let vacation_se = $('#vacation_se').val();
                                let dep_id = $('#dep_select').val();
                                let railway_id = $('#railway_select').val();
                                let org_id = $('#org_select').val();

                                let url = '{{ route('uty_organ') }}';
                                window.location.href = `${url}?name_se=${name_se}&staff_se=${staff_se}&education_se=${education_se}&region_se=${region_se}&start_se=${start_se}&end_se=${end_se}&sex_se=${sex_se}&vacation_se=${vacation_se}&railway_id=${railway_id}&dep_id=${dep_id}&org_id=${org_id}&`;
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
                            $('#railway_select').change(function(e) {
                                myFilter();
                            })
                            $('#dep_select').change(function(e) {
                                myFilter();
                            })
                            $('#org_select').change(function(e) {
                                myFilter();
                            })
                        </script>
                    @endpush
            </form>
        </div>
    </div>

    <div class="card animate__animated animate__pulse">
        <div class="card-body">
            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="dataTables_length" id="datatable_length">
                            <label>Umumiy xodimlar:<span class="fw-bold text-success"> <br> {{ $countcadries }} </span> ta
                                topildi</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div id="datatable_filter" class="dataTables_filter">
                           
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="fw-bold text-center" width="60px">No</th>
                                    <th class="fw-bold text-center" width="60px">Photo</th>
                                    <th class="fw-bold text-center">FIO</th>
                                    <th class="fw-bold text-center">Lavozimi</th>
                                    <th class="fw-bold text-center">Korxonasi</th>
                                    <th class="fw-bold text-center" width="80px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($cadries))
                                    @foreach ($cadries as $key => $item)
                                        <tr>
                                            <td class="fw-bold align-middle text-center">
                                                {{ $cadries->currentPage() * 10 - 10 + $loop->index + 1 }}</td>
                                            <td class="text-center">
                                                <a href="{{ asset('storage/' . $item->photo) }}" class="image-popup-desc"
                                                    data-title="{{ $item->last_name }} {{ $item->first_name }} {{ $item->middle_name }}"
                                                    data-description="{{ $item->post_name }}">
                                                    <img class="rounded avatar" src="{{ asset('storage/' . $item->photo) }}"
                                                        height="40" width="40">
                                                </a>
                                            </td>
                                            <td class="fw-bold align-middle text-center">{{ $item->last_name }}
                                                {{ $item->first_name }} {{ $item->middle_name }}</td>
                                            <td class="text-center align-middle">{{ $item->post_name }}</td>
                                            <td class="text-center align-middle">{{ $item->organization->name }}</td>
                                            <td class="text-center">
                                                <a type="button" href="{{ route('word_export', ['id' => $item->id]) }}"
                                                    class="btn btn-soft-primary waves-effect waves-light"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    title="Yuklab olish">
                                                    <i class="bx bxs-file-doc font-size-16 align-middle"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <ul class="pagination mb-0">
                        {{ $cadries->withQueryString()->links() }}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('.js-example-basic-single').select2();
    </script>
@endsection
