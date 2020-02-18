import { request } from '../services/request'

export default {
    register(params) {
        return request({
            method: "post",
            url: `/api/user.php?action=register`,
            params: params
        })
    },
    login(params) {
        return request({
            method: "post",
            url: `/api/user.php?action=login`,
            params: params
        })
    },
    userinfo(params) {
        return request({
            method: "post",
            url: "/api/user.php?action=userinfo",
            params: params
        })
    },
    avatar(params) {
        return request({
            method: "file",
            url: "/api/user.php?action=avatar",
            params: params
        })
    },
    selectaddress(params) {
        return request({
            method: "post",
            url: "/api/user.php?action=selectaddress",
            params: params
        })
    },
   

}