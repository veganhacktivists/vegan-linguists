const mix = require('laravel-mix')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
  .js('resources/js/app.js', 'public/js')
  .js('resources/js/components/language-picker.js', 'public/js')
  .js('resources/js/components/rich-text-editor.js', 'public/js')
  .postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
  ])

// vendor CSS
mix.copy('node_modules/quill/dist/quill.snow.css', 'public/css')
mix.copy(
  './node_modules/@algolia/autocomplete-theme-classic/dist/theme.min.css',
  'public/css/autocomplete.css',
)

if (mix.inProduction()) {
  mix.version()
}
