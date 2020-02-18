import cart from '@/components/cart'
export default [
  {
    path: '/cart',
    name: 'cart',
    component: cart,
    meta:{
      requireAuth: true, // 添加该字段，表示进入这个路由是需要登录的
    }
  }
]
