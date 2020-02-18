<template>
<div class="constrian">
    <div class="header">
        <router-link to="/" class="left"></router-link>优惠券
    </div>
    
    <scroller class="scroller" :on-refresh="refresh" :on-infinite="load" ref="myscroller">
        <div v-for="(item,key) in getcouponlist" :key="key" class="coupon-bigbox">
            <div class="coupon-box2">
                <span class="coupon-semicircle1"></span>
                <span class="coupon-semicircle2"></span>
                <span class="coupon-line"></span>
                <!--现金券内容开始-->
                <div class="coupon-box3">
                    <span class="coupon-text1">可领取</span>
                    
                    <span class="coupon-text2">￥{{item.menoy}}</span>
                    <span class="coupon-text3">{{item.detail}}</span>
                </div>
                <div class="coupon-box4">
                    <span class="coupon-text4">{{item.name}}</span>
                    <!-- <span class="coupon-text4">{{item.description}}</span> -->
                    <span class="coupon-text5">有效期：{{item.longtime}}个月 
                    <i class="particulars" @click="getcoupon(item.id)" >领取</i>
                    <!-- <i class="particulars" v-if="show==false">已领取</i> -->
                    </span>
                    
                </div>    
            </div>
            
        </div>
    </scroller>
</div>
    
 
</template>

<script>
    
    export default {
        name:"getcoupon",
        data(){
            return{
                
                getcouponlist:[],
                page:1,
                noData:false,
                user:null,
                couponid:0,
                addcoupon:null,
                
            }
        },
        created(){
            this.user = this.$cookies.get('user')
        
        },
         methods: {
            onChange(key) {
                this.getcouponlist = [];
                this.page = 1;
                //重新加载
                this.$refs.myscroller.finishInfinite(false);
            },
            refresh(done)
            {
                if(!this.noData)
                {
                this.getcouponlist = [];
                this.page = 1;
                }
                done();

            },
            load(done)
            {        
                this.$store.dispatch('getcouponinfo',{userid:this.user.id,page:this.page}).then(success => {
                if(success.result)
                {
                    this.getcouponlist = this.getcouponlist.concat(success.data)
                    this.$refs.myscroller.resize();
                    done();
                    this.page+=1;
                }else{
                    this.noData = true;
                    done(true);
                }
                })
            },
            getcoupon(couponid)
            {
                this.couponid=couponid;
              this.$store.dispatch('addcouponinfo',{userid:this.user.id,getcouponlist:this.getcouponlist,couponid:this.couponid}).then(success => {
                if(success.result)
                {
                    this.$alert(success.msg)
                    
                }else{
                   this.$alert(success.msg)
                }
                })
            }
        }
      
    }
</script>
<style scoped>
    @import url("../../static/css/discount-coupon.css");
</style>
<style scoped>
    .scroller{
        margin-top: 80px;
    }
    
    #tag{
        z-index: 9999;
    }
    .particulars{
    display: flex;
    color:#FF9201;
    line-height: 30px;
    font-size: 16px;
    width: 50px;
    background: #ccc;
    align-content: center;
    justify-content: center;
    
}
</style>