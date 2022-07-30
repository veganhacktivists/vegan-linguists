require('./bootstrap')
require('./tooltips')
require('./components/autocomplete')
require('./components/rich-text-editor')
require('./components/tour')

import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.start()
