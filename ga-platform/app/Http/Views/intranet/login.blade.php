@section('content')
<div class="display-container body-gray row">
    <div class="col-sm-12 text-center simple-form">
        @if (isset($validationErrors) && count($validationErrors))
            <div class="col-sm-6 col-sm-offset-3">
            <div class="alert alert-warning">
            @foreach ($validationErrors as $error)
                {{ $error }}<br>
            @endforeach
            </div>
            </div>
            <div class="clearfix"></div>
        @endif
        <form class="form-signin" method="POST" action="{{ config('app.url-gai') }}/login">       
            <h4>Intranet - Signin</h4>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="text" id="username" class="form-control" placeholder="Username" name="username" required>
            <input type="password" id="password" class="form-control" placeholder="Password" name="password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign In</button>   
        </form>
    </div>
</div>
@stop
@extends('layouts.intranet-blank')
