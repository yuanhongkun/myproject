<template>
<div class="constrian">
    <div class="header">
        <router-link to="/" class="left"></router-link>优惠券
    </div>
    <div class="bigbox">
        <van-tabs v-model="active" @change="onChange" id="tag">
            <van-tab title="未使用"></van-tab>
            <van-tab title="已使用"></van-tab>
            <van-tab title="已过期"></van-tab>
        </van-tabs>
    </div>
    <scroller class="scroller" :on-refresh="refresh" :on-infinite="load" ref="myscroller">
        <div v-for="(item,key) in couponlist" :key="key" class="coupon-bigbox">
            <div class="coupon-box2">
                <span class="coupon-semicircle1"></span>
                <span class="coupon-semicircle2"></span>
                <span class="coupon-line"></span>
                <!--现金券内容开始-->
                <div class="coupon-box3">
                    <span class="coupon-text1" v-if="item.state==0">未使用</span>
                    <span class="coupon-text1" v-else-if="item.state==1">已使用</span>
                    <span class="coupon-text1" v-else-if="item.state==2">已过期</span>
                    <span class="coupon-text2">￥{{item.valueDesc}}</span>
                    <span class="coupon-text3">{{item.condition}}</span>
                </div>
                <div class="coupon-box4">
                    <span class="coupon-text4">{{item.name}}</span>
                    <span class="coupon-text4">{{item.description}}</span>
                    <span class="coupon-text5">{{item.endAt | dateformat}} 到期 <i class="particulars" @click="detail()">详情</i></span>
                </div>    
            </div>
            <div class="coupon-box5" v-if="show==true">
                <span class="coupon-line2"></span>	
                <span class="coupon-text6">现金券号：565855316</span>
                <span class="coupon-text6">使用时间：{{item.startAt | dateformat}}至{{item.endAt | dateformat}}</span>
            </div>
        </div>
    </scroller>
</div>
    
 
</template>

<script>
    
    export default {
        name:"coupon",
        data(){
            return{
                show:false,
                active:0,
                couponlist:[],
                page:1,
                noData:false,
                user:null,
            }
        },
        created(){
            this.user = this.$cookies.get('user')
            
        },
         methods: {
            onChange(key) {
                this.couponlist = [];
                this.page = 1;
                //重新加载
                this.$refs.myscroller.finishInfinite(false);
            },
            refresh(done)
            {
                if(!this.noData)
                {
                this.couponlist = [];
                this.page = 1;
                }
                done();

            },
            load(done)
            {        
                this.$store.dispatch('couponinfo',{state:this.active,userid:this.user.id,page:this.page}).then(success => {
                if(success.result)
                {
                    this.couponlist = this.couponlist.concat(success.data)
                    this.$refs.myscroller.resize();
                    done();
                    this.page+=1;
                }else{
                    this.noData = true;
                    done(true);
                }
                })
            },
            detail()
            {
               this.show=!this.show
            }
        }
      
    }
</script>
<style scoped>
    @import url("../../static/css/discount-coupon.css");
</style>
<style>
    .scroller{
        margin-top: 80px;
    }
    
    #tag{
        z-index: 9999;
    }
</style>