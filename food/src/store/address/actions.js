import proxy from '../../proxy/index'

export default {
  province(commit,params = {})
  {
    return proxy.province(params)
  },
  city(commit,params = {})
  {
    return proxy.city(params)
  },
  district(commit,params = {})
  {
    return proxy.district(params)
  },
  addresslist(commit,params)
  {
    return proxy.addresslist(params)
  },
  addressdefault(commit,params)
  {
    return proxy.addressdefault(params)
  },
  addressadd(commit,params = {})
  {
    return proxy.addressadd(params)
  },
  addressdel(commit,params = {})
  {
    return proxy.addressdel(params)
  },
  addressinfo(commit,params = {})
  {
    return proxy.addressinfo(params)
  },
  addressedit(commit,params = {})
  {
    return proxy.addressedit(params)
  }
}