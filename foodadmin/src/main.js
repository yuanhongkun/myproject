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

//引入vant
import { Pagination,DropdownMenu, DropdownItem} from 'vant';
import 'vant/lib/index.css';

//挂载vant
Vue.use(Pagination).use(DropdownMenu).use(DropdownItem)

//挂载插件
Vue.use(Alert)
Vue.use(Confirm)
Vue.use(Toast, 1000)
Vue.use(Loading)

//挂载cookie
Vue.use(VueCookies)

//全局设置过滤器
Vue.filter("dateformat", (dataStr, pattern = 'YYYY-MM-DD HH:mm') => {
    return moment(dataStr * 1000).format(pattern)
})

//给路由添加一个拦截器，判断某些路由是否登录
router.beforeEach((to, from, next) => {
    if (to.meta.requireAuth) {
        //如果为true 说明需要登录
        var admin = VueCookies.get('admin')

        if (admin) {
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

Vue.prototype.CDN = "http://www.foodadminapi.com/"
    /* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    store,
    components: { App },
    template: '<App/>'
})