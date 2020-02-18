import my from '@/components/my'
import register from '@/components/register'
import login from '@/components/login'
import userinfo from '@/components/userinfo'
export default [
  {
    path: '/my',
    name: 'my',
    component: my,
    meta:{
      requireAuth: true, // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/userinfo',
    name: 'userinfo',
    component: userinfo,
    meta: {
      requireAuth: true, // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/register',
    name: 'register',
    component:register
  },
  {
    path:'/login',
    name:'login',
    component:login
  }
]
