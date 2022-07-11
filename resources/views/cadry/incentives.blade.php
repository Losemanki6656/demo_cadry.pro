@extends('layouts.master')
@section('content')


    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Rag'batlantirishlar</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Bosh menu</a></li>
                        <li class="breadcrumb-item active">Boshqa</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">

            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <form action="{{ route('incentives') }}" method="get">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="datatable_length">
                                <label><input type="search" class="form-control form-control" placeholder="Search ..."
                                        name="search" value="{{ request()->query('search') }}"></label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="datatable_filter" class="dataTables_filter">
                                <label>
                                    <a href="{{ route('export_excel') }}" type="button"
                                        class="btn btn-success waves-effect btn-label waves-light">
                                        <i class="bx bxs-file label-icon"></i> Export</a>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center fw-bold">No</th>
                                    <th class="text-center fw-bold">Photo</th>
                                    <th class="text-center fw-bold">FIO</th>
                                    <th class="text-center fw-bold">Rag'batlantirishlar soni</th>
                                    <th class="text-center fw-bold">Intizomiy jazolar soni</th>
                                    <th width="180" class="text-center fw-bold">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($cadries))
                                    @foreach ($cadries as $key => $item)
                                        <tr>
                                            <td class="text-center fw-bold">
                                                {{ $cadries->currentPage() * 10 - 10 + $loop->index + 1 }}</td>
                                            <td class="text-center">
                                                <img class="rounded avatar" src="{{ asset('storage/' . $item->photo) }}"
                                                    height="40" width="40">
                                            </td>
                                            <td class="text-center fw-bold">{{ $item->last_name }}
                                                {{ $item->first_name }} {{ $item->middle_name }}</td>
                                            <td class="text-center">
                                                @if ($item->incentives->count() == 0)
                                                    Mavjud emas
                                                @else
                                                    {{ $item->incentives->count() }}
                                            </td>
                                    @endif

                                    <td class="text-center">
                                        @if ($item->discips->count() == 0)
                                            Mavjud emas
                                        @else
                                            {{ $item->discips->count() }}
                                    </td>
                                @endif
                                <td class="text-center">
                                    <a type="button" href="" class="btn btn-soft-success"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="To'liq ma'lumot">
                                        <i class="bx bxs-user-detail font-size-16 align-middle"></i></a>
                                    <a type="button" href="{{ route('word_export', ['id' => $item->id]) }}"
                                        class="btn btn-soft-primary" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        title="Yuklab olish">
                                        <i class=" bx bxs-file-doc font-size-16 align-middle"></i></a>
                                    <a href="{{ route('cadry_edit', ['id' => $item->id]) }}" type="button"
                                        class="btn btn-soft-secondary" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="Taxrirlash">
                                        <i class="bx bx-edit font-size-16 align-middle"></i></a>
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
@endsection
