@section('content')
<br>
<form class="col-sm-5 col-centered" method="POST" action="{{ config('app.url-ga') }}/user-agreement/signature">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="">
        <input type=hidden value=""name="customTerms">
        @if (isset($validationErrors) && count($validationErrors))
        <div class="col-sm-12">
            @foreach ($validationErrors as $error)
            <div class="alert alert-warning">
                {{ $error }}
            </div>
            @endforeach
        </div>
        <div class="clearfix"></div>
        @endif
        <div>
            <h4>Electronic Signature:</h4>
            <p>
                I, a user of Great Agent, warrant the truthfulness of the information provided in this form.
            </p>
            <p>
                I understand that entering my name in the line below constitutes a legal signature confirming<br>
                that I acknowledge and agree to the above Terms of Acceptance.
            </p>
        </div>
        <br>
        <div>
            Please type your First and Last name
            <div>
                <input type="text" name="signature_name" class="signature">
            </div>
        </div>
        <div>
            Your current IP address will be log: <strong>{{ \GAPlatform\Libraries\Helpers::getRemoteIP() }}</strong>
        </div>
    </div>
    <br><br>
    <div>
        <button type="submit" class="btn btn-primary" name="agree-terms">Continue &raquo;</button>
    </div>
</form>
<br><br>
@stop
@section('design')
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Tangerine">
<style>
.signature {
    outline:none;
    font-size:50px !important;
    line-height:200px;
    font-family: 'Tangerine', serif;
    height:50px !important;
    width:600px !important;
    border-top:0 !important;
    border-left:0 !important;
    border-right:0 !important;
    border-bottom:1px solid #666 !important;
    border-radius:0px !important;
    margin:35px 0;
    box-shadow: none !important;
    padding:0 5px;
    background:transparent;
}
</style>
@stop
@extends('layouts.default')
