@extends('layouts.master')
@section('content')

    <div class="card animate__animated animate__pulse">
        <div class="card-body p-2">
            <form method="get" action="{{ route('shtat') }}">
                @csrf
                <div class="row">
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

                    @push('scripts')
                        <script>
                            $('#railway_select').change(function(e) {
                                let railway_id = $(this).val();
                                let url = '{{ route('uty_organ') }}';
                                window.location.href = `${url}?railway_id=${railway_id}`;


                            })

                            $('#org_select').change(function(e) {
                                let org_id = $(this).val();
                                let railway_id = $('#railway_select').val();
                                let url = '{{ route('uty_organ') }}';
                                window.location.href = `${url}?railway_id=${railway_id}&org_id=${org_id}`;
                            })

                            $('#dep_select').change(function(e) {
                                let dep_id = $(this).val();
                                let railway_id = $('#railway_select').val();
                                let org_id = $('#org_select').val();
                                let url = '{{ route('uty_organ') }}';
                                window.location.href = `${url}?railway_id=${railway_id}&org_id=${org_id}&dep_id=${dep_id}`;
                            })

                            $("#search").keyup(function(event) {
                                if (event.keyCode === 13) {
                                    let search = $(this).val();
                                    let dep_id = $('#dep_select').val();
                                    let railway_id = $('#railway_select').val();
                                    let org_id = $('#org_select').val();
                                    let url = '{{ route('uty_organ') }}';
                                    window.location.href =
                                        `${url}?railway_id=${railway_id}&org_id=${org_id}&dep_id=${dep_id}&search=${search}`;
                                }
                            });
                        </script>
                    @endpush

                    <div class="col-12 col-sm-6 col-lg-3">
                        <button type="submit" style="margin-top: 25px;width: 100%" class="btn btn-primary"><i
                                class="fas fa-eye"></i> Shtat bo'yicha</button>
                    </div>
                </div>
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
                            <label>
                                <input type="search" class="form-control form-control-sm" placeholder="search ..."
                                    id="search" name="search" value="{{ request()->query('search') }}"
                                    aria-controls="datatable"></label>
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
