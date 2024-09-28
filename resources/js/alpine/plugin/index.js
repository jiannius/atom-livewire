import Alpine from 'alpinejs'

// data
import Alert from './data/alert.js'
import Confirm from './data/confirm.js'
import Modal from './data/modal.js'
import Toast from './data/toast.js'
import Overlay from './data/overlay.js'

// magic
import SortId from './magic/sortid.js'
import Clipboard from './magic/clipboard.js'

// directive
import Icon from './directive/icon.js'
import Badge from './directive/badge.js'
import Prompt from './directive/prompt.js'
import WireOn from './directive/wire-on.js'
import Recaptcha from './directive/recaptcha.js'
import Autoresize from './directive/autoresize.js'

export default function (Alpine) {
    Alpine.data('alert', Alert)
    Alpine.data('confirm', Confirm)
    Alpine.data('modal', Modal)
    Alpine.data('toast', Toast)
    Alpine.data('overlay', Overlay)
    Alpine.magic('sortid', SortId)
    Alpine.magic('clipboard', Clipboard)
    Alpine.directive('icon', Icon)
    Alpine.directive('badge', Badge)
    Alpine.directive('prompt', Prompt)
    Alpine.directive('wire-on', WireOn)
    Alpine.directive('recaptcha', Recaptcha)
    Alpine.directive('autoresize', Autoresize)
}
