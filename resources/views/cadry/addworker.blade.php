@extends('layouts.master')
@section('content')
<link rel='stylesheet' href='https://foliotek.github.io/Croppie/croppie.css'>

<style>
    label.cabinet{
	display: block;
	cursor: pointer;
}

label.cabinet input.file{
	position: relative;
	height: 100%;
	width: auto;
	opacity: 0;
	-moz-opacity: 0;
  filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
  margin-top:-30px;
}

#upload-demo{
	width: 250px;
	height: 250px;
  padding-bottom:25px;
}
</style>
<div class="card">
    <div class="card-body">
        <form action="{{route('addworkersuccess')}}" method="post"  class="needs-validation"
                    enctype='multipart/form-data' novalidate>
            @csrf
            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="dataTables_length" id="datatable_length">
                            <h5> Yangi xodim ma'lumotlari:</h5>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div id="datatable_filter" class="dataTables_filter">
                            <label>
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Saqlash</button>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">

                    <label class="cabinet center-block mb-2 pr-2 ml-1">
                        <figure>
                            <img src="{{asset('app-assets\images\favicon.png')}}"
                                class="gambar img-responsive img-thumbnail" id="item-img-output" width="120"
                                height="120" />
                            <figcaption><i class="fa fa-camera"></i></figcaption>
                        </figure>
                        <input type="file" class="item-img file center-block" value="" name="photo" />
                    </label>
                    <div class="modal fade text-left" id="cropImagePop" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel160" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-dark white">
                                    <h5 class="modal-title" id="myModalLabel160">Rasmni kesish</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div id="upload-demo" class="center-block"></div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                                <input type="text" class="form-control" name="last_name" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Ismi</td>
                            <td>
                                <input type="text" class="form-control" name="first_name" required>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 140px" class="font-weight-bold">Otasining ismi</td>
                            <td>
                                <input type="text" class="form-control" name="middle_name" required>
                            </td>
                        </tr>

                    </table>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <table class="ml-0 ml-sm-0 ml-lg-0">
                        <tr>
                            <td style="width: 190px" class="font-weight-bold">Tu'gilgan sanasi</td>
                            <td>
                                <input type="date" class="form-control" name="birht_date" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tug'ilgan joyi(V)</td>
                            <td>
                                <select class="js-example-basic-single" style="max-width: 220px" name="birth_region_id" required>
                                    <option value="">--Tanlash--</option>
                                    @foreach ($regions as $region)
                                        <option value="{{$region->id}}">{{$region->name}}</option>
                                    @endforeach
                                </select>                                       
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tug'lgan joyi(T)</td>
                            <td>
                                <select class="js-example-basic-single" style="max-width: 220px" name="birth_city_id"
                                    required>
                                    <option value="">--Tanlash--</option>
                                    @foreach ($cities as $city)
                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
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
                                    <th>Yashash manzili(T,Sh)</th>
                                    <th>Qo'shimcha manzili</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="300px">
                                        <select class="js-example-basic-single" name="address_region_id" style="width: 100%;" required>
                                            <option value="">--Tanlash--</option>
                                            @foreach ($regions as $region)
                                                <option value="{{$region->id}}">{{$region->name}}</option>
                                            @endforeach
                                        </select>                                       
                                    </td>
                                    <td width="300px">
                                        <select class="js-example-basic-single" name="address_city_id"
                                            required>
                                            <option value="">--Tanlash--</option>
                                            @foreach ($cities as $city)
                                            <option value="{{$city->id}}">{{$city->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="address">
                                    </td>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
             <div class="row mt-1">
                <div class="col-12">
                    <div class="table-responsive border rounded px-1 ">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Passport ma'lumotlari</th>
                                    <th>Berilgan joyi(V)</th>
                                    <th>Berilgan joyi(T,Sh)</th>
                                    <th>Berilgan sanasi</th>
                                    <th>JSHSHIR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="220px">
                                        <input type="text" class="passport form-control" name="passport" required>
                                    </td>
                                    <td width="240px">
                                        <select class="js-example-basic-single" style="max-width: 240px" name="pass_region_id" required>
                                            <option value="">--Tanlash--</option>
                                            @foreach ($regions as $region)
                                                <option value="{{$region->id}}">{{$region->name}}</option>
                                            @endforeach
                                        </select>                                       
                                    </td>
                                    <td width="240px">
                                        <select class="js-example-basic-single" style="max-width: 240px" name="pass_city_id"
                                            required>
                                            <option value="">--Tanlash--</option>
                                            @foreach ($cities as $city)
                                            <option value="{{$city->id}}">{{$city->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="date" class="form-control" name="pass_date" required>
                                    </td>
                                    <td>
                                        <input type="number" class="jshshir form-control" name="jshshir" required>
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
                                    <th>Qachondan beri ishlaydi</th>
                                    <th>Bo'lim nomi</th>
                                    <th>Shtat bo'yicha lavozimi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="date" class="form-control" width="120px" name="job_date" required>
                                    </td>
                                    <td>
                                        <select class="department" style="width: 100%" name="department_id" id="department_id" required>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="staff" style="width: 100%" id="staff_id" name="staff_id" required>
                                        </select>
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
                                    <th width="200px">Stavka</th>
                                    <th width="120px">Lavozim sanasi</th>
                                    <th>Jinsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="number" class="form-control" value="1" name="stavka" step="0.01" required>
                                    </td>
                                    <td>
                                        <input type="date" class="form-control" name="post_date" required>
                                    </td>
                                    <td>
                                        <select class="form-control" name="sex" required>
                                            <option value="1" selected>Erkak</option>
                                            <option value="0">Ayol</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-12">
                    <div class="table-responsive border rounded px-1 ">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Ma'lumoti</th>
                                    <th>Ilmiy darajasi:</th>
                                    <th>Ilmiy unvoni</th>
                                    <th>Millati</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-control" name="education_id" required>
                                            @foreach ($info as $inf)
                                            <option value="{{$inf->id}}">{{$inf->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="academictitle_id" required>
                                            @foreach ($academictitle as $academictitl)
                                            <option value="{{$academictitl->id}}">{{$academictitl->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="academicdegree_id" required>
                                            @foreach ($academicdegree as $academicdegr)
                                            <option value="{{$academicdegr->id}}">{{$academicdegr->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>
                                        <select class="form-control" name="nationality_id" required>
                                            @foreach ($naties as $natie)
                                            <option value="{{$natie->id}}">{{$natie->name}}</option>
                                            @endforeach
                                        </select>
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
                                    <th width="400px" style="max-width: 400px">Chet tillari</th>
                                    <th width="200px">Xizmat darajasi</th>
                                    <th>Partiyaviyligi</th>
                                    <th>Xarbiy unvoni</th>
                                    <th>Saylangan organlarga a'zoligi</th>
                                    <th>Tel raqami</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="js-example-basic-multiple" multiple="multiple" name="language[]" style="width: 300px" required>
                                            @foreach ($langues as $language)
                                            <option value="{{$language->id}}"> {{$language->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="worklevel_id" required>
                                            @foreach ($worklevel as $level)
                                            <option value="{{$level->id}}">{{$level->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="party_id" required>
                                            @foreach ($parties as $party)
                                            <option value="{{$party->id}}">{{$party->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="military_rank" required>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="deputy" required>
                                    </td>
                                    <td>
                                        <input type="text" class="phone form-control" id="phone" name="phone" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
<script src="{{asset('assets/croppie/croppie.js')}}"></script>
<script src="{{asset('assets/croppie/croppie.min.js')}}"></script>
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
                        var name = data[i].staff.name;
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

    function myFilter() {
        let department_id = $('#department_id').val();
        let url = '{{ route('cadry') }}';

        window.location.href = `${url}?
    department_id=${department_id}&`;
    }
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
    $('#cropImagePop').on('shown.bs.modal', function(){
        // alert('Shown pop');
        $uploadCrop.croppie('bind', {
            url: rawImg
        }).then(function(){
            console.log('jQuery bind complete');
        });
    });

    $('.item-img').on('change', function () { imageId = $(this).data('id'); tempFilename = $(this).val();
     $('#cancelCropBtn').data('id', imageId); readFile(this); });
    $('#cropImageBtn').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'base64',
            format: 'jpeg',
            size: {width: 150, height: 200}
        }).then(function (resp) {
            $('#item-img-output').attr('src', resp);
            
            $('#cropImagePop').modal('hide');
        });
    });									
</script>

<script>   
  $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
                var date2career = document.getElementById('date2_career');
                date2career.value = '';
                date2career.disabled = true;
            }
            else if($(this).prop("checked") == false){
                date2career.value = '';
                date2career.disabled = false;
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        var msg = '{{ Session::get('msg') }}';
        var exist = '{{ Session::has('msg') }}';
        if (exist) {
            if (msg == 4) {
                var name = '{{ Session::get('name') }}';
                var cadry_name = '{{ Session::get('cadry_name') }}';
                Swal.fire({
                    title: "Ruxsat etilmadi!",
                    text: "Ushbu xodim (" + cadry_name + ") " + name + " korxonasida mavjud!",
                    icon: "warning",
                    confirmButtonColor: "#1c84ee"
                }).then(function() {
                    location.reload();
                });
            } else if (msg == 5) {
                Swal.fire({
                    title: "Ruxsat etilmadi!",
                    text: "Ushbu xodim arxivda mavjud!",
                    icon: "warning",
                    confirmButtonColor: "#1c84ee"
                }).then(function() {
                    location.reload();
                });
            } else if (msg == 6) {
                Swal.fire({
                    title: "Ruxsat etilmadi!",
                    text: "Ushbu xodim qora ro'yxatga kiritilgan!",
                    icon: "warning",
                    confirmButtonColor: "#1c84ee"
                }).then(function() {
                    location.reload();
                });
            }
        }

    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>  
<script>
     $('.staff').select2();
    $('.js-example-basic-single').select2();
    $('.js-example-basic-multiple').select2();
    $(document).ready(function(){  
        $('.phone').inputmask('(99)-999-99-99');  
    });  

    $(document).ready(function(){  
        $('.infodate').inputmask('9999');
    });  

    $(document).ready(function(){  
        $('.infodate2').inputmask('9999');
    }); 

    $(document).ready(function(){  
        $('.passport').inputmask('AA 9999999');
    }); 

  

</script>

<script>
    function selins(sel) {
        var s = sel.value;
        var a = document.getElementById('ins')
        a.value = s;
     }
</script>

@endsection