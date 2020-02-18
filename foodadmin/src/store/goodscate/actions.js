import proxy from '../../proxy/index'

export default {
    goodscatelist(commit, params) {
        return proxy.goodscatelist(params)
    },
    goodscateinfo(commit, params) {
        return proxy.goodscateinfo(params)
    },
    cover(commit, params) {
        return proxy.cover(params)
    },
    editgoodscate(commit, params) {
        return proxy.editgoodscate(params)
    },
    addgoodscate(commit, params) {
        return proxy.addgoodscate(params)
    },
    deletegoodscate(commit, params) {
        return proxy.deletegoodscate(params)
    },
   
}