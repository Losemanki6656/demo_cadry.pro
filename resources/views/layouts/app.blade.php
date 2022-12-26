<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <title>Exodim</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="{{ asset('auth-login/images/logo.png') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('auth-login/vendor/bootstrap/css/bootstrap.min.css') }}">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('auth-login/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('auth-login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('auth-login/vendor/animate/animate.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('auth-login/vendor/css-hamburgers/hamburgers.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('auth-login/vendor/select2/select2.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('auth-login/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth-login/css/main.css') }}">

    <meta name="robots" content="noindex, follow">
</head>

<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url('auth-login/images/img-01.jpg');">
            <div class="wrap-login100 p-t-190 p-b-30">
                @yield('content')
            </div>
        </div>
    </div>
    <script>
        // window.location.href = 'https://exodim.netlify.app';
   </script>
    <script>
        function showDateTime() {
            var myDiv = document.getElementById("myDiv");

            var date = new Date();
            var dayList = ["Yakshanba", "Dushanba", "Seshanba", "Chorshanba", "Payshanba", "Juma", "Shanba"];
            var monthNames = [
                "Yanvar",
                "Fevral",
                "Mart",
                "Aprel",
                "May",
                "Iyun",
                "Iyul",
                "Avgust",
                "Sentyabr",
                "Oktyabr",
                "Noyabr",
                "Dekabr"
            ];
            var dayName = dayList[date.getDay()];
            var monthName = monthNames[date.getMonth()];
            var today = `${dayName}, ${monthName} ${date.getDate()}, ${date.getFullYear()}`;

            var hour = date.getHours();
            var min = date.getMinutes();
            var sec = date.getSeconds();

            var time = hour + ":" + min + ":" + sec;
            myDiv.innerText = `${today}. ${time}`;
        }
        setInterval(showDateTime, 1000);
    </script>
   
</body>

</html>
