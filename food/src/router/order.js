import orderlist from '@/components/orderlist'
import orderinfo from '@/components/orderinfo'
import ordercomment from '@/components/ordercomment'

export default [
    {
        path: '/order/list',
        name: 'orderlist',
        component: orderlist,
        meta:{
            requireAuth: true, //需要登录
        }
    },
    {
        path: '/order/info',
        name: 'orderinfo',
        component: orderinfo,
        meta: {
          requireAuth: true, // 添加该字段，表示进入这个路由是需要登录的
        }
      },
      {
        path: '/order/comment',
        name: 'ordercomment',
        component: ordercomment,
        meta: {
          requireAuth: true, // 添加该字段，表示进入这个路由是需要登录的
        }
      },
]