<template>
  <div class="zjzz-buylist-wear">
			
			<div class="zjzz-buylist-top">
				<router-link to="/my" class="zjzz-buylist-t1"></router-link>
				<span class="zjzz-buylist-t2">我的订单</span>
				<span class="zjzz-buylist-t3">
					<span class="zjzz-buylist-t4"></span>
				</span>
			</div>
      
      <!-- 导航 -->
			<div class="zjzz-buylist-top2">		
        <van-tabs v-model="active" @change="changeOrder">
          <van-tab title="全部"></van-tab>
          <van-tab title="待发货"></van-tab>
          <van-tab title="待收货"></van-tab>
          <van-tab title="待评价"></van-tab>
          <van-tab title="已完成"></van-tab>
          <van-tab title="已取消"></van-tab>
        </van-tabs>
			</div>		

      <!-- 列表 -->
			<div class="zjzz-buylist-mid">
				<!--全部-->
				<div class="zjzz-buylist-m1" id="orderlist">
          <scroller class="scroller" :on-refresh="refresh" :on-infinite="load" ref="myscroller">
            <div v-for="(item,key) in orderlist" :key="key" class="zjzz-buylist-goods1">
              <!-- 状态 -->
              <router-link :to="{name:'orderinfo',query:{'orderid':item.id}}">
                <div class="zjzz-buylist-gtime">
                  <span class="zjzz-buylist-gtime1">{{item.createtime | dateformat}}</span>
                  <span class="zjzz-buylist-gtime2" v-if="item.status == 1">已支付、待发货</span>
                  <span class="zjzz-buylist-gtime2" v-else-if="item.status == 2">已发货、待收货</span>
                  <span class="zjzz-buylist-gtime2" v-else-if="item.status == 3">已收货、待评价</span>
                  <span class="zjzz-buylist-gtime2" v-else-if="item.status == 4">已完成</span>
                  <span class="zjzz-buylist-gtime2" v-else-if="item.status == 5">已取消</span>
                </div>
              </router-link>
              
              <!-- 商品列表 -->
              <div v-if="item.orderpro" v-for="(food,index) in item.orderpro" :key="index" class="zjzz-buylist-det">
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

              <span class="zjzz-buylist-goodsm">
                <i class="zjzz-buylist-gm3">共{{item.ordernum}}件</i>
                <i>应付总额：<i class="zjzz-buylist-gm4">￥{{item.total}}</i></i>
              </span>

              <div class="zjzz-buylist-btn">
                <a v-if="item.status == 1" class="zjzz-buylist-btn3">退款</a>
                <a v-if="item.status == 1" class="zjzz-buylist-btn1">催单</a>
                <a @click="confirmOrder(item.id)" href="javascript:void(0)" v-if="item.status == 2" class="zjzz-buylist-btn3">确认收货</a>
                <a v-if="item.status == 2" href="order-tracking.html" class="zjzz-buylist-btn1">查看物流</a>
                <router-link :to="{name:'ordercomment',query:{'orderid':item.id}}" v-if="item.status == 3" class="zjzz-buylist-btn3">评价</router-link>
                <router-link :to="{name:'cart',query:{'orderid':item.id}}" v-if="item.status == 4" class="zjzz-buylist-btn3">再来一单</router-link>
                <a v-if="item.status == 4" class="zjzz-buylist-btn1">删除订单</a>
                
              </div>
            </div>
          </scroller>

				</div>
			</div>
		</div>
</template>


<script>
  export default {
    name:"orderlist",
    created()
    {
      this.user = this.$cookies.get('user')
      
    },
    data(){
      return {
        active:0,
        orderlist:[],
        CDN:this.CDN,
        page:1,
        noData:false,
        user:null,
      }
    },
    methods:{
      confirmOrder(orderid)
      {
        this.$confirm("是否确认收货").then(res => {
          this.$store.dispatch('confirmOrder',{orderid:orderid}).then(success => {
            if(success.result)
            {
              this.$router.go(0)
            }else{
              this.$alert(success.msg)
            }
          })
        }).catch(err => {})
      },
      changeOrder(index)
      {
        this.orderlist = [];
        this.page = 1;
        //重新加载
        this.$refs.myscroller.finishInfinite(false);  //done(false)
      },
      refresh(done)
      {
        if(!this.noData)
        {
          this.orderlist = [];
          this.page = 1;
        }
        done();

      },
      load(done)
      {        
        this.$store.dispatch('orderlist',{status:this.active,userid:this.user.id,page:this.page}).then(success => {
          if(success.result)
          {
            this.orderlist = this.orderlist.concat(success.data)
            this.$refs.myscroller.resize();
            done();
            this.page+=1;
          }else{
            this.noData = true;
            done(true);
          }
        })
      }
    }
  }
</script>


<style scoped>
  @import url('../../static/css/my-indent.css');
</style>