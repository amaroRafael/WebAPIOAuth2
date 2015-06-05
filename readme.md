# PHP OAuth 2.0 Server for Lumen

[OAuth 2.0](http://tools.ietf.org/wg/oauth/draft-ietf-oauth-v2/) authorization server and resource server for the Laravel framework. 
Standard compliant thanks to the amazing work by [The League of Extraordinary Packages](http://www.thephpleague.com) OAuth 2.0 authorization server and resource server.

The package assumes you have a good-enough knowledge of the principles behind the [OAuth 2.0 Specification](http://tools.ietf.org/html/rfc6749).

## Version Compability

 Lumen    | OAuth Server | PHP
:---------|:-------------|:----
 5.0.x    | 4.1.x        |>= 5.5

## Documentation

This package features an [extensive wiki](https://github.com/amaroRafael/WebAPIOAuth2/wiki) to help you getting started implementing an OAuth 2.0 Server in your Laravel app.

## Support

Bugs and feature request are tracked on [GitHub](https://github.com/amaroRafael/WebAPIOAuth2/issues)

## License

This package is released under [the MIT License](LICENSE).

## Credits

#The code on which this package are based:

 - [Oauth2 server Lumen](https://github.com/amaroRafael/oauth2server-lumen), is principally developed and maintained by [Rafael Luis Neves Amaro](https://br.linkedin.com/in/rafamaro).

### OAuth2Server-Lumen

PHP OAuth 2.0 Server for Lumen

## Installation

### Via composer

Run ```composer require 'rapiro/oauth2server-lumen:0.1.*'```

### Migrate

In ```bootstrap/app.php``` file and uncomment ```$app->withFacades();``` and ```$app->withEloquent();```

Run ```php artisan migrate --path=vendor/Rapiro/oauth2server-lumen/database/migrations```
