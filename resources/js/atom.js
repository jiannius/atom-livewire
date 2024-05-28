import './prototype/array.js'
import './prototype/number.js'
import './prototype/string.js'
import './prototype/element.js'
import './helper/function.js'
import Ajax from './helper/ajax.js'
import Color from './helper/color.js'
import Modal from './alpine/magic/modal.js'
import SortId from './alpine/magic/sortid.js'
import Clipboard from './alpine/magic/clipboard.js'
import Badge from './alpine/directive/badge.js'
import Textarea from './alpine/directive/textarea.js'

window.dd = console.log.bind(console)
window.ulid = () => (ULID.ulid())
window.ajax = (url) => (new Ajax(url))
window.color = (name) => new Color(name)
window.href = (url) => window.location = url

window.dayjs?.extend(dayjs_plugin_utc)
window.dayjs?.extend(dayjs_plugin_relativeTime)

document.addEventListener('alpine:init', () => {
    Alpine.magic('modal', Modal)
    Alpine.magic('sortid', SortId)
    Alpine.magic('clipboard', Clipboard)
    Alpine.directive('badge', Badge)
    Alpine.directive('textarea', Textarea)
})
