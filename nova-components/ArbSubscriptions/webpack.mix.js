let mix = require('laravel-mix')

require('./nova.mix')

require('laravel-mix-tailwind')

mix
  .setPublicPath('dist')
  .js('resources/js/tool.js', 'js')
  .vue({ version: 3 })
  .css('resources/css/tool.css', 'css')
  .nova('powerlift/arb-subscriptions')
  .tailwind('./tailwind.config.js')
