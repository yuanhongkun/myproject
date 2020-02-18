import home from '@/components/home'
import search from '@/components/search'
import coupon from '@/components/coupon'
import getcoupon from '@/components/getcoupon'
import catedetail from '@/components/catedetail'
export default [
  {
    path: '/',
    name: 'home',
    component: home
  },
  {
    path: '/home/search',
    name: 'search',
    component: search
  },
  {
    path:"/home/coupon",
    name: "coupon",
    component:coupon,
    meta:{
        requireAuth: true, // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path:"/home/getcoupon",
    name: "getcoupon",
    component:getcoupon,
    meta:{
        requireAuth: true, // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path:"/home/catedetail",
    name: "catedetail",
    component:catedetail,
    meta:{
      requireAuth:true,
    }
  }
]
