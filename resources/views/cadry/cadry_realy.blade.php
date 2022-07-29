@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">Ma'lumotlarni taxrirlash</h4>
        <div class="flex-shrink-0">
            <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('cadry_edit',['id' => $cadry->id])}}" role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                        <span class="d-none d-sm-block">Shaxsiy ma'lumotlari</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('cadry_information',['id' => $cadry->id])}}" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block">Ma'lumoti</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('cadry_career',['id' => $cadry->id])}}" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block">Mehnat faoliyati</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('cadry_realy',['id' => $cadry->id])}}" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                        <span class="d-none d-sm-block">Yaqin qarindoshlari</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('cadry_other',['id' => $cadry->id])}}" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block"> Qo'shimcha ma'lumotlar</span>
                    </a>
                </li>
            </ul>
        </div>
    </div><!-- end card header -->

    <div class="card-body">

        <!-- Tab panes -->
        <div class="tab-content text-muted">
            <div class="tab-pane active" role="tabpanel">
                <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="datatable_length">
                                <h5>Yaqin qarindoshlari</h5>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="datatable_filter" class="dataTables_filter">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addrelativcadry"><i class="fas fa-plus"></i> Qo'shish</button>
                            </div>

                            <div class="modal fade" id="addrelativcadry" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Yaqin qarindoshlari qo'shish</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{route('add_relative_cadry',['id' => $cadry->id])}}"
                                            method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" class="form-control" name="sort"
                                                    value="{{$cadryrelatives->count()+1}}">
                                                <div class="mb-3">
                                                    <label>Qarindoshligi:</label></h6>
                                                    <select class="select2 js-example-programmatic form-control"
                                                        name="relative_id" required>
                                                        @foreach ($relatives as $relative)
                                                        <option value="{{$relative->id}}"> {{$relative->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>FIO:</label>
                                                    <input class="form-control" type="text" name="fullname" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Tug'ilgan yili va joyi:</label></h6>
                                                    <input class="form-control" type="text" name="birth_place" required>
                                                </div>
                                                <div class="mb-3">
                                                    <h6><label>Kasbi:</label>
                                                        <input class="form-control" type="text" name="post" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Xozirda yashash manzili::</label>
                                                    <input class="form-control" type="text" name="address">
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary" type="submit"> <i
                                                        class="fas fa-save"></i> Saqlash </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-75">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center fw-bold">Saralash</th>
                                    <th class="text-center fw-bold">Qarindoshligi</th>
                                    <th class="text-center fw-bold">FIO</th>
                                    <th class="text-center fw-bold">Tugilgan joyi</th>
                                    <th class="text-center fw-bold">Kasbi</th>
                                    <th class="text-center fw-bold">Yashash manzili</th>
                                    <th class="text-center fw-bold" style="min-width: 130px; max-width: 130px">Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cadryrelatives as $cadryrelative)
                                <tr class="row1" data-id="{{ $cadryrelative->id }}">
                                    <td class="text-center"><i class="fas fa-stream"
                                            style="color: blue; cursor: pointer"></i></td>
                                    <td>
                                        @if ($cadryrelative->relative_id != 1)
                                        {{$cadryrelative->relative->name}}
                                        @endif
                                    </td>
                                    <td class="text-center">{{$cadryrelative->fullname}}</td>
                                    <td class="text-center">
                                        {{$cadryrelative->birth_place}}
                                    </td>
                                    <td class="text-center">{{$cadryrelative->post}}</td>
                                    <td class="text-center">
                                        {{$cadryrelative->address}}
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-soft-secondary waves-effect"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editrelativcadry{{$cadryrelative->id}}">
                                            <i class="bx bx-edit font-size-16 align-middle"></i>
                                        </button>
                                        <button type="button" class="btn btn-soft-danger waves-effect"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleterelativcadry{{$cadryrelative->id}}">
                                            <i class="bx bx-trash font-size-16 align-middle"></i>
                                        </button>
                                    </td>
                                </tr>

                                <div class="modal fade" id="editrelativcadry{{$cadryrelative->id}}" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ma'lumotni o'chirish</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{route('edit_relative_cadry',['id' => $cadryrelative->id])}}"
                                                method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>Qarindoshligi:</label>
                                                        <select class="select2 js-example-programmatic form-control"
                                                            name="relative_id" required>
                                                            @foreach ($relatives as $relative)
                                                            <option value="{{$relative->id}}" @if($relative->id ==
                                                                $cadryrelative->relative_id) selected
                                                                @endif>{{$relative->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>FIO:</label>
                                                        <input class="form-control" type="text"
                                                            value="{{$cadryrelative->fullname}}" name="fullname"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Tug'ilgan joyi:</label>
                                                        <input class="form-control" type="text"
                                                            value="{{$cadryrelative->birth_place}}" name="birth_place"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Kasbi:</label>
                                                        <input class="form-control" type="text"
                                                            value="{{$cadryrelative->post}}" name="post" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Xozirda yashash manzili::</label>
                                                        <input class="form-control" type="text"
                                                            value="{{$cadryrelative->address}}" name="address">
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-dark" type="submit"> <i
                                                            class="fas fa-edit"></i> Taxrirlash </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="deleterelativcadry{{$cadryrelative->id}}" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ma'lumotni o'chirish</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form
                                                action="{{route('delete_relative_cadry',['id' => $cadryrelative->id])}}"
                                                method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>Malumotlarni o'chirmoqchmisiz ?</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-danger" type="submit"> <i
                                                            class="fas fa-trash"></i> Xa, O'chirish</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('input[type="checkbox"]').click(function () {
            if ($(this).prop("checked") == true) {
                var date2career = document.getElementById('date2_career');
                date2career.value = '';
                date2career.disabled = true;
            }
            else if ($(this).prop("checked") == false) {
                date2career.value = '';
                date2career.disabled = false;
            }
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $('.phone').inputmask('(99)-999-99-99');
    });

    $(document).ready(function () {
        $('.infodate').inputmask('9999');
    });

    $(document).ready(function () {
        $('.infodate2').inputmask('9999');
    });

    $(document).ready(function () {
        $('.passport').inputmask('AA 9999999');
    });
</script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script>
    $("table tbody").sortable({

        update: function (event, ui) {

            var order = [];
            $('tr.row1').each(function (index, element) {
                order.push({
                    id: $(this).attr('data-id'),
                    position: index + 1
                });
            });

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ url('relatives/sortable') }}",
                data: {
                    order: order,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {
                    if (response.status == "success") {
                        console.log(response);
                    } else {
                        console.log(response);
                    }
                }
            });
        }
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