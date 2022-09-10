@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Bo'sh va ortiqcha ish o'rinlari</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">{{ __('messages.menu') }}</a></li>
                        <li class="breadcrumb-item active">Bo'sh va ortiqcha ish o'rinlari</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <button class="btn btn-success btn-sm"><i class="fas fa-filter"></i> Bo'sh ish o'rni - {{ $vacanCount }} </button>
            <button class="btn btn-danger btn-sm"><i class="fas fa-filter"></i> Ortiqcha ish o'rni - {{ $sverxCount }} </button>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped animate__animated animate__fadeIn table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center fw-bold" width="60px">{{ __('messages.no') }}</th>
                                    <th class="text-center fw-bold" width="200px">Korxona nomi</th>
                                    <th class="text-center fw-bold" width="350px">Lavozim nomi</th>
                                    <th class="text-center fw-bold" width="30px">Stavkasi</th>
                                    <th width="130px" class="text-center fw-bold">Turi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allStaffs as $key => $item)
                                    <tr>
                                        <td class="text-center fw-bold align-middle">
                                                {{ $allStaffs->currentPage() * 10 - 10 + $loop->index + 1 }}
                                        </td>
                                        <td class="text-center fw-bold align-middle">{{ $item->organization->name }}</td>
                                        <td class="text-center align-middle ">{{ $item->staff_full }}</td>
                                        <td class="text-center align-middle fw-bold">
                                            @if ($item->stavka > $item->summ_stavka)
                                                {{ $item->stavka - $item->summ_stavka }}
                                            @else
                                                {{ $item->summ_stavka - $item->stavka }}
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            @if ($item->stavka > $item->summ_stavka)
                                               <span class="fw-bold text-success"> Bo'sh ish o'rni</span> 
                                            @else
                                                <span class="fw-bold text-danger">Ortiqcha ish o'rni</span>
                                            @endif
                                        </td>
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
                                {{ $allStaffs->withQueryString()->links() }}
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
