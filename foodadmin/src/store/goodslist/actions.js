import proxy from '../../proxy/index'

export default {
  goodslist(commit,params = {})
  {
    return proxy.goodslist(params)
  },
  foodinfo(commit,params = {})
  {
    return proxy.foodinfo(params)
  },
  foodcover(commit,params = {})
  {
    return proxy.foodcover(params)
  },
  editfood(commit,params = {})
  {
    return proxy.editfood(params)
  },
  deletefood(commit,params = {})
  {
    return proxy.deletefood(params)
  },
  addfood(commit,params = {})
  {
    return proxy.addfood(params)
  },
}