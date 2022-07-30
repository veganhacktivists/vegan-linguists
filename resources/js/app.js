require('./bootstrap')
require('./tooltips')
require('./components/autocomplete')
require('./components/rich-text-editor')
require('./components/tour')

import Alpine from 'alpinejs'
import Turbolinks from 'turbolinks'

window.Alpine = Alpine
window.Turbolinks = Turbolinks

Alpine.start()
