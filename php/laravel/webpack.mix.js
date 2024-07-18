const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .vue() // Essa função é crucial para o vue-loader
   .sass('resources/sass/app.scss', 'public/css');
