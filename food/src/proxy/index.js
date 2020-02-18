import user from './user'
import address from './address'
import pay from './pay'
import food from './food'
import cart from './cart'
import order from './order'
import coupon from './coupon'
export default {
  ...user,
  ...address,
  ...pay,
  ...food,
  ...cart,
  ...order,
  ...coupon
}