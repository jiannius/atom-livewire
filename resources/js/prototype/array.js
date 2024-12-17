Array.prototype.pluck = function (attr) {
    if (!Array.isArray(this)) return

    return this.map(val => (val[attr]))
}

Array.prototype.unique = function (attr = null) {
    if (!Array.isArray(this)) return

    if (typeof attr === 'function') {
        let values = this.map(row => (attr(row)))

        return [...new Set(values)].map(val => (
            this.find(row => (attr(row) == val))
        ))
    }
    else if (attr) {
        const values = this
            .map(row => (row[attr]))
            .map(val => (this.find(row => (row[attr] == val))))

        return [...new Set(values)]
    }

    return [...new Set([...this])]
}

Array.prototype.sum = function (attr = null) {
    if (!Array.isArray(this)) return

    return this.reduce((acc, value) => {
        if (typeof attr === 'function') value = attr(value)
        else if (attr) value = value[attr]

        return value + acc
    }, 0)
}

Array.prototype.toggle = function (value) {
    if (!Array.isArray(this)) return

    const index = this.indexOf(value)
    
    if (index === -1) this.push(value)
    else this.splice(index, 1)
    
    return this
}

Array.prototype.take = function (n) {
    if (!Array.isArray(this)) return

    let array = [...this]

    return array.slice(0, n)
}

Array.prototype.prepend = function (value) {
    if (!Array.isArray(this)) return

    this.unshift(value)
}

Array.prototype.last = function (n = 1) {
    if (!Array.isArray(this)) return
    if (!this.length) return

    let index = this.length - n

    return this[index]
}

Array.prototype.lastIndex = function (n = 1) {
    if (!Array.isArray(this)) return
    if (!this.length) return -1

    let index = this.length - n

    return index
}

Array.prototype.where = function (key, value) {
    if (!Array.isArray(this)) return

    return this.filter(item => (item[key] === value))
}

Array.prototype.firstWhere = function (key, value) {
    if (!Array.isArray(this)) return

    let index = this.findIndex(item => (item[key] === value))

    return this[index]
}

Array.prototype.findIndexWhere = function (key, value) {
    if (!Array.isArray(this)) return

    return this.findIndex(item => (item[key] === value))
}

Array.prototype.max = function (key = null) {
    if (!Array.isArray(this)) return
    if (key) return Math.max(...this.pluck(key))

    return Math.max(...this)
}

Array.prototype.min = function (key = null) {
    if (!Array.isArray(this)) return
    if (key) return Math.min(...this.pluck(key))

    return Math.min(...this)
}