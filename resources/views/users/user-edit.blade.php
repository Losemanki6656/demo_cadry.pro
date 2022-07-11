@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="profile-user"></div>
    </div>
</div>

<div class="row">
   <div class="profile-content">
       <div class="row align-items-end">
            <div class="col-sm">
                <div class="d-flex align-items-end mt-3 mt-sm-0">
                    <div class="flex-shrink-0">
                        <div class="avatar-xxl me-3">
                            <img src="{{asset($user[0]->photo)}}" alt="" class="img-fluid rounded-circle d-block img-thumbnail">
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div>
                            <h5 class="font-size-16 mb-1">{{Auth::user()->name}}</h5>
                            <p class="text-muted font-size-13 mb-2 pb-2">{{$user[0]->organization->name}}</p>
                        </div>
                    </div>
                </div>
            </div>
       </div>
   </div>
</div>

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

<div class="row mt-3">
    <div class="col-xl-9 col-lg-9">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">About</h5>
            </div>

            <div class="card-body">
                <div>
                 <form action="{{route('user_edit_success',['id' => $user[0]->id])}}" method="post" id="edit" class="needs-validation"
                        enctype='multipart/form-data' novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-6 col-md-6 col-lg-2">
                                <label class="cabinet center-block mb-2 pr-2 ml-1">
                                    <figure>
                                        <img src="{{asset($user[0]->photo)}}"
                                            class="gambar img-responsive img-thumbnail" width="120" height="120"
                                            id="item-img-output" />
                                        <figcaption><i class="fas fa-camera-retro"></i></figcaption>
                                    </figure>
                                    <input type="file" class="item-img file center-block" value="" name="photo" />
                                </label>
                                <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Rasmni saqlash</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <div class="col-12 col-md-6 col-lg-5">
                                <table>
                                    <tr>
                                        <td>FIO</td>
                                        <td>
                                            <input type="text" name="name" required class="form-control" value="{{Auth::user()->name}}" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 140px">Tel raqami</td>
                                        <td>
                                            <input type="text" name="phone" class="form-control phone" value="{{$user[0]->phone}}" required >
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 col-md-6 col-lg-5">
                                <table>
                                    <tr>
                                        <td>Email</td>
                                        <td>
                                            <input type="email" class="form-control"name="email" value="{{Auth::user()->email}}"  required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Parol</td>
                                        <td>
                                            <input type="password" name="password" required class="form-control" placeholder="Yangi parol .." required>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success"><i class="me-1"></i> Saqlash</button>
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
                @if (Session::get('msg') == 2)
                    alertify.error("Parol to'g'ri terilmadi !");
                @else 
                    alertify.success("Taxrirlash muvaffaqiyatli amalga oshirildi !");
                @endif
            @endif
        });
</script>
<script src="{{asset('assets/croppie/croppie.js')}}"></script>
<script src="{{asset('assets/croppie/croppie.min.js')}}"></script>
<script>
    var $uploadCrop,
        tempFilename,
        rawImg,
        imageId;
    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.upload-demo').addClass('ready');
                $('#cropImagePop').modal('show');
                rawImg = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
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
    $('#cropImagePop').on('shown.bs.modal', function () {
        // alert('Shown pop');
        $uploadCrop.croppie('bind', {
            url: rawImg
        }).then(function () {
            console.log('jQuery bind complete');
        });
    });

    $('.item-img').on('change', function () {
        imageId = $(this).data('id'); tempFilename = $(this).val();
        $('#cancelCropBtn').data('id', imageId); readFile(this);
    });
    $('#cropImageBtn').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'base64',
            format: 'jpeg',
            size: { width: 150, height: 200 }
        }).then(function (resp) {
            $('#item-img-output').attr('src', resp);

            $('#cropImagePop').modal('hide');
        });
    });									
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $('.phone').inputmask('+999(99)-999-99-99');
    });
</script>

@endsection