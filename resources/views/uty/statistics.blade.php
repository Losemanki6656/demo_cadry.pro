@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-3">
                    <label for="users-list-role">
                        <h6 class="mb-0">Katta korxonalar - {{ $railways->count() }} ta</h6>
                    </label>
                    <select id="railway_select" style="width: 100%" class="js-example-basic-single" name="railway_id">
                        <option value="">--Barchasi--</option>
                        @foreach ($railways as $railway)
                            @if ($railway->id == request('railway_id'))
                                <option value={{ $railway->id }} selected>{{ $railway->name }}</option>
                            @else
                                <option value={{ $railway->id }}>{{ $railway->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <label for="users-list-status">
                        <h6 class="mb-0">Korxonalar - {{ $organizations->count() }} ta</h6>
                    </label>
                    <select id="org_select" style="width: 100%" class="js-example-basic-single" name="organization_id"
                        required>
                        <option value="">--Barchasi--</option>
                        @foreach ($organizations as $organization)
                            @if ($organization->id == request('org_id'))
                                <option value={{ $organization->id }} selected>{{ $organization->name }}</option>
                            @else
                                <option value={{ $organization->id }}>{{ $organization->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <label for="users-list-verified">
                        <h6 class="mb-0">Bo'limlar va bekatlar - {{ $departments->count() }} ta</h6>
                    </label>
                    <select id="dep_select" style="width: 100%" class="js-example-basic-single" name="department_id">
                        <option value="">--Barchasi--</option>
                        @foreach ($departments as $department)
                            @if ($department->id == request('dep_id'))
                                <option value={{ $department->id }} selected>{{ $department->name }}</option>
                            @else
                                <option value={{ $department->id }}>{{ $department->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <a href="{{ route('photoView') }}" type="button" style="margin-top: 25px;width: 100%"
                        class="btn btn-primary"><i class="fas fa-eye"></i> Tashkiliy tuzilma</a>
                </div>
                @push('scripts')
                    <script>
                        $('#railway_select').change(function(e) {
                            let railway_id = $(this).val();
                            let url = '{{ route('statistics') }}';
                            window.location.href = `${url}?railway_id=${railway_id}`;


                        })
                        $('#org_select').change(function(e) {
                            let org_id = $(this).val();
                            let railway_id = $('#railway_select').val();
                            let url = '{{ route('statistics') }}';
                            window.location.href = `${url}?railway_id=${railway_id}&org_id=${org_id}`;
                        })

                        $('#dep_select').change(function(e) {
                            let dep_id = $(this).val();
                            let railway_id = $('#railway_select').val();
                            let org_id = $('#org_select').val();
                            let url = '{{ route('statistics') }}';
                            window.location.href = `${url}?railway_id=${railway_id}&org_id=${org_id}&dep_id=${dep_id}`;
                        })

                        function CadryCareers() {
                            let dep_id = $('#dep_select').val();
                            let railway_id = $('#railway_select').val();
                            let org_id = $('#org_select').val();
                            let url = '{{ route('CadryCareers') }}';
                            window.location.href = `${url}?railway_id=${railway_id}&org_id=${org_id}&dep_id=${dep_id}`;
                        }

                        function CadryRelatives() {
                            let dep_id = $('#dep_select').val();
                            let railway_id = $('#railway_select').val();
                            let org_id = $('#org_select').val();
                            let url = '{{ route('CadryRelatives') }}';
                            window.location.href = `${url}?railway_id=${railway_id}&org_id=${org_id}&dep_id=${dep_id}`;
                        }

                        function CadryVS() {
                            let dep_id = $('#dep_select').val();
                            let railway_id = $('#railway_select').val();
                            let org_id = $('#org_select').val();
                            let url = '{{ route('CadryVS') }}';
                            window.location.href = `${url}?railway_id=${railway_id}&org_id=${org_id}&dep_id=${dep_id}`;
                        }

                        function CadryMeds() {
                            let dep_id = $('#dep_select').val();
                            let railway_id = $('#railway_select').val();
                            let org_id = $('#org_select').val();
                            let url = '{{ route('CadryMeds') }}';
                            window.location.href = `${url}?railway_id=${railway_id}&org_id=${org_id}&dep_id=${dep_id}`;
                        }

                        function CadryVacations() {
                            let dep_id = $('#dep_select').val();
                            let railway_id = $('#railway_select').val();
                            let org_id = $('#org_select').val();
                            let url = '{{ route('CadryVacations') }}';
                            window.location.href = `${url}?railway_id=${railway_id}&org_id=${org_id}&dep_id=${dep_id}`;
                        }

                        function newcadries() {
                            let dep_id = $('#dep_select').val();
                            let railway_id = $('#railway_select').val();
                            let org_id = $('#org_select').val();
                            let url = '{{ route('newcadries') }}';
                            window.location.href = `${url}?railway_id=${railway_id}&org_id=${org_id}&dep_id=${dep_id}`;
                        }

                        function delcadries() {
                            let dep_id = $('#dep_select').val();
                            let railway_id = $('#railway_select').val();
                            let org_id = $('#org_select').val();
                            let url = '{{ route('delcadries') }}';
                            window.location.href = `${url}?railway_id=${railway_id}&org_id=${org_id}&dep_id=${dep_id}`;
                        }

                        function birthcadries() {
                            let dep_id = $('#dep_select').val();
                            let railway_id = $('#railway_select').val();
                            let org_id = $('#org_select').val();
                            let url = '{{ route('birthcadries') }}';
                            window.location.href = `${url}?railway_id=${railway_id}&org_id=${org_id}&dep_id=${dep_id}`;
                        }

                        function ExcelCareers() {
                            let dep_id = $('#dep_select').val();
                            let railway_id = $('#railway_select').val();
                            let org_id = $('#org_select').val();
                            let url = '{{ route('ExcelCareers') }}';
                            window.location.href = `${url}?railway_id=${railway_id}&org_id=${org_id}&dep_id=${dep_id}`;
                        }

                        function ExcelRelatives() {
                            let dep_id = $('#dep_select').val();
                            let railway_id = $('#railway_select').val();
                            let org_id = $('#org_select').val();
                            let url = '{{ route('ExcelRelatives') }}';
                            window.location.href = `${url}?railway_id=${railway_id}&org_id=${org_id}&dep_id=${dep_id}`;
                        }

                        function ExcelMeds() {
                            let dep_id = $('#dep_select').val();
                            let railway_id = $('#railway_select').val();
                            let org_id = $('#org_select').val();
                            let url = '{{ route('ExcelMeds') }}';
                            window.location.href = `${url}?railway_id=${railway_id}&org_id=${org_id}&dep_id=${dep_id}`;
                        }
                        function ExcelNotMeds() {
                            let dep_id = $('#dep_select').val();
                            let railway_id = $('#railway_select').val();
                            let org_id = $('#org_select').val();
                            let url = '{{ route('ExcelNotMeds') }}';
                            window.location.href = `${url}?railway_id=${railway_id}&org_id=${org_id}&dep_id=${dep_id}`;
                        }
                    </script>
                @endpush
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card card-h-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"> Nafaqa yoshidagi xodimlar</h4>
                    <div class="flex-shrink-0">
                        <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="doughnut-chart" data-colors='["#1c84ee", "#ffcc5a"]' class="e-charts"></div>
                </div>
                <div class="card-footer">
                    <div class="text-nowrap">
                        <span class="ms-1 text-muted font-size-11">Umumiy xodimlardan -</span>
                        <span class="badge bg-soft-danger font-size-11 text-dark fw-bold">
                            {{ number_format((($nafaqaMan + $nafaqaWoman) / $all) * 100, 1) }}%</span>,
                        <span class="badge bg-soft-warning font-size-11 text-dark fw-bold">Ayollar -
                            {{ $nafaqaWoman }}</span>,
                        <span class="badge bg-soft-primary font-size-11 text-dark fw-bold">Erkaklar -
                            {{ $nafaqaMan }}</span>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-xl-4 col-md-6">
            <div class="card card-h-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"> Xodimlarning yoshi bo'yicha</h4>
                    <div class="flex-shrink-0">
                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="pie-chart" data-colors='["#ef6767", "#34c38f" , "#1c84ee"]' class="e-charts"></div>
                </div>
                <div class="card-footer">
                    <div class="text-nowrap">
                        <span class="ms-1 text-muted font-size-11">Umumiy xodimlardan -</span>
                        <span class="badge bg-soft-danger font-size-11 text-dark fw-bold">30 yosh -
                            {{ number_format(($cadry30 / $all) * 100, 1) }}%</span>,
                        <span class="badge bg-soft-success font-size-11 text-dark fw-bold">30-45 yosh
                            {{ number_format((($cadry45 - $cadry30) / $all) * 100, 1) }}%</span>,
                        <span class="badge bg-soft-primary font-size-11 text-dark fw-bold">45 yoshdan -
                            {{ number_format((($all - $cadry45) / $all) * 100, 1) }}%</span>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-xl-4 col-md-6">
            <div class="card card-h-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"> Xodimlarning ma'lumoti bo'yicha</h4>
                    <div class="flex-shrink-0">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chart" class="e-charts"></div>
                </div>
                <div class="card-footer">
                    <div class="text-nowrap">
                        <span class="ms-1 text-muted font-size-11">Umumiy xodimlardan -</span>
                        <span class="badge bg-soft-primary font-size-11 text-dark fw-bold">Oliy -
                            {{ number_format(($eduoliy / $all) * 100, 1) }}%</span>,
                        <span class="badge bg-soft-primary font-size-11 text-dark fw-bold">O'rta -
                            {{ number_format((($all - $eduoliy - $edumaxsus) / $all) * 100, 1) }}%</span>,
                        <span class="badge bg-soft-primary font-size-11 text-dark fw-bold">O'rta-maxsus -
                            {{ number_format(($edumaxsus / $all) * 100, 1) }}%</span>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Davlat akademiyasida ta'lim olganlar</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div id="chart_academic" class="e-charts"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Xorijda ta'lim olganlar</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div id="chart_x" class="e-charts"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Mehnat faoliyati yakunlanish</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div id="chart_ish" class="e-charts"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Ishga qabul qilinganlar</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div id="chart_ish_qabul" class="e-charts"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Erkak va ayol</h4>
                    <div class="flex-shrink-0">
                        <button class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-3">
                                Erkaklar-<span class="counter-value text-primary fw-bold"
                                    data-target="{{ $man }}">0</span>;
                                Ayollar-<span class="counter-value text-success fw-bold"
                                    data-target="{{ $woman }}">0</span>
                            </h5>
                            <div class="text-nowrap">
                                <span class="ms-1 text-muted font-size-13">Xodimlar soni</span>
                                <span class="badge bg-soft-success text-success fw-bold">{{ $all }}</span>
                            </div>
                        </div>

                        <div class="flex-shrink-0 text-end dash-widget">
                            <div id="mini-chart1" data-colors='["#1c84ee", "#33c38e"]' class="apex-charts"></div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Kasanachi xodimlar</h4>
                    <div class="flex-shrink-0">
                        <button class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-3">
                                Kasanachi - <span class="counter-value text-primary fw-bold"
                                    data-target="{{ $dog }}">0</span>
                            </h5>
                            <div class="text-nowrap">
                                <span class="ms-1 text-muted font-size-13">Umumiy xodimlardan</span>
                                <span
                                    class="badge bg-soft-danger text-danger fw-bold">{{ number_format(($dog / $all) * 100, 1) }}
                                    %</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-end dash-widget">
                            <div id="mini-chart2" data-colors='["#1c84ee", "#EF6767"]' class="apex-charts"></div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Bo'sh ish o'rinlari</h4>
                    <div class="flex-shrink-0">
                        <button onclick="CadryVS()" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-3">
                                Vakant-<span class="counter-value text-primary fw-bold"
                                    data-target="{{ $vakant }}">0</span>;
                                Sverx-<span class="counter-value text-success fw-bold"
                                    data-target="{{ $sverx }}">0</span>
                            </h5>
                            <div class="text-nowrap">
                                <span class="ms-1 text-muted font-size-13">Plan</span>
                                <span class="badge bg-soft-success text-success fw-bold">{{ $plan }}
                                    ta</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-end dash-widget">
                            <div id="mini-chart3" data-colors='["#1c84ee", "#33c38e"]' class="apex-charts"></div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Temir daftardagi xodimlar</h4>
                    <div class="flex-shrink-0">
                        <button class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-3">
                                Soni - <span class="counter-value text-primary fw-bold" data-target="0">0</span>
                            </h5>
                            <div class="text-nowrap">
                                <span class="ms-1 text-muted font-size-13">Umumiy xodimlardan -</span>
                                <span class="badge bg-soft-warning text-dark fw-bold">0%</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-end dash-widget">
                            <div id="mini-chart4" data-colors='["#1c84ee", "#33c38e"]' class="apex-charts"></div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Ta'tildagi xodimlar</h4>
                    <div class="flex-shrink-0">
                        <button onclick="CadryVacations()" class="btn btn-primary btn-sm"> <i
                                class="fas fa-eye"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-3">
                                Mehnat ta'tili-<span class="counter-value text-primary fw-bold"
                                    data-target="{{ $vac - $vacDec }}">0</span>;
                                Bola parvarish ta'tili-<span class="counter-value text-success fw-bold"
                                    data-target="{{ $vacDec }}">0</span>
                            </h5>
                            <div class="text-nowrap">
                                <span class="ms-1 text-muted font-size-13">Umumiy</span>
                                <span class="badge bg-soft-success text-success fw-bold">{{ $vac }}</span>
                            </div>
                        </div>

                        <div class="flex-shrink-0 text-end dash-widget">
                            <div id="mini-chart1" data-colors='["#1c84ee", "#33c38e"]' class="apex-charts"></div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div>

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Tibbiy ko'rik ma'lumotlari</h4>
                    <div class="flex-shrink-0">
                        <button onclick="ExcelMeds()" class="btn btn-success btn-sm"><i
                                class="fas fa-file-excel"></i></button>
                        <button onclick="ExcelNotMeds()" class="btn btn-success btn-sm"><i
                                class="fas fa-file-excel"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-3">
                                <button onclick="CadryMeds()" class="btn btn-primary btn-sm mb-2"><i
                                        class="fas fa-eye"></i></button>
                                Muddati tugagan xodimlar -<span class="counter-value text-primary fw-bold"
                                    data-target="{{ $meds }}">0</span> <br>
                                <button onclick="CadryNotMeds()" class="btn btn-primary btn-sm"><i
                                        class="fas fa-eye"></i></button>
                                Kiritilmagan xodimlar -<span class="counter-value text-primary fw-bold"
                                    data-target="{{ $mednotCount }}">0</span>
                            </h5>
                            <div class="text-nowrap">
                                <span class="ms-1 text-muted font-size-13">Umumiy</span>
                                <span
                                    class="badge bg-soft-success text-success fw-bold">{{ number_format(($meds / $all) * 100, 1) }}
                                    %</span>
                            </div>
                        </div>

                        <div class="flex-shrink-0 text-end dash-widget">
                            <div id="mini-chart1" data-colors='["#1c84ee", "#33c38e"]' class="apex-charts"></div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div>

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Mehnat faoliyati kiritilmagan xodimlar</h4>
                    <div class="flex-shrink-0">
                        <button onclick="ExcelCareers()" class="btn btn-success btn-sm"><i
                                class="fas fa-file-excel"></i></button>
                        <button onclick="CadryCareers()" class="btn btn-primary btn-sm"><i
                                class="fas fa-eye"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-3">
                                Xodimlar soni -<span class="counter-value text-primary fw-bold"
                                    data-target="{{ $careersCount }}">0</span>
                            </h5>
                            <div class="text-nowrap">
                                <span class="ms-1 text-muted font-size-13">Umumiy</span>
                                <span
                                    class="badge bg-soft-success text-success fw-bold">{{ number_format(($careersCount / $all) * 100, 1) }}
                                    %</span>
                            </div>
                        </div>

                        <div class="flex-shrink-0 text-end dash-widget">
                            <div id="mini-chart1" data-colors='["#1c84ee", "#33c38e"]' class="apex-charts"></div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div>

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Qarindoshligi kiritilmagan xodimlar</h4>
                    <div class="flex-shrink-0">
                        <button onclick="ExcelRelatives()" class="btn btn-success btn-sm"><i
                                class="fas fa-file-excel"></i></button>
                        <button onclick="CadryRelatives()" class="btn btn-primary btn-sm"><i
                                class="fas fa-eye"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-3">
                                Xodimlar soni -<span class="counter-value text-primary fw-bold"
                                    data-target="{{ $relativesCount }}">0</span>
                            </h5>
                            <div class="text-nowrap">
                                <span class="ms-1 text-muted font-size-13">Umumiy</span>
                                <span
                                    class="badge bg-soft-success text-success fw-bold">{{ number_format(($relativesCount / $all) * 100, 1) }}
                                    %</span>
                            </div>
                        </div>

                        <div class="flex-shrink-0 text-end dash-widget">
                            <div id="mini-chart1" data-colors='["#1c84ee", "#33c38e"]' class="apex-charts"></div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-h-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Bugungi tu'gilgan kunlar</h4>
                    <div class="flex-shrink-0">
                        <button onclick="birthcadries()" class="btn btn-danger btn-sm"> <i
                                class="fas fa-eye"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center" dir="ltr">
                        <h5 class="font-size-14 mb-3">Umumiy soni - <span
                                class="badge bg-danger fw-bold">{{ $birthdays }} ta</span></h5>
                        <input class="knob" data-width="150" data-angleoffset="90" readonly data-linecap="round"
                            data-fgcolor="#fa5f1c" value="{{ number_format(($birthdays / $all) * 100, 2) }}">
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-h-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Yangi xodimlar</h4>
                    <div class="flex-shrink-0">
                        <button onclick="newcadries()" class="btn btn-warning btn-sm"> <i
                                class="fas fa-eye"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center" dir="ltr">
                        <h5 class="font-size-14 mb-3">Umumiy soni - <span
                                class="badge bg-warning fw-bold">{{ $newcadries }} ta</span></h5>
                        <input class="knob" data-width="150" data-angleoffset="{{ $all }}" readonly
                            data-linecap="round" data-fgcolor="#ffcc5a" value="{{ $newcadries }}">
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-h-100">
                <div class="card-header align-items-center d-flex">
                    <h6 class="card-title mb-0 flex-grow-1">Faoliyati yakunlangan xodimlar</h6>
                    <div class="flex-shrink-0">
                        <button onclick="delcadries()" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center" dir="ltr">
                        <h5 class="font-size-14 mb-3">Umumiy soni - <span
                                class="badge bg-primary fw-bold">{{ $democadries }} ta</span></h5>
                        <input class="knob" data-width="150" data-angleoffset="{{ $all }}" readonly
                            data-linecap="round" data-fgcolor="#1c84ee" value="{{ $democadries }}">
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-h-100">
                <div class="card-header align-items-center d-flex">
                    <h6 class="card-title mb-0 flex-grow-1">Qora ro'yxatdagi xodimlar</h6>
                    <div class="flex-shrink-0">
                        <a href="{{ route('black_del') }}" class="btn btn-dark btn-sm"><i class="fas fa-eye"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center" dir="ltr">
                        <h5 class="font-size-14 mb-3">Umumiy soni - <span
                                class="badge bg-dark fw-bold">{{ $democadriesback }} ta</span></h5>
                        <input class="knob" data-width="150" data-min="0" data-max="600" data-step="10"
                            value="{{ $democadriesback }}" data-fgcolor="#000000" readonly>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
    </div>
@endsection

@section('scripts')
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="assets/libs/echarts/echarts.min.js"></script>
    <script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>
    <script>
        var options = {
            series: [{
                name: "Desktops",
                data: [{{ implode(',', $news) }}]
            }],
            chart: {
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            title: {
                text: "2022 yil oylar ko'rinishida",
                align: 'left'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart_ish_qabul"), options);
        chart.render();
    </script>
    <script>
        var options = {
            series: [{
                name: "Desktops",
                data: [{{ implode(',', $demo) }}]
            }],
            chart: {
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            title: {
                text: "2022 yil oylar ko'rinishida",
                align: 'left'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart_ish"), options);
        chart.render();
    </script>
    <script>
        var colors = [
            '#566DF2',
            '#FE593E',
            '#FE9C78',
            '#9BCB7C'
        ]

        var options = {
            series: [{
                data: [{{ $abroad1 }}, {{ $abroad2 }},
                    {{ $abroad3 }}, {{ $abroad4 }}
                ],
            }],
            chart: {
                type: 'bar',
                events: {
                    click: function(chart, w, e) {
                        // console.log(chart, w, e)
                    }
                }
            },
            colors: colors,
            plotOptions: {
                bar: {
                    columnWidth: '45%',
                    distributed: true,
                }
            },
            dataLabels: {
                enabled: true
            },
            legend: {
                show: true
            },
            xaxis: {
                categories: [
                    ["Xorijda grant asosida - ", {{ $abroad1 }} + " ta"],
                    ["Jamiyat mablag???i hisobidan o???qiganlar - ", {{ $abroad2 }} + " ta"],
                    ["El-yurt ??umid fondi stipendiyasi - ", {{ $abroad3 }} + " ta"],
                    ["O???z hisobidan - ", {{ $abroad4 }} + " ta"],
                ],
                labels: {
                    style: {
                        colors: colors,
                        fontSize: '0'
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart_x"), options);
        chart.render();
    </script>
    <script>
        var colors = [
            '#FE007B',
            '#FE8300',
            '#1CD8F9',
            '#003AFE',
            '#CC00FE'
        ]

        var options = {
            series: [{
                data: [{{ $academic1 }}, {{ $academic2 }},
                    {{ $academic3 }}, {{ $academicBosh }}, {{ $academicBiznes }}
                ],
            }],
            chart: {
                type: 'bar',
                events: {
                    click: function(chart, w, e) {
                        // console.log(chart, w, e)
                    }
                }
            },
            colors: colors,
            plotOptions: {
                bar: {
                    columnWidth: '45%',
                    distributed: true,
                }
            },
            dataLabels: {
                enabled: true
            },
            legend: {
                show: true
            },
            xaxis: {
                categories: [
                    ["Davlat akademiyasi(1 yillik)", {{ $academic1 }} + " ta"],
                    ["Davlat akademiyasi(2 yillik)", {{ $academic2 }} + " ta"],
                    ["Davlat akademiyasi(3 yillik)", {{ $academic3 }} + " ta"],
                    ["Boshqarma akademiyasi", {{ $academicBosh }} + " ta"],
                    ["Biznes va tadbirkorlik akademiyasi", {{ $academicBiznes }} + " ta"],
                ],
                labels: {
                    style: {
                        colors: colors,
                        fontSize: '0'
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart_academic"), options);
        chart.render();
    </script>
    <script>
        var colors = [
            '#008FFB',
            '#00E396',
            '#FEB019'
        ]

        var options = {
            series: [{
                data: [{{ $eduoliy }}, {{ $all }} - {{ $eduoliy }} - {{ $edumaxsus }},
                    {{ $edumaxsus }}
                ],
            }],
            chart: {
                height: 350,
                type: 'bar',
                events: {
                    click: function(chart, w, e) {
                        // console.log(chart, w, e)
                    }
                }
            },
            colors: colors,
            plotOptions: {
                bar: {
                    columnWidth: '45%',
                    distributed: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            xaxis: {
                categories: [
                    ['Oliy', {{ $eduoliy }} + " ta"],
                    ["O'rta", {{ $all }} - {{ $eduoliy }} - {{ $edumaxsus }} + " ta"],
                    ["O'rta-maxsus", {{ $edumaxsus }} + " ta"],
                ],
                labels: {
                    style: {
                        colors: colors,
                        fontSize: '12px'
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
    <script>
        $('.js-example-basic-single').select2();

        function newcadry() {
            document.getElementById("newcadry").style.display = "block";
        }

        function democadry() {
            document.getElementById("democadry").style.display = "block";
        }

        function getChartColorsArray(r) {
            r = $(r).attr("data-colors");
            return (r = JSON.parse(r)).map(function(r) {
                r = r.replace(" ", "");
                if (-1 == r.indexOf("--")) return r;
                r = getComputedStyle(document.documentElement).getPropertyValue(r);
                return r || void 0;
            });
        }
        var barchartColors = getChartColorsArray("#mini-chart1"),
            options = {
                series: [{{ $man }}, {{ $woman }}],
                chart: {
                    type: "donut",
                    height: 110
                },
                colors: barchartColors,
                legend: {
                    show: !1
                },
                dataLabels: {
                    enabled: !1
                },
            },
            chart = new ApexCharts(document.querySelector("#mini-chart1"), options);
        chart.render();
    </script>
    <script>
        var barchartColors = getChartColorsArray("#mini-chart2"),
            options = {
                series: [{{ $all }} - {{ $cadry30 }}, {{ $cadry30 }}],
                chart: {
                    type: "donut",
                    height: 110
                },
                colors: barchartColors,
                legend: {
                    show: !1
                },
                dataLabels: {
                    enabled: !1
                },
            },
            chart = new ApexCharts(document.querySelector("#mini-chart2"), options);
        chart.render();
    </script>
    <script>
        var barchartColors = getChartColorsArray("#mini-chart3"),
            options = {
                series: [{{ $vakant }}, {{ $sverx }}],
                chart: {
                    type: "donut",
                    height: 110
                },
                colors: barchartColors,
                legend: {
                    show: !1
                },
                dataLabels: {
                    enabled: !1
                },
            },
            chart = new ApexCharts(document.querySelector("#mini-chart3"), options);
        chart.render();
    </script>
    <script>
        var barchartColors = getChartColorsArray("#mini-chart4"),
            options = {
                series: [60, 40],
                chart: {
                    type: "donut",
                    height: 110
                },
                colors: barchartColors,
                legend: {
                    show: !1
                },
                dataLabels: {
                    enabled: !1
                },
            },
            chart = new ApexCharts(document.querySelector("#mini-chart4"), options);
        chart.render();
    </script>
    <script>
        function getChartColorsArray(e) {
            e = $(e).attr("data-colors");
            return (e = JSON.parse(e)).map(function(e) {
                e = e.replace(" ", "");
                if (-1 == e.indexOf("--")) return e;
                e = getComputedStyle(document.documentElement).getPropertyValue(e);
                return e || void 0;
            });
        }
        var pieColors = getChartColorsArray("#pie-chart"),
            dom = document.getElementById("pie-chart"),
            myChart = echarts.init(dom),
            app = {};
        (option = null),
        (option = {
            tooltip: {
                trigger: "item",
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient: "vertical",
                left: "left",
                data: ["30-yoshgacha", "30-45 yoshgacha", "45 yoshdan kattalar"],
                textStyle: {
                    color: "#858d98"
                },
            },
            color: pieColors,
            series: [{
                name: "Total sales",
                type: "pie",
                radius: "55%",
                center: ["45%", "50%"],
                data: [{
                        value: {{ $cadry30 }},
                        name: "30-yoshgacha"
                    },
                    {
                        value: {{ $cadry45 }} - {{ $cadry30 }},
                        name: "30-45 yoshgacha"
                    },
                    {
                        value: {{ $all }} - {{ $cadry45 }},
                        name: "45 yoshdan kattalar"
                    },
                ],
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: "rgba(0, 0, 0, 0.5)",
                    },
                },
            }, ],
        }),
        option && "object" == typeof option && myChart.setOption(option, !0);
    </script>
    <script>
        var doughnutColors = getChartColorsArray("#doughnut-chart"),
            dom = document.getElementById("doughnut-chart"),
            myChart = echarts.init(dom),
            app = {};
        (option = null),
        (option = {
            tooltip: {
                trigger: "item",
                formatter: "{a} <br/>{b}: {c} ({d}%)"
            },
            legend: {
                orient: "vertical",
                x: "left",
                data: ["Erkaklar", "Ayollar"],
                textStyle: {
                    color: "#858d98"
                },
            },
            color: doughnutColors,
            series: [{
                name: "Total sales",
                type: "pie",
                radius: ["35%", "55%"],
                avoidLabelOverlap: !1,
                label: {
                    normal: {
                        show: !1,
                        position: "center"
                    },
                    emphasis: {
                        show: !0,
                        textStyle: {
                            fontSize: "30",
                            fontWeight: "bold"
                        },
                    },
                },
                labelLine: {
                    normal: {
                        show: !1
                    }
                },
                data: [{
                        value: {{ $nafaqaMan }},
                        name: "Erkaklar"
                    },
                    {
                        value: {{ $nafaqaWoman }},
                        name: "Ayollar"
                    },
                ],
            }, ],
        }),
        option && "object" == typeof option && myChart.setOption(option, !0);
    </script>
    <script>
        $(function() {
            $(".knob").knob();
        });
    </script>
@endsection
