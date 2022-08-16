@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Lavozimlar</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Bo'limlar</a></li>
                        <li class="breadcrumb-item active">Lavozimlar</li>
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
                    <div class="">
                        <table class="table table-centered align-middle table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center fw-bold" width="30px">#</th>
                                    <th class="text-center fw-bold" style="max-width: 300px">
                                        {{ $department->name }}ga tegishli ish o'rinlari
                                    </th>
                                    <th class="text-center fw-bold">Stavka</th>
                                    <th class="text-center fw-bold">Mavjud xodimlar</th>
                                    <th class="text-center fw-bold" width="110px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($depstaff as $ds)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td style="max-width: 300px" class="text-center">{{ $ds->staff->name }}</td>
                                        <td class="text-center fw-bold">{{ $ds->stavka }}</td>
                                        <td class="text-center fw-bold">
                                            @if ($ds->cadry->sum('stavka') < $ds->stavka)
                                                @if ($ds->status == false)
                                                    <a href="{{ route('department_cadry_add', ['id' => $ds->id]) }}"
                                                        class="btn btn-outline-success btn-sm">
                                                        Bo'sh ish o'rni - {{ $ds->stavka - $ds->cadry->sum('stavka') }} </a>
                                                @else
                                                    <a href="{{ route('department_cadry_add', ['id' => $ds->id]) }}"
                                                        class="btn btn-outline-danger btn-sm">
                                                        Xodim qo'shish - {{ $ds->stavka - $ds->cadry->sum('stavka') }} </a>
                                                @endif
                                            @elseif($ds->cadry->sum('stavka') > $ds->stavka)
                                                <span class="text-danger fw-bold">{{ $ds->cadry->sum('stavka') }}</span>
                                            @else 
                                                {{ $ds->stavka }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a type="button" href="{{ route('department_staffs', ['id' => $ds->id]) }}"
                                                class="btn btn-primary btn-sm"> <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editdepstaff{{ $ds->id }}"> <i
                                                    class="fa fa-edit"></i></button>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="deleteFunc({{ $ds->id }})"> <i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="editdepstaff{{ $ds->id }}" tabindex="-1"
                                        role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"> Ish o'rnini taxrirlash
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('editDepStaff', ['id' => $ds->id]) }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <h5 class="fw-bold">Lavozim nomi </h5>
                                                            {{ $ds->staff->name }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <h5 class="fw-bold">Stavka:<h5>
                                                                    <div class="row">
                                                                        <div class="col">
                                                                           <input type="number" value="1" class="form-control" name="st_1">
                                                                        </div>
                                                                        <div class="col">
                                                                            <select class="form-select" name="st_2">
                                                                                <option value="0">.00</option>
                                                                                <option value="0.01">.01</option>
                                                                                <option value="0.02">.02</option>
                                                                                <option value="0.03">.03</option>
                                                                                <option value="0.04">.04</option>
                                                                                <option value="0.05">.05</option>
                                                                                <option value="0.06">.06</option>
                                                                                <option value="0.07">.07</option>
                                                                                <option value="0.08">.08</option>
                                                                                <option value="0.09">.09</option>
                                                                                <option value="0.1">.1</option>
                                                                                <option value="0.11">.11</option>
                                                                                <option value="0.12">.12</option>
                                                                                <option value="0.13">.13</option>
                                                                                <option value="0.14">.14</option>
                                                                                <option value="0.15">.15</option>
                                                                                <option value="0.16">.16</option>
                                                                                <option value="0.17">.17</option>
                                                                                <option value="0.18">.18</option>
                                                                                <option value="0.19">.19</option>
                                                                                <option value="0.2">.2</option>
                                                                                <option value="0.21">.21</option>
                                                                                <option value="0.22">.22</option>
                                                                                <option value="0.23">.23</option>
                                                                                <option value="0.24">.24</option>
                                                                                <option value="0.25">.25</option>
                                                                                <option value="0.26">.26</option>
                                                                                <option value="0.27">.27</option>
                                                                                <option value="0.28">.28</option>
                                                                                <option value="0.29">.29</option>
                                                                                <option value="0.30">.3</option>
                                                                                <option value="0.31">.31</option>
                                                                                <option value="0.32">.32</option>
                                                                                <option value="0.33">.33</option>
                                                                                <option value="0.34">.34</option>
                                                                                <option value="0.35">.35</option>
                                                                                <option value="0.36">.36</option>
                                                                                <option value="0.37">.37</option>
                                                                                <option value="0.38">.38</option>
                                                                                <option value="0.39">.39</option>
                                                                                <option value="0.4">.4</option>
                                                                                <option value="0.41">.41</option>
                                                                                <option value="0.42">.42</option>
                                                                                <option value="0.43">.43</option>
                                                                                <option value="0.44">.44</option>
                                                                                <option value="0.45">.45</option>
                                                                                <option value="0.46">.46</option>
                                                                                <option value="0.47">.47</option>
                                                                                <option value="0.48">.48</option>
                                                                                <option value="0.49">.49</option>
                                                                                <option value="0.5">.5</option>
                                                                                <option value="0.51">.51</option>
                                                                                <option value="0.52">.52</option>
                                                                                <option value="0.53">.53</option>
                                                                                <option value="0.54">.54</option>
                                                                                <option value="0.55">.55</option>
                                                                                <option value="0.56">.56</option>
                                                                                <option value="0.57">.57</option>
                                                                                <option value="0.58">.58</option>
                                                                                <option value="0.59">.59</option>
                                                                                <option value="0.6">.6</option>
                                                                                <option value="0.61">.61</option>
                                                                                <option value="0.62">.62</option>
                                                                                <option value="0.63">.63</option>
                                                                                <option value="0.64">.64</option>
                                                                                <option value="0.65">.65</option>
                                                                                <option value="0.66">.66</option>
                                                                                <option value="0.67">.67</option>
                                                                                <option value="0.68">.68</option>
                                                                                <option value="0.69">.69</option>
                                                                                <option value="0.7">.7</option>
                                                                                <option value="0.71">.71</option>
                                                                                <option value="0.72">.72</option>
                                                                                <option value="0.73">.73</option>
                                                                                <option value="0.74">.74</option>
                                                                                <option value="0.75">.75</option>
                                                                                <option value="0.76">.76</option>
                                                                                <option value="0.77">.77</option>
                                                                                <option value="0.78">.78</option>
                                                                                <option value="0.79">.79</option>
                                                                                <option value="0.8">.8</option>
                                                                                <option value="0.81">.81</option>
                                                                                <option value="0.82">.82</option>
                                                                                <option value="0.83">.83</option>
                                                                                <option value="0.84">.84</option>
                                                                                <option value="0.85">.85</option>
                                                                                <option value="0.86">.86</option>
                                                                                <option value="0.87">.87</option>
                                                                                <option value="0.88">.88</option>
                                                                                <option value="0.89">.89</option>
                                                                                <option value="0.9">.9</option>
                                                                                <option value="0.91">.91</option>
                                                                                <option value="0.92">.92</option>
                                                                                <option value="0.93">.93</option>
                                                                                <option value="0.94">.94</option>
                                                                                <option value="0.95">.95</option>
                                                                                <option value="0.96">.96</option>
                                                                                <option value="0.97">.97</option>
                                                                                <option value="0.98">.98</option>
                                                                                <option value="0.99">.99</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary" type="submit"> <i
                                                                class="bx bx-edit font-size-16 align-middle me-2"></i>
                                                            Taxrirlash </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
                <form action="{{ route('stafftoDepartment') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="department_id" value="{{ request('id') }}">
                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <h5 class="card-title me-2">Lavozimni biriktirish</h5>
                            <select class="staff_id js-example-basic-single" name="staff_id" required>
                                <option value="">-- Lavozimni tanlang --</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <h5 class="card-title me-2">Lavozim to'liq nomi</h5>
                            <textarea name="staff_full" class="form-control"></textarea>
                        </div>

                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <h5 class="card-title me-2">Klassifikatordagi lavozim ko'rinishini tanlang</h5>
                            <select class="js-example-basic-single js-data-example-ajax" name="class_staff_id"
                                id="classifications" style="width: 100%">
                            </select>
                        </div>
                        <div class="mb-4">
                            <h5 class="card-title me-2">Stavka</h5>
                            <div class="row">
                                <div class="col">
                                    <input type="number" value="1" class="form-control" name="st_1">
                                </div>
                                <div class="col">
                                    <select class="form-select" name="st_2">
                                        <option value="0">.00</option>
                                        <option value="0.01">.01</option>
                                        <option value="0.02">.02</option>
                                        <option value="0.03">.03</option>
                                        <option value="0.04">.04</option>
                                        <option value="0.05">.05</option>
                                        <option value="0.06">.06</option>
                                        <option value="0.07">.07</option>
                                        <option value="0.08">.08</option>
                                        <option value="0.09">.09</option>
                                        <option value="0.1">.1</option>
                                        <option value="0.11">.11</option>
                                        <option value="0.12">.12</option>
                                        <option value="0.13">.13</option>
                                        <option value="0.14">.14</option>
                                        <option value="0.15">.15</option>
                                        <option value="0.16">.16</option>
                                        <option value="0.17">.17</option>
                                        <option value="0.18">.18</option>
                                        <option value="0.19">.19</option>
                                        <option value="0.2">.2</option>
                                        <option value="0.21">.21</option>
                                        <option value="0.22">.22</option>
                                        <option value="0.23">.23</option>
                                        <option value="0.24">.24</option>
                                        <option value="0.25">.25</option>
                                        <option value="0.26">.26</option>
                                        <option value="0.27">.27</option>
                                        <option value="0.28">.28</option>
                                        <option value="0.29">.29</option>
                                        <option value="0.30">.3</option>
                                        <option value="0.31">.31</option>
                                        <option value="0.32">.32</option>
                                        <option value="0.33">.33</option>
                                        <option value="0.34">.34</option>
                                        <option value="0.35">.35</option>
                                        <option value="0.36">.36</option>
                                        <option value="0.37">.37</option>
                                        <option value="0.38">.38</option>
                                        <option value="0.39">.39</option>
                                        <option value="0.4">.4</option>
                                        <option value="0.41">.41</option>
                                        <option value="0.42">.42</option>
                                        <option value="0.43">.43</option>
                                        <option value="0.44">.44</option>
                                        <option value="0.45">.45</option>
                                        <option value="0.46">.46</option>
                                        <option value="0.47">.47</option>
                                        <option value="0.48">.48</option>
                                        <option value="0.49">.49</option>
                                        <option value="0.5">.5</option>
                                        <option value="0.51">.51</option>
                                        <option value="0.52">.52</option>
                                        <option value="0.53">.53</option>
                                        <option value="0.54">.54</option>
                                        <option value="0.55">.55</option>
                                        <option value="0.56">.56</option>
                                        <option value="0.57">.57</option>
                                        <option value="0.58">.58</option>
                                        <option value="0.59">.59</option>
                                        <option value="0.6">.6</option>
                                        <option value="0.61">.61</option>
                                        <option value="0.62">.62</option>
                                        <option value="0.63">.63</option>
                                        <option value="0.64">.64</option>
                                        <option value="0.65">.65</option>
                                        <option value="0.66">.66</option>
                                        <option value="0.67">.67</option>
                                        <option value="0.68">.68</option>
                                        <option value="0.69">.69</option>
                                        <option value="0.7">.7</option>
                                        <option value="0.71">.71</option>
                                        <option value="0.72">.72</option>
                                        <option value="0.73">.73</option>
                                        <option value="0.74">.74</option>
                                        <option value="0.75">.75</option>
                                        <option value="0.76">.76</option>
                                        <option value="0.77">.77</option>
                                        <option value="0.78">.78</option>
                                        <option value="0.79">.79</option>
                                        <option value="0.8">.8</option>
                                        <option value="0.81">.81</option>
                                        <option value="0.82">.82</option>
                                        <option value="0.83">.83</option>
                                        <option value="0.84">.84</option>
                                        <option value="0.85">.85</option>
                                        <option value="0.86">.86</option>
                                        <option value="0.87">.87</option>
                                        <option value="0.88">.88</option>
                                        <option value="0.89">.89</option>
                                        <option value="0.9">.9</option>
                                        <option value="0.91">.91</option>
                                        <option value="0.92">.92</option>
                                        <option value="0.93">.93</option>
                                        <option value="0.94">.94</option>
                                        <option value="0.95">.95</option>
                                        <option value="0.96">.96</option>
                                        <option value="0.97">.97</option>
                                        <option value="0.98">.98</option>
                                        <option value="0.99">.99</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary" style="width: 100%"> Saqlash </button>

                    </div>
                </form>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
@endsection

@section('scripts')
    <script>
        function deleteFunc(id) {
            Swal.fire({
                text: "Ushbu ish o'rnini o'chirishni xoxlaysizmi",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Xa, bajarish!",
                cancelButtonText: "Yo'q, qaytish!",
                confirmButtonClass: "btn btn-success mt-2",
                cancelButtonClass: "btn btn-danger ms-2 mt-2",
                buttonsStyling: !1,
            }).then(function(e) {
                if (e.value) {

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('deleteDepStaff') }}",
                        data: {
                            "id": id,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Success!",
                                text: "Ish o'rni o'chirildi",
                                icon: "success",
                                confirmButtonColor: "#1c84ee",
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error: function(response) {
                            Swal.fire({
                                title: "Error",
                                text: "Ushbu lavozimga biriktirilgan xodimlar mavjud :)",
                                icon: "error",
                                confirmButtonColor: "#1c84ee",
                            });
                        }
                    });

                } else {
                    e.dismiss;
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            @if (\Session::has('msg'))
                @if (Session::get('msg') == 1)
                    Swal.fire({
                        title: "Good!",
                        text: "Muvaffaqqiyatli bajarildi!",
                        icon: "success",
                        showCancelButton: !0,
                        confirmButtonColor: "#1c84ee",
                        cancelButtonColor: "#fd625e",
                    });
                @endif
            @endif
        });
    </script>
    <script>
        $('.staff_id').select2();
    </script>
    <script>
        $('.cadry').select2({
            ajax: {
                url: '{{ route('loadCadry') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.last_name + ' ' + item.first_name + ' ' + item.middle_name,
                                id: item.id
                            }
                        }),
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Xodim ismini kiriting',
            minimumInputLength: 1,
        });
    </script>
    <script>
        $('.js-data-example-ajax').select2({
            ajax: {
                url: '{{ route('loadClassification') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.code_staff + '-' + item.name_uz,
                                id: item.id
                            }
                        }),
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Lavozim nomini kiriting',
            minimumInputLength: 1,
        });
    </script>
@endsection
