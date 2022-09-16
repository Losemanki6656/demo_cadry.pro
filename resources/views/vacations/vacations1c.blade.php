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
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped animate__animated animate__fadeIn table-sm">
                            <thead class="thead-dark ">
                                <tr>
                                    <th class="text-center fw-bold" width="60px">{{ __('messages.no') }}</th>
                                    <th class="text-center fw-bold" width="60px">{{ __('messages.photo') }}</th>
                                    <th class="text-center fw-bold" width="350px">{{ __('messages.fio') }}</th>
                                    <th class="text-center fw-bold">Pikaz raqami</th>
                                    <th class="text-center fw-bold">Period1</th>
                                    <th class="text-center fw-bold">Period2</th>
                                    <th class="text-center fw-bold">Umumiy kun</th>
                                    <th class="text-center fw-bold">Qachondan</th>
                                    <th class="text-center fw-bold">Qachongacha</th>
                                    <th class="text-center fw-bold">Status</th>
                                    <th width="100px" class="text-center fw-bold">{{ __('messages.action') }}</th>
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
                                                <a href="{{ asset('storage/' . $item->cadry->photo) }}"
                                                    class="image-popup-desc"
                                                    data-title="{{ $item->cadry->last_name }} {{ $item->cadry->first_name }} {{ $item->cadry->middle_name }}">
                                                    <img class="rounded avatar"
                                                        src="{{ asset('storage/' . $item->cadry->photo) }}" height="40"
                                                        width="40">
                                                </a>

                                            </td>
                                            <td class="text-center align-middle fw-bold"><a class="text-dark">
                                                    {{ $item->cadry->last_name }}
                                                    {{ $item->cadry->first_name }}
                                                    {{ $item->cadry->middle_name }}</a></td>
                                            <td class="text-center align-middle fw-bold">
                                                {{$item->number_order}}
                                            </td>
                                            <td class="text-center align-middle fw-bold">
                                                {{$item->period1->format('Y-m-d')}}
                                            </td>
                                            <td class="text-center align-middle fw-bold"> 
                                                {{$item->period2->format('Y-m-d')}}
                                            </td>
                                            <td class="text-center align-middle fw-bold"> 
                                                {{$item->alldays}}
                                            </td>
                                            <td class="text-center align-middle">{{ $item->date1->format('Y-m-d') }} dan
                                            </td>
                                            <td class="text-center align-middle">
                                                @if ($item->status_decret == true)
                                                    Bola parvarish ta'tilida
                                                @else
                                                    {{ $item->date2->format('Y-m-d') }} gacha
                                                @endif
                                            </td>
                                            <td class="text-center align-middle fw-bold"> 
                                                @if ($item->status == true)
                                                    <span class="text-primary"> Kutilmoqda </span>
                                                @else
                                                    <span class="text-danger"> Xato </span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('deleteVacIntro',['id' => $item->id])}}" type="button"
                                                    class="btn btn-danger btn-sm">
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


@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var msg = '{{ Session::get('msg') }}';
            var exist = '{{ Session::has('msg') }}';
            if (exist) {
                 if (msg == 4) {
                    Swal.fire({
                        title: "Good!",
                        text: "Muvaffaqqiyatli o'chirildi!",
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
