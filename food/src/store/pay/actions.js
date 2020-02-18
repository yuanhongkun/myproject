import proxy from '../../proxy/index'

export default {
  paylist(commit,params = {})
  {
    return proxy.paylist(params)
  },
  paydel(commit,params = {})
  {
    return proxy.paydel(params)
  },
  payadd(commit,params = {})
  {
    return proxy.payadd(params)
  }
}