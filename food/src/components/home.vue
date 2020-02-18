<template>
  <div class="near-box">
      <!--头部开始-->
      <div class="yx-index-top">
        <div @click="lookaddress()" class="index-top-boxone">
          <span class="index-top-img1"><img src="/static/images/scan.png" alt=""></span>
          <span  class="index-top-text1">地址</span>
        </div>
         <van-dropdown-menu class="index-top-box2">
          <!--<van-dropdown-item class="fresh-toptext1" v-model="value1" :options="option1" @open="openselect" />
           <van-dropdown-item v-model="value2" :options="option2" /> -->
        </van-dropdown-menu>
        <router-link to="/home/search" class="index-top-boxone">
          <span class="index-top-img1"><img src="/static/images/search3.png" alt=""></span>
          <span class="index-top-text1">搜索</span>
        </router-link>
      </div>

      <!--中间内容-->
      <div class="index-bigbox">
        
        <!--轮播开始-->
        <div id="slideBox" class="slideBox">
          <van-swipe :autoplay="3000">
            <van-swipe-item v-for="(image, index) in images" :key="index">
              <img v-lazy="CDN + image" @click="getcoupon()" width="400" height="170"/>
            </van-swipe-item>
          </van-swipe>
        </div>
        <!--轮播开始-->

        <!--分类导航开始-->
        <div class="classify-menu">
            <a v-for="item in topcate" href="javascript:void(0)" class="classify-menu-box1">
              <span class="classify-menu-img1" @click="detail(item.id)"><img src="/static/images/trophy.png" alt=""></span>
              <span class="classify-menu-text1">{{item.name}}</span>
            </a>
        </div>
        <!--分类导航结束-->
        
        <!--分类循环开始-->
        <div v-for="item in catelist">
          <div class="brand-box1">
            <span class="brand-text1">{{item.name}}</span>
            <span class="brand-img1"></span>
          </div>
          <div class="special-sale-banner">
            <img :src="CDN + item.cover">
          </div>
          <div class="special-sale-box3">
            <div v-for="food in item.foodlist" class="special-sale-box4">
              <span @click="lookfood(food.id)"  class="special-sale-img1"><img :src="CDN + food.cover"></span>
              <span class="special-sale-tbox">{{food.name}}</span>
              <span class="special-sale-text2">￥{{food.price}}</span>
            </div>
          </div>
        </div>
        <!--分类循环结束-->

      </div>

      <!--底部-->
      <food-menu></food-menu>
      
  </div>
</template>

<script>
  import foodMenu from './foodMenu'
  export default {
    name: 'home',
    components:{
      foodMenu
    },
    created()
    {
     
      this.action = this.$route.query.action ? this.$route.query.action : "";
      this.keywords = this.$route.query.keywords ? this.$route.query.keywords : "";
      if(this.action=="search")
      {
        this.$store.dispatch("searchfood",{keywords:this.keywords}).then(success=>{
                if(success.result)
                {
                    this.topcate = success.data.topcate
                    this.catelist = success.data.catelist
                    
                }else{
                    this.$alert(success.msg)
                }
            })
      }else{
        this.$store.dispatch('homefood').then(success => {
        this.topcate = success.data.topcate
        this.catelist = success.data.catelist
        })
      }
    },
    data()
    {
      return {
        option1:[{ text: '请选择地区', value: 0 }],
        value1:0,
        keywords:'',
        action:'',
        topcate:[],
        catelist:[],
        CDN:this.CDN,
        images: [
          'assets/uploads/banner-img2.jpg',
          'assets/uploads/discounts-img1.jpg',
          'assets/uploads/banner-img3.jpg',
          'assets/uploads/discounts-img1.jpg',
          'assets/uploads/banner-img3.jpg',
        ],
        user:{}

      }
    },
    destroyed()
    {
      window.removeEventListener('scroll',this.btn_pos)
    },
    methods:{
      lookfood(foodid)
      {
        //console.log(e)
        this.$router.push({name:"foodDetail",query:{id:foodid}});
      },
      lookaddress()
      {
        this.$router.push("/address/list")
      },
      openselect()
      {
        this.user = this.$cookies.get('user')
        if(!this.user)
        {
          this.$router.push("/login")
        }else{
          this.$store.dispatch("selectaddress",{userid:this.user.id}).then(success=>{
            if(success.result)
            {
            
            }
          })
         
        }
        
      },
      getcoupon()
      {
        this.$router.push("/home/getcoupon")
      },
      detail(topcateid)
      {
        
        this.$router.push({path:"/home/catedetail",query:{topcateid:topcateid}})
      }
    }
  }
</script>


<style scoped>
  @import url('../../static/css/index.css');
</style>