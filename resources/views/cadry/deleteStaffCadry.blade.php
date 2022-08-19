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
                <form action="{{ route('successEditStaffCadry', ['id' => $item->id]) }}" method="post">
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

                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <label class="fw-bold text-primary">Bo'linmani tanlang</label>
                            <select class="js-example-basic-single department" name="department_id" id="department_id"
                                style="width: 100%" required>
                                <option value="{{ $item->department_id }}">{{ $item->department->name }}</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold text-primary">Lavozimni tanlang</label>
                            <select name="staff_id" id="staff_id" style="width: 100%" class="js-example-basic-single staff"
                                required>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id }}" @if ($item->department_staff_id == $staff->id) selected @endif>
                                        {{ $staff->id }} - {{ $staff->staff_full }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <div class="row">
                                <div class="col">
                                    <span class="fw-bold text-primary">Stavka</span>
                                    <input type="number" name="st_1" value="{{ $item->stavka }}" class="form-control"
                                        step="0.01">
                                </div>
                                <div class="col">
                                    <span class="fw-bold text-primary">Faoliyat turi</span>
                                    <select name="staff_status" id="staff_status" class="form-select">
                                        <option value="0" @if ($item->staff_status == false) selected @endif>Asosiy
                                        </option>
                                        <option value="1" @if ($item->staff_status == true) selected @endif>O'rindosh
                                        </option>
                                    </select>
                                </div>
                                <div class="col">
                                    <span class="fw-bold text-primary">Lavozim sanasi</span>
                                    <input type="date" name="staff_date" value="{{ $item->staff_date }}"
                                        class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <input class="form-check-input" type="checkbox" id="careerCheck" onclick="CareerFunc()"
                                name="careerCheck">
                            <label class="form-check-label" for="careerCheck">
                                Xodim mehnat faoliyatiga yangi lavozim nomi qo'shilsinmi ?!
                            </label>
                        </div>

                        <div class="mb-4" id="carSt" style="display: none">
                            <label class="fw-bold text-primary">Mehnat faoliyatidagi qaysi lavozim yakunlanishini
                                ko'rsating</label>
                            <select name="career" id="career" style="width: 100%" class="career">
                            </select>
                        </div>

                        <button class="btn btn-outline-primary" type="submit" style="width: 100%"> O'zgartirish
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
