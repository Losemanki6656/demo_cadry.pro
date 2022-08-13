@extends('layouts.master')
@section('content')

    @if (\Session::has('msg'))
        @if (Session::get('msg') == 1)
            <div class="alert alert-success" id="success-alert">Succesfully!</div>
        @endif
    @endif

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Kirishlar</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Bosh menu</a></li>
                        <li class="breadcrumb-item active">Kirishlar</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <form action="{{ route('userDevices') }}" method="get">
                                    <div class="dataTables_length" id="datatable_length">
                                        <label><input type="search" class="form-control form-control"
                                                placeholder="Search ..." name="search"
                                                value="{{ request()->query('search') }}"></label>
                                    </div>
                                </form>
                            </div>
                    </div>

                    <div class="table-responsive mt-1">
                        <table class="table table-bordered table-striped table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center fw-bold">#</th>
                                    <th class="text-center fw-bold">Foydalanuvchi nomi</th>
                                    <th class="text-center fw-bold">Kirgan vaqti</th>
                                    <th class="text-center fw-bold">Ip manzili</th>
                                    <th class="text-center fw-bold">Browser</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($devices as $item)
                                    <tr>
                                        <td class="text-center fw-bold">
                                            {{ $devices->currentPage() * 10 - 10 + $loop->index + 1 }}</td>
                                        <td class="text-center fw-bold" style="font-size: 14px">
                                            {{ $item->user->name }}</td>
                                        <td>{{ $item->login_at }}</td>
                                        <td>{{ $item->ip_address }}</td>
                                        <td>{{ $item->user_agent }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <ul class="pagination mb-0">
                            {{ $devices->withQueryString()->links() }}
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
@endsection
