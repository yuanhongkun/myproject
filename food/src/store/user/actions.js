import proxy from '../../proxy/index'

export default {
    register(commit, params) {
        return proxy.register(params)
    },
    login(commit, params) {
        return proxy.login(params)
    },
    userinfo(commit, params) {
        return proxy.userinfo(params)
    },
    avatar(commit, params) {
        return proxy.avatar(params)
    },
    selectaddress(commit, params) {
        return proxy.selectaddress(params)
    },
  
}