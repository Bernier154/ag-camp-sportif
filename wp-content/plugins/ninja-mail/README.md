# Ninja Mail

A transactional email service for Ninja Forms.

## Development with a local server

When developing with a local copy of the Ninja Mail server, be sure to filter `https_ssl_verify`.

```php
add_filter( 'https_local_ssl_verify', '__return_false' );
add_filter( 'https_ssl_verify', '__return_false' );
```.
