<div class="row">
    <div class="col-md-12">
        <div class="pull-left">
            <h3>Agents ({{ $title }})</h3>
        </div>
    </div>
    <table class="table table-striped table-bordered table-hover table-responsive small intranet-table">
        <thead>
            <tr class="{{ $tableClass }}">
                <th width="3%">#</th>
                <th width="10%">User ID</th>
                <th width="15%">Agent Name / ID</th>
                <th width="15%">Username</th>
                <th width="15%">Name / Email</th>
                <th width="10%">Location</th>
                <th width="12%">Company Name</th>
                <th width="12%">Created</th>
                <th width="8%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if (count($users))
                @foreach($users as $key => $user)
                <tr data-id="{{ $user->SalesPersonID }}">
                    <td>{{ ((isset($page) ? $page : 1) - 1) * $users->perPage() + $key + 1 }}</td>
                    <td>{{ $user->UserID }}</td>
                    <td><strong>{{ $user->AgentsName }}</strong><br>ID: {{ $user->SalesPersonID }}</td>
                    <td>{{ $user->UserName }}</td>
                    <td>{{ $user->Name }}<br>{{ $user->Email }}</td>
                    <td>{{ $user->Location }}</td>
                    <td>{{ $user->CompanyName }}</td>
                    <td class="force-center">{{ date("M/d/Y g:iA", strtotime($user->Created)) }}</td>
                    <td class="force-center">
                        <a href="{{ config('app.url-ga') }}/login?1={{ base64_encode($user->UserName) }}&2={{ base64_encode($user->Password) }}" class="fa fa-sign-in" title="Login Agent as: {{$user->UserName}}"></a>
                        <a href="{{ config('app.url-gai') }}/agents/form/{{ $user->SalesPersonID }}/" class="fa fa-pencil-square" title="Edit Agent"></a>
                        <a href="{{ config('app.url-gai') }}/agents/delete/{{ $user->SalesPersonID }}/" class="fa fa-times-circle" title="Delete Agent"></a>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="15"> - no records -</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="15" class="text-right">
                    <div class="col-md-12">
                    @if (count($users))
                        <a href="{{ config('app.url-gai') }}/agents/{{ $type }}/">Show more &raquo;</a>
                    @endif
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
