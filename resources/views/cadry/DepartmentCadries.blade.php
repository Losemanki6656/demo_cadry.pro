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

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered align-middle table-nowrap table-hover mb-0 table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center fw-bold">
                                        {{ $cadries[0]->staff->name }} lavozimiga tegishli ish o'rinlari
                                    </th>
                                    <th class="text-center fw-bold">Stavka</th>
                                    <th class="text-center fw-bold" width="80px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cadries as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->cadry->last_name }} {{ $item->cadry->first_name }}
                                            {{ $item->cadry->middle_name }}</td>
                                        <td class="text-center">{{ $item->stavka }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm" onclick="deleteFunc({{$item->id}})"> <i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <!-- end col -->
    </div>
@endsection

@section('scripts')
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
                                title: "Error",
                                text: "Your imaginary file is safe :)",
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
