@extends('layouts.master')

@section('content')

    <div class="card animate__animated animate__zoomIn">
        <div class="card-header">
            <div class="card-body">

                <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <form action="{{route('turnicet')}}" method="get">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_length" id="datatable_length">
                                    <label>
                                        <input type="search" class="form-control form-control" placeholder="{{ __('messages.search') }} ..." 
                                        name="search" value="{{request()->query('search')}}">
                                    </label>
                                   
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="datatable_filter" class="dataTables_filter">
                                    <label>
                                        <input type="date" class="form-control form-control" name="data" value="{{request()->query('data')}}">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" width="60px">#</th>
                                    <th class="text-center fw-bold">FIO</th>
                                    <th class="text-center fw-bold">Korxona</th>
                                    <th class="text-center fw-bold">Tabel raqami</th>
                                    <th class="text-center fw-bold">Control</th>
                                    <th class="text-center fw-bold">Action</th>
                                    <th class="text-center fw-bold" width="80">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($controls))
                                    @foreach ($controls as $key => $item)
                                        <tr>
                                            <td class="text-center">
                                                {{ $controls->currentPage() * 10 - 10 + $loop->index + 1 }}</td>
                                            <td class="text-center fw-bold">{{ $item->fullname }}</td>
                                            <td class="text-center fw-bold">{{ $item->organization_name }}</td>
                                            <td class="text-center">{{ $item->tabel }}</td>
                                            <td class="text-center">
                                                @if ($item->department_name = '1')
                                                    <span class="badge bg-danger font-size-12"> Chiqish</span>
                                                @else
                                                    <span class="badge bg-success font-size-12"> Kirish</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $item->created_at }}
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input ml-2" name="cadries[{{ $item->id }}]"
                                                    type="checkbox" style="zoom: 1.5" form="success_message">
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <form action="{{ route('cadry_search') }}" method="get">
                                <div class="dataTables_length" id="datatable_length">
                                    <label><input type="number" class="form-control form-control" placeholder="Page ..."
                                            name="page" value="{{ request()->query('page') }}"></label>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="datatable_filter" class="dataTables_filter">
                                <label>
                                    {{ $controls->withQueryString()->links() }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            @if (\Session::has('msg'))
                @if (Session::get('msg') == 'Request is received')
                    alertify.success("Send Sms Successfully!");
                @endif
            @endif
        });
    </script>
@endsection
