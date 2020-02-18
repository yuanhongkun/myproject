import admin from '@/components/admin'
import login from '@/components/login'
import adminadd from '@/components/adminadd'
import editadmin from '@/components/editadmin'

export default [{
        path: '/admin',
        name: 'admin',
        component: admin,
        meta: {
            requireAuth: true, //需要登录
        }
    },
    {
        path: '/',
        name: 'login',
        component: login,
    },
    {
        path: '/admin/add',
        name: 'adminadd',
        component: adminadd,
        meta: {
            requireAuth: true, //需要登录授权
        }
    },
    {
        path: '/admin/edit',
        name: 'editadmin',
        component: editadmin,
        meta: {
            requireAuth: true, //需要登录授权
        }
    }
]