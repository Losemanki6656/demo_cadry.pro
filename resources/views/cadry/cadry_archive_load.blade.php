@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <img src="{{ asset('storage/' . $cadry->photo) }}" alt=""
                                        class="avatar-lg rounded-circle img-thumbnail">
                                </div>
                                <div class="flex-1 ms-3">
                                    <h5 class="font-size-15 mb-1">{{ $cadry->last_name }} {{ $cadry->first_name }}
                                        {{ $cadry->middle_name }}</h5>
                                    <p class="text-muted mb-0">{{ $cadry->organization->name }}</p>
                                </div>
                            </div>
                            <div class="mt-3 pt-1">
                                <p class="text-muted mb-0"><i
                                        class="mdi mdi-phone font-size-15 align-middle pe-2 text-primary"></i>
                                    {{ $cadry->phone }}</p>
                                <p class="text-muted mb-0 mt-2"><i
                                        class="mdi mdi-email font-size-15 align-middle pe-2 text-primary"></i>
                                    {{ $cadry->post_name }}</p>
                                <p class="text-muted mb-0 mt-2"><i
                                        class="mdi mdi-google-maps font-size-15 align-middle pe-2 text-primary"></i>
                                    {{ $item->region->name ?? '' }},{{ $item->city->name ?? '' }},{{ $item->address ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <form action="{{ route('save_archive_cadry', ['id' => $cadry->id]) }}" method="post">
                            @csrf
                            <div class="d-flex flex-wrap align-items-center mb-4">
                                <label class="fw-bold text-primary">Bo'linmani tanlang</label>
                                <select class="js-example-basic-single department" name="department_id" id="department_id"
                                    style="width: 100%" required>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="fw-bold text-primary">Lavozimni tanlang</label>
                                <select name="staff_id" id="staff_id" style="width: 100%"
                                    class="js-example-basic-single staff" required>
                                </select>
                            </div>
                            <div class="mb-4">
                                <div class="row">
                                    <div class="col">
                                        <span class="fw-bold text-primary">Stavka</span>
                                        <input type="number" name="st_1" value="1" class="form-control" step="0.01">
                                    </div>
                                    <div class="col">
                                        <span class="fw-bold text-primary">Faoliyat turi</span>
                                        <select name="staff_status" id="staff_status" class="form-select">
                                            <option value="0">Asosiy
                                            </option>
                                            <option value="1">O'rindosh
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <span class="fw-bold text-primary">Lavozim sanasi</span>
                                        <input type="date" name="staff_date" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <a class="btn btn-dark" type="button" style="width: 100%">Back</a>
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-primary" type="submit" style="width: 100%">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('.js-example-basic-single').select2();
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
                                text: item.name,
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
    <script>
        $('#department_id').change(function(e) {
            let department_id = $('#department_id').val();
            $.ajax({
                url: '{{ route('loadVacan') }}',
                type: 'GET',
                dataType: 'json',
                cache: false,
                data: {
                    department_id: department_id
                },
                success: function(data) {
                    var len = 0;
                    if (data != null) {
                        len = data.length;
                    }

                    if (len > 0) {
                        $("#staff_id").empty();
                        for (var i = 0; i < len; i++) {
                            console.log(len);
                            var id = data[i].id;
                            var name = data[i].staff_full;
                            var option = "<option value='" + id + "'>" + id + " - " + name +
                                "</option>";
                            $("#staff_id").append(option);
                        }
                    } else {
                        $("#staff_id").empty();
                        var option = "<option value=''>" + "Bo'sh ish o'rni mavjud emas!" + "</option>";
                        $("#staff_id").append(option);
                    }
                }
            });
        })
    </script>
@endsection
