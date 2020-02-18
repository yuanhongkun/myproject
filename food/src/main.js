// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'

//引入插件
import { Alert, Confirm, Toast, Loading } from 'wc-messagebox'
import 'wc-messagebox/style.css'

//cookie插件
import VueCookies from 'vue-cookies'

//时间转化
import moment from 'moment'

//滚动刷新
import VueScroller from 'vue-scroller'

//引入Vant UI 框架
import { DropdownMenu, DropdownItem, Uploader, Picker, Field, Popup, Area, Swipe, SwipeItem, Lazyload, Sidebar, SidebarItem, PullRefresh, List, Dialog, Cell, CellGroup, Tab, Tabs, Rate, Checkbox, CheckboxGroup } from 'vant';
import { CouponCell, CouponList } from 'vant';
import 'vant/lib/index.css';

//挂载插件
Vue.use(Alert)
Vue.use(Confirm)
Vue.use(Toast, 1000)
Vue.use(Loading)

//挂载cookie
Vue.use(VueCookies)

//挂载滚动刷新
Vue.use(VueScroller)

//全局设置过滤器
Vue.filter("dateformat", (dataStr, pattern = 'YYYY-MM-DD HH:mm') => {
    return moment(dataStr * 1000).format(pattern)
})

//挂载
Vue.use(Picker).use(Uploader).use(Field).use(Popup).use(Area).use(Swipe).use(SwipeItem).use(Lazyload, {}).use(Sidebar).use(SidebarItem).use(PullRefresh).use(List).use(Dialog).use(Cell).use(CellGroup).use(Tab).use(Tabs).use(Rate).use(Checkbox).use(CheckboxGroup)
Vue.use(DropdownMenu).use(DropdownItem)
Vue.use(CouponCell).use(CouponList)
//给路由添加一个拦截器，判断某些路由是否登录
router.beforeEach((to, from, next) => {
    if (to.meta.requireAuth) {
        //如果为true 说明需要登录
        var user = VueCookies.get('user')

        if (user) {
            next()
        } else {
            next('/login')
        }

    } else {
        //不需要登录
        next()
    }
})


Vue.config.productionTip = false

Vue.prototype.CDN = "http://vueyhk.arrilay.com/"

/* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    store,
    components: { App },
    template: '<App/>'
})