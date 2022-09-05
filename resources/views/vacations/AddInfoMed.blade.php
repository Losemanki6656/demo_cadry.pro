@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Tibbiy ko'rik</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Bo'limlar</a></li>
                        <li class="breadcrumb-item active">Tibbiy ko'rik</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <form action="{{ route('addInfoMedSuccess') }}" method="post">
                    @csrf
                    <div class="card-body">

                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <label class="fw-bold text-primary">Xodimni kiriting</label>
                            <select class="js-example-basic-single cadry" name="cadry_id" id="cadry_id" style="width: 100%"
                                required>
                            </select>
                        </div>

                        <div class="mb-4">
                            <div class="row">
                                <div class="col">
                                    <span class="fw-bold text-primary">Oxirgi o'tgan sanasi</span>
                                    <input type="date" name="date1" id="date1" class="form-control" required>
                                </div>
                                <div class="col">
                                    <span class="fw-bold text-primary">Keyingi o'tish sanase</span>
                                    <input type="date" name="date2" id="date2" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label>Izoh</label>
                            <textarea name="result" class="form-control"></textarea>
                        </div>

                        <button class="btn btn-success" type="submit" style="width: 100%"> Saqlash
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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
