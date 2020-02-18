import admin from './admin'
import goodscate from './goodscate'
import pay from './pay'
import goodslist from './goodslist'

import order from './order'
import activity from './activity'
export default {
    ...admin,
    ...goodscate,
    ...pay,
    ...goodslist,

    ...order,
    ...activity
}