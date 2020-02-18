import { request } from '../services/request'

export default {
   
    couponinfo(params) {
        return request({
            method: "post",
            url: "/api/coupon.php?action=couponinfo",
            params: params
        })
    },
    getcouponinfo(params) {
        return request({
            method: "post",
            url: "/api/coupon.php?action=getcouponinfo",
            params: params
        })
    },
    addcouponinfo(params) {
        return request({
            method: "post",
            url: "/api/coupon.php?action=addcouponinfo",
            params: params
        })
    },
    usecoupon(params){
        return request({
            method:"post",
            url:"/api/coupon.php?action=usecoupon",
            params:params
        })
    },
    unusecoupon(params){
        return request({
            method:"post",
            url:"/api/coupon.php?action=unusecoupon",
            params:params
        })
    },
    updatecoupon(params){
        return request({
            method:"post",
            url:"/api/coupon.php?action=updatecoupon",
            params:params
        })
    }

}