@section('content')
<div class="display-container body-gray row text-left">
    <div class="col-sm-12 simple-form">
        @if (isset($validationErrors) && count($validationErrors))
            <div class="col-sm-10 col-sm-offset-0">
            <div class="alert alert-warning">
            @foreach ($validationErrors as $error)
                {{ $error }}<br>
            @endforeach
            </div>
            </div>
            <div class="clearfix"></div>
        @endif
        @if (isset($confirmed))
            <div class="col-md-12 alert alert-danger">
                {{ $confirmed }}
            </div>
        @else
            Delete {{ $type }} Confirmation:
            <form class="form-signin" method="POST" action="{{ config('app.url-gai') }}{{ $link }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @if (isset($optinalField['hiddenField1']))
                <input type="hidden" name="hiddenField1" value="{{ $optinalField['hiddenField1'] }}">
                @endif
                <h4>{{ $confirmInfo }}</h4>
                <p>{{ $confirmDesc }}</p>
                @if (isset($optinalField))
                    @include('widgets.' . $optinalField['type'], $optinalField['data'])
                @endif
                <button class="btn btn-danger" type="submit" name="confirm_id" value="{{ $id }}">{{ $button }}</button>   
            </form>
        @endif
    </div>
</div>
@stop
@extends('layouts.intranet')
