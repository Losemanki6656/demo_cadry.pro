@if (count($cadries))
<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped animate__animated animate__fadeIn table-sm" >
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center fw-bold" width="60px">{{ __('messages.no') }}</th>
                        <th class="text-center fw-bold" width="60px">{{ __('messages.photo') }}</th>
                        <th class="text-center fw-bold">{{ __('messages.fio') }}</th>
                        <th class="text-center fw-bold">{{ __('messages.staff') }}</th>
                        <th width="130px" class="text-center fw-bold">{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($cadries))
                        @foreach ($cadries as $key => $item)
                            <tr>
                                <td class="text-center fw-bold align-middle">
                                    {{ $cadries->currentPage() * 10 - 10 + $loop->index + 1 }}</td>
                                <td class="text-center">
                                    <a href="{{ asset('storage/' . $item->photo) }}" class="image-popup-desc"
                                        data-title="{{ $item->last_name }} {{ $item->first_name }} {{ $item->middle_name }}"
                                        data-description="{{ $item->post_name }}">
                                        <img class="rounded avatar"
                                            src="{{ asset('storage/' . $item->photo) }}" height="40"
                                            width="40">
                                    </a>

                                </td>
                                <td class="text-center align-middle fw-bold"><a
                                        href="{{ route('cadry_edit', ['id' => $item->id]) }}"
                                        class="text-dark"> {{ $item->last_name }} {{ $item->first_name }}
                                        {{ $item->middle_name }}</a></td>
                                <td class="text-center align-middle">{{ $item->post_name }}</td>
                                <td class="text-center">
                                    <a type="button" href="{{ route('word_export', ['id' => $item->id]) }}"
                                        class="btn btn-soft-primary" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="Yuklab olish">
                                        <i class=" bx bxs-file-doc font-size-16 align-middle"></i></a>

                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button"
                                            class="btn btn-soft-dark dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-filter font-size-16 align-middle"></i>
                                        </button>

                                        <ul class="dropdown-menu">
                                            <li><a data-bs-toggle="modal" data-bs-target="#vacation{{$item->id}}"
                                                    type="button" class="dropdown-item fw-bold"> Mehnat
                                                    ta'tili</a></li>
                                            <li>
                                                @if ($item->sex == 0)
                                                    <a href="{{ route('decret_cadry', ['id' => $item->id]) }}"
                                                        type="button"
                                                        class="dropdown-item fw-bold text-primary"> Bola
                                                        parvarish ta'tili</a>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="vacation{{$item->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-success">Mehnat ta'tiliga chiqarish</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{route('vacation',['id' => $item->id ])}}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="fw-bold text-center">FIO: {{$item->last_name}} {{$item->first_name}} {{$item->middle_name}}</label>
                                                </div> 
                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col">
                                                            <label>Qachondan:</label>
                                                            <input type="text" class="form-control" id="datepicker-basic" name="date1">
                                                        </div>
                                                        <div class="col">
                                                            <label>Qachongacha:</label>
                                                            <input type="text" class="form-control" id="datepicker-basic" name="date2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Keyingi chiqish sanasi:</label>
                                                    <input type="text" class="form-control text-center" id="datepicker-basic" name="datenext">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-success" type="submit"> <i class="bx bx-save font-size-16 align-middle me-2"></i>
                                                    Saqlash </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> 
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif