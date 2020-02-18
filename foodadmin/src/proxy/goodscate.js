import { request } from '../services/request'

export default {
    goodscatelist(params) {
        return request({
            method: "post",
            url: `/api/goodscate.php?action=goodscatelist`,
            params: params
        })
    },
    goodscateinfo(params) {
        return request({
            method: "post",
            url: `/api/goodscate.php?action=goodscateinfo`,
            params: params
        })
    },
    cover(params) {
        return request({
            method: "file",
            url: `/api/goodscate.php?action=cover`,
            params: params
        })
    },
    editgoodscate(params) {
        return request({
            method: "post",
            url: `/api/goodscate.php?action=editgoodscate`,
            params: params
        })
    },
    addgoodscate(params) {
        return request({
            method: "post",
            url: `/api/goodscate.php?action=addgoodscate`,
            params: params
        })
    },
    deletegoodscate(params) {
        return request({
            method: "post",
            url: `/api/goodscate.php?action=deletegoodscate`,
            params: params
        })
    },


}