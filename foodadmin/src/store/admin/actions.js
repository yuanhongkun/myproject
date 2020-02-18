import proxy from '../../proxy/index'

export default {

    login(commit, params) {
        return proxy.login(params)
    },
    adminlist(commit, params) {
        return proxy.adminlist(params)
    },
    addadmin(commit, params) {
        return proxy.addadmin(params)
    },
    admininfo(commit, params) {
        return proxy.admininfo(params)
    },
    editadmin(commit, params) {
        return proxy.editadmin(params)
    },
    deleteadmin(commit, params) {
        return proxy.deleteadmin(params)
    },

}