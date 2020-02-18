import Vue from 'vue'
import Router from 'vue-router'
import adminRouter from './admin'
import orderRouter from './order'
import goodslistRouter from './goodslist'
import goodscateRouter from './goodscate'
import activityRouter from './activity'
import payRouter from './pay'


Vue.use(Router)

export default new Router({
    mode: 'history', //去掉url中的#
    routes: [
        ...adminRouter,
        ...payRouter,
        ...orderRouter,
        ...goodslistRouter,
        ...goodscateRouter,
        ...activityRouter,
    ]
})