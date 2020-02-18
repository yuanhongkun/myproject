<template>
  <div class="near-box">
      <router-link to="/order/list" class="jd-qrdd-topbox">订单详情</router-link>
      <div class="jd-qrdd-bigbox">
          <!--商品地址管理部分-->
          <div class="indent-details-box">
              <span class="indent-details-img1"></span>
              <span class="indent-details-text1" v-if="orderinfo.orderStatus == 1">已支付、待发货</span>
              <span class="indent-details-text1" v-else-if="orderinfo.orderStatus == 2">已发货、待收货</span>
              <span class="indent-details-text1" v-else-if="orderinfo.orderStatus == 3">已收货、待评价</span>
              <span class="indent-details-text1" v-else-if="orderinfo.orderStatus == 4">已完成</span>
              <span class="indent-details-text1" v-else-if="orderinfo.orderStatus == 5">已取消</span>
              <span class="indent-details-text2">物流信息：客户签收人：邮件收发 已签收 感谢使用圆通快递，期待再次为您服务！</span>
              <span class="indent-details-text3">2017-10-23 12:25:12</span>
          </div>
          <!--地址部分-->
          <div class="jd-qrdd-a1">
            <span class="qrdd-a1-t1">{{orderinfo.consignee}}</span>
            <span class="qrdd-a1-t1">{{orderinfo.mobile}}</span>
            <span v-if="orderinfo.status == 1" class="qrdd-a1-t2">默认</span>
            <div class="qrdd-a1-b1">
              <span class="qrdd-a1-img1"></span>
              <span class="qrdd-a1-t3">{{orderinfo.provinceName}} {{orderinfo.cityName}} {{orderinfo.districtName}} {{orderinfo.info}}</span>
            </div>
            <span class="qrdd-a1-img2"></span>
          </div>
          <!--商品部分-->
          <div class="zjzz-buylist-goods1">

              <!-- 头部 -->
              <div class="zjzz-buylist-gtime">
                  <span class="zjzz-buylist-gtime1"><i class="indent-details-img2"></i>商品列表</span>
                  <span class="zjzz-buylist-gtime2">更多</span>
              </div>

              <!-- 商品列表 -->
              <div v-if="orderinfo.orderpro" v-for="(food,index) in orderinfo.orderpro" :key="index" class="zjzz-buylist-det">
                <img v-if="food.cover" :src="CDN + food.cover"/>
                <img v-else src="/static/del/2017-11-21_162114.png"/>
                <div class="zjzz-buylist-gdetail">
                  <span class="zjzz-buylist-gtit1">{{food.name}}</span>
                  <span class="zjzz-buylist-gmoney">
                    <i class="zjzz-buylist-gm1">￥{{food.foodprice}}</i>
                    <i class="zjzz-buylist-gm2">x{{food.foodnum}}</i>
                  </span>
                </div>
              </div>
          </div>
          <!--商品金额部分-->
          <div class="indent-details-box2">
              <span class="indent-details-text4">订单总额</span>
              <span class="indent-details-text5">￥{{orderinfo.total}}</span>
          </div>
          <div class="indent-details-box2">
              <span class="indent-details-text4 tcolor-grey">数量</span>
              <span class="indent-details-text5 tcolor-black">{{orderinfo.ordernum}}件</span>
          </div>
          <!--订单编号部分-->
          <div class="indent-details-box3">
              <p>订单编号:{{orderinfo.ordersn}}</p>
              <p>下单时间:{{orderinfo.createtime | dateformat}}</p>
          </div>
      </div>
  </div>
</template>

<script>
  export default {
    name:"orderinfo",
    created()
    {
      this.user = this.$cookies.get('user')
      this.orderid = this.$route.query.orderid

      this.$store.dispatch("orderinfo",{orderid:this.orderid}).then(success => {
        if(success.result)
        {
          this.orderinfo = success.data
        }else{
          this.$alert(success.msg).then(res => {
            this.$router.push('/order/list')
          }).catch(err => {})
        }
      })

    },
    data()
    {
      return {
        user:null,
        orderid:0,
        orderinfo:{}
      }
    }
  }
</script>

<style scoped>
  @import url('../../static/css/indent-details.css');
</style>