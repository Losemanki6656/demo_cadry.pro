@extends('layouts.master')
@section('content')

    <div class="card-body position-relative">
        <div class="row flex-between-end">
        <div class="col-auto align-self-center">
            <h5>  Tables </h5>
        </div>
        <div class="col-auto align-self-center">
            <button class="btn btn-info me-1 mb-1" type="button" data-bs-toggle="modal" data-bs-target="#error-modal">
                <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Add Task
            </button>
        </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body bg-light">
            <div class="card-body bg-light">
                <div class="tab-content">
                    <div class="tab-pane preview-tab-pane active" role="tabpanel"
                        aria-labelledby="tab-dom-c49cfa40-b0cf-4567-9397-ea10dc097076"
                        id="dom-c49cfa40-b0cf-4567-9397-ea10dc097076">
                        <ul class="nav nav-pills" id="pill-myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="pill-home-tab" data-bs-toggle="tab"
                                    href="#pill-tab-home" role="tab" aria-controls="pill-tab-home" aria-selected="true">Archive Tasks</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" id="pill-profile-tab" data-bs-toggle="tab"
                                    href="#pill-tab-profile" role="tab" aria-controls="pill-tab-profile"
                                    aria-selected="false">Archive Files</a></li>
                        </ul>

                        <div class="tab-content p-3 mt-3" id="pill-myTabContent">
                            <div class="tab-pane fade show active" id="pill-tab-home">
                                <div class="table-responsive scrollbar">
                                    <table class="table mb-0 fs--1 border-200 table-borderless">
                                        <thead class="bg-light">
                                            <tr class="text-800 bg-200">
                                                <th class="text-nowrap" width="180">Recipient</th>
                                                <th class="text-center text-nowrap">Task</th>
                                                <th class="text-center text-nowrap" width="100">Success Date</th>
                                                <th class="text-center text-nowrap" width="120">Date Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($archives as $archive)
                                                <tr class="border-bottom border-200">
                                                    <td class="align-middle font-sans-serif fw-medium text-nowrap">
                                                        <a href="../app/e-commerce/customer-details.html">{{$archive->user->name}}</a>
                                                    </td>
                                                    <td class="align-middle text-center">{{$archive->task_success_text}}</td>
                                    
                                                    <td class="text-center">
                                                        <span class="badge badge rounded-pill d-block p-2 badge-soft-success">{{$archive->success_date}}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge badge rounded-pill d-block p-2 badge-soft-warning"> to
                                                            {{$archive->task_term_date}}</span>
                                                    </td>                             
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $archives->links() }}
                            </div>
                            <div class="tab-pane fade" id="pill-tab-profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="tab-pane fade show active" id="pill-tab-home">
                                    <div class="table-responsive scrollbar">
                                        <table class="table mb-0 fs--1 border-200 table-borderless">
                                            <thead class="bg-light">
                                                <tr class="text-800 bg-200">
                                                    <th class="text-nowrap" width="180">Recipient</th>
                                                    <th class="text-center text-nowrap">Task</th>
                                                    <th class="text-center text-nowrap" width="50">View</th>
                                                    <th class="text-center text-nowrap" width="100">Success Date</th>
                                                    <th class="text-center text-nowrap" width="120">Status </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($archivefiles as $arfile)
                                                    <tr class="border-bottom border-200">
                                                        <td class="align-middle font-sans-serif fw-medium text-nowrap">
                                                            <a href="../app/e-commerce/customer-details.html">{{$arfile->user->name}}</a>
                                                        </td>
                                                        <td class="align-middle text-center">{{$arfile->topic}}</td>
                                                        <td>
                                                            <input type="hidden" id="file-input{{$arfile->id}}" value="{{$arfile->file_path}}">
                                                            <button class="btn p-0 ms-2" type="button" data-bs-placement="top" title="View File" onclick="openfile({{$arfile->id}})">
                                                                <span class="text-500 fas fa-eye"></span>
                                                            </button>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge badge rounded-pill d-block p-2 badge-soft-success">{{$archive->success_date}}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge badge rounded-pill d-block p-2 badge-soft-warning"> to
                                                                {{$archive->task_term_date}}</span>
                                                        </td>                             
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $archives->links() }}
                                </div>
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
       function openfile(id) {
        let s = $("#file-input"+id).val();
        window.open(s);
        }
   </script>
@endsection
