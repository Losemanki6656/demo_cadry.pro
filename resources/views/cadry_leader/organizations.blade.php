@extends('layouts.master')
@section('content')


        <div class="card">
            <div class="card-content collapse show">
                <div class="card-body">
                    <div class="users-list-filter">
                        <form method="get" action="{{route('shtat')}}">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <label for="users-list-role"><h6>Katta korxonalar - 1 ta</h6></label>
                                    <fieldset class="form-group">
                                        <select id="railway_select" disabled class="js-example-basic-single" style="width: 90%">
                                            <option value={{$railways->id}} selected>{{$railways->name}}</option>
                                        </select>
                                    </fieldset>
                                    <label></label>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <label for="users-list-status"><h6>Korxonalar - {{$organizations->count()}} ta</h6></label>
                                    <fieldset class="form-group">
                                        <select id="org_select" class="js-example-basic-single" style="width: 90%" name="organization_id" required>
                                            <option value="">--Barchasi--</option>
                                            @foreach ($organizations as $organization)
                                                @if ($organization->id == request('org_id'))
                                                    <option value={{$organization->id}} selected>{{$organization->name}}</option>
                                                @else
                                                      <option value={{$organization->id}}>{{$organization->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>

                                <div class="col-12 col-sm-6 col-lg-3">
                                    <label for="users-list-verified"><h6>Bo'limlar va bekatlar - {{$departments->count()}} ta</h6></label>
                                    <fieldset class="form-group">
                                        <select id="dep_select" class="js-example-basic-single" style="width: 90%" name="usersharesimpid">
                                            <option value="">--Barchasi--</option>
                                            @foreach ($departments as $department)
                                            @if ($department->id == request('dep_id'))
                                                <option value={{$department->id}} selected>{{$department->name}}</option>
                                            @else
                                                  <option value={{$department->id}}>{{$department->name}}</option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </fieldset>
                                </div>


                                @push('scripts')
                                    <script>
                                        $('#org_select').change(function (e) {
                                            let org_id = $(this).val();
                                            let railway_id = $('#railway_select').val();
                                            let url = '{{ route('cadry_leader') }}';
                                            window.location.href = `${url}?railway_id=${railway_id}&org_id=${org_id}`;
                                        })

                                        $('#dep_select').change(function (e) {
                                            let dep_id = $(this).val();
                                            let railway_id = $('#railway_select').val();
                                            let org_id = $('#org_select').val();
                                            let url = '{{ route('cadry_leader') }}';
                                            window.location.href = `${url}?railway_id=${railway_id}&org_id=${org_id}&dep_id=${dep_id}`;
                                        })

                                    </script>
                                @endpush


                                <div class="col-12 col-sm-6 col-lg-3">
                                    <label for="users-list-department"></label>
                                    <fieldset class="form-group">
                                        <button type="submit" id="users-list-department" class="btn btn-primary mr-1 mb-1">Shtat bo'yicha</button>
                                    <fieldset class="form-group">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        
<div class="card">
    <div class="card-header">
        <div class="card-body">
            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <form action="{{route('cadry_leader')}}" method="get">
                                <div class="dataTables_length" id="datatable_length">
                                    <label>Umumiy xodimlar: <span class="fw-bold text-success">  {{$countcadries}} </span> ta topildi
                                    <input type="search" class="form-control form-control-sm" name="page" value="{{request()->query('page')}}" placeholder="Page ...">
                                    </label>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <form id="search_form" action="{{route('cadry_leader', ['railway_id' => request('railway_id'), 'org_id' => request('org_id'), 'dep_id' => request('dep_id')])}}" method="get">
                                <div id="datatable_filter" class="dataTables_filter">
                                    <label>Qidirish:<input type="search" class="form-control form-control-sm" placeholder="Search ..." name="search" value="{{request()->query('search')}}"></label>
                                </div>
                            </form>
                        </div>
                        @push('scripts')
                            <script>
                                $('#search_form').submit(function (e) {
                                    e.preventDefault();
                                    let url = "{{ route('cadry_leader', ['railway_id' => request('railway_id'), 'org_id' => request('org_id'), 'dep_id' => request('dep_id'), 'search' => '__search__']) }}";
                                    let search = $('input[name="search"]').val();                                 
                                    url = url.replace('__search__', search);
                                    url = url.replace(/amp;/, '');
                                    window.location.href = url;
                                })
                            </script>
                        @endpush
                    </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered">
                            <thead >
                                <tr>    
                                    <th class="text-center">#</th>
                                    <th width="50" class="text-center">Photo</th>
                                    <th class="text-center fw-bold">FIO</th>
                                    <th class="text-center fw-bold">Korxona</th>
                                    <th class="text-center fw-bold">Lavozimi</th>
                                    <th class="text-center fw-bold" width="80">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($cadries))
                                    @foreach ($cadries as $key=>$item)
                                    <tr>
                                        <td class="text-center">{{(($cadries->currentPage() * 10) - 10) + $loop->index + 1}}</td>
                                        <td class="text-center">
                                            <ul class="list-unstyled users-list m-0  d-flex align-items-center">
                                                <li data-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-placement="bottom"
                                                    data-original-title="{{$item->first_name}}"
                                                    class="avatar pull-up">
                                                    <img class="media-object rounded-circle"
                                                        src="{{asset('storage/'.$item->photo)}}"
                                                        alt="Avatar" height="40" width="40">
                                                </li>
                                             </ul>
                                        </td>
                                        <td class="text-center fw-bold">{{$item->last_name}} {{$item->first_name}} {{$item->middle_name}}</td>
                                        <td class="text-center fw-bold">{{$item->organization->name}}</td>
                                        <td class="text-center">{{$item->post_name}}</td>
                                        <td class="text-center"> 
                                            <a type="button" href="{{route('cadry_leader_view',['id' => $item->id])}}" 
                                                class="btn btn-soft-primary waves-effect waves-light"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Yuklab olish">
                                                <i class="bx bxs-user font-size-16 align-middle"></i></a>    
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-3">             
                    <ul class="pagination mb-0">
                        {{ $cadries->withQueryString()->links() }}
                    </ul> 
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
