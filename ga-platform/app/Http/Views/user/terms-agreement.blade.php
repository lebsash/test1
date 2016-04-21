@section('content')
<br>
<form class="col-sm-5 col-centered" method="POST" action="{{ config('app.url-ga') }}/user-agreement">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="is-agree" value="yes" />
    <div>
        <h4>Terms</h4>
        <p>
            {{ $customTerms }}
        </p>
    </div>
    <br>
    <div>
        <button type="submit" class="btn btn-primary" name="agree-terms">I Agree</button>
        <a href="{{ config('app.url-ga') }}/" class="btn">Cancel</a>
    </div>
</form>
<br><br>
@stop
@extends('layouts.default')
