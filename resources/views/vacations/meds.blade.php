@extends('layouts.master')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Tibbiy ko'rik</h4>

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
            <form action="{{ route('meds') }}" method="get">
                <div class="row mb-2">
                    <div class="col-3 col-sm-6 col-lg-2">
                        <input type="search" id="name_se" class="form-control" placeholder="Qidirish ..."
                            value="{{ request('name_se') }}" name="name_se">
                    </div>
                    <div class="col-3 col-sm-6 col-lg-2">
                        <a href="{{ route('AddInfoMed') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Ma'lumot qo'shish</a>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped animate__animated animate__fadeIn table-sm">
                            <thead class="thead-dark ">
                                <tr>
                                    <th class="text-center fw-bold" width="60px">{{ __('messages.no') }}</th>
                                    <th class="text-center fw-bold" width="60px">{{ __('messages.photo') }}</th>
                                    <th class="text-center fw-bold" width="350px">{{ __('messages.fio') }}</th>
                                    <th class="text-center fw-bold">Oxirgi o'tgan vaqti</th>
                                    <th class="text-center fw-bold">Izoh</th>
                                    <th class="text-center fw-bold">Kengi o'tish sanasi</th>
                                    <th class="text-center fw-bold">Status</th>
                                    <th width="200px" class="text-center fw-bold">{{ __('messages.action') }}</th>
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
                                                <a href="{{ asset('storage/' . $item->photo) }}" class="image-popup-desc"
                                                    data-title="{{ $item->last_name }} {{ $item->first_name }} {{ $item->middle_name }}">
                                                    <img class="rounded avatar"
                                                        src="{{ asset('storage/' . $item->photo) }}" height="40"
                                                        width="40">
                                                </a>

                                            </td>
                                            <td class="text-center align-middle fw-bold"><a class="text-dark">
                                                    {{ $item->last_name }}
                                                    {{ $item->first_name }}
                                                    {{ $item->middle_name }}</a></td>
                                            @if ($item->med)
                                                <td class="text-center align-middle">
                                                    {{ $item->med->date1->format('Y-m-d') }}
                                                </td>
                                                <td class="text-center align-middle">
                                                    {{ $item->med->result }}
                                                </td>
                                                <td class="text-center align-middle">
                                                    {{ $item->med->date2->format('Y-m-d') }}
                                                </td>
                                                <td class="text-center align-middle">
                                                    @if ($item->med->date2 > now())
                                                        @if ($item->med->date2->diffInDays() + 1 > 12)
                                                            <span class="text-primary" style="font-weight: bold">
                                                                {{ $item->med->date2->diffInDays() + 1 }} </span>kun qoldi
                                                        @else
                                                            <span class="text-warning" style="font-weight: bold">
                                                                {{ $item->med->date2->diffInDays() + 1 }} </span>kun qoldi
                                                        @endif
                                                    @else
                                                        <span class="text-danger" style="font-weight: bold"> Muddat tugagan
                                                        </span>
                                                    @endif
                                                </td>
                                            @else
                                                <td class="text-center align-middle"><span class="text-primary"> - </span>
                                                </td>
                                                <td class="text-center align-middle"><span class="text-primary"> - </span>
                                                </td>
                                                <td class="text-center align-middle"><span class="text-primary"> - </span>
                                                </td>
                                                <td></td>
                                            @endif

                                            <td class="text-center align-middle">
                                                <a type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#edit{{ $item->id }}">
                                                    <i class="fa fa-edit"></i> Taxrirlash</a>
                                                <a type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#addMed{{ $item->id }}">
                                                    <i class="fa fa-check"></i> Tasdiqlash</a>
                                            </td>
                                            @if ($item->med)
                                                <div class="modal fade" id="edit{{ $item->id }}" tabindex="-1"
                                                    role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title text-primary">Taxrirlash</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('editMed', ['id' => $item->id]) }}"
                                                                method="post">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="row mb-3">
                                                                        <div class="col">
                                                                            <label>Oxirgi o'tgan sanasi</label>
                                                                            <input type="date" class="form-control"
                                                                                name="date1"
                                                                                @if ($item->med) value = "{{ $item->med->date1->format('Y-m-d') }}" @endif>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label>Keyingi o'tish sanasi</label>
                                                                            <input type="date" class="form-control"
                                                                                name="date2"
                                                                                @if ($item->med) value = "{{ $item->med->date2->format('Y-m-d') }}" @endif>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Izoh</label>
                                                                        <textarea name="result" class="form-control">
@if ($item->med)
{{ $item->med->result }}
@endif
</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-primary" type="submit"> <i
                                                                            class="bx bx-edit font-size-16 align-middle me-2"></i>
                                                                        Taxrirlash </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="modal fade" id="addMed{{ $item->id }}" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-success">Tasdiqlash</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('addMed', ['id' => $item->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <div class="col">
                                                                        <label>Ko'rikdan o'tgan sanasi</label>
                                                                        <input type="date" class="form-control"
                                                                            name="date1" required>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label>Keyingi o'tish sanasi</label>
                                                                        <input type="date" class="form-control"
                                                                            name="date2" required>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label>Izoh</label>
                                                                    <textarea name="result" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-success" type="submit"> <i
                                                                        class="bx bx-edit font-size-16 align-middle me-2"></i>
                                                                    Tasdiqlash </button>
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
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script>
        flatpickr("#datepicker-basic", {
            defaultDate: new Date()
        });
    </script>
    <script>
        $(document).ready(function() {
            var msg = '{{ Session::get('msg') }}';
            var exist = '{{ Session::has('msg') }}';
            if (exist) {
                if (msg == 2) {
                    Swal.fire({
                        title: "Amalga oshirilmadi",
                        text: "!",
                        icon: "warning",
                        confirmButtonColor: "#1c84ee"
                    });
                } else if (msg == 1) {
                    Swal.fire({
                        title: "Good!",
                        text: "Muvaffaqqiyatli bajarildi!",
                        icon: "success",
                        confirmButtonColor: "#1c84ee",
                    }).then(function() {
                        location.reload();
                    });
                }
            }

        });
    </script>
@endsection
