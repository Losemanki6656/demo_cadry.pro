@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Ta'tillar</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Bo'limlar</a></li>
                        <li class="breadcrumb-item active">Ta'tillar</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <form action="{{ route('editVacationPost',['id' => $item->id]) }}" method="post">
                    @csrf
                    <div class="card-body">

                        <div class="mb-4">
                            <label class="fw-bold text-primary">Ta'til turini tanlang</label>
                            <select class="form-select" name="status_vacation" id="status_vacation" required>
                                <option value="0" @if ($item->status_decret == 0)
                                    selected
                                @endif>Mehnat ta'tili</option>
                                <option value="1"  @if ($item->status_decret == 1)
                                    selected
                                @endif>Bola parvarish ta'tili</option>
                            </select>
                        </div>

                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <label class="fw-bold text-primary">Xodimni kiriting</label>
                            <select class="js-example-basic-single cadry" name="cadry_id" id="cadry_id" style="width: 100%"
                                required>
                                <option value="{{$item->cadry_id}}"> {{ $item->cadry->last_name }}  {{ $item->cadry->first_name }}  {{ $item->cadry->middle_name }}</option>
                            </select>
                        </div>

                        

                        <div class="mb-4">
                            <div class="row">
                                <div class="col">
                                    <span class="fw-bold text-primary">Qachondan</span>
                                    <input type="date" name="date1" id="date1" value="{{ $item->date1->format('Y-m-d') }}" class="form-control" required>
                                </div>
                                <div class="col">
                                    <span class="fw-bold text-primary">Qachongacha</span>
                                    <input type="date" name="date2" id="date2" @if ($item->date2)
                                    value="{{ $item->date2->format('Y-m-d') }}"
                                    @endif class="form-control">
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary" type="submit" style="width: 100%"> Taxrirlash
                        </button>

                    </div>
                </form>
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
                if (msg == 2) {
                    Swal.fire({
                        title: "Amalga oshirilmadi",
                        text: "Xodimning jinsi ta'til turiga to'g'ri kelmaydi!",
                        icon: "warning",
                        confirmButtonColor: "#1c84ee"
                    }).then(function() {
                        location.reload();
                    });
                } 
            }

        });
    </script>
     <script>
        $('.cadry').select2({
            ajax: {
                url: '{{ route('loadCadry') }}',
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
                                text: item.last_name + ' ' + item.first_name + ' ' + item.middle_name,
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
            placeholder: 'Xodim ismini kiriting',
            minimumInputLength: 1,
        });
    </script>
@endsection
