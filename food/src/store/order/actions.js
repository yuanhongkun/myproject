import proxy from '../../proxy/index'

export default {
  orderlist(commit,params)
  {
    return proxy.orderlist(params)
  },
  orderinfo(commit, params) 
  {
    return proxy.orderinfo(params)
  },
  confirmOrder(commit, params) 
  {
    return proxy.confirmOrder(params)
  },
  commentAdd(commit,params)
  {
    return proxy.commentAdd(params)
  },
  addorder(commit,params)
  {
    return proxy.addorder(params)
  },
}