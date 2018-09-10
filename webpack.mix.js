let mix = require('laravel-mix');

mix.setPublicPath('public');

mix.setResourceRoot('../');

mix.sass('src/css/style.scss', 'public/css/styles.css')
   .sass('src/css/admin.scss', 'public/css/admin.css')
   .js('src/js/ninja_mortgage_calc.js', 'public/js/ninja_mortgage_calc.js')
   .js('src/js/UserShowApp.js', 'public/js/UserShowApp.js');