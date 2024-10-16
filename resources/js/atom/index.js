import Ajax from './ajax.js'

export default {
    ajax: (url) => (new Ajax(url)),
    goto: (url) => window.location = url,
    json: (...args) => (JSON.stringify(...args)),
    newtab: (url) => window.open(url, '_blank'),
    random: () => Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15),
    dispatch: (name, detail) => dispatchEvent(new CustomEvent(name, { bubbles: true, detail })),

    // get highest zindex
    highestZIndex: () => {
        let z = []

        for (let dom of document.querySelectorAll('body *:not(script, style)')) {
            let zvalue = window.getComputedStyle(dom, null).getPropertyValue('z-index')
            let display = window.getComputedStyle(dom, null).getPropertyValue('display')

            if (zvalue !== null && zvalue !== 'auto' && zvalue < 999 && display !== 'none') {
                z.push(+zvalue)
            }
        }

        if (!z.length) return 0

        return Math.max(...z)
    },

    // check for emptyness
    empty: (value) => {
        if (value === undefined || value === null) return true

        value = JSON.parse(JSON.stringify(value))

        return (Array.isArray(value) && !value.length)
            || (typeof value === 'object' && !Object.keys(value).length && Object.getPrototypeOf(value) === Object.prototype)
            || (typeof value === 'string' && value.trim() === '')
    },

    // check page is reloaded
    isPageReloaded: () => {
        return (window.performance.navigation && window.performance.navigation.type === 1)
            || window.performance.getEntriesByType('navigation').map((nav) => nav.type).includes('reload')
    },

    // rgb to hex
    rgbToHex: (r, g, b) => {
        return "#" + (1 << 24 | r << 16 | g << 8 | b).toString(16).slice(1);
    },

    // hex to rgb
    hexToRgb: (hex) => {
        // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
        const shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
        hex = hex.replace(shorthandRegex, function(m, r, g, b) {
            return r + r + g + g + b + b;
        });

        const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    },

    // screen size
    screensize: (size = null) => {
        const w = window.innerWidth
        let value

        if (w <= 640) value = 'sm'
        if (w > 640 && w <= 768) value = 'md'
        if (w > 768 && w <= 1024) value = 'lg'
        if (w > 1024 && w <= 1280) value = 'xl'
        if (w > 1280 && w <= 1536) value = '2xl'
        if (w > 1536 && w <= 2000) value = '3xl'

        if (size) return [size].flat().includes(value)
        else return value
    },

    // device type
    deviceType: () => {
        const ua = navigator.userAgent

        if (/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i.test(ua)) {
            return 'tablet'
        }
        else if (/Mobile|Android|iP(hone|od)|IEMobile|BlackBerry|Kindle|Silk-Accelerated|(hpw|web)OS|Opera M(obi|ini)/.test(ua)) {
            return 'mobile'
        }

        return 'desktop'
    },

    // get
    get: (haystack, needle) => {
        let value = { ...haystack }
        let keys = needle.split('.')

        while(keys.length && value) {
            let key = keys.shift()
            value = value.hasOwnProperty(key) ? value[key] : null
        }

        return value
    },

    // translate
    tr: (...args) => {
        if (!window.lang) return args[0]

        let key = args.shift()
        let lang = Atom.get(window.lang, key)

        if (!lang) return key
        if (typeof lang !== 'string') return key

        let arg = args[0]
        let split = lang.split('|')
        let singular = split[0]
        let plural = split[1]

        if (Atom.empty(arg)) {
            return singular
        }

        if (typeof arg === 'number') {
            if (arg > 1 && plural) return plural.replace(':count', arg)
            else return singular.replace(':count', arg)
        }

        if (typeof arg === 'object') {
            Object.keys(arg).forEach(key => {
                singular = singular.replace(key, arg[key])
            })

            return singular
        }
    },

    // short for tr()
    t: (...args) => (Atom.tr(...args)),
}