[![Build Status](https://travis-ci.com/dialect-katrineholm/laravel-internetx.svg?token=EdYhqXZq4TUuwAgtq16F&branch=master)](https://travis-ci.com/dialect-katrineholm/laravel-internetx)

# laravel-internetx
API wrapper for Internetx. This is currently a work in progress and doesn't support everything in the API.

## Basic usage
Set `INTERNETX_USERNAME` and `INTERNETX_PASSWORD` in the `.env` or publish the config file.



### Domains

``` php
Internetx::domains()->where('name', '=', '*.com')->get();
```


