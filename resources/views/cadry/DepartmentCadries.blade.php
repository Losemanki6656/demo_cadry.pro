@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Lavozimlar</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Bo'limlar</a></li>
                        <li class="breadcrumb-item active">Lavozimlar</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    @if (count($cadries))
    <div class="row">
        <div class="col-xl-8">
            <a type="button" href="{{ route('department_cadry_add',['id' => $cadries[0]->department_staff_id]) }}" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Xodim qo'shish</a>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered align-middle mb-0 table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center fw-bold" width="50px">Status</th>
                                    <th class="text-center fw-bold" width="100px">Photo</th>
                                    <th class="text-center fw-bold">
                                        {{ $cadries[0]->staff->name }} lavozimiga tegishli xodimlar
                                    </th>
                                    <th class="text-center fw-bold">Stavka</th>
                                    <th class="text-center fw-bold" width="80px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cadries as $item)
                                    <tr>
                                        <td>
                                            @if ($item->status_sv == false)
                                                <div class="bg-success bg-gradient p-2"></div>
                                            @else
                                                <div class="bg-danger bg-gradient p-2"></div>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            <a href="{{ asset('storage/' . $item->cadry->photo) }}" class="image-popup-desc">
                                                <img class="rounded avatar"
                                                    src="{{ asset('storage/' . $item->cadry->photo) }}" height="40"
                                                    width="40">
                                            </a>
                                        </td>
                                        <td class="text-center">{{ $item->cadry->last_name }} {{ $item->cadry->first_name }}
                                            {{ $item->cadry->middle_name }}
                                            @if ($item->status == true)
                                                 (Dekretdagi xodim o'rniga)
                                            @endif
                                         </td>
                                        <td class="text-center fw-bold">{{ $item->stavka }}</td>
                                        <td class="text-center fw-bold">
                                            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editcadryStaff{{ $item->id }}"> <i
                                                    class="fa fa-edit"></i></button>
                                            <button class="btn btn-danger btn-sm" onclick="deleteFunc({{ $item->id }})">
                                                <i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="editcadryStaff{{ $item->id }}" tabindex="-1"
                                        role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"> Taxrirlash
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('editcadryStaffStatus', ['id' => $item->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <h5 class="fw-bold">Lavozim nomi </h5>
                                                            {{ $item->cadry->last_name }} {{ $item->cadry->first_name }}
                                                            {{ $item->cadry->middle_name }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <h5 class="card-title me-2">Stavka</h5>
                                                            <input type="number" name="st_1" value="{{ $item->stavka }}" class="form-control"
                                                            step="0.01">
                                                        </div>
                                                        <div class="mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="formCheck{{ $item->id }}"
                                                                @if ($item->status_sv == true) checked @endif
                                                                name="status_sv">
                                                            <label class="form-check-label"
                                                                for="formCheck{{ $item->id }}">
                                                                Ortiqcha ish o'rni
                                                            </label>
                                                        </div>
                                                        <div class="mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                @if ($item->status == true) checked @endif
                                                                id="formCh{{ $item->id }}" name="status_decret">
                                                            <label class="form-check-label"
                                                                for="formCh{{ $item->id }}">
                                                                Dekretdagi xodim o'rniga
                                                            </label>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <table>
                <tbody>
                    <tr>
                        <td style="width: 120px;">
                            <span>Asosiy ish o'rni</span>
                        </td>
                        <td style="width: 50px;">
                            <div class="bg-success bg-gradient p-2"></div>
                        </td>
                        <td style="width: 30px;"></td>
                        <td style="width: 135px;">
                            <span>Ortiqcha ish o'rni</span>
                        </td>
                        <td style="width: 50px;">
                            <div class="bg-danger p-2"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- end col -->
    </div>
    @endif
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            @if (\Session::has('msg'))
                @if (Session::get('msg') == 1)
                    Swal.fire({
                        title: "Good!",
                        text: "Muvaffaqqiyatli bajarildi!",
                        icon: "success",
                        showCancelButton: !0,
                        confirmButtonColor: "#1c84ee",
                        cancelButtonColor: "#fd625e",
                    });
                @endif
            @endif
        });
    </script>
    <script>
        function deleteFunc(id) {
            Swal.fire({
                text: "Ushbu ish o'rnini o'chirishni xoxlaysizmi",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Xa, bajarish!",
                cancelButtonText: "Yo'q, qaytish!",
                confirmButtonClass: "btn btn-success mt-2",
                cancelButtonClass: "btn btn-danger ms-2 mt-2",
                buttonsStyling: !1,
            }).then(function(e) {
                if (e.value) {

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('deleteDepCadry') }}",
                        data: {
                            "id": id,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Success!",
                                text: "Ish o'rni o'chirildi",
                                icon: "success",
                                confirmButtonColor: "#1c84ee",
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error: function(response) {
                            Swal.fire({
                                title: "Xato",
                                text: "Xodimning asosiy ish faoliyatini o'chirish xatoiligi :)",
                                icon: "error",
                                confirmButtonColor: "#1c84ee",
                            });
                        }
                    });

                } else {
                    e.dismiss;
                }
            });
        }
    </script>
@endsection
