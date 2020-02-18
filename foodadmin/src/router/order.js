import order from '@/components/order'


export default [{
        path: '/order',
        name: 'order',
        component: order,
        meta: {
            requireAuth: true, //需要登录
        }
    },

]