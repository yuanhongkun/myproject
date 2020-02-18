import Vue from 'vue'
import Vuex from 'vuex'

//挂载
Vue.use(Vuex)

import user from './user'
import address from './address'
import pay from './pay'
import food from './food'
import cart from './cart'
import order from './order'
import coupon from './coupon'
//创建一个数据管理对象
export default new Vuex.Store({
  modules:{
    user,
    address,
    pay,
    food,
    cart,
    order,
    coupon
  }
})