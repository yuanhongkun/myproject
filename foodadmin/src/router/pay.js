import pay from '@/components/pay'


export default [{
        path: '/pay',
        name: 'pay',
        component: pay,
        meta: {
            requireAuth: true, //需要登录
        }
    },

]