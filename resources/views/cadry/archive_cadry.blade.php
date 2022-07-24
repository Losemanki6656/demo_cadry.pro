@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Arxivdan qidirish</h4>
                    <form class="outer-repeater" action="{{ route('archive_cadry') }}" method="get">
                        @csrf
                        <div data-repeater-list="outer-group" class="outer">
                            <div data-repeater-item class="outer">
                                <div class="form-group row mb-4">
                                    <label for="taskname" class="col-form-label col-lg-2">JSHSHIR</label>
                                    <div class="col-7">
                                        <input id="taskname" name="jshshir" type="number" class="form-control"
                                            placeholder="JSHSHIR ni kiriting..." value="{{request('jshshir')}}">
                                    </div>
                                    <div class="col-3">
                                        <button class="btn btn-primary" type="submit" style="width: 100%"> <i class="fa fa-search"></i>
                                            Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if ($cadries->count())
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Photo</th>
                                    <th>FIO / Korxona</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cadries as $item)
                                <tr>
                                    <td>
                                        {{ $cadries->currentPage() * 10 - 10 + $loop->index + 1 }}
                                    </td>
                                    <td><a href="{{ asset('storage/' . $item->photo) }}"
                                        class="image-popup-desc"
                                        data-title="{{ $item->last_name }} {{ $item->first_name }} {{ $item->middle_name }}"
                                        data-description="{{ $item->post_name }}">
                                        <img class="rounded avatar"
                                            src="{{ asset('storage/' . $item->photo) }}" height="40"
                                            width="40">
                                    </a>
                                </td>
                                    <td>
                                        <p class="mb-1 fw-bold">{{ $item->last_name }} {{ $item->first_name }}
                                            {{ $item->middle_name }}</p>
                                        <p class="mb-0">{{$item->organization->name}}</p>
                                    </td>
                                    
                                    <td>{{$item->region->name ?? ''}},{{$item->city->name ?? ''}},{{$item->address ?? ''}}</td>
                                    <td>
                                        <span>
                                            <a type="button" href="{{ route('cadry_archive_load',['id' => $item->id]) }}" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="Ma'lumotlarni yuklash"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-check-circle"></i>
                                            </a>
                                        </span>
                                    
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                @if (count($cadries) > 9)
                                    <form action="{{ route('cadry') }}" method="get">
                                        <div class="dataTables_length" id="datatable_length">
                                            <label><input type="number" class="form-control form-control"
                                                    placeholder="{{ __('messages.page') }} ..." name="page"
                                                    value="{{ request()->query('page') }}"></label>
                                        </div>
                                    </form>
                                @endif
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="datatable_filter" class="dataTables_filter">
                                    <label>
                                        {{ $cadries->withQueryString()->links() }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                        <h5 class="text-center text-danger">Ma'lumot topilmadi</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
