@extends('layouts.master')
@section('content')
    <link rel='stylesheet' href='https://foliotek.github.io/Croppie/croppie.css'>

    <style>
        label.cabinet {
            display: block;
            cursor: pointer;
        }

        label.cabinet input.file {
            position: relative;
            height: 100%;
            width: auto;
            opacity: 0;
            -moz-opacity: 0;
            filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0);
            margin-top: -30px;
        }

        #upload-demo {
            width: 250px;
            height: 250px;
            padding-bottom: 25px;
        }
    </style>
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Ma'lumotlarni taxrirlash</h4>
            <div class="flex-shrink-0">
                <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('cadry_edit', ['id' => $cadry->id]) }}" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Shaxsiy ma'lumotlari</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cadry_information', ['id' => $cadry->id]) }}" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Ma'lumoti</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cadry_career', ['id' => $cadry->id]) }}" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Mehnat faoliyati</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cadry_realy', ['id' => $cadry->id]) }}" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Yaqin qarindoshlari</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cadry_other', ['id' => $cadry->id]) }}" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block"> Qo'shimcha ma'lumotlar</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div><!-- end card header -->

        <div class="card-body">
            <div class="tab-content text-muted">
                <div class="tab-pane active" id="home2" role="tabpanel">
                    <form action="{{ route('edit_cadry_us', ['cadry' => $cadry->id]) }}" method="post"
                        class="needs-validation" enctype='multipart/form-data' novalidate>
                        @csrf
                        <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="dataTables_length" id="datatable_length">
                                        <h5>
                                            @if ($cadry->staff)
                                                {{ $cadry->staff->name }}
                                            @endif
                                        </h5>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <div id="datatable_filter" class="dataTables_filter">
                                        <a type="button" class="btn btn-primary btn-sm" id="sa-params"><i
                                                class="fas fa-angle-double-right"></i> Cyrillic To Latin </a>
                                        <a type="button" data-bs-toggle="modal" data-bs-target="#delcadry"
                                            class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Xizmat faoliyatini
                                            yakunlash </a>
                                        <label>
                                            <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i>
                                                Saqlash</button>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="cabinet center-block mb-2 pr-2 ml-1">
                                    <figure>
                                        <img src="{{ asset('storage/' . $cadry->photo) }}"
                                            class="gambar img-responsive img-thumbnail" width="120" height="120"
                                            id="item-img-output" />
                                        <figcaption><i class="fa fa-camera"></i></figcaption>
                                    </figure>
                                    <input type="file" class="item-img file center-block" value=""
                                        name="photo" />
                                </label>

                                <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Rasmni saqlash</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <div id="upload-demo" class="center-block"></div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="cropImageBtn" class="btn btn-dark"><i
                                                        class="fa fa-crop"></i> Crop</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <table>
                                    <tr>
                                        <td class="font-weight-bold">Familiyasi</td>
                                        <td>
                                            <input type="text" value="{{ $cadry->last_name }}" name="last_name"
                                                required class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Ismi</td>
                                        <td>
                                            <input type="text" class="form-control" value="{{ $cadry->first_name }}"
                                                name="first_name" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 140px" class="font-weight-bold">Otasining ismi</td>
                                        <td>
                                            <input type="text" class="form-control" value="{{ $cadry->middle_name }}"
                                                name="middle_name" required>
                                        </td>
                                    </tr>

                                </table>
                            </div>

                            <div class="col-12 col-md-6 col-lg-4">
                                <table>
                                    <tr>
                                        <td style="width: 190px" class="font-weight-bold">Tu'gilgan sanasi</td>
                                        <td>
                                            <input type="date" class="form-control" value="{{ $cadry->birht_date }}"
                                                name="birht_date" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Tug'ilgan joyi(V)</td>
                                        <td>
                                            <select class="loadregion" name="birth_region_id"
                                                style="max-width: 220px; width: 100%" required>
                                                @if ( $cadry->birth_region)
                                                    <option value="{{ $cadry->birth_region_id }}">
                                                            {{ $cadry->birth_region->name }}</option>
                                                @endif
                                            </select>
                                            <div class="invalid-feedback">Tug'ilgan viloyatini tanlang</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Tug'lgan joyi(T,SH)</td>
                                        <td>
                                            <select class="loadcity" name="birth_city_id"
                                                style="max-width: 220px; width: 100%" required>
                                              
                                                @if ( $cadry->birth_city)
                                                    <option value="{{ $cadry->birth_city_id }}">
                                                            {{ $cadry->birth_city->name }}</option>
                                                @endif
                                            </select>
                                            <div class="invalid-feedback">Tug'ilgan tuman yoki shaharni tanlang</div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive border rounded px-1 ">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>Yashash manzili(V)</th>
                                                <th>Yashash manzili(T)</th>
                                                <th>Qo'shimcha manzil</th>
                                                <th>Passport berilgan joyi(V)</th>
                                                <th>Passport berilgan joyi(T)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="220px">
                                                    <select class="loadregion1" name="address_region_id"
                                                        style="max-width: 220px; width: 100%" required>
                                                        @if ( $cadry->address_region)
                                                            <option value="{{ $cadry->address_region_id }}">
                                                                {{ $cadry->address_region->name }}</option>
                                                        @endif
                                                        
                                                    </select>
                                                    <div class="invalid-feedback">Обязательное поле</div>
                                                </td>
                                                <td width="220px">
                                                    <select class="loadcity1" name="address_city_id"
                                                        style="max-width: 220px; width: 100%" required>
                                                        @if ( $cadry->address_city)
                                                            <option value="{{ $cadry->address_city_id }}">
                                                                    {{ $cadry->address_city->name }}</option>
                                                        @endif
                                                    </select>
                                                    <div class="invalid-feedback">Обязательное поле</div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control"
                                                        value="{{ $cadry->address }}" name="address">
                                                </td>
                                                <td width="220px">
                                                    <select class="loadregion2" name="pass_region_id"
                                                        style="max-width: 220px; width: 100%" required>
                                                        @if ( $cadry->pass_region)
                                                            <option value="{{ $cadry->pass_region_id }}">
                                                                    {{ $cadry->pass_region->name }}</option>
                                                        @endif
                                                    </select>
                                                    <div class="invalid-feedback">Обязательное поле</div>
                                                </td>
                                                <td width="220px">
                                                    <select class="loadcity2" name="pass_city_id"
                                                        style="max-width: 220px; width: 100%" required>
                                                        @if ( $cadry->pass_city)
                                                            <option value="{{ $cadry->pass_city_id }}">
                                                                    {{ $cadry->pass_city->name }}</option>
                                                        @endif
                                                    </select>
                                                    <div class="invalid-feedback">Обязательное поле</div>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <div class="table-responsive border rounded">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th width="150px">Passport berilgan sanasi</th>
                                                <th width="220px">Passport ma'lumotlari</th>
                                                <th width="250px">JSHSHIR</th>
                                                <th width="130px">Jinsi</th>
                                                <th width="220px">Tel raqami</th>
                                                <th width="200px">Xizmat darajasi</th>
                                                <th width="150px">Qachondan beri ishlaydi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="date" class="form-control" name="pass_date"
                                                        value="{{ $cadry->pass_date }}" required>
                                                </td>
                                                <td>
                                                    <input type="text" class="passport form-control"
                                                        value="{{ $cadry->passport }}" name="passport" required>
                                                </td>

                                                <td>
                                                    <input type="text" class="jshshir form-control"
                                                        value="{{ $cadry->jshshir }}" name="jshshir" required>
                                                </td>
                                                <td>
                                                    <select class="form-select" name="sex" required>
                                                        @if ($cadry->sex == 1)
                                                            <option value="1" selected>Erkak</option>
                                                            <option value="0">Ayol</option>
                                                        @else
                                                            <option value="1">Erkak</option>
                                                            <option value="0" selected>Ayol</option>
                                                        @endif
                                                    </select>
                                                    <div class="invalid-feedback">Обязательное поле</div>
                                                </td>
                                                <td>
                                                    <input type="text" class="phone form-control"
                                                        value="{{ $cadry->phone }}" id="phone" name="phone"
                                                        required>
                                                </td>
                                                <td>
                                                    <select class="form-select" name="worklevel_id" required>
                                                        @foreach ($worklevel as $level)
                                                            <option value="{{ $level->id }}"
                                                                @if ($level->id == $cadry->worklevel_id) selected @endif>
                                                                {{ $level->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">Обязательное поле</div>
                                                </td>

                                                <td>
                                                    <input type="date" class="form-control"
                                                        value="{{ $cadry->job_date }}" name="job_date" required>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <div class="table-responsive border rounded px-1">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th class="fw-bold" width="200px">Lavozim sanasi</th>
                                                <th class="fw-bold">Lavozimi</th>
                                                <th class="fw-bold text-center" width="80px">Stavka</th>
                                                <th class="fw-bold text-center" width="130px">Faoliyat turi</th>
                                                <th class="fw-bold text-center" width="360px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cadry->allStaffs as $staff)
                                                <tr>
                                                    <td>
                                                        <input type="date" class="form-control"
                                                            value="{{ $staff->staff_date }}" name="post_date" required>
                                                    </td>
                                                    <td>
                                                        <input readonly class="form-control"
                                                            value="{{ $staff->staff_full }}">
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        {{ $staff->stavka }}
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        @if ($staff->staff_status == false)
                                                            Asosiy
                                                        @else
                                                            O'rindosh
                                                        @endif
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <a type="button"
                                                            href="{{ route('StaffCadryEdit', ['id' => $staff->id]) }}"
                                                            class="btn btn-secondary btn-sm"> <i class="fa fa-edit"></i>
                                                            Lavozimni o'zgartirish</a>
                                                            @if (count($cadry->allStaffs ) > 1)
                                                            <a href="{{ route('deleteStaffCadry', ['id' => $staff->id]) }}" type="button" class="btn btn-danger btn-sm"> <i
                                                                class="fa fa-trash"></i> Faoiliyatni yakunlash</a> 
                                                            @endif
                                                        
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                     
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="delcadry" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Xizmat faoliyatini yakunlash</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('delete_cadry', ['id' => $cadry->id]) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="fw-bold text-center">FIO: {{ $cadry->last_name }} {{ $cadry->first_name }}
                                {{ $cadry->middle_name }}</label>
                        </div>
                        <div class="mb-3">
                            <label>Prikaz raqami:</label>
                            <input class="form-control" type="text" name="number" required>
                        </div>
                        <div class="mb-3">
                            <label>Izoh:</label>
                            <textarea class="form-control" type="text" name="comment"></textarea>
                        </div>
                        <div class="mb-3">
                            <input class="form-check-input" type="checkbox" name="blackStatus" id="formCheck1">
                            <label class="form-check-label" for="formCheck1">
                                Mehnat faoliyati davrida yo'l qo'ygan qo'pol xatolari munosabati bilan
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="submit"> <i
                                class="bx bx-trash font-size-16 align-middle me-2"></i>
                            Yakunlash </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('.loadcity').select2({
            ajax: {
                url: '{{ route('loadcity') }}',
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
            placeholder: 'Qidirish',
            minimumInputLength: 1,
        });
    </script>
    <script>
        $('.loadcity1').select2({
            ajax: {
                url: '{{ route('loadcity') }}',
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
            placeholder: 'Qidirish',
            minimumInputLength: 1,
        });
    </script>
    <script>
        $('.loadcity2').select2({
            ajax: {
                url: '{{ route('loadcity') }}',
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
            placeholder: 'Qidirish',
            minimumInputLength: 1,
        });
    </script>
    <script>
        $('.loadregion').select2({
            ajax: {
                url: '{{ route('loadRegion') }}',
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
            placeholder: 'Qidirish',
            minimumInputLength: 1,
        });
    </script>
    <script>
        $('.loadregion1').select2({
            ajax: {
                url: '{{ route('loadRegion') }}',
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
            placeholder: 'Qidirish',
            minimumInputLength: 1,
        });
    </script>
    <script>
        $('.loadregion2').select2({
            ajax: {
                url: '{{ route('loadRegion') }}',
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
            placeholder: 'Qidirish',
            minimumInputLength: 1,
        });
    </script>
    <script>
        $('.js-example-basic-single').select2();
    </script>
    <script src="{{ asset('assets/croppie/croppie.js') }}"></script>
    <script src="{{ asset('assets/croppie/croppie.min.js') }}"></script>

    <script>
        var $uploadCrop,
            tempFilename,
            rawImg,
            imageId;

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.upload-demo').addClass('ready');
                    $('#cropImagePop').modal('show');
                    rawImg = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                swal("Kechirasiz, Amalga oshirish muvaffaqqiyatsiz bajarildi");
            }
        }

        $uploadCrop = $('#upload-demo').croppie({
            viewport: {
                width: 150,
                height: 200,
            },
            enforceBoundary: false,
            enableExif: true
        });
        $('#cropImagePop').on('shown.bs.modal', function() {
            // alert('Shown pop');
            $uploadCrop.croppie('bind', {
                url: rawImg
            }).then(function() {
                console.log('jQuery bind complete');
            });
        });

        $('.item-img').on('change', function() {
            imageId = $(this).data('id');
            tempFilename = $(this).val();
            $('#cancelCropBtn').data('id', imageId);
            readFile(this);
        });
        $('#cropImageBtn').on('click', function(ev) {
            $uploadCrop.croppie('result', {
                type: 'base64',
                format: 'jpeg',
                size: {
                    width: 150,
                    height: 200
                }
            }).then(function(resp) {
                $('#item-img-output').attr('src', resp);

                $('#cropImagePop').modal('hide');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.phone').inputmask('(99)-999-99-99');
        });

        $(document).ready(function() {
            $('.passport').inputmask('AA 9999999');
        });

        $(document).ready(function() {
            $('.jshshir').inputmask('99999999999999');
        });

        document.getElementById("sa-params").addEventListener("click", function() {
            Swal.fire({
                text: "Xodimga tegishli barcha ma'lumotlar krilldan lotinga o'zgartirishni xoxlaysizmi ?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Xa, bajarish!",
                cancelButtonText: "Yo'q, qaytish!",
                confirmButtonClass: "btn btn-success mt-2",
                cancelButtonClass: "btn btn-danger ms-2 mt-2",
                buttonsStyling: !1,
            }).then(function(e) {
                if (e.value) {

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('krilltolatin') }}",
                        data: {
                            "id": {!! $cadry->id !!},
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Success!",
                                text: "Xodim ma'lumotlari lotinchaga o'zgartirildi!",
                                icon: "success",
                                confirmButtonColor: "#1c84ee",
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error: function(response) {
                            Swal.fire({
                                title: "Error",
                                text: "Your imaginary file is safe :)",
                                icon: "error",
                                confirmButtonColor: "#1c84ee",
                            });
                        }
                    });

                } else {
                    e.dismiss;
                }
            });
        });
    </script>

    <script>
        function selins(sel) {
            var s = sel.value;
            var a = document.getElementById('ins')
            a.value = s;
        }
    </script>

    <script>
        $(document).ready(function() {
            @if (\Session::has('msg'))
                @if (Session::get('msg') == 1)
                    alertify.success("Taxrirlash muvaffaqqiyatli amalga oshirildi!");
                @endif
            @endif
        });
    </script>
    <script>
        $(document).ready(function() {
            var msg = '{{ Session::get('msg') }}';
            var exist = '{{ Session::has('msg') }}';
            if (exist) {
                if (msg == 3) {
                    Swal.fire({
                        title: "Good!",
                        text: "Muvafaqqiyatli qo'shildi",
                        icon: "success",
                        confirmButtonColor: "#1c84ee",
                    }).then(function() {
                        location.reload();
                    });
                }
                if (msg == 4) {
                    Swal.fire({
                        title: "Good!",
                        text: "Muvafaqqiyatli o'chirildi",
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
