@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="pull-left">
                <h3>{{ isset($type) ? ucfirst($type).' ' : '' }}Offices</h3>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="pull-left">
            @if (count($items))
                {!! $items->appends(['search' => (isset($search) ? $search : '')])->links() !!}
            @endif
        </div>
        <form class="form-inline pull-right" method="POST" action="{{ config('app.url-gai') }}/offices/{{ isset($type) ? $type : '' }}/">
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
                <th width="20%">Office ID</th>
                <th width="20%">Name</th>
                <th width="15%">Email</th>
                <th width="15%">Phone</th>
                
                <th width="13%">Created</th>
                <th width="13%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if (count($items))
                @foreach($items as $key => $item)
                <tr>
                    <td>{{ ((isset($page) ? $page : 1) - 1) * $items->perPage() + $key + 1 }}</td>
                    <td>{{ $item->UID }}</td>
                    <td><strong>{{ $item->Name }}</strong><br>ID: {{ $item->id }}</td>
                    <td>{{ $item->Email }}</td>
                    <td>{{ $item->Phone }}</td>
                    <td class="force-center">{{ date("M/d/Y g:iA", strtotime($item->created_at)) }}</td>
                    <td class="force-center">
                    
                        <a href="{{ config('app.url-gai') }}/offices/main/{{ $item->id }}/" class="fa fa-info-circle" id="info" title="Info"></a>
                        <a href="{{ config('app.url-gai') }}/offices/form/{{ $item->id }}/" class="fa fa-pencil-square" title="Edit Office"></a>
                        <a href="{{ config('app.url-gai') }}/offices/delete/{{ $item->id }}/" class="fa fa-times-circle" title="Delete Office"></a>
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
