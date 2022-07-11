@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Bola parvarishlash ta'tili</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">{{ __('messages.menu') }}</a></li>
                        <li class="breadcrumb-item active">Ta'til</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <div class="mb-3">
                        <label>Prikaz raqami</label>
                        <input type="text" class="form-control" placeholder="Prikaz raqamini kiriting" required>
                    </div>
                    <div class="mb-3">
                        <label>Ta'tilga chiqish sanasi</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>O'rniga ishlaydigan xodimni ko'rsating</label>
                        <select name="" id="" class="js-example-basic-single" style="width: 100%">
                            @foreach ($fullcadries as $cadry)
                                <option value="">{{ $cadry->last_name }} {{ $cadry->first_name }} {{ $cadry->middle_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                            <input type="checkbox" class="form-check-input" id="cust4">
                            <label class="form-check-label" for="cust4"> O'rniga ishlovchi xodimning mehnat faoliyati o'gartirilsinmi ?</label>
                        </div>
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
