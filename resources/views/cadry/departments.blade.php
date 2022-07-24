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
                <h4 class="mb-sm-0 font-size-18">Bo'limlar</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Bosh menu</a></li>
                        <li class="breadcrumb-item active">Bo'limlar</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <form action="{{ route('departments') }}" method="get">
                                    <div class="dataTables_length" id="datatable_length">
                                        <label><input type="search" class="form-control form-control"
                                                placeholder="Search ..." name="search"
                                                value="{{ request()->query('search') }}"></label>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="datatable_filter" class="dataTables_filter">
                                    <button type="button" class="btn btn-primary w-sm waves-effect waves-ligh"
                                        data-bs-toggle="modal" data-bs-target="#adddepartment">
                                        <i class="bx bx-plus font-size-16 align-middle me-2"></i> Bo'lim qo'shish
                                    </button>
                                </div>
                                <div class="modal fade" id="adddepartment" tabindex="-1" role="dialog"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Bo'lim qo'shish</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('add_department') }}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <h6><label>Bo'lim nomini kiriting:</label></h6>
                                                        <input class="form-control" type="text" name="name">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-primary" type="submit"> <i
                                                            class="fas fa-plus"></i> Qo'shish </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mt-1">
                        <table class="table table-bordered table-striped table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center fw-bold">#</th>
                                    <th class="text-center fw-bold">Bo'lim nomi</th>
                                    <th class="text-center fw-bold">Ishchilar soni</th>
                                    <th class="text-center" width="180">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departments as $department)
                                    <tr>
                                        <td class="text-center fw-bold">
                                            {{ $departments->currentPage() * 10 - 10 + $loop->index + 1 }}</td>
                                        <td class="text-center fw-bold" style="font-size: 14px">
                                            {{ $department->name }}</td>
                                        <td class="text-center fw-bold">{{ $department->cadries->where('status',true)->count() }}</td>
                                        <td class="text-center">
                                            <a type="button"
                                                href="{{ route('cadry_department', ['id' => $department->id]) }}"
                                                class="btn btn-soft-primary waves-effect" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="Xodimlarni ko'rish">
                                                <i class="bx bx-user font-size-16 align-middle"></i>
                                            </a>

                                            <span data-bs-toggle="modal" data-bs-target="#del{{ $department->id }}">
                                                <button type="button" class="btn btn-soft-secondary waves-effect"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    title="Taxrirlash">
                                                    <i class="bx bx-edit font-size-16 align-middle"></i>
                                                </button>
                                            </span>

                                            <span data-bs-toggle="modal"
                                                data-bs-target="#delete{{ $department->id }}">
                                                <button type="button" class="btn btn-soft-danger waves-effect"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    title="O'chirish">
                                                    <i class="bx bx-trash font-size-16 align-middle"></i>
                                                </button>

                                            </span>

                                        </td>
                                    </tr>
                                    <div class="modal fade" id="del{{ $department->id }}" tabindex="-1"
                                        role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Taxrirlash</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form
                                                    action="{{ route('edit_department', ['id' => $department->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <h6><label>Bo'lim nomi:</label></h6>
                                                            <input class="form-control" type="text"
                                                                value="{{ $department->name }}" name="name">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-dark" type="submit"> <i
                                                                class="fas fa-edit"></i> Taxrirlash </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="delete{{ $department->id }}" tabindex="-1"
                                        role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Taxrirlash</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form
                                                    action="{{ route('delete_department', ['id' => $department->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <h6><label>{{ $department->name }} bo'limni o'chirishni
                                                                    xoxlaysizmi
                                                                    ?</label></h6>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-danger" type="submit"> <i
                                                                class="fas fa-trash"></i> Xa, O'chirish</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <ul class="pagination mb-0">
                            {{ $departments->withQueryString()->links() }}
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
@endsection
