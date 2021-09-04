const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js');

mix.js('resources/js/backend.js', 'public/js');

mix.css('resources/css/app.css', 'public/css');
