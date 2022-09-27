@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Ma'lumotlarni taxrirlash</h4>
            <div class="flex-shrink-0">
                <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cadry_edit', ['id' => $cadry->id]) }}" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Shaxsiy ma'lumotlari</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cadry_information', ['id' => $cadry->id]) }}" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Ma'lumoti</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cadry_career', ['id' => $cadry->id]) }}" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Mehnat faoliyati</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cadry_realy', ['id' => $cadry->id]) }}" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Yaqin qarindoshlari</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('cadry_other', ['id' => $cadry->id]) }}" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block"> Qo'shimcha ma'lumotlar</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content text-muted">
                <div class="tab-pane active" role="tabpanel">
                    <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_length" id="datatable_length">
                                    <h5>Intizomiy jazo</h5>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="datatable_filter" class="dataTables_filter">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#addintiz"><i class="fas fa-plus"></i> Qo'shish</button>
                                </div>
                                <div class="modal fade" id="addintiz" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ma'lumot qo'shish</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('add_discip_cadry', ['id' => $cadry->id]) }}"
                                                method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>Prikaz Nomer:</label>
                                                        <input type="text" class="form-control" name="number" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Sanasi:</label>
                                                        <input type="date" class="form-control" name="date_action"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Jazo turi:</label>
                                                        <input type="text" class="form-control" name="type_action"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Jazo sababi:</label>
                                                        <input type="text" class="form-control" name="reason_action"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-primary" type="submit"> <i
                                                            class="fas fa-save"></i> Saqlash </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Prikaz nomer</th>
                                <th scope="col">Sanasi</th>
                                <th scope="col">Jazo turi</th>
                                <th scope="col">Jazo sababi</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($discips as $discip)
                                <tr>
                                    <th>{{ $discip->number }}</th>
                                    <td>{{ $discip->date_action }}</td>
                                    <td>{{ $discip->type_action }}</td>
                                    <td>{{ $discip->reason_action }}</td>
                                    <td width="180">
                                        <button type="button" class="btn btn-soft-secondary waves-effect"
                                            data-bs-toggle="modal" data-bs-target="#editdiscip{{ $discip->id }}">
                                            <i class="bx bx-edit font-size-16 align-middle"></i>
                                        </button>
                                        <button type="button" class="btn btn-soft-danger waves-effect"
                                            data-bs-toggle="modal" data-bs-target="#deletediscip{{ $discip->id }}">
                                            <i class="bx bx-trash font-size-16 align-middle"></i>
                                        </button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="editdiscip{{ $discip->id }}" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ma'lumot taxrirlash</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('edit_discip_cadry', ['id' => $discip->id]) }}"
                                                method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>Prikaz Nomer:</label>
                                                        <input type="text" class="form-control" name="edit_number"
                                                            value="{{ $discip->number }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Sanasi:</label>
                                                        <input type="date" class="form-control"
                                                            name="edit_date_action" value="{{ $discip->date_action }}"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Jazo turi:</label>
                                                        <input type="text" class="form-control"
                                                            name="edit_type_action" value="{{ $discip->type_action }}"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Jazo sababi:</label>
                                                        <input type="text" class="form-control"
                                                            name="edit_reason_action"
                                                            value="{{ $discip->reason_action }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-primary" type="submit"> <i
                                                            class="fas fa-save"></i> Saqlash </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="deletediscip{{ $discip->id }}" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ma'lumotni o'chirish</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('delete_discip_cadry', ['id' => $discip->id]) }}"
                                                method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <h6><label>Malumotlarni o'chirmoqchmisiz ?</label></h6>
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
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="dataTables_length" id="datatable_length">
                            <h5>Tibbiy ko'rik</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped mb-0 table-sm">
                    <thead>
                        <tr>
                            <th>O'tgan sanasi</th>
                            <th>Xulosasi</th>
                            <th>Keyingi o'tish sanasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($meds as $med)
                            <tr>
                                <th>{{ $med->date1->format('Y-m-d') }}</th>
                                <td>{{ $med->result }}</td>
                                <td>{{ $med->date2->format('Y-m-d') }}</td>
                                <td width="180">
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deletemed{{ $med->id }}">
                                        <i class="bx bx-trash"></i> O'chirish
                                    </button>
                                </td>
                            </tr>
                            <div class="modal fade" id="deletemed{{ $med->id }}" tabindex="-1" role="dialog"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ma'lumotni O'chirish</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('delete_med_cadry', ['id' => $med->id]) }}"
                                            method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>Malumotni o'chirishni xoxlaysizmi ?</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-danger" type="submit"> <i
                                                        class="fas fa-trash"></i> Xa, O'chirish </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>

    
    <div class="card">
        <div class="card-body">
            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="dataTables_length" id="datatable_length">
                            <h5>Ta'tillar</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped mb-0 table-sm">
                    <thead>
                        <tr>
                            <th>Qachondan</th>
                            <th>Qachongacha</th>
                            <th>Ta'til turi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vacations as $vac)
                            <tr>
                                <th>{{ $vac->date1->format('Y-m-d') }}</th>
                                <td>{{ $vac->date2->format('Y-m-d') }}</td>
                                <td>
                                    @if ($vac->status_decret == 1)
                                        Bola parvarish ta'tili
                                    @else
                                        Mehnat ta'tili
                                    @endif
                                </td>
                                <td width="180">
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deletevac{{ $vac->id }}">
                                        <i class="bx bx-trash"></i> O'chirish
                                    </button>
                                </td>
                            </tr>
                            <div class="modal fade" id="deletevac{{ $vac->id }}" tabindex="-1" role="dialog"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ma'lumotni O'chirish</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('delete_vacation_cadry', ['id' => $vac->id]) }}"
                                            method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>Malumotni o'chirishni xoxlaysizmi ?</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-danger" type="submit"> <i
                                                        class="fas fa-trash"></i> Xa, O'chirish </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="dataTables_length" id="datatable_length">
                            <h5>Rag'batlantirish</h5>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div id="datatable_filter" class="dataTables_filter">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addincentive"><i class="fas fa-plus"></i> Qo'shish</button>
                        </div>
                        <div class="modal fade" id="addincentive" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ma'lumot qo'shish</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('add_incentive_cadry', ['id' => $cadry->id]) }}"
                                        method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Kim tomonidan:</label>
                                                <input type="text" class="form-control" name="by_whom" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Buyruq raqami:</label>
                                                <input type="text" class="form-control" name="number" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Sanasi:</label>
                                                <input type="date" class="form-control" name="incentive_date"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Rag'bat turi:</label>
                                                <input type="text" class="form-control" name="type_action" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Rag'bat sababi:</label>
                                                <input type="text" class="form-control" name="reason_action" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary" type="submit"> <i class="fas fa-save"></i>
                                                Saqlash </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Kim tomonidan</th>
                        <th>Buyruq raqami</th>
                        <th>Sanasi</th>
                        <th>Rag'bat turi</th>
                        <th>Rag'bat sababi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($incentives as $incentive)
                        <tr>
                            <th>{{ $incentive->by_whom }}</th>
                            <td>{{ $incentive->number }}</td>
                            <td>{{ $incentive->incentive_date }}</td>
                            <td>{{ $incentive->type_action }}</td>
                            <td>{{ $incentive->type_reason }}</td>
                            <td width="180">
                                <button type="button" class="btn btn-soft-secondary waves-effect" data-bs-toggle="modal"
                                    data-bs-target="#editicentive{{ $incentive->id }}">
                                    <i class="bx bx-edit font-size-16 align-middle"></i>
                                </button>
                                <button type="button" class="btn btn-soft-danger waves-effect" data-bs-toggle="modal"
                                    data-bs-target="#deleteicentive{{ $incentive->id }}">
                                    <i class="bx bx-trash font-size-16 align-middle"></i>
                                </button>
                            </td>
                        </tr>
                        <div class="modal fade" id="editicentive{{ $incentive->id }}" tabindex="-1" role="dialog"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ma'lumot qo'shish</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('edit_incentive_cadry', ['id' => $incentive->id]) }}"
                                        method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Kim tomonidan:</label>
                                                <input type="text" class="form-control" name="by_whom"
                                                    value="{{ $incentive->by_whom }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Buyruq raqami:</label>
                                                <input type="text" class="form-control" name="number"
                                                    value="{{ $incentive->number }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Sanasi:</label>
                                                <input type="date" class="form-control" name="incentive_date"
                                                    value="{{ $incentive->incentive_date }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Rag'bat turi:</label>
                                                <input type="text" class="form-control" name="type_action"
                                                    value="{{ $incentive->type_action }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Rag'bat sababi:</label>
                                                <input type="text" class="form-control" name="reason_action"
                                                    value="{{ $incentive->type_reason }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary" type="submit"> <i class="fas fa-save"></i>
                                                Saqlash </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="deleteicentive{{ $incentive->id }}" tabindex="-1" role="dialog"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ma'lumotni o'chirish</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('delete_incentive_cadry', ['id' => $incentive->id]) }}"
                                        method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Ma'lumotlarni o'chirishni xoxlaysizmi ?</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-danger" type="submit"> <i class="fas fa-trash"></i>
                                                Xa, O'chirish </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>

    <div class="card">
        <div class="card-body">
            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="dataTables_length" id="datatable_length">
                            <h5>Lavozim yo'riqnomasi</h5>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div id="datatable_filter" class="dataTables_filter">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addstaff"><i class="fas fa-plus"></i> Qo'shish</button>
                        </div>
                        <div class="modal fade" id="addstaff" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ma'lumot qo'shish</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('add_filestaff_cadry', ['id' => $cadry->id]) }}"
                                        method="post" enctype='multipart/form-data'>
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Izoh:</label>
                                                <input type="text" class="form-control" name="comment" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Fayl:</label>
                                                <input type="file" class="form-control" name="file_path" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary" type="submit"> <i class="fas fa-save"></i>
                                                Saqlash </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Izoh</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stafffiles as $stafffile)
                        <tr>
                            <th>{{ $stafffile->comment }}</th>
                            <td width="180">
                                <button type="button" class="btn btn-soft-secondary waves-effect" data-bs-toggle="modal"
                                    data-bs-target="#stafffileedit{{ $stafffile->id }}">
                                    <i class="bx bx-edit font-size-16 align-middle"></i>
                                </button>
                                <button type="button" class="btn btn-soft-danger waves-effect" data-bs-toggle="modal"
                                    data-bs-target="#stafffiledelete{{ $stafffile->id }}">
                                    <i class="bx bx-trash font-size-16 align-middle"></i>
                                </button>
                            </td>
                        </tr>
                        <div class="modal fade" id="stafffileedit{{ $stafffile->id }}" tabindex="-1" role="dialog"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ma'lumot qo'shish</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('edit_stafffile_cadry', ['id' => $stafffile->id]) }}"
                                        method="post" enctype='multipart/form-data'>
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Kim tomonidan:</label>
                                                <input type="text" class="form-control" name="comment"
                                                    value="{{ $stafffile->comment }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Buyruq raqami:</label>
                                                <input type="file" class="form-control" name="file_path" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary" type="submit"> <i class="fas fa-save"></i>
                                                Saqlash </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="stafffiledelete{{ $stafffile->id }}" tabindex="-1" role="dialog"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ma'lumotni o'chirish</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('delete_stafffile_cadry', ['id' => $stafffile->id]) }}"
                                        method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Ma'lumotlarni o'chirishni xoxlaysizmi ?</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-danger" type="submit"> <i class="fas fa-trash"></i>
                                                Xa, O'chirish </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.phone').inputmask('(99)-999-99-99');
        });

        $(document).ready(function() {
            $('.infodate').inputmask('9999');
        });

        $(document).ready(function() {
            $('.infodate2').inputmask('9999');
        });

        $(document).ready(function() {
            $('.passport').inputmask('AA 9999999');
        });
    </script>
@endsection
