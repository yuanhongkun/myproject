import {request} from '../services/request'
export default{
    orderlist(params)
  {
    return request({
      method:"post",
      url:`/api/order.php?action=orderlist`,
      params: params
    })
  },
  orderinfo(params) {
    return request({
      method: "post",
      url: `/api/order.php?action=orderinfo`,
      params: params
    })
  },
  confirmOrder(params) {
    return request({
      method: "post",
      url: `/api/order.php?action=confirmOrder`,
      params: params
    })
  },
  commentAdd(params) {
    return request({
      method: "file",
      url: "/api/order.php?action=commentAdd",
      params: params
    })
  },
  addorder(params) {
    return request({
      method: "post",
      url: "/api/order.php?action=addorder",
      params: params
    })
  }
}