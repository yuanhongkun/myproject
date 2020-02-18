<template>
  <div class="near-box">
    <div class="yx-index-top">
        <div class="index-top-box2">
          <span class="fresh-toptext1">派送至：北京石景山</span>
          <span class="fresh-topimg1"></span>
        </div>
        <div class="index-top-box1">
        <span class="index-top-img1"><img src="/static/images/search3.png" alt=""></span>
        </div>
    </div>
    <div class="classify-bigbox">
        <div class="classify-left">
          <div class="classify-perch"></div>
          <van-sidebar v-model="activeKey" @change="onChange">
            <van-sidebar-item v-for="(item,key) in catelist" :title="item.name" :key="key" />
          </van-sidebar>
          <div class="classify-perch2"></div>
        </div>
        <div class="classify-right content2" id="content">
          <div class="classify-perch-r"></div>
          <div class="classify-right-title">
            <span class="classifyrt-text1">综合排序</span>
            <span class="classifyrt-text1 price">
              按价格<i class="sort-img"></i>
              <i class="sort-img2" style="display: none;"></i>
            </span>
            <span class="classifyrt-text1 list-show">分类</span>
          </div>
          <!--商品列表循环-->
          <div class="foodlist">
            <scroller 
            class="scroller"
            :on-refresh="refresh"
            :on-infinite="load"
            ref="myscroller"
            >
              <div class="classify-box1" v-for="(item,index) in foodlist">
                <a href="goods-details.html" class="classify-box1-img1">
                  <img v-if="item.cover" :src="CDN + item.cover">
                  <img v-else src="/static/del/fruits-img7.png">
                </a>
                <div class="classify-box2">
                  <a href="goods-details.html" class="classify-box2-text1">{{item.name}}</a>
                  <span class="classify-box2-text2">￥{{item.price}}</span>
                  <div class="shop-cart-box3">
                      <span class="shop-cart-subtract" @click="subtract(item.id,index)"></span>
                      <input type="number" size="4" v-model="item.cartnum" class="shop-cart-numer">
                      <span class="shop-cart-add" @click="add(item.id,index)"></span>
                  </div>
                </div>
              </div>
            </scroller>
          </div>
        </div>
    </div>

    <!--底部-->
    <food-menu></food-menu>
  </div>
</template>

<script>
  import foodMenu from './foodMenu'
  export default {
    name: 'cate',
    components:{
      foodMenu
    },
    created()
    {
      this.user = this.$cookies.get('user')
      this.$store.dispatch('catelist').then(success => {
        this.catelist = success.data
        this.catelist.unshift({id:0,name:'全部'})
      })
    },
    data()
    {
      return {
        activeKey:0,
        cateid:0,
        catelist:[],
        foodlist:[],
        CDN:this.CDN,
        page:1,
        noData:false,
        user:null
      }
    },
    methods:{
      //下拉刷新
      refresh(done)
      {
        if(!this.noData)
        {
          this.foodlist = [];
        this.page = 1;
        }     
        done();
      },
      //上拉加载
      load(done)
      {
        this.$store.dispatch('foodlist',{cateid:this.cateid,page:this.page}).then(success => {
          if(success.result)
          {
            for(var key in success.data)
            {
              success.data[key].cartnum = 0
            }
            this.foodlist = this.foodlist.concat(success.data)
            this.$refs.myscroller.resize();
            done();
            this.page+=1;
          }else{
            this.noData = true;
            done(true);
          }
        })
        
      },
      onChange(index)
      {
        this.cateid = this.catelist[index].id
        this.foodlist = [];
        this.page = 1;
        this.$store.dispatch('foodlist',{cateid:this.cateid,page:this.page}).then(success => {
          if(success.result)
          {
            for(var key in success.data)
            {
              success.data[key].cartnum = 0
            }
            this.foodlist = success.data
            
            this.page+=1;
          }
        })
      },
      //购物车减少
      subtract(foodid,index)
      {
        console.log(foodid,index)
        if(this.foodlist[index].cartnum>0)
        {
          this.foodlist[index].cartnum--;
          var data = {
            'userid':this.user.id,
            'foodid':foodid,
            'foodnum':this.foodlist[index].cartnum
          }

          this.$store.dispatch('cartupdate',data).then(success => {
            console.log(success)
          })
        }else{
          this.$alert('数量不能小于0')
        }
      },
      add(foodid,index)
      {
        this.foodlist[index].cartnum++;
         var data = {
          'userid':this.user.id,
          'foodid':foodid,
          'foodnum':this.foodlist[index].cartnum
        }
        this.$store.dispatch('cartupdate',data).then(success => {
          console.log(success)
        })
      }
    },
  }
</script>


<style>
  @import url('../../static/css/classify.css');
 

</style>
<style >
  .classify-right-title{
    z-index:100;
  }

  .foodlist{
    position: relative;
    width:100%;
    height:100%;
    margin-top:100px;
  }

  .loading-layer{
    padding-bottom:100px;
  }
</style>