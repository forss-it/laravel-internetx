# laravel-internetx
API wrapper for Internetx. This is currently a work in progress and doesn't support everything in the API.

##Basic usage
Set `INTERNETX_USERNAME` and `INTERNETX_PASSWORD` in the `.env` or publish the config file.



###Domains

``` php
Internetx::domains()->where('name', '=', '*.com')->get();
```


