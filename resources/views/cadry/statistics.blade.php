@extends('layouts.master')
@section('content')
    <div class="row animate__animated animate__fadeIn">
        <div class="col-xl-4 col-md-6">
            <div class="card card-h-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"> Nafaqa yoshidagi xodimlar</h4>
                    <div class="flex-shrink-0">
                        <button type="submit" class="btn btn-warning btn-sm"> Barchasini ko'rish</button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="pie_chart" data-colors='["#34c38f", "#1c84ee"]' class="apex-charts" dir="ltr"></div>
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
                        <button type="submit" class="btn btn-success btn-sm"> Barchasini ko'rish</button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="pie_chart2" data-colors='["#34c38f", "#1c84ee", "#fa5f1c"]' class="apex-charts" dir="ltr">
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
                        <button type="submit" class="btn btn-primary btn-sm"> Barchasini ko'rish</button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chart" class="e-charts"></div>
                </div>
            </div>
            <!-- end card -->
        </div>
    </div>

    <div class="row animate__animated animate__fadeIn">
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Erkak va ayol</span>
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
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Kasanachi xodimlar</span>
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
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Bo'sh va ortiqcha ish o'rinlari</span>
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
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Temir daftardagi xodimlar</span>
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
                                    data-target="{{ $vac }}">0</span> <br>
                                Bola parvarish ta'tili-<span class="counter-value text-success fw-bold"
                                    data-target="{{ $vacDec }}">0</span>
                            </h5>
                            <div class="text-nowrap">
                                <span class="ms-1 text-muted font-size-13">Umumiy</span>
                                <span class="badge bg-soft-success text-success fw-bold">{{ $vac + $vacDec }}</span>
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


    <div class="row animate__animated animate__fadeIn">
        <div class="col-xl-3 col-md-6">
            <div class="card card-h-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Bugungi tu'gilgan kunlar</h4>
                    <div class="flex-shrink-0">
                        <button onclick="birthcadries()" class="btn btn-danger btn-sm"> Barchasini ko'rish</button>
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
                        <button onclick="newcadries()" class="btn btn-warning btn-sm"> Barchasini ko'rish</button>
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
                        <button onclick="delcadries()" class="btn btn-primary btn-sm"> Barchasini ko'rish</button>
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
                        <a class="btn btn-dark btn-sm"> Barchasini ko'rish</a>
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

    @push('scripts')
        <script>
            function CadryCareers() {
                let url = '{{ route('CadryCareers_org') }}';
                window.location.href = `${url}`;
            }

            function CadryRelatives() {
                let url = '{{ route('CadryRelatives_org') }}';
                window.location.href = `${url}`;
            }

            function CadryMeds() {
                let url = '{{ route('CadryMeds_org') }}';
                window.location.href = `${url}`;
            }

            function CadryNotMeds() {
                let url = '{{ route('CadryNotMeds_org') }}';
                window.location.href = `${url}`;
            }

            function CadryVacations() {
                let url = '{{ route('CadryVacations_org') }}';
                window.location.href = `${url}`;
            }
        </script>
    @endpush
@endsection

@section('scripts')
    <script src="/assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="/assets/libs/echarts/echarts.min.js"></script>
    <script src="/assets/libs/jquery-knob/jquery.knob.min.js"></script>
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
                    ['Oliy', {{ number_format(($eduoliy / $all) * 100, 1) }} + " %"],
                    ["O'rta", {{ number_format((($all - $eduoliy - $edumaxsus) / $all) * 100, 1) }} + " %"],
                    ["O'rta-maxsus", {{ number_format(($edumaxsus / $all) * 100, 1) }} + " %"],
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
        var pieColors = getChartColorsArray("#pie_chart"),
            options = {
                chart: {
                    height: 320,
                    type: "pie"
                },
                series: [{{ $nafaqaWoman }}, {{ $nafaqaMan }}],
                labels: ["Ayollar", "Erkaklar"],
                colors: pieColors,
                legend: {
                    show: !0,
                    position: "bottom",
                    horizontalAlign: "center",
                    verticalAlign: "middle",
                    floating: !1,
                    fontSize: "14px",
                    offsetX: 0,
                },
                responsive: [{
                    breakpoint: 600,
                    options: {
                        chart: {
                            height: 240
                        },
                        legend: {
                            show: !1
                        }
                    },
                }, ],
            };
        (chart = new ApexCharts(
            document.querySelector("#pie_chart"),
            options
        )).render();
    </script>
    <script>
        var pieColors = getChartColorsArray("#pie_chart2"),
            options = {
                chart: {
                    height: 320,
                    type: "pie"
                },
                series: [{{ $cadry30 }}, {{ $cadry45 }} - {{ $cadry30 }}, {{ $all }} -
                    {{ $cadry45 }}
                ],
                labels: ["30 yoshgacha", "30-45 yoshgacha", "45 yoshdan"],
                colors: pieColors,
                legend: {
                    show: !0,
                    position: "bottom",
                    horizontalAlign: "center",
                    verticalAlign: "middle",
                    floating: !1,
                    fontSize: "14px",
                    offsetX: 0,
                },
                responsive: [{
                    breakpoint: 600,
                    options: {
                        chart: {
                            height: 240
                        },
                        legend: {
                            show: !1
                        }
                    },
                }, ],
            };
        (chart = new ApexCharts(
            document.querySelector("#pie_chart2"),
            options
        )).render();
    </script>
    <script>
        $(function() {
            $(".knob").knob();
        });
    </script>
@endsection
