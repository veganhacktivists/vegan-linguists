require('./bootstrap')
require('./tooltips')
require('./components/autocomplete')
require('./components/rich-text-editor')

import Alpine from 'alpinejs'
import Turbolinks from 'turbolinks'

window.Alpine = Alpine
window.Turbolinks = Turbolinks

Alpine.start()
Turbolinks.start()
