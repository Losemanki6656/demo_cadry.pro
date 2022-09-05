@extends('layouts.master')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Ta'tildagi xodimlar</h4>

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
                    <a type="button" href="{{ route('addVacation') }}" class="btn btn-primary btn-sm mb-2">
                        <i class="fa fa-plus"></i> Ta'tilga yuborish</a>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped animate__animated animate__fadeIn table-sm">
                            <thead class="thead-dark ">
                                <tr>
                                    <th class="text-center fw-bold" width="60px">{{ __('messages.no') }}</th>
                                    <th class="text-center fw-bold" width="60px">Status</th>
                                    <th class="text-center fw-bold" width="60px">{{ __('messages.photo') }}</th>
                                    <th class="text-center fw-bold" width="350px">{{ __('messages.fio') }}</th>
                                    <th class="text-center fw-bold">Qachondan</th>
                                    <th class="text-center fw-bold">Qachongacha</th>
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
                                            <td class="text-center align-middle">
                                                @if ($item->status_decret == true)
                                                <div class="bg-primary p-2"></div>
                                                @else
                                                <div class="bg-warning p-2"></div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ asset('storage/' . $item->cadry->photo) }}"
                                                    class="image-popup-desc"
                                                    data-title="{{ $item->cadry->last_name }} {{ $item->cadry->first_name }} {{ $item->cadry->middle_name }}">
                                                    <img class="rounded avatar"
                                                        src="{{ asset('storage/' . $item->cadry->photo) }}" height="40"
                                                        width="40">
                                                </a>

                                            </td>
                                            <td class="text-center align-middle fw-bold"><a 
                                                    class="text-dark"> {{ $item->cadry->last_name }}
                                                    {{ $item->cadry->first_name }}
                                                    {{ $item->cadry->middle_name }}</a></td>
                                            <td class="text-center align-middle">{{ $item->date1->format('Y-m-d') }} dan
                                            </td>
                                            <td class="text-center align-middle">
                                               @if ($item->status_decret == true)
                                                    Bola parvarish ta'tilida
                                               @else
                                                    {{ $item->date2->format('Y-m-d') }} gacha
                                               @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('editVacation',['id' => $item->id]) }}" type="button" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-edit"></i> Taxrirlash</a>
                                                <a onclick="delFunc({{ $item->id }})" type="button" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i> O'chirish</a>

                                            </td>
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
            </tr>
        </tbody>
    </table>


@endsection

@section('scripts')
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
<script>
      function delFunc(id){
        Swal.fire({
                text: "Xodimga tegishli ta'tilni o'chirishni xoxlaysizmi ?!",
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
                        url: "{{ route('deleteVacationPost') }}",
                        data: {
                            "id": id,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Success!",
                                text: "Ta'til o'chirildi!",
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
