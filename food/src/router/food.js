import cate from '@/components/cate'
import foodDetail from '@/components/foodDetail'
export default [
  {
    path: '/cate',
    name: 'cate',
    component: cate,
    meta:{
      requireAuth: true, // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/foodDetail',
    name: 'foodDetail',
    component: foodDetail,
    meta:{
      requireAuth: true, // 添加该字段，表示进入这个路由是需要登录的
    }
  }
]
