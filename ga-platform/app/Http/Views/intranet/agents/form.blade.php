@section('content')
<div class="row text-left">
    <form method="POST" action="{{ config('app.url-gai') }}/agents/form/{{ (isset($id) ? $id : '' ) }}/" role="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="SalesPersonID" value="{{ (isset($agent['SalesPersonID']) ? $agent['SalesPersonID'] : '' ) }}">
        @if (!isset($created))
        @if (isset($updated))
            <div class="col-md-12 alert alert-success">
                {{ $updated }}
            </div>
        @endif
        <div class="col-md-12">
            <h4>{{ (isset($id) ? 'Edit' : 'Create') }} Agent Form</h4>
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
            @if (isset($agent['SalesPersonID']))
            <div class="col-md-12 alert alert-success">
                <div class="col-md-6">
                    <p>SalesPerson ID: <strong>{{ $agent['SalesPersonID'] }}</strong></p>
                    <p>Name: <strong>{{ $agent['Name'] }}</strong></p>
                    <p>User ID: <strong><a href="{{ config('app.url-gai') }}/users/form/{{ $agent['UserID'] }}/">{{ $agent['UserID'] }}</a></p>
                </div>
                <div class="col-md-6">
                    <p>Email: <strong>{{ $agent['Email'] }}</strong></p>
                    <p>Last Live Date: <strong>{{ date("M/d/Y g:iA", strtotime($agent['LastLiveDate'])) }}</strong></p>
                    <p>Password: <strong>{{ $agent['Password'] }}</strong></p>
                </div>
            </div>
            @endif
            <div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>User</label>
                        <select class="form-control" name="UserID">
                            <option value="">- Select User -</option>
                            <?php var_dump($usersList) ?>
                            @foreach ($usersList as $user)
                                <option value="{{ $user['UserID'] }}" {{ (isset($agent['UserID']) ? ( $user['UserID'] == $agent['UserID'] ? 'selected="selected"' : '') : '' ) }}>{{ $user['fullName'] }}</option>
                            @endforeach
                            
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" type="text" name="Name" value="{{ (isset($agent['Name']) ? $agent['Name'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="text" name="Email" value="{{ (isset($agent['Email']) ? $agent['Email'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input class="form-control" type="text" name="Title" value="{{ (isset($agent['Title']) ? $agent['Title'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Office</label>
                        <input class="form-control" type="text" name="Office" value="{{ (isset($agent['Office']) ? $agent['Office'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Stripe ID</label>
                        <input class="form-control" type="text" name="StripeCustomerID" value="{{ (isset($agent['StripeCustomerID']) ? $agent['StripeCustomerID'] : '' ) }}" />
                    </div>

                    <div class="form-group">
                        <label>Cell</label>
                        <input class="form-control" type="text" name="Cell" value="{{ (isset($agent['Cell']) ? $agent['Cell'] : '' ) }}" />
                    </div>
                    <div class="form-group">
                        <label>Picure URL</label>
                        <input class="form-control" type="text" name="PictureURL" value="{{ (isset($agent['PictureURL']) ? $agent['PictureURL'] : '' ) }}" />
                    </div>
                    <div class="col-md-12 col-thin">
                        <div class="col-md-6 col-thin">
                            <div class="form-group">
                                <label>Total Leads</label>
                                <input class="form-control" type="text" name="numberOfLeads" value="{{ (isset($agent['numberOfLeads']) ? $agent['numberOfLeads'] : '' ) }}" />
                                <em></em>
                            </div>
                        </div>
                        <div class="col-md-6 col-thin">
                            <div class="form-group">
                                <label>Total Recent Leads</label>
                                <input class="form-control" type="text" name="NumberOfLeadsRecently" value="{{ (isset($agent['NumberOfLeadsRecently']) ? $agent['NumberOfLeadsRecently'] : '' ) }}" />
                                <em></em>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Password</label>
                            <input class="form-control" type="text" name="Password" value="{{ (isset($agent['Password']) ? $agent['Password'] : '' ) }}" />
                        </div>
                        <div class="form-group">
                            <label>MLSN</label>
                            <input class="form-control" type="text" name="MLSN" value="{{ (isset($agent['MLSN']) ? $agent['MLSN'] : '' ) }}" />
                        </div>
                        <div class="form-group">
                            <label>Sub-domain</label>
                            <input class="form-control" type="text" name="subdomain" value="{{ (isset($agent['subdomain']) ? $agent['subdomain'] : '' ) }}" />
                            <em></em>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Automated Text</label>
                            <textarea class="form-control" name="automatedText" rows="4">{{ (isset($agent['subdomain']) ? $agent['subdomain'] : '' ) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <label><input type="checkbox" name="ReceiveTextAlerts" value="1" {{ (isset($agent['ReceiveTextAlerts']) && $agent['ReceiveTextAlerts'] ? 'checked="checked"' : '' ) }} /> Receive Text Alerts</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="ReceivePhoneAlerts" value="1" {{ (isset($agent['ReceivePhoneAlerts']) && $agent['ReceivePhoneAlerts'] ? 'checked="checked"' : '' ) }}> Receive Phone Alerts</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="isBroker" value="1" {{ (isset($agent['isBroker']) && $agent['isBroker'] ? 'checked="checked"' : '' ) }} {{ (isset($agent['ReceiveTextAlerts']) && $agent['ReceiveTextAlerts'] ? 'checked="checked"' : '' ) }}> is Broker</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="isRealtor" value="1" {{ (isset($agent['isRealtor']) && $agent['isRealtor'] ? 'checked="checked"' : '' ) }}> is Realtor</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="isLender" value="1" {{ (isset($agent['isLender']) && $agent['isLender'] ? 'checked="checked"' : '' ) }}> is Lender</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="WantsSellerLeads" value="1" {{ (isset($agent['WantsSellerLeads']) && $agent['WantsSellerLeads'] ? 'checked="checked"' : '' ) }}> Wants Seller Leads</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <label><input type="checkbox" name="NotifyFavor" value="1" {{ (isset($agent['NotifyFavor']) && $agent['NotifyFavor'] ? 'checked="checked"' : '' ) }}> Notify Favor</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="NotifyHouseView" value="1" {{ (isset($agent['NotifyHouseView']) && $agent['NotifyHouseView'] ? 'checked="checked"' : '' ) }}> Notify House View</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="NotifyEmailOpen" value="1" {{ (isset($agent['NotifyEmailOpen']) && $agent['NotifyEmailOpen'] ? 'checked="checked"' : '' ) }}> Notify Email Open</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="ReceiveDailyTODO" value="1" {{ (isset($agent['ReceiveDailyTODO']) && $agent['ReceiveDailyTODO'] ? 'checked="checked"' : '' ) }}> Receive Daily TODO</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="sendText" value="1" {{ (isset($agent['sendText']) && $agent['sendText'] ? 'checked="checked"' : '' ) }}> send Text</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="clearfix"></div>
                <button type="submit" class="btn btn-primary form-submit">Submit</button>
                @if (isset($agent['SalesPersonID']))
                <a href="{{ config('app.url-ga') }}/login?1={{ base64_encode($agent['Email']) }}&2={{ base64_encode($agent['Password']) }}" target="_blank" class="pull-right btn btn-info" title="Login Agent as: {{ $agent['Email'] }}">Login to this agent <i class="fa fa-sign-in"> </i></a>
                @endif
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
