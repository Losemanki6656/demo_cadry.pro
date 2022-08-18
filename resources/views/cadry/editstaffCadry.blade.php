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
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('editDepStaff', ['id' => $item->id]) }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <h5 class="fw-bold">Lavozim nomi </h5>
                            {{ $item->staff->name }}
                        </div>
                        <div class="mb-3">
                            <h5 class="fw-bold">Lavozim to'liq nomi </h5>
                            <textarea name="staff_full" class="form-control">{{ $item->staff_full }}</textarea>
                        </div>
                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <h5 class="card-title me-2">Klassifikatordagi lavozim ko'rinishini tanlang</h5>
                            <select class="js-example-basic-single js-data-example-ajax" name="class_staff_id"
                                id="classifications" style="width: 100%">
                                @if ($item->classification)
                                     <option value="{{ $item->classification->id }}">{{ $item->classification->code_staff }} -  {{ $item->classification->name_uz }} </option>
                                @endif
                            </select>
                            
                        </div>
                        <div class="mb-3">
                            <h5 class="fw-bold">Stavka:<h5>
                                <input type="number" name="st_1" value="{{ $item->stavka }}" class="form-control"
                                step="0.01">
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
    </div>
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
        $('.js-data-example-ajax').select2({
            ajax: {
                url: '{{ route('loadClassification') }}',
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
                                text: item.code_staff + '-' + item.name_uz,
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
            placeholder: 'Lavozim nomini kiriting',
            minimumInputLength: 1,
        });
    </script>
@endsection
