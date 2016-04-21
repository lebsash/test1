@section('content')
<h2>Dashboard</h2>
@include('intranet.dashboard.widgets.agents-table', ['title' => 'Live', 'type' => 'live', 'tableClass' => 'bg-primary', 'users' => $users['live']])
@include('intranet.dashboard.widgets.agents-table', ['title' => 'Deployed', 'type' => 'deployed', 'tableClass' => 'bg-info', 'users' => $users['deployed']])
@include('intranet.dashboard.widgets.agents-table', ['title' => 'Suspended', 'type' => 'suspended', 'tableClass' => 'bg-danger', 'users' => $users['suspended']])
@stop
@extends('layouts.intranet')
