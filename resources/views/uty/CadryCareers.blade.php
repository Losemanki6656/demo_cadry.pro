@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Mehnat faoliyati kiritilmagan xodimlar</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">{{ __('messages.menu') }}</a></li>
                        <li class="breadcrumb-item active">Mehnat faoliyati</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mt-2">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped animate__animated animate__fadeIn table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center fw-bold" width="60px">{{ __('messages.no') }}</th>
                                    <th class="text-center fw-bold" width="250px">Korxona nomi</th>
                                    <th class="text-center fw-bold" width="350px">FIO</th>
                                    <th width="130px" class="text-center fw-bold">Izoh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cadries as $key => $item)
                                    <tr>
                                        <td class="text-center fw-bold align-middle">
                                                {{ $cadries->currentPage() * 15 - 15 + $loop->index + 1 }}
                                        </td>
                                        <td class="text-center fw-bold align-middle">{{ $item->organization->name }}</td>
                                        <td class="text-center align-middle ">{{ $item->last_name }} {{ $item->first_name }} {{ $item->middle_name }}</td>
                                        <td class="align-middle text-center"><span class="text-danger fw-bold">Kiritilmagan</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
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
