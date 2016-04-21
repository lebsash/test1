@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="pull-left">
                <h3>{{ isset($type) ? ucfirst($type).' ' : '' }}Offices - main information</h3>
            </div>
        </div>
    </div>

    @if (isset($data['id']))
            <div class="col-md-12 alert alert-success text-left">
                <div class="col-md-6">
                    <p>OFFICE UID: <strong>{{ $data['UID'] }}</strong></p>
                    <p>Name: <strong>{{ $data['Name'] }}</strong></p>
                    <p>Office ID: <strong><a href="{{ config('app.url-gai') }}/offices/form/{{ $data['id'] }}/">{{ $data['id'] }}</a></strong></p>

                </div>
                <div class="col-md-6">
                    <p>Email: <strong>{{ $data['Email'] }}</strong></p>
                    <p>Phone: <strong>{{ $data['Phone'] }}</strong></p>
                    <p>Domain: <strong><a href="{{ $data['DomainName'] }}">{{ $data['DomainName'] }}</a></strong></p>
                </div>
                </div>
                <div class="col-md-12 alert alert-success text-left">
                <div class="col-md-6">
                <p>For all time</p>
                <p>Total charges: {{$data['OFFICE_TOTAL_SUMM']/100}} $</p>
                <p>Total refunds: {{$data['OFFICE_TOTAL_REF_SUMM']/100}} $</p>     
                </div>
                <div class="col-md-6">
                <p>For this month</p>
                <p>Total charges:  {{$data['OFFICE_TOTAL_SUMM_MONTH']/100}} $</p>
                <p>Total refunds:  {{$data['OFFICE_TOTAL_REF_SUMM_MONTH']/100}} $</p>
                </div>
            </div>
            @endif

@foreach ($stripe_info as $user)
   <div class="col-md-12  text-left">
   <h2>By Agents</h2>
   </div>
    <div class="col-md-12 alert alert-success text-left">
    <h2>{{ $user['SalesPersonName'] }}</h2>
    <div class="col-md-6">
    <p>For all time</p>
    <p>Total charges: {{$user['Total_summ']['Total_summ']/100}} $</p>
    <p>Total refunds: {{$user['Total_summ']['Total_refunds']/100}} $</p>
    </div>
    <div class="col-md-6">
    <p>For this month</p>
    <p>Total charges:  {{$user['Total_summ_month']['Total_summ']/100}} $</p>
    <p>Total refunds:  {{$user['Total_summ_month']['Total_refunds']/100}} $</p>
    </div>

    </div>
    <div class="col-md-12 text-right">
     <h4>Charges</h4>
    </div>
    <div class="col-md-12 text-left">

    <table class="table table-striped table-bordered table-hover table-responsive small intranet-table">
        <thead>
            <tr class="bg-primary">
                <th width="20%">#</th>
                <th width="20%">Amount</th>
                <th width="15%">Invoice</th>
                <th width="25%">Status</th>               
                <th width="20%">Created</th>
            </tr>
        </thead>
         
         <tbody>
         @foreach ($user['charges'] as $charges)
    @if ($charges['dispute'] != NULL)    
        <tr class="alert alert-error">
    @else 
        @if ($charges['refunded'] != NULL)   
            <tr class="alert alert-danger">
        @else
            <tr>
        @endif 
    @endif

         <td>{{$charges['id']}}</td>
         <td>{{$charges['amount']/100}} {{$charges['currency']}}</td>
         <td>{{$charges['invoice']}}</td>

            <td>


  
            @if ($charges['paid'] == true)
            Paid: <strong>Ok</strong><br>
            @else
            Paid: <strong>FALSE</strong><br>
            @endif
            @if ($charges['dispute'] != NULL)
            <strong>DISPUT!</strong><br>
            @else
            <strong>No disputes</strong><br>
            @endif
            @if ($charges['refunded'] != NULL)
            <strong>Refunded {{$charges['amount_refunded']}}</strong><br>
            @else
            <strong>No refunds</strong><br>
            @endif


         </td>
         <td>{{date("M/d/Y g:iA", $charges['created'])}}</td>
         </tr>
         @endforeach
         </tbody>
    </table>
    </div>
@if (count($user['subscription'])>0) 
<div class="col-md-12 text-right">
  <h4>Subscription</h4>
 </div> 
    <div class="col-md-12 text-left">
    <table class="table table-striped table-bordered table-hover table-responsive small intranet-table">
        <thead>
            <tr class="bg-primary">
                <th width="10%">#</th>
                <th width="10%">Amount</th>
                <th width="10%">Interval</th>
                <th width="15%">Plan</th>
                <th width="10%">Status</th>
                <th width="15%">current period start</th>               
                <th width="15%">current period end</th>
                <th width="15%">Created</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($user['subscription'] as $subscription)
        @if ($subscription['status'] != "active")
        <tr class="alert alert-danger">
        @else
        <tr>
        @endif
       
        <td>{{$subscription['id']}}</td>
        <td>{{$subscription['plan']['amount']/100}} {{$subscription['plan']['currency']}} </td>
        <td>{{$subscription['plan']['interval']}}</td>     
        <td>{{$subscription['plan']['name']}}</td>
        <td>{{$subscription['status']}}</td>
        <td>{{ date("M/d/Y g:iA", $subscription['current_period_start']) }}</td>
        <td>{{ date("M/d/Y g:iA", $subscription['current_period_end']) }}</td>
        <td>{{ date("M/d/Y g:iA", $subscription['plan']['created']) }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    </div>
@endif

@endforeach 

</div>
@stop
@extends('layouts.intranet')
