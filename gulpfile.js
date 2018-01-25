var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
elixir.config.sourcemaps = false;

elixir(function(mix) {
    mix
        .sass('index.scss')
        .sass('introduce-hotel.scss')
        .sass('introduce-food.scss')
        .sass('search-hotel.scss')
        .sass('search-food.scss')
        .sass('order-hotel.scss')
        .sass('order-finish-hotel.scss')
        .sass('member-order-hotel.scss')
        .sass('member-point-use.scss')
        .sass('member-point-record.scss')
        .sass('member-point-buy.scss')
        .sass('member-point-give.scss')
        .sass('member-favorite-hotel.scss')
        .sass('member-favorite-food.scss')
        .sass('member-account.scss')
        .sass('about.scss')
        .sass('contact.scss')
        .sass('privacy.scss')
        .sass('terms.scss');


    mix
        .babel('common.js')
        .babel('index.js')
        .babel(['introduce.js', 'introduce-hotel.js'], 'public/js/introduce-hotel.js')
        .babel(['introduce.js', 'introduce-food.js'], 'public/js/introduce-food.js')
        .babel(['search.js', 'search-hotel.js'], 'public/js/search-hotel.js')
        .babel(['search.js', 'search-food.js'], 'public/js/search-food.js')
        .babel('order-hotel.js')
        .babel('contact.js')
        .babel('facebook.js');
});
