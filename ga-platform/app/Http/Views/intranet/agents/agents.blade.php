@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="pull-left">
                <h3>{{ isset($type) ? ucfirst($type).' ' : '' }}Agents</h3>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="pull-left">
            @if (count($items))
                {!! $items->appends(['search' => (isset($search) ? $search : '')])->links() !!}
            @endif
        </div>
        <form class="form-inline pull-right" method="POST" action="{{ config('app.url-gai') }}/agents/{{ isset($type) ? $type : '' }}/">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label class="sr-only" for="searchKeyword">Search</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="searchKeyword" placeholder="keyword..." value="{{ isset($search) ? $search : '' }}" name="search">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
            <span class="pagination-total text-right">{{$items->total() }} records</span>
        </form>
    </div>
    <table class="table  table-bordered table-hover table-responsive small intranet-table">
        <thead>
            <tr class="bg-primary">
                <th width="3%">#</th>
                <th width="7%">User ID</th>
                <th width="15%">Agent Name / ID</th>
                <th width="15%">Username</th>
                <th width="15%">Name / Email</th>
                <th width="15%">Company/Location</th>
                <th width="10%">Leads</th>
                <th width="10%">Created</th>
                <th width="10%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if (count($items))
                @foreach($items as $key => $item)

                 @if (isset($WOffice[$item->SalesPersonID]))
                    @if ($WOffice[$item->SalesPersonID]['ErrorCharges'] == 1)
                    <tr class="alert alert-danger">
                    @else
                    <tr>
                    @endif
                 @else
                 <tr>
                 @endif    


                    <td>{{ ((isset($page) ? $page : 1) - 1) * $items->perPage() + $key + 1 }}</td>
                    <td>{{ $item->UserID }}</td>
                    <td><strong>{{ $item->AgentsName }}</strong><br>ID: {{ $item->SalesPersonID }}</td>
                    <td>{{ $item->UserName }}</td>
                    <td>{{ $item->Name }}<br>{{ $item->Email }}</td>
                    <td>{{ $item->CompanyName }}<br>{{ $item->Location }}
                    @if (isset($WOffice[$item->SalesPersonID]))
                        <br>All charges: {{$WOffice[$item->SalesPersonID]['Total_SUMM']/100}}$    
                        <br>Total sub's: {{$WOffice[$item->SalesPersonID]['subscription']}} 

                     
                    @endif    
                    </td>
                    <td>
                        {{ $item->numberofLeadsLastWeek }} (7 Days)<br>
                        {{ $item->numberofLeadsLastMonth }} (1 Month)
                    </td>
                    <td class="force-center">{{ date("M/d/Y g:iA", strtotime($item->Created)) }}</td>
                    <td class="force-center">
                        <a href="{{ config('app.url-ga') }}/login?1={{ base64_encode($item->UserName) }}&2={{ base64_encode($item->Password) }}" target="_blank" class="fa fa-sign-in" title="Login Agent as: {{$item->UserName}}"></a>
                        <a href="{{ config('app.url-gai') }}/agents/form/{{ $item->SalesPersonID }}/" class="fa fa-pencil-square" title="Edit Agent"></a>
                        <a href="{{ config('app.url-gai') }}/agents/delete/{{ $item->SalesPersonID }}/" class="fa fa-times-circle" title="Delete Agent"></a>
                @if (isset($WOffice[$item->SalesPersonID]))
                    @if ($WOffice[$item->SalesPersonID]['ErrorCharges'] == 1)
                    <div class="fa fa-flag" data-title="Errors in charges"></div>
                    @endif
                @endif    
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="15" class="force-center"><i>- no records -</i></td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="15" class="text-right">
                    <div class="col-md-12">
                    @if (count($items))
                        {!! $items->appends(['search' => (isset($search) ? $search : '')])->links() !!}
                    @endif
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
@stop
@extends('layouts.intranet')
