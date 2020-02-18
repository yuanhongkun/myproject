import goodscate from '@/components/goodscate'
import editgoodscate from '@/components/editgoodscate'
import addgoodscate from '@/components/addgoodscate'

export default [
    {
        path: '/goodscate',
        name: 'goodscate',
        component: goodscate,
        meta: {
            requireAuth: true, //需要登录
        }
    },
    {
        path: '/goodscate/edit',
        name: 'editgoodscate',
        component: editgoodscate,
        meta: {
            requireAuth: true, //需要登录
        }
    },
    {
        path: '/goodscate/add',
        name: 'addgoodscate',
        component: addgoodscate,
        meta: {
            requireAuth: true, //需要登录
        }
    },

]