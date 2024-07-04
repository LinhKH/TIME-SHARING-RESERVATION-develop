@extends('mail.templateMail')
@section('contentEmail')
    <div>
        <p>{{ $email }} 様 </p>
        <p>まだ、登録は終わっていません。</p>
        <p>以下のリンクから、プロフィールの設定を行ってください。</p>
        <a href="{{ config('services.url_page_time_sharing') }}/customer/registered/update-info?email={{ $email }}"
            target="_blank">{{ config('services.url_page_time_sharing') }}/customer/confirm</a>
    </div>
@stop
