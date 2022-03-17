const mix = require('laravel-mix');

mix.setPublicPath('build')
    .js('src/scripts/vendor/jquery.js', 'js')
    .js('src/scripts/app.js', 'js')
    .sass('src/styles/app.scss', 'css');