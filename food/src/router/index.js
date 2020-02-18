import Vue from 'vue'
import Router from 'vue-router'
import homeRouter from './home'
import foodRouter from './food'
import shopRouter from './shop'
import userRouter from './user'
import addressRouter from './address'
import payRouter from './pay'
import orderRouter from './order'


Vue.use(Router)

export default new Router({
  mode: 'history',  //去掉url中的#
  routes: [
    ...homeRouter,
    ...foodRouter,
    ...shopRouter,
    ...userRouter,
    ...addressRouter,
    ...payRouter,
    ...orderRouter
    
  ]
})
