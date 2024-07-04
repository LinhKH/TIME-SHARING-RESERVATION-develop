@extends('mail.templateMail')
@section('contentEmail')
    <div>
        <p>email : {{ $data['email'] }} </p>
        <p>new pass word : {{ $data['newPassword'] }} </p>
        <a href="{{ url('/admin/login') }}">{{ url('/admin/login') }}</a>
    </div>
@stop
