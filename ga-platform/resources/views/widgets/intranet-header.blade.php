<div id="page-container">
<header>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ config('app.url-gai') }}/dashboard">Great Agent Intranet</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="{{ config('app.url-gai') }}/dashboard">Dashboard</a></li>
                    <li>
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">Users <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ config('app.url-gai') }}/users">All Users</a></li>
                                    <li class="divider"></li>
                                    <li><a href="{{ config('app.url-gai') }}/users/live/">Live</a></li>
                                    <li><a href="{{ config('app.url-gai') }}/users/deployed/">Deployed</a></li>
                                    <li><a href="{{ config('app.url-gai') }}/users/suspended/">Suspended</a></li>
                                    <li><a href="{{ config('app.url-gai') }}/users/cancelled/">Cancelled</a></li>
                                    <li class="divider"></li>
                                    <li><a href="{{ config('app.url-gai') }}/users/form">Create New User</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">Agents <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ config('app.url-gai') }}/agents">All Agents</a></li>
                                    <li class="divider"></li>
                                    <li><a href="{{ config('app.url-gai') }}/agents/live/">Live</a></li>
                                    <li><a href="{{ config('app.url-gai') }}/agents/deployed/">Deployed</a></li>
                                    <li><a href="{{ config('app.url-gai') }}/agents/suspended/">Suspended</a></li>
                                    <li class="divider"></li>
                                    <li><a href="{{ config('app.url-gai') }}/agents/form">Create New Agent</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">Offices <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ config('app.url-gai') }}/offices">All Offices</a></li>
                                    <li class="divider"></li>
                                    <li><a href="{{ config('app.url-gai') }}/offices/form">Create New Offices</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">Admin <span class="caret"></span></a>
                            <ul class="dropdown-menu-right dropdown-menu" role="menu">
                                <li class="divider"></li>
                                <li><a href="{{ config('app.url-gai') }}/logout/">Signout</a></li>
                                <li class="divider"></li>
                            </ul>
                        </li>
                    </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
</header>