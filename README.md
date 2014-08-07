rust-example
================

This is a working example using the rust-framework to create a RESTFul API.

Suppose you wanted to create a RESTFul service that could add two numbers
and give you back the result. 

```
/svc/example/add/5/5.json
```

And all that would need to write out in json was the following:

```
{"result":10}
```

That is just what this does. To see it work from the command line:

```
git clone https://github.com/russellsimpkins/rust-example.git
cd rust-example
composer install --no-dev
php -f cmdline.php
```

To see this work in your apache server you will need to make
sure you have the correct permissions (see http://httpd.apache.org/docs/2.2/mod/core.html#directory)

```
<Directory /where/you/put/rust-example>
    Options Indexes FollowSymLinks MultiViews
    AllowOverride All
    Order allow,deny
    Allow from all
</Directory>
```

And/or you will need to add a mapping e.g.

```
AliasMatch /svc/example/addition/where/you/put/rust-example/index.php [L]
```

Then you should be able to hit your url
