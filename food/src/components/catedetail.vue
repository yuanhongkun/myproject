<template>
    <div class="near-box">
      <!--头部开始-->
	  <div class="header">
	  	 <router-link to="/" class="left"></router-link>
	  	 {{foodcate.name}}
	  </div>
	  <!--头部结束-->
      <div class="discounts-bigbox">
		  <div class="discounts-banner1 mt-10"><img :src="CDN + foodcate.cover" alt=""></div>
		  <div class="discounts-banner1 mt-10"><img src="/static/images/coupon.jpg" alt=""></div>
          <div class="special-sale-box3 border-top">


		  	 <div v-for="item in foodlist"  class="special-sale-box4 border-bottom">
		  	 	 <span class="special-sale-img1" @click="lookfood(item.id)"><img :src="CDN + item.cover" alt=""><i class="d-box1-img2"></i></span>
		  	 	 <span class="special-sale-tbox">{{item.name}}</span>
		  	 	 <span class="special-sale-text2">￥{{item.price}} <i>￥50</i></span>
		  	 	 <span @click="buy(item.id)" class="special-sale-text3">购买</span>
		  	 </div>
		  	 
		  	 <span class="special-sale-line1"></span>
		  	 <span class="special-sale-line2"></span>
		  </div>
          <div class="rule-title">活动规则</div>
          <div class="rule-box1">
          	  <p>1.优惠劵仅限新用户领取</p>
          	  <p>2.活动地区：本活动仅限北京地区用户参与</p>
          </div>

      </div>
      
      
    </div>
</template>
<script>
    export default {
        name:"catedetail",
        data()
        {
            return {
                user:null,
                topcateid:0,
                foodcate:[],
                CDN:this.CDN,
                foodlist:[],
            }
        },
        created()
        {
            this.user = this.$cookies.get('user')
            this.topcateid=this.$route.query.topcateid
            this.$store.dispatch("foodcateinfo",{topcateid:this.topcateid}).then(success=>{
                if(success.data)
                {
                    this.foodcate = success.data
                }else{
                    this.$alert(success.msg)
                }
            })

            this.$store.dispatch("topcatefood",{topcateid:this.topcateid}).then(success=>{
                if(success.data)
                {
                    this.foodlist = success.data
                }else{
                    this.$alert(success.msg)
                }
            })

           
        },
        
        methods:{
            buy(foodid)
            {
                
                this.$store.dispatch("addorder",{foodid:foodid,userid:this.user.id}).then(success=>{
                    if(success.data)
                    {
                        this.$router.push("/cart")
                    }else{
                        this.$alert(success.msg)
                    }
                })
            },
            lookfood(foodid)
            {
                //console.log(e)
                this.$router.push({name:"foodDetail",query:{id:foodid}});
            },
        }
    }
</script>
<style scoped>
    @import url("../../static/css/index.css");
    @import url("../../static/css/discounts.css");
</style>
