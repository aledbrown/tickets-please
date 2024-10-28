## Tickets Please Laravel 11 API
> https://laracasts.com/series/laravel-api-master-class/episodes/1
> php artisan install:api
> 
> 
## Useful commands
> php artisan make:controller Api/V1/TicketController --resource --model=Ticket --requests
> php artisan make:controller Api/V1/UsersController --resource --model=User --requests
> php artisan make:resource V1/UserResource

## Info
> Route prefix and new api route file added to Laravel 11 in bootstrap/app.php

## Documentation
> Using "scribe"
> https://scribe.knuckles.wtf/laravel/
> composer require --dev knuckleswtf/scribe
> php artisan vendor:publish --tag=scribe-config
> setup config
> php artisan scribe:generate
> If generate won't run (null errors for auth user) then make sure the API key in Scribe.php is valid.
> 
