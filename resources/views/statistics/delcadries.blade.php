@extends('layouts.master')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Mehnat faoliyati yakunlangan xodimlar</h4>

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
        <div class="card-header">
            <div class="card-body">

                <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <form action="{{ route('cadry') }}" method="get">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                
                                <div class="dataTables_length" id="datatable_length">
                                    <label>
                                        <input type="search" class="form-control form-control-sm"
                                            placeholder="{{ __('messages.search') }} ..." name="search"
                                            value="{{ request()->query('search') }}">
                                    </label> <label>
                                        <input type="date" class="form-control form-control-sm" name="date_filter"
                                            value="{{ now()->format('Y-m-d') }}">
                                    </label>
                                    <label>
                                        <button class="btn btn-primary btn-sm"> <i class="fas fa-filter"></i> Filter</button>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="datatable_filter" class="dataTables_filter">
                                    <label>
                                        <a type="button" href="{{route('black_del')}}" class="btn btn-dark btn-sm"> <i class="fas fa-trash"></i> Qora ro'yxatdagi xodimlar</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped animate__animated animate__fadeIn">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center fw-bold" width="60px">{{ __('messages.no') }}</th>
                                        <th class="text-center fw-bold" width="60px">{{ __('messages.photo') }}</th>
                                        <th class="text-center fw-bold">{{ __('messages.fio') }}</th>
                                        <th class="text-center fw-bold">Korxona nomi</th>
                                        <th class="text-center fw-bold">{{ __('messages.staff') }}</th>
                                        <th width="100px" class="text-center fw-bold">{{ __('messages.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($cadries))
                                        @foreach ($cadries as $key => $item)
                                            <tr>
                                                <td class="text-center fw-bold">
                                                    {{ $cadries->currentPage() * 10 - 10 + $loop->index + 1 }}</td>
                                                <td class="text-center">
                                                    <a href="{{ asset('storage/' . $item->photo) }}" class="image-popup-desc"
                                                        data-title="{{ $item->last_name }} {{ $item->first_name }} {{ $item->middle_name }}"
                                                        data-description="{{ $item->post_name }}">
                                                        <img class="rounded avatar"
                                                            src="{{ asset('storage/' . $item->photo) }}" height="40"
                                                            width="40">
                                                    </a>

                                                </td>
                                                <td class="text-center fw-bold"> {{ $item->last_name }} {{ $item->first_name }}
                                                        {{ $item->middle_name }}</td>
                                                <td class="text-center">{{ $item->organization->name }}</td>
                                                <td class="text-center">{{ $item->post_name }}</td>
                                                <td class="text-center">
                                                    <a type="button" href="{{ route('word_export', ['id' => $item->id]) }}"
                                                        class="btn btn-soft-primary" data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom" title="Yuklab olish">
                                                        <i class=" bx bxs-file-doc font-size-16 align-middle"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
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
