@extends('mail.templateMail')
@section('contentEmail')
    <div>
        <p>会員種類: {{ $data['business_structure'] }} </p>
        <p>会社・団体名: {{ $data['company_name'] }} </p>
        <p>お名前 姓名: {{ $data['first_name'] }} - {{ $data['last_name'] }} </p>
        <p>お名前（カナ）: {{ $data['first_name_kana'] }} - {{ $data['last_name_kana'] }} </p>
        <p>性別: {{ $data['gender'] }} </p>
        <p>
            生年月日:
            {{ $data['birthday_day_ident']['year'] }}年
            {{ $data['birthday_day_ident']['month'] }}月
            {{ $data['birthday_day_ident']['day'] }}日
        </p>
        <p>電話番号（ハイフンなし）: {{ $data['phone_number'] }} </p>
        <p>住所: {{ $data['address'] }} </p>
    </div>
@stop
