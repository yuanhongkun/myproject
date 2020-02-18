import goodslist from '@/components/goodslist'
import editfood from '@/components/editfood'
import addfood from '@/components/addfood'

export default [
    {
        path: '/goodslist',
        name: 'goodslist',
        component: goodslist,
        meta: {
            requireAuth: true, //需要登录
        }
    },
    {
        path: '/goodslist/edit',
        name: 'editfood',
        component: editfood,
        meta: {
            requireAuth: true, //需要登录
        }
    },
    {
        path: '/goodslist/add',
        name: 'addfood',
        component: addfood,
        meta: {
            requireAuth: true, //需要登录
        }
    },

]