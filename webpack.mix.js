let mix = require('laravel-mix')
.options({
    fileLoaderDirs: {
        images: 'public/images',
        fonts: 'public/fonts'
    }
});

mix.autoload({
    jquery: ['$', 'jQuery', 'window.jQuery'],
});

mix.js('resources/js/custom.js', 'public/js/app.js')
mix.css('node_modules/@fortawesome/fontawesome-free/css/all.css', 'public/css/app.css');
mix.sass('resources/css/style.scss', 'public/css/app.css')

// npx mix --production