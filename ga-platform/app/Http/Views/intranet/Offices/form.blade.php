@section('content')
<div class="row text-left">
    <form method="POST" action="{{ config('app.url-gai') }}/offices/form/{{ (isset($id) ? $id : '' ) }}/" role="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{ (isset($office['id']) ? $office['id'] : '' ) }}">
        @if (!isset($created))
        @if (isset($updated))
            <div class="col-md-12 alert alert-success">
                {{ $updated }}
            </div>
        @endif
        <div class="col-md-12">
            <h4>{{ (isset($id) ? 'Edit' : 'Create') }} office Form</h4>
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
            @if (isset($office['id']))
            <div class="col-md-12 alert alert-success">
                <div class="col-md-6">
                    <p>OFFICE UID: <strong>{{ $office['UID'] }}</strong></p>
                    <p>Name: <strong>{{ $office['Name'] }}</strong></p>
                    <p>Office ID: <strong><a href="{{ config('app.url-gai') }}/offices/form/{{ $office['id'] }}/">{{ $office['id'] }}</a></p>
                </div>
                <div class="col-md-6">
                    <p>Email: <strong>{{ $office['Email'] }}</strong></p>
                </div>
            </div>
            @endif
            <div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" type="text" name="Name" value="{{ (isset($office['Name']) ? $office['Name'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>UID</label>
                        <input class="form-control" type="text" name="UID" value="{{ (isset($office['UID']) ? $office['UID'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="text" name="Email" value="{{ (isset($office['Email']) ? $office['Email'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input class="form-control" type="text" name="Phone" value="{{ (isset($office['Phone']) ? $office['Phone'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Logo_URL</label>
                        <input class="form-control" type="text" name="Logo_URL" value="{{ (isset($office['Logo_URL']) ? $office['Logo_URL'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Logo_ID</label>
                        <input class="form-control" type="text" name="Logo_ID" value="{{ (isset($office['Logo_ID']) ? $office['Logo_ID'] : '' ) }}" />
                    </div>

                    <div class="form-group">
                        <label>Domain Name</label>
                        <input class="form-control" type="text" name="DomainName" value="{{ (isset($office['DomainName']) ? $office['DomainName'] : '' ) }}" />
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <label><input type="checkbox" name="isActive" value="1" {{ (isset($office['isActive']) && $office['isActive'] ? 'checked="checked"' : '' ) }} /> isActive</label>
                        </div>
                    </div>


                </div>

        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="clearfix"></div>
                <button type="submit" class="btn btn-primary form-submit">Submit</button>

            </div>
        </div>
        @else
            <div class="col-md-12 alert alert-success">
                {{ $created }}
            </div>
        @endif
    </form>
</div>
@stop
@extends('layouts.intranet')
