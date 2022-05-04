const mix = require('laravel-mix');

mix.setPublicPath('public')
mix.setResourceRoot('../');

mix 
    // scripts
    .scripts('resources/js/app.js', 'public/js/app.js')
    .scripts('node_modules/jquery/dist/jquery.js', 'public/js/jquery.js')
    .scripts('node_modules/bootstrap/dist/js/bootstrap.bundle.js', 'public/js/bootstrap.bundle.js')
    .scripts('node_modules/chart.js/dist/chart.js', 'public/js/chart.js')
    .scripts('node_modules/bootstrap-table/dist/bootstrap-table-locale-all.js', 'public/js/bootstrap-table-locale-all.js')
    .scripts('node_modules/bootstrap-table/dist/bootstrap-table.js', 'public/js/bootstrap-table.js')
    .scripts('node_modules/tableexport.jquery.plugin/tableExport.min.js', 'public/js/tableExport.min.js')
    .scripts('node_modules/bootstrap-table/dist/extensions/export/bootstrap-table-export.js', 'public/js/bootstrap-table-export.js')
    .scripts('node_modules/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.js', 'public/js/bootstrap-editable.js')
    .scripts('node_modules/bootstrap-table/dist/extensions/editable/bootstrap-table-editable.js', 'public/js/bootstrap-table-editable.js')
    // sass
    .sass('resources/sass/app.scss', 'public/css/app.css')
    .css('resources/css/style.css', 'public/css/style.css')
    .css('node_modules/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css', 'public/css/bootstrap-editable.css')
    .css('node_modules/bootstrap-table/dist/bootstrap-table.css', 'public/css/bootstrap-table.css')
    .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts') 
    .sourceMaps()
    //Versionamento
    .version();