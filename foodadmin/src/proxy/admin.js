import { request } from '../services/request'

export default {

    login(params) {
        return request({
            method: "post",
            url: `/api/admin.php?action=login`,
            params: params
        })
    },
    adminlist(params) {
        return request({
            method: "post",
            url: "/api/admin.php?action=adminlist",
            params: params
        })
    },
    addadmin(params) {
        return request({
            method: "post",
            url: "/api/admin.php?action=addadmin",
            params: params
        })
    },
    admininfo(params) {
        return request({
            method: "post",
            url: "/api/admin.php?action=admininfo",
            params: params
        })
    },
    editadmin(params) {
        return request({
            method: "post",
            url: "/api/admin.php?action=editadmin",
            params: params
        })
    },
    deleteadmin(params) {
        return request({
            method: "post",
            url: "/api/admin.php?action=deleteadmin",
            params: params
        })
    },

}