*************************

The Laravel code in GA is an example of a less-than-optimal code base that may need some refactoring. Please refer to the initial task document for instructions on this coding challenge.

This readme file is to help you install on Apache. If you use a different webserver, that's totally fine - so do we - but we would ask you to install the code base on your own.

*************************

Apache config changes:

0. Move the ga-platform folder to somewhere where your Apache server has read and write access.

Run the command "composer install" in the ga-platform folder.

1. SSL (if you haven't already done this before)

<IfModule ssl_module>
SSLRandomSeed startup builtin
SSLRandomSeed connect builtin
</IfModule>

2. Setting up the app:

2a) Change localhost to the domain name you want to use

2b) Change C:\Apache24\htdocs\Dropbox\WWW\intranet\greatagent to the path of the installed app (e.g. \var\www\html\greatagent\ )

<VirtualHost domain.com:80>
  ServerName localhost
  Alias /great-agent-dev C:\Apache24\htdocs\Dropbox\WWW\intranet\greatagent
  DocumentRoot C:\Apache24\htdocs\Dropbox\WWW\intranet\greatagent
  <Directory "C:\Apache24\htdocs\Dropbox\WWW\intranet\greatagent">
    AllowOverride all
    Order allow,deny
    Allow from all
  </Directory>
</VirtualHost>

