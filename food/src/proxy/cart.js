import { request } from '../services/request'

export default {
    cartupdate(params) {
        return request({
            method: "post",
            url: `/api/cart.php?action=cartupdate`,
            params: params
        })
    },
    cartlist(params) {
        return request({
            method: "post",
            url: `/api/cart.php?action=cartlist`,
            params: params
        })
    },
    cartadd(params) {
        return request({
            method: "post",
            url: `/api/cart.php?action=cartadd`,
            params: params
        })
    },
    cart(params) {
        return request({
            method: "post",
            url: `/api/cart.php?action=cart`,
            params: params
        })
    },
}