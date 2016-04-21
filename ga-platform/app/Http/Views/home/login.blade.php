@section('content')
<div class="display-container body-gray row">
    <div class="col-sm-12 text-center simple-form">
        @if (isset($validationErrors) && count($validationErrors))
            <div class="col-sm-6 col-sm-offset-3">
            @foreach ($validationErrors as $error)
                <div class="alert alert-warning">
                  {{ $error }}
                </div>
            @endforeach
            </div>
            <div class="clearfix"></div>
        @endif
        <form class="form-signin" method="POST" action="/ga/login">       
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div>
                <p>
                    If you're already using the Great Agent platform,<br>please sign in below.
                    If not, <a title="Ready to See a Demo?" href="{{\Config::get('app.url')}}/request-a-demo/">please request a demo</a>.
                </p>
                <br>
            </div>
            <input type="text" class="form-control" name="email" placeholder="E-mail (the one you used at sign up)" autofocus="" />
            <input type="password" class="form-control" name="password" placeholder="Password"/>
            <label class="checkbox">
                <input type="checkbox" value="terms" id="rememberMe" name="termsOfService" placeholder="Terms of Service Agreement" alt="Please agree to the Terms of Service Agreement"> I agree to the latest version of the<br><a href="https://greatagent.net/landing/GreatAgent-terms-20140108.htm" target="_blank">Terms of Service Agreement</a>.
            </label>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign In</button>   
        </form>
    </div>
</div>
@stop
@extends('layouts.default')
