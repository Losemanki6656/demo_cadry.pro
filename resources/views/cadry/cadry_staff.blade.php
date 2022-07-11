@extends('layouts.master')
@section('content')

    @if (\Session::has('msg'))
        @if (Session::get('msg') == 1)
            <div class="alert alert-success" id="success-alert">Succesfully!</div>
        @endif
    @endif

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $staff_name }} lavozimidagi xodimlar</h4>

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

            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <form action="{{ route('cadry') }}" method="get">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="datatable_length">
                                <label><input type="search" class="form-control form-control"
                                        placeholder="{{ __('messages.search') }} ..." name="search"
                                        value="{{ request()->query('search') }}"></label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="datatable_filter" class="dataTables_filter">
                                <label>
                                    <a href="{{ route('addworker') }}" type="button"
                                        class="btn btn-primary w-sm waves-effect waves-ligh" style="margin-left: 5px">
                                        <i class="bx bx-plus font-size-16 align-middle me-2"></i>
                                        {{ __('messages.addcadry') }}
                                    </a>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center fw-bold">{{ __('messages.no') }}</th>
                                    <th class="text-center fw-bold">{{ __('messages.photo') }}</th>
                                    <th class="text-center fw-bold">{{ __('messages.fio') }}</th>
                                    <th class="text-center fw-bold">{{ __('messages.staff') }}</th>
                                    <th width="180" class="text-center fw-bold">{{ __('messages.action') }}</th>
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
                                                <a type="button" href="{{ route('word_export', ['id' => $item->id]) }}"
                                                    class="btn btn-soft-primary">
                                                    <i class="bx bx-download font-size-16 align-middle"></i></a>
                                                <a href="{{ route('cadry_edit', ['id' => $item->id]) }}" type="button"
                                                    class="btn btn-soft-secondary">
                                                    <i class="bx bx-edit font-size-16 align-middle"></i></a>

                                                <button type="button" class="btn btn-soft-danger"
                                                    data-bs-toggle="modal" data-bs-target="#del{{ $item->id }}">
                                                    <i class="bx bx-trash font-size-16 align-middle"></i>
                                                </button>
                                            </td>
                                            <div class="modal fade" id="del{{ $item->id }}" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Xizmat faoliyatini yakunlash</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('delete_cadry', ['id' => $item->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label class="fw-bold text-center">FIO:
                                                                        {{ $item->last_name }} {{ $item->first_name }}
                                                                        {{ $item->middle_name }}</label>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label>Prikaz raqami:</label>
                                                                    <input class="form-control" type="text"
                                                                        name="number" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label>Izoh:</label>
                                                                    <textarea class="form-control" type="text" name="comment"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-danger" type="submit"> <i
                                                                        class="bx bx-trash font-size-16 align-middle me-2"></i>
                                                                    Yakunlash </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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
@endsection
