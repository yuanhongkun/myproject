import paylist from '@/components/paylist'
import payadd from '@/components/payadd'
export default [
    {
        path: '/pay/list',
        name: 'paylist',
        component: paylist,
        meta:{
            requireAuth: true, //需要登录
        }
    },
    {
        path: '/pay/add',
        name: 'payadd',
        component: payadd,
        meta:{
            requireAuth: true, //需要登录
        }
    }
]