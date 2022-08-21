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

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <form action="{{ route('SuccessDeleteCadryStaff', ['id' => $item->id]) }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="fw-bold text-primary">FIO:</label>
                            <h5>{{ $item->cadry->last_name }} {{ $item->cadry->first_name }} {{ $item->cadry->middle_name }}
                            </h5>
                            <input type="hidden" name="cadr" id="cadr" value="{{ $item->cadry_id }}">
                        </div>
                        <div class="mb-4">
                            <label class="fw-bold text-primary">Bo'linma:</label>
                            <h5>{{ $item->department->name }}</h5>
                        </div>
                        <div class="mb-4">
                            <label class="fw-bold text-primary">Lavozimi:</label>
                            <h5>{{ $item->staff_full }}</h5>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold text-primary">Stavka</label>
                            <h5>{{ $item->stavka }}</h5>
                        </div>

                        <div class="mb-4">
                            <div class="row">
                                <div class="col">
                                    <span class="fw-bold text-primary">Prikaz raqami</span>
                                    <input type="text" name="number"  class="form-control" value="">
                                </div>
                                <div class="col">
                                    <span class="fw-bold text-primary">Faoliyat yakunlanish sanasi</span>
                                    <input type="date" name="del_date"  class="form-control" required>
                                </div>
                            </div>
                        </div>


                        <div class="mb-4">
                            <label class="fw-bold text-primary">Mehnat faoliyatidagi qaysi lavozim yakunlanishini
                                ko'rsating</label>
                            <select name="career" id="career" style="width: 100%" class="career">
                                @foreach ($careers as $career)
                                    <option value="{{ $career->id }}">{{ $career->date1 }} - {{ $career->date2 }} - {{ $career->staff }} </option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-outline-danger" type="submit" style="width: 100%">Faoliyatni Yakunlash
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $('.career').select2();
</script>
@endsection
