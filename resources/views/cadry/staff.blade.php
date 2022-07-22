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
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.staff') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">{{ __('messages.menu') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.staff') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">

            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">

                <form id="form-staff" action="{{ route('staff') }}" method="get">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <input type="hidden" name="type" id="filter_form" value="">
                            <div class="dataTables_length" id="datatable_length">
                                <label>
                                    <input type="search" class="form-control form-control"
                                        placeholder="{{ __('messages.search') }} ..." name="search"
                                        value="{{ request()->query('search') }}">
                                </label>
                            </div>

                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_filter">

                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-filter font-size-16 align-middle me-2"></i>
                                        Filter
                                        <i class="mdi mdi-chevron-down"></i>
                                    </button>

                                    <ul class="dropdown-menu">
                                        <li>
                                            <button type="button" onclick="sverx()"
                                                class="dropdown-item">Sverxlar</button>
                                        </li>
                                        <li>
                                            <button type="button" onclick="vakant()"
                                                class="dropdown-item">Vakantlar</button>
                                        </li>
                                    </ul>
                                </div>

                                <label>
                                    <button type="button" class="btn btn-primary w-sm waves-effect waves-ligh"
                                        data-bs-toggle="modal" data-bs-target="#addstaff">
                                        <i class="bx bx-plus font-size-16 align-middle me-2"></i> Lavozim qo'shish
                                    </button>
                                </label>

                            </div>

                        </div>
                    </div>
                </form>

            </div>
            @push('scripts')
                <script>
                    function sverx() {
                        $('#filter_form').val('sverx');
                        document.getElementById('form-staff').submit();
                    }

                    function vakant() {
                        $('#filter_form').val('vakant');
                        document.getElementById('form-staff').submit();
                    }
                </script>
            @endpush
            <div class="modal fade" id="addstaff" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Lavozim qo'shish</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('add_staff') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Lavozimni kiriting:</label>
                                    <input class="form-control" type="text" name="name" placeholder="Lavozim:"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label>Kategoriyani belgilang:</label>
                                    <select class="form-select" name="category_id" required>
                                        @foreach ($categories as $category)
                                            <option value={{ $category->id }}>{{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Lavozim bo'yicha belgilangan shtat birligi:</label>
                                    <input class="form-control" type="text" name="staff_count" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bx bx-save font-size-16 align-middle me-2"></i> Saqlash
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center fw-bold">{{ __('messages.no') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.staff') }}</th>
                            <th class="text-center fw-bold">Kategoriya</th>
                            <th class="text-center fw-bold">Soni</th>
                            <th class="text-center fw-bold">Soni(Fakt)</th>
                            <th class="text-center fw-bold">Vakant/Sverx</th>
                            <th class="text-center fw-bold" width="230">{{ __('messages.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($staffs))
                            @foreach ($staffs as $key => $staff)
                                <tr>
                                    <td class="text-center fw-bold">
                                        {{ $staffs->currentPage() * 10 - 10 + $loop->index + 1 }}</td>
                                    <td class="text-center fw-bold" style="font-size: 14px">{{ $staff->name }}</td>
                                    <td class="text-center fw-bold">
                                        @if ($staff->category_id != '0' || $staff->category_id != 0)
                                            {{ $staff->category->name }}
                                        @endif
                                    </td>
                                    <td class="text-center fw-bold">{{ $staff->staff_count }}</td>
                                    <td class="text-center fw-bold">{{ $arr[$staff->id] }}</td>
                                    <td class="text-center">
                                        @if ($arr[$staff->id] > floatval($staff->staff_count))
                                            <span class="text-danger fw-bold">Sverx -
                                                {{ $arr[$staff->id] - floatval($staff->staff_count) }}</span>
                                        @elseif($arr[$staff->id] < floatval($staff->staff_count))
                                            <span class="text-success fw-bold">Vakant -
                                                {{ floatval($staff->staff_count) - $arr[$staff->id] }}</span>
                                        @else
                                            <span class="fw-bold">0/0</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a type="button"
                                            href="{{ route('cadry_staff_view', ['id' => $staff->id]) }}"
                                            class="btn btn-soft-primary waves-effect" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Xodimlarni ko'rish">
                                            <i class="bx bx-user font-size-16 align-middle"></i>
                                        </a>
                                        <span data-bs-toggle="modal" data-bs-target="#addfile{{ $staff->id }}">
                                            <button type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="Faylni yuklash"
                                                class="btn btn-soft-dark waves-effect">
                                                <i class="bx bx-plus font-size-16 align-middle"></i>
                                            </button>
                                        </span>
                                        <span data-bs-toggle="modal" data-bs-target="#editstaff{{ $staff->id }}">
                                            <button type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="Taxrirlash"
                                                class="btn btn-soft-secondary waves-effect">
                                                <i class="bx bx-edit font-size-16 align-middle"></i>
                                            </button>
                                        </span>
                                        <span data-bs-toggle="modal" data-bs-target="#dellstaff{{ $staff->id }}">
                                            <button type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="O'chirish"
                                                class="btn btn-soft-danger waves-effect">
                                                <i class="bx bx-trash font-size-16 align-middle"></i>
                                            </button>
                                        </span>
                                    </td>
                                </tr>
                                <div class="modal fade" id="editstaff{{ $staff->id }}" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Lavozimni taxrirlash</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('edit_staf', ['id' => $staff->id]) }}"
                                                method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>Lavozimni nomi:</label>
                                                        <input class="form-control" type="text" name="name"
                                                            value="{{ $staff->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Kategoriyani belgilang:</label>
                                                        <select class="select2 js-example-programmatic form-control"
                                                            name="category_id" required>
                                                            @foreach ($categories as $category)
                                                                @if ($staff->category_id == $category->id)
                                                                    <option value={{ $category->id }} selected>
                                                                        {{ $category->name }} </option>
                                                                @else
                                                                    <option value={{ $category->id }}>
                                                                        {{ $category->name }} </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <h6><label>Lavozim bo'yicha belgilangan shtat birligi:</label>
                                                        </h6>
                                                        <input class="form-control" type="text" name="staff_count"
                                                            value="{{ $staff->staff_count }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="submit"> <i
                                                            class="bx bx-edit font-size-16 align-middle"></i>
                                                        Taxrirlash </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="addfile{{ $staff->id }}" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Yo'riqnoma</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action=""
                                                method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>Lavozim yo'riqnomasini yuklang:</label>
                                                        <input class="form-control" type="file" name="file_staff" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" type="submit"> <i
                                                            class="bx bx-save font-size-16 align-middle"></i>
                                                        Saqlash </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="dellstaff{{ $staff->id }}" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Lavozimni o'chirish</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('del_staf', ['id' => $staff->id]) }}"
                                                method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="fw-bold">{{ $staff->name }} lavozimini
                                                            o'chirishni xoxlaysizmi ?</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-danger" type="submit"> <i
                                                            class="bx bx-trash font-size-16 align-middle"></i> Xa,
                                                        O'chirish</button>
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

            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <form action="{{ route('staff') }}" method="get">
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
                                {{ $staffs->withQueryString()->links() }}
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
