import proxy from '../../proxy/index'

export default {
    cartupdate(commit, params = {}) {
        return proxy.cartupdate(params)
    },
    cartlist(commit, params = {}) {
        return proxy.cartlist(params)
    },
    cartadd(commit, params = {}) {
        return proxy.cartadd(params)
    },
    cart(commit, params = {}) {
        return proxy.cart(params)
    },

}