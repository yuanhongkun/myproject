import proxy from '../../proxy/index'

export default {
    couponinfo(commit, params) {
        return proxy.couponinfo(params)
    },
    getcouponinfo(commit, params) {
        return proxy.getcouponinfo(params)
    },
    addcouponinfo(commit, params) {
        return proxy.addcouponinfo(params)
    },
    usecoupon(commit,params){
        return proxy.usecoupon(params)
    },
    unusecoupon(commit,params){
        return proxy.unusecoupon(params)
    },
    updatecoupon(commit,params){
        return proxy.updatecoupon(params)
    }
}