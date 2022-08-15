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
        @foreach ($cadries as $item)
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <label>FIO:</label>
                            <h5>{{ $item->cadry->last_name }} {{ $item->cadry->first_name }} {{ $item->cadry->middle_name }}
                            </h5>
                        </div>
                        <div class="mb-4">
                            <label>Bo'linma:</label>
                            <h5>{{ $item->department->name }}</h5>
                        </div>
                        <div class="mb-4">
                            <label>Lavozimi:</label>
                            <h5>{{ $item->staff_full }}</h5>
                        </div>

                        <div class="mb-4">
                            <label>Stavka</label>
                            <h5>{{ $item->stavka }}</h5>
                        </div>

                        <a type="button" href="{{ route('StaffCadryEdit', ['id' => $item->id]) }}"
                            class="btn btn-outline-primary" style="width: 100%"> O'zgartirish </a>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            @if (\Session::has('msg'))
                @if (Session::get('msg') == 1)
                    Swal.fire({
                        title: "Amalga oshirilmadi",
                        text: "Xodimning stavkasi amaldagi bo'sh lavozim stavkasiga to'gri kelmadi!",
                        icon: "warning",
                        confirmButtonColor: "#1c84ee"
                    });
                @endif
            @endif
        });
    </script>
    <script>
        $('.department').select2({
            ajax: {
                url: '{{ route('loadDepartment') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: name,
                                id: item.id
                            }
                        }),
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            placeholder: "Bo'linmani tanlang",
            minimumInputLength: 1,
        });
    </script>
@endsection
