@extends('layouts.master')
@section('content')

    @if (\Session::has('msg'))
        @if (Session::get('msg') == 1)
        <div class="alert alert-success" id="success-alert">A simple success alert—check it out!</div>
        @endif
    @endif

<form action="{{route('sel_user')}}" method="post">
    @csrf
    <div class="card-body position-relative">
        <div class="row flex-between-end">
        <div class="col-auto align-self-center">
            <h5> Users Table</h5>
        </div>
        <div class="col-auto align-self-center">
            <button class="btn btn-success me-1 mb-1" type="submit" data-bs-toggle="modal" data-bs-target="#error-modal">
                <span class="fas fa-check me-1" data-fa-transform="shrink-3"></span>Select
            </button>
        </div>
        </div>
    </div>


    <div class="card">

        <div class="card-header border-bottom">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <div class="row">
                        <div class=" col">
                            <label>Organizations:</label>
                            <select class="form-select form-select-sm">
                                @foreach ($railways as $railway)
                                    <option value={{$railway->id}}>{{$railway->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label>Enterprise:</label>
                            <select class="form-select form-select-sm">
                                @foreach ($organizations as $organization)
                                    <option value={{$organization->id}}>{{$organization->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label>Departments:</label>
                            <select class="form-select form-select-sm">
                                @foreach ($departments as $department)
                                    <option value={{$department->id}}>{{$department->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                
            </div>
            <div class="col-auto align-self-center">
               
            </div>
            </div>
        </div>
    
            <div class="card-body py-0 border-top">
                <div class="tab-content">
                <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="tab-dom-6c6d4d05-aead-4c75-a3a2-7f8fa2f05831" id="dom-6c6d4d05-aead-4c75-a3a2-7f8fa2f05831">
                    <div class="card shadow-none">
                        <div class="card-body p-0 pb-3">
                        <div class="table-responsive scrollbar">
                                <table class="table mb-0">
                                    <thead class="text-black bg-200">
                                        <tr>
                                            <th class="align-middle white-space-nowrap">
                                            <div class="form-check mb-0"><input class="form-check-input" type="checkbox" data-bulk-select='{"body":"bulk-select-body","actions":"bulk-select-actions","replacedElement":"bulk-select-replace-element"}' /></div>
                                            </th>
                                            <th class="align-middle">Name</th>
                                            <th class="align-middle">Organization </th>
                                            <th class="align-middle">Enterprice</th>
                                            <th class="align-middle">Department</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bulk-select-body">
                                        @foreach ($users as $item)
                                            <tr>
                                                <td class="align-middle white-space-nowrap">     
                                                    <div class="form-check mb-0">           
                                                        @if ($sel[$item->id] == 1)
                                                            <input class="form-check-input" type="checkbox" checked name="check[{{$item->id}}]" value="{{$item->id}}" data-bulk-select-row="data-bulk-select-row" />
                                                        @else
                                                            <input class="form-check-input" type="checkbox" name="check[{{$item->id}}]" value="{{$item->id}}" data-bulk-select-row="data-bulk-select-row" />
                                                        @endif 
                                                    </div>
                                                </td>
                                                <td class="align-middle">{{$item->name}}</td>
                                                <th class="align-middle">
                                                   РЖУ Бухара
                                                </th>
                                                <td class="align-middle">
                                                    Ржу Собс
                                                </td>
                                                <td class="align-middle">
                                                    Кадр
                                                </td>
                                            </tr>
                                        @endforeach             
                                    </tbody>
                                </table>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
    </div>
</form>

    
@endsection

@section('scripts')
    <script type="text/javascript">
            $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
                $("#success-alert").slideUp(500);
            });
    </script>
@endsection