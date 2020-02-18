import {request} from '../services/request'

export default {
  province(params)
  {
    return request({
      method:"get",
      url:`/api/address.php?action=province`,
      params: params
    })
  },
  city(params) {
    return request({
      method: "post",
      url: `/api/address.php?action=city`,
      params: params
    })
  },
  district(params)
  {
    return request({
      method:"post",
      url:`/api/address.php?action=district`,
      params:params
    })
  },
  addresslist(params)
  {
    return request({
      method:"post",
      url:`/api/address.php?action=addresslist`,
      params: params
    })
  },
  addressdefault(params)
  {
    return request({
      method:"post",
      url:`/api/address.php?action=addressdefault`,
      params:params
    })
  },
  addressadd(params) {
    return request({
      method: "post",
      url: `/api/address.php?action=addressadd`,
      params: params
    })
  },
  addressdel(params)
  {
    return request({
      method:"post",
      url:`/api/address.php?action=addressdel`,
      params:params
    })
  },
  addressinfo(params) {
    return request({
      method: "post",
      url: `/api/address.php?action=addressinfo`,
      params: params
    })
  },
  addressedit(params) {
    return request({
      method: "post",
      url: `/api/address.php?action=addressedit`,
      params: params
    })
  }
}