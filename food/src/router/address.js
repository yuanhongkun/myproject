import addresslist from '@/components/addresslist'
import addressadd from '@/components/addressadd'
import addressedit from '@/components/addressedit'
export default [
  {
    path: '/address/list',
    name: 'addresslist',
    component: addresslist,
    meta:{
      requireAuth: true, // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path:"/address/add",
    name:"addressadd",
    component: addressadd,
    meta:{
      requireAuth: true, // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path:"/address/edit/:addrid",
    name:"addressedit",
    component: addressedit,
    meta: {
      requireAuth: true, // 添加该字段，表示进入这个路由是需要登录的
    }
  }
]
