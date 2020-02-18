<template>
  <div class="near-box">
    <div class="index-bigbox" style="margin-top: 0px;">
        <!--头部开始-->
        <div class="personal-top">
          <img src="/static/images/599aa36d5e4a4.jpg" alt="" class="personal-img">
          <div class="personal-top-box1">
            <span v-if="user.avatar" class="personal-top-img1">
              <img :src="CDN + user.avatar" >
            </span>
            <span v-else class="personal-top-img1">
              <img src="/static/del/timg1.jpg" >
            </span>
            <div class="personal-top-box2">
              <span class="personal-top-text1">{{user.username}}</span>
            </div>
          </div>
        </div>
        <!--头部结束--> 
        <!--代付款分类开始-->
        <div class="personal-box1 mbt-05">
            <router-link to="/order/list" class="personal-box2 box3">
                <span class="personal-box1-img1"><img src="/static/images/personal-center-img1.png" alt=""></span>
                <span class="personal-box1-text1">全部订单</span>
            </router-link>
            <router-link to="/order/list" class="personal-box2 box3">
                <span class="personal-box1-img1"><img src="/static/images/personal-center-img2.png" alt=""></span>
                <span class="personal-box1-text1">待发货</span>
            </router-link>
            <router-link to="/order/list" class="personal-box2 box3">
                <span class="personal-box1-img1"><img src="/static/images/personal-center-img3.png" alt=""></span>
                <span class="personal-box1-text1">待收货</span>
            </router-link>
            <router-link to="/order/list" class="personal-box2 box3">
                <span class="personal-box1-img1"><img src="/static/images/personal-center-img4.png" alt=""></span>
                <span class="personal-box1-text1">待评价</span>
            </router-link>
            <router-link to="/order/list" class="personal-box2 box3">
                <span class="personal-box1-img1"><img src="/static/images/personal-center-img5.png" alt=""></span>
                <span class="personal-box1-text1">已取消</span>
            </router-link>
        </div>
        <!--代付款分类结束-->
        <!--功能分类开始-->
        <router-link to="/userinfo" class="personal-box5">
            <span class="personal-box5-img1"><img src="/static/images/personal-center-img12.png" alt=""></span>
            <span>个人信息</span>
        </router-link>
        <router-link to="/address/list" class="personal-box5">
            <span class="personal-box5-img1"><img src="/static/images/personal-center-img11.png" alt=""></span>
            <span>收货地址</span>
        </router-link>
        <router-link to="/pay/list" class="personal-box5">
            <span class="personal-box5-img1"><img src="/static/images/personal-center-img10.png" alt=""></span>
            <span>充值</span>
        </router-link>
        <router-link to="/home/coupon" class="personal-box5">
            <span class="personal-box5-img1"><img src="/static/images/personal-center-img10.png" alt=""></span>
            <span>我的优惠券</span>
        </router-link>
        
        
        <span @click="logout()" class="personal-box5-text2">退出登录</span>
    </div>

    <food-menu></food-menu>
  </div>
</template>

<script>
  import foodMenu from './foodMenu'
  export default {
    name: 'cart',
    created()
    {
      this.user = this.$cookies.get('user')
    },
    data(){
      return {
        user:null,
        CDN:this.CDN
      }
    },
    methods:{
      logout()
      {
        this.$confirm('是否确认注销').then(success => {
          this.$cookies.remove("user")
          this.$router.push('/login')
        }).catch(err => {})
      }
    },
    components:{
      foodMenu
    }
  }
</script>


<style scoped>
  
  @import url('../../static/css/personal-center.css');
  
</style>
<style  scoped>
  body{background: #F7F7F7;}
</style>