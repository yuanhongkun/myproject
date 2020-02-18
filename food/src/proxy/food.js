import { request } from '../services/request'

export default {
    homefood(params) {
        return request({
            method: "post",
            url: `/api/food.php?action=homefood`,
            params: params
        })
    },
    catelist(params) {
        return request({
            method: "post",
            url: `/api/food.php?action=catelist`,
            params: params
        })
    },
    foodlist(params) {
        return request({
            method: "post",
            url: `/api/food.php?action=foodlist`,
            params: params
        })
    },
    fooddetail(params) {
        return request({
            method: "post",
            url: `/api/food.php?action=fooddetail`,
            params: params
        })
    },
    searchfood(params) {
        return request({
            method: "post",
            url: `/api/food.php?action=searchfood`,
            params: params
        })
    },
    foodcateinfo(params){
        return request({
            method:"post",
            url:`/api/food.php?action=foodcateinfo`,
            params:params
        })
    },
    topcatefood(params){
        return request({
            method:"post",
            url:`/api/food.php?action=topcatefood`,
            params:params
        })
    }
}