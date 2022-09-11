@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Ta'tildagi xodimlar</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">{{ __('messages.menu') }}</a></li>
                        <li class="breadcrumb-item active">Ta'tildagi xodimlar</li>
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
                                    <th class="text-center fw-bold" width="120px">Qachondan</th>
                                    <th width="130px" class="text-center fw-bold">Qachongacha</th>
                                    <th width="130px" class="text-center fw-bold">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cadries as $key => $item)
                                    <tr>
                                        <td class="text-center fw-bold align-middle">
                                                {{ $cadries->currentPage() * 15 - 15 + $loop->index + 1 }}
                                        </td>
                                        <td class="text-center fw-bold align-middle">{{ $item->cadry->organization->name }}</td>
                                        <td class="text-center align-middle ">{{ $item->cadry->last_name }} {{ $item->cadry->first_name }} {{ $item->cadry->middle_name }}</td>
                                        <td class="text-center align-middle fw-bold">
                                            {{$item->date1->format('Y-m-d')}}
                                        </td>
                                        <td class="text-center fw-bold align-middle">
                                          {{ $item->date2->format('Y-m-d')}}
                                        </td>
                                        <td class="align-middle text-center">
                                            @if ($item->status_decret == true)
                                                <span class="text-warning fw-bold">Bola parvarish ta'tilida</span>  
                                            @else
                                                <span class="text-primary fw-bold">Mehnat ta'tilida</span> 
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
