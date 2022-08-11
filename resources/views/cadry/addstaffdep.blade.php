@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Shops</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                        <li class="breadcrumb-item active">Shops</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered align-middle table-nowrap table-hover mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Brand</th>
                                    <th scope="col">Name</th>
                                    <th scope="">Email</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Current Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <img src="assets/images/companies/img-1.png" alt="" class="avatar-md p-1">
                                    </td>
                                    <td>
                                        <h5 class="font-size-15"> Nedick's</h5>
                                        <p class="text-muted mb-0">
                                            <i class="mdi mdi-account me-1"></i> Wayne McClain
                                        </p>
                                    </td>
                                    <td>WayneMcclain@gmail.com</td>
                                    <td>07/10/2020</td>
                                    <td>86</td>
                                    <td>
                                        $12,456
                                    </td>

                                </tr>

                                <tr>
                                    <td>
                                        <img src="assets/images/companies/img-2.png" alt="" class="avatar-md p-1">
                                    </td>
                                    <td>
                                        <h5 class="font-size-15"> Brendle's</h5>
                                        <p class="text-muted mb-0">
                                            <i class="mdi mdi-account me-1"></i> David Marshall
                                        </p>
                                    </td>
                                    <td> Davidmarshall@gmail.com</td>
                                    <td>12/10/2020</td>
                                    <td>72</td>
                                    <td>
                                        $10,352
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <img src="assets/images/companies/img-3.png" alt="" class="avatar-md p-1">
                                    </td>
                                    <td>
                                        <h5 class="font-size-15"> Tech Hifi</h5>
                                        <p class="text-muted mb-0">
                                            <i class="mdi mdi-account me-1"></i> Katia Stapleton
                                        </p>
                                    </td>
                                    <td> Katiastapleton@gmail.com</td>
                                    <td>14/10/2020</td>
                                    <td>75</td>
                                    <td>
                                        $9,963
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <img src="assets/images/companies/img-5.png" alt="" class="avatar-md p-1">
                                    </td>
                                    <td>
                                        <h5 class="font-size-15"> Packer</h5>
                                        <p class="text-muted mb-0">
                                            <i class="mdi mdi-account me-1"></i> Mae Rankin
                                        </p>
                                    </td>
                                    <td> Maerankingmail.com</td>
                                    <td>15/10/2020</td>
                                    <td>72</td>
                                    <td>
                                        $10,352
                                    </td>
                                </tr>


                                <tr>
                                    <td>
                                        <img src="assets/images/companies/img-4.png" alt="" class="avatar-md p-1">
                                    </td>
                                    <td>
                                        <h5 class="font-size-15"> Lafayette</h5>
                                        <p class="text-muted mb-0">
                                            <i class="mdi mdi-account me-1"></i> Andrew Bivens
                                        </p>
                                    </td>
                                    <td>Andrewbivens@gmail.com</td>
                                    <td>20/11/2020</td>
                                    <td>65</td>
                                    <td>
                                        $14,568
                                    </td>

                                </tr>

                                <tr>
                                    <td>
                                        <img src="assets/images/companies/img-8.png" alt="" class="avatar-md p-1">
                                    </td>
                                    <td>
                                        <h5 class="font-size-15"> Tech Hifi</h5>
                                        <p class="text-muted mb-0">
                                            <i class="mdi mdi-account me-1"></i> John McLeroy
                                        </p>
                                    </td>
                                    <td> JohnmcLeroy@gmail.com</td>
                                    <td>30/31/2020</td>
                                    <td>58</td>
                                    <td>
                                        $14,654
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <!-- card -->
            <div class="card">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center mb-4">
                        <h5 class="card-title me-2">Sales by Locations</h5>
                        <div class="ms-auto">
                            <div class="dropdown">
                                <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="text-muted font-size-12">Sort By:</span> <span class="fw-medium">World<i
                                            class="mdi mdi-chevron-down ms-1"></i></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                    <a class="dropdown-item" href="#">USA</a>
                                    <a class="dropdown-item" href="#">Russia</a>
                                    <a class="dropdown-item" href="#">Australia</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="sales-by-locations" data-colors='["#34c38f"]' style="height: 284px"></div>

                    <div class="px-2 py-2">
                        <p class="mb-1">USA <span class="float-end">75%</span></p>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 75%"
                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="75">
                            </div>
                        </div>

                        <p class="mt-3 mb-1">Russia <span class="float-end">55%</span></p>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar progress-bar-striped bg-primary" role="progressbar"
                                style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="55">
                            </div>
                        </div>

                        <p class="mt-3 mb-1">Australia <span class="float-end">85%</span></p>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar progress-bar-striped bg-primary" role="progressbar"
                                style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="85">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- END ROW -->


    <div class="row">
        <div class="col-12">
            <div class="text-center my-3">
                <a href="javascript:void(0);" class="text-success"><i
                        class="bx bx-loader bx-spin font-size-18 align-middle me-2"></i> Load more </a>
            </div>
        </div> <!-- end col-->
    </div>
    
@endsection
