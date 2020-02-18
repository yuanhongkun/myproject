import proxy from '../../proxy/index'

export default {
    homefood(commit, params = {}) {
        return proxy.homefood(params)
    },
    catelist(commit, params = {}) {
        return proxy.catelist(params)
    },
    foodlist(commit, params = {}) {
        return proxy.foodlist(params)
    },
    fooddetail(commit, params) {
        return proxy.fooddetail(params)
    },
    searchfood(commit, params) {
        return proxy.searchfood(params)
    },
    foodcateinfo(commit,params){
        return proxy.foodcateinfo(params)
    },
    topcatefood(commit,params){
        return proxy.topcatefood(params)
    }

}