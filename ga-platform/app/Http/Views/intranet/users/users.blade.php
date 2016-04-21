@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="pull-left">
                <h3>{{ isset($type) ? ucfirst($type).' ' : '' }}Users</h3>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="pull-left">
            @if (count($items))
                {{ $items->links() }}
            @endif
        </div>
        <form class="form-inline pull-right" method="POST" action="{{ config('app.url-gai') }}/users/{{ isset($type) ? $type : '' }}/">
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
    <table class="table table-striped table-bordered table-hover table-responsive small intranet-table">
        <thead>
            <tr class="bg-primary">
                <th width="4%">#</th>
                <th width="8%">User ID</th>
                <th width="20%">Name / Email</th>
                <th width="15%">Phone</th>
                <th width="15%">Company Name</th>
                <th width="10%">Location</th>
                <th width="10%">Domain Name</th>
                <th width="10%">Created</th>
                <th width="8%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if (count($items))
                @foreach($items as $key => $item)
                <tr>
                    <td>{{ ((isset($page) ? $page : 1) - 1) * $items->perPage() + $key + 1 }}</td>
                    <td>{{ $item->UserID }}</td>
                    <td>{{ $item->Name }}<br>{{ $item->Email }}</td>
                    <td>{{ $item->Phone }}</td>
                    <td>{{ $item->CompanyName }}</td>
                    <td>{{ $item->Location }}</td>
                    <td>{{ $item->DomainName }}</td>
                    <td class="force-center">{{ date("M/d/Y g:iA", strtotime($item->Created)) }}</td>
                    <td class="force-center">
                        <a href="{{ config('app.url-gai') }}/users/form/{{ $item->UserID }}/" class="fa fa-pencil-square" title="Edit User"></a>
                        <a href="{{ config('app.url-gai') }}/users/delete/{{ $item->UserID }}/" class="fa fa-times-circle" title="Delete User"></a>
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
