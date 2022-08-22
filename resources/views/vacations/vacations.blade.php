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
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped animate__animated animate__fadeIn table-sm">
                            <thead class="thead-dark ">
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
                                                {{ $cadries->currentPage() * 10 - 10 + $loop->index + 1 }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ asset('storage/' . $item->cadry->photo) }}" class="image-popup-desc"
                                                    data-title="{{ $item->cadry->last_name }} {{ $item->cadry->first_name }} {{ $item->cadry->middle_name }}">
                                                    <img class="rounded avatar"
                                                        src="{{ asset('storage/' . $item->cadry->photo) }}" height="40"
                                                        width="40">
                                                </a>

                                            </td>
                                            <td class="text-center align-middle fw-bold"><a
                                                    href="{{ route('cadry_edit', ['id' => $item->id]) }}"
                                                    class="text-dark"> {{ $item->last_name }} {{ $item->first_name }}
                                                    {{ $item->middle_name }}</a></td>
                                            <td class="text-center align-middle">{{ $item->post_name }}</td>
                                            <td class="text-center">
                                                <a type="button" href="{{ route('word_export', ['id' => $item->id]) }}"
                                                    class="btn btn-soft-primary" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title="Yuklab olish">
                                                    <i class=" bx bxs-file-doc font-size-16 align-middle"></i></a>
                                                <div class="btn-group" role="group">
                                                    <button type="button"
                                                        class="btn btn-soft-dark dropdown-toggle"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-filter font-size-16 align-middle"></i>
                                                    </button>

                                                    <ul class="dropdown-menu">
                                                        <li><a data-bs-toggle="modal"
                                                                data-bs-target="#vacation{{ $item->id }}"
                                                                type="button"
                                                                class="dropdown-item fw-bold text-success"><i
                                                                    class="fa fa-plus"></i> Mehnat
                                                                ta'tili</a></li>
                                                        <li>
                                                            @if ($item->sex == 0)
                                                                <a href="{{ route('decret_cadry', ['id' => $item->id]) }}"
                                                                    type="button"
                                                                    class="dropdown-item fw-bold text-primary"><i
                                                                        class="fa fa-plus"></i> Bola
                                                                    parvarish ta'tili</a>
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="vacation{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-success">Mehnat ta'tiliga chiqarish
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('vacation', ['id' => $item->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="fw-bold text-center">FIO:
                                                                    {{ $item->last_name }} {{ $item->first_name }}
                                                                    {{ $item->middle_name }}</label>
                                                            </div>
                                                            <div class="mb-3">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label>Qachondan:</label>
                                                                        <input type="text" class="form-control"
                                                                            id="datepicker-basic" name="date1">
                                                                    </div>
                                                                    <div class="col">
                                                                        <label>Qachongacha:</label>
                                                                        <input type="text" class="form-control"
                                                                            id="datepicker-basic" name="date2">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-success" type="submit"> <i
                                                                    class="bx bx-save font-size-16 align-middle me-2"></i>
                                                                Saqlash </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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