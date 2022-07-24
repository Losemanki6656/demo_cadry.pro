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
                        <form action="{{ route('save_archive_cadry',['id' => $cadry->id]) }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label> Ishga qabul qilingan sanasi</label>
                                <input type="date" name="post_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label> Qabul qilingan bo'limni tanlang</label>
                                <select class="js-example-basic-single" name="department_id" required style="width: 100%">
                                    <option value="">--Tanlash--</option>
                                    @foreach ($departments as $dep)
                                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label> Qabul qilingan lavozimni tanlang</label>
                                <select class="js-example-basic-single" name="staff_id" required style="width: 100%">
                                    <option value="">--Tanlash--</option>
                                    @foreach ($staffs as $staff)
                                        <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label> Lavozimning to'liq nomi</label>
                                <textarea name="full_post" class="form-control"></textarea>
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
@endsection
