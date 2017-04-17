<!-- language: lang-js -->
var elixir = require('laravel-elixir')

require('laravel-elixir-vue-2');


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

elixir(function(mix) {

    mix.sass('app.scss')
        .webpack('app.js');

    mix.styles([
        'bootstrap.min.css',
        'editor.dataTables.min.css',
        'font-awesome.min.css',
        'gridstack.css',
        'jquery-ui.css',
        'buttons.dataTables.min.css',
        'select.dataTables.min.css',
        'dataTables.bootstrap.min.css',
        'keyTable.dataTables.min.css',
        'fixedHeader.bootstrap.min.css',
        'fullcalendar.min.css',
        'churchillcalendar.css'

    ]);


    mix.scripts([
        'jquery-3.1.1.js',
        'jquery-ui.js',
        'lodash.js',
        'vue.js',
        'jquery.dataTables.js',
        'dataTables.buttons.min.js',
        'dataTables.select.min.js',
        'dataTables.editor.js',
        'jszip.min.js',
        'pdfmake.min.js',
        'vfs_fonts.js',
        'buttons.html5.min.js',
        'buttons.print.min.js',
        'dataTables.responsive.min.js',
        'dataTables.bootstrap.min.js',
        'dataTables.fixedHeader.min.js',
        'responsive.bootstrap.min.js',
        'ratchet.js',
        'axios.js',
        'resources/assets/js/moment.min.js',
        'fullcalendar.min.js'


    ]);

    mix.version(['css/all.css', 'js/all.js','js/app.js']);


});


