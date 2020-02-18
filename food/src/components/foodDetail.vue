<template>
    <div class="near-box">
        <div class="gdetails-header">
            <router-link to="/" class="gdetails-hleft"></router-link>
            <div class="gdetails-htbox">
                商品详情
            </div>
            <span class="gdetails-hshare"></span>
        </div>
        <div class="gdetails-bigbox">
            <!--轮播部分-->
            <div id="slideBox" class="slideBox">
                    <div class="bd">
                        <van-swipe :autoplay="3000">
                            <van-swipe-item v-for="(images, index) in images" :key="index">
                            <img v-lazy="CDN + images" width="100%" height="100%"/>
                            </van-swipe-item>
                        </van-swipe>
                    </div>
                    <div class="hd">
                        <ul></ul>
                    </div>
            </div>
            <!--轮播部分-->
            <!--商品价格部分-->
            <div class="gdetails-price">
                <div class="gdetails-price-box1">
                    
                    <span class="gdetails-price-text2">原价￥999</span>
                    <span class="gdetails-price-text3">特价{{food.price}}</span>
                </div>
                <div class="gdetails-price-box1">
                    <div class="gdetails-price-text5">{{food.description}}</div>
                </div>
            </div>
            <!--商品价格部分-->
          
            <!--图文详情部分-->
            <div class="recommend-box1">商品详情</div>
            <div class="recommend-box2">
                <span class="recommend-box2-text1"><i>品牌： </i>{{food.catename}}</span>
                <span class="recommend-box2-text1"><i>{{food.attrname}}： </i>￥5/{{food.value}}</span>
            </div>
         
        </div>
        <!--加入购物车部分-->
        <div class="goods-details-bottom">
            <div class="gd-collect">
                <span class="gd-collect-img1"></span>
                <router-link to="/" class="gd-collect-text1">首页</router-link>
            </div>
            <router-link to="/cart" class="gd-collect">
                <span class="gd-collect-img1 img2"></span>
                <span class="gd-collect-text1">购物车</span>
            </router-link>
            <div class="gd-collect-sx"></div>
            <button @click="addcar(food.id)" class="gd-collect-btn1 addcar">加入购物车</button>
            <button @click="addcar(food.id)" class="gd-collect-btn1 btn2">立即购买</button>
        </div>

    </div>
</template>
<script>
export default {
    name: 'foodDetail',
    created()
    {
        this.user = this.$cookies.get("user")
        this.foodid = this.$route.query.id ? this.$route.query.id : 0;

        this.$store.dispatch("fooddetail",{id:this.foodid}).then(success=>{
            if(success.result){
                this.food = success.data
                this.images = this.food.thumb.split(",")
            }else{
                this.$alert(success.msg)
            }
        })
    },
    data()
    {
        return {
            foodid:0,
            user:{},
            food:[],
            images:[],
            CDN: this.CDN
        }
    },
    methods:{
        addcar(foodid)
        {
            this.$store.dispatch("cart",{food:this.food,userid:this.user.id}).then(success=>{
                if(success.result)
                {
                    this.$alert(success.msg);
                    this.$router.push("/cart");
                }
            })
        }
    }
}
</script>

<style scoped>
    @import url("../../static/css/goods-details.css");
</style>