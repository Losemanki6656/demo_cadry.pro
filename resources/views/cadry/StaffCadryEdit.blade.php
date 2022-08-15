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

    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <form action="{{ route('addCadryToDepartmentStaff', ['id' => 1]) }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="mb-4">
                            <label>FIO:</label>
                            <h5>{{ $item->cadry->last_name}} {{ $item->cadry->first_name}} {{ $item->cadry->middle_name}}</h5>
                        </div>
                        <div class="mb-4">
                            <label>Bo'linma:</label>
                            <h5>{{ $item->department->name}}</h5>
                        </div>
                        <div class="mb-4">
                            <label>Lavozimi:</label>
                            <h5>{{ $item->staff_full}}</h5>
                        </div>
                        
                        <div class="mb-4">
                            <label>Stavka</label>
                            <h5>{{ $item->stavka}}</h5>
                        </div>

                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <label>Bo'linmani tanlang</label>
                            <select class="js-example-basic-single department" name="department_id" id="department_id" style="width: 100%" required>
                            </select>
                        </div>

                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <label>Lavozimni tanlang</label>
                            <select name="staff_if" id="staff_id" class="form-control">

                            </select>
                        </div>

                        <div class="mb-4">
                            <h5 class="card-title me-2">Stavka</h5>
                            <div class="row">
                                <div class="col">
                                    <select class="form-select" name="st_1">
                                        <option value="1">1</option>
                                        <option value="0">0</option>
                                    </select>
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

                        <button class="btn btn-outline-primary" style="width: 100%"> O'zgartirish </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
       
        $('#department_id').change(function(e) {
            myFilter();
        })

        function myFilter() {
            let department_id = $('#department_id').val();
            let url = '{{ route('cadry') }}';

            window.location.href = `${url}?
            department_id=${department_id}&`;
        }
    </script>
@endpush
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            @if (\Session::has('msg'))
                @if (Session::get('msg') == 1)
                    Swal.fire({
                        title: "Amalga oshirilmadi",
                        text: "Xodimning stavkasi amaldagi bo'sh lavozim stavkasiga to'gri kelmadi!",
                        icon: "warning",
                        confirmButtonColor: "#1c84ee"
                    });
                @endif
            @endif
        });
    </script>
    <script>
        $('.staff').select2();
    </script>
    <script>
        $('.department').select2({
            ajax: {
                url: '{{ route('loadDepartment') }}',
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
                                text: item.name,
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
            placeholder: "Bo'linmani tanlang",
            minimumInputLength: 1,
        });
    </script>
@endsection
