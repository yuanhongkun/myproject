import Vue from 'vue'
import Vuex from 'vuex'

//挂载
Vue.use(Vuex)

import admin from './admin'
import goodscate from './goodscate'
import pay from './pay'
import goodslist from './goodslist'

import order from './order'
import activity from './activity'
//创建一个数据管理对象
export default new Vuex.Store({
    modules: {
        admin,
        goodscate,
        pay,
        goodslist,

        order,
        activity
    }
})