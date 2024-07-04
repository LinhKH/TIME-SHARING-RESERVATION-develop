<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>

<body>

    {{-- header mail --}}

    <a href="{{ config('services.url_page_time_sharing') }}" target="_blank">
        <img style="width:20%" src="{{ asset('images/time_sharing_logo.png') }}">
    </a>

    <br>

    <div style="background-color:#0d3f58;color:#b6b0ba;padding:8px 0 8px 15px;font-size:21px">
        【TIME SHARING】アカウント本登録のお願い
    </div>

    {{-- content  mail --}}
    @yield('contentEmail')

    {{-- bottom  mail --}}
    <br><br><br>
    <hr>
    <p>TIME SHARING 運営事務局<br>
        <a href="{{ config('services.url_page_time_sharing') }}"
            target="_blank">{{ config('services.url_page_time_sharing') }}</a>
    </p>
    <p style="color:red">※<a href="mailto:info@time-sharing.jp"
            target="_blank">{{ config('mail.mailers.smtp.username') }}</a>は送信専用アドレス<wbr>です。<br>
        直接返信されてもご返答できませんので予めご了承ください。</p>

</body>

</html>
