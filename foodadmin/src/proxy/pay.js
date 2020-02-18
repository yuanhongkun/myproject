import {request} from '../services/request'

export default {
  paylist(params)
  {
    return request({
      method:"post",
      url:`/api/pay.php?action=paylist`,
      params: params
    })
  },
  paydel(params)
  {
    return request({
      method:"post",
      url:`/api/pay.php?action=paydel`,
      params:params
    })
  },
  payadd(params) {
    return request({
      method: "post",
      url: `/api/pay.php?action=payadd`,
      params: params
    })
  }
}