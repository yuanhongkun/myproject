import { request } from '../services/request'

export default {
    goodslist(params) {
        return request({
            method: "post",
            url: `/api/goodslist.php?action=goodslist`,
            params: params
        })
    },
    foodinfo(params) {
        return request({
            method: "post",
            url: `/api/goodslist.php?action=foodinfo`,
            params: params
        })
    },
    foodcover(params) {
        return request({
            method: "file",
            url: `/api/goodslist.php?action=foodcover`,
            params: params
        })
    },
    editfood(params) {
        return request({
            method: "post",
            url: `/api/goodslist.php?action=editfood`,
            params: params
        })
    },
    deletefood(params) {
        return request({
            method: "post",
            url: `/api/goodslist.php?action=deletefood`,
            params: params
        })
    },
    addfood(params) {
        return request({
            method: "post",
            url: `/api/goodslist.php?action=addfood`,
            params: params
        })
    },
}