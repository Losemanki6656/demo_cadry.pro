@extends('layouts.master')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Qora ro'yxatdagi xodimlar</h4>

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
            <div class="row mb-3 mt-0">
                <div class="col-12 col-sm-6 col-lg-3">
                    <label for="users-list-role">
                        <h6 class="mb-0">Katta korxonalar </h6>
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
                        <h6 class="mb-0">Korxonalar</h6>
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
                <div class="col-12 col-sm-6 col-lg-2">
                     <button class="btn btn-danger" type="button" style="margin-top: 25px"> Xodim qo'shish</button>
                </div>

                @push('scripts')
                    <script>
                        $('#railway_select').change(function(e) {
                            let railway_id = $(this).val();
                            let url = '{{ route('black_del') }}';
                            window.location.href = `${url}?railway_id=${railway_id}`;


                        })
                        $('#org_select').change(function(e) {
                            let org_id = $(this).val();
                            let railway_id = $('#railway_select').val();
                            let url = '{{ route('black_del') }}';
                            window.location.href = `${url}?railway_id=${railway_id}&org_id=${org_id}`;
                        })
                    </script>
                @endpush
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped animate__animated animate__fadeIn table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center fw-bold" width="60px">{{ __('messages.no') }}</th>
                                    <th class="text-center fw-bold">{{ __('messages.fio') }}</th>
                                    <th class="text-center fw-bold">Tug'ilgan sanasi</th>
                                    <th class="text-center fw-bold">Korxona nomi</th>
                                    <th class="text-center fw-bold">{{ __('messages.staff') }}</th>
                                    <th class="text-center fw-bold">Bo'shash sanasi</th>
                                    <th class="text-center fw-bold">Sababi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($cadries))
                                    @foreach ($cadries as $key => $item)
                                        <tr>
                                            <td class="text-center fw-bold">
                                                {{ $cadries->currentPage() * 15 - 15 + $loop->index + 1 }}</td>
                                            <td class="text-center fw-bold"> {{ $item->last_name }} {{ $item->first_name }}
                                                    {{ $item->middle_name }}</td>
                                            <td class="text-center">{{ $item->birht_date }}</td>
                                            <td class="text-center">{{ $item->organization->name }}</td>
                                            <td class="text-center">{{ $item->post_name }}</td>
                                            <td class="text-center">{{ $item->job_date }}</td>
                                            <td class="text-center">{{ $item->comment }}</td>
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
                        <form action="{{ route('black_del') }}" method="get">
                            <div class="dataTables_length" id="datatable_length">
                                <label><input type="number" class="form-control form-control"
                                        placeholder="{{ __('messages.page') }} ..." name="page"
                                        value="{{ request()->query('page') }}"></label>
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
        $('.js-example-basic-single').select2();
    </script>
@endsection
