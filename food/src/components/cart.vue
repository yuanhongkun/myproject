<template>
  <div class="near-box">
    <div class="header">
      <router-link to="/" class="left"></router-link>
      购物车
    </div>
    <div class="shop-cart-bigbox">
      <div @click="selectAddr" class="cart-title" v-if="addrdefault">收货地址 <i>{{addrdefault.info}}</i></div>
      <div @click="selectAddr" class="cart-title" v-else>收货地址 <i>选择收货地址</i></div>
      <div class="shop-cart-listbox1" v-if="cartlist">
        <div class="index-goods" v-for="(item,key) in cartlist" :key="key">
          <span class="shop-cart-check2">
            <input ref="check" @click="selectCart($event,key)" type="checkbox" name="sub2" :cartid="item.id" class="shopcart-input1 btn2">
          </span>
          <span class="index-goods-img">
            <img v-if="item.cover" :src="CDN + item.cover">
            <img v-else src="/static/del/fruits-img12.png">
          </span>
          <div class="index-goods-textbox">
            <span class="index-goods-text1">{{item.name}}</span>
            <div class="index-goods-text2">￥<i class="priceJs">{{item.foodprice}}</i></div>
            <div class="shop-cart-box3">
              <span @click="subtract(key)" class="shop-cart-subtract"></span>
              <input type="number" size="4" v-model="item.foodnum" class="shop-cart-numer" readonly>
              <span @click="add(key)" class="shop-cart-add"></span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <van-coupon-cell class="coupon"
      :coupons="coupons"
      :chosen-coupon="chosenCoupon"
      @click="showlist=true"
    />
    <van-popup
      v-model="showlist"
      round
      position="bottom"
      style="height: 90%; padding-top: 4px;"
    >
      <van-coupon-list
        :coupons="coupons"
        :chosen-coupon="chosenCoupon"
        :disabled-coupons="disabledCoupons"
        :show-exchange-bar="false"
        @change="onChange"
        
      />
    </van-popup>




    <div class="shop-cart-total">
      <label class="checkall">
        <span class="shop-cart-check1"><input type="checkbox" class="" id="ckAll" @click="all($event)"></span>
        全选
      </label>
      <span class="scart-total-text2">合计：￥</span>
      <span id="AllTotal" class="scart-total-text3">{{totals}}</span>
      <a @click="order" class="scart-total-text4">去结算<i id="selectedTotal"></i></a>
      <span class="delete hide"></span>
    </div>
    
    <food-menu></food-menu>
  </div>
</template>

<script>
  
  import foodMenu from './foodMenu'

  export default {
    name: 'cart',
    components:{
      foodMenu
    },
    created()
    {
       this.user = this.$cookies.get('user')
      this.orderid = this.$route.query.orderid ? this.$route.query.orderid : 0
      
      this.$store.dispatch("cartlist",{userid:this.user.id,orderid:this.orderid}).then(success => {
        this.cartlist = success.data.cartlist
        this.addrdefault = success.data.addrdefault
      })
      
      this.addrid = this.$route.query.addrid ? this.$route.query.addrid : 0
      this.$store.dispatch('addressinfo',{addrid:this.addrid}).then(success => {
        if(success.result)
        {
          this.addrdefault = success.data.address
        }
      })

      this.$store.dispatch("usecoupon",{userid:this.user.id}).then(success=>{
        if(success.result)
        {
          this.coupons = success.data
          
        }
      })
      this.$store.dispatch("unusecoupon",{userid:this.user.id}).then(success=>{
        if(success.result)
        {
          this.disabledCoupons = success.data
        }
      })
     
    },
    data()
    {
      return {
        user:null,
        cartlist:[],
        addrdefault:null,
        CDN:this.CDN,
        totals:0,
        addrid:0,
        chosenCoupon: -1,
        coupons: [],
        disabledCoupons:[],
        showlist:false,
        orderid:0,
      }
    },
    methods:{
      
      onChange(index) {
        
       
        this.showlist=false
        this.chosenCoupon = index
        if(this.chosenCoupon>=0)
        {
          
          if(Number(this.coupons[index].price) < Number(this.totals)&&this.totals>0)
          {
            
            this.totals = this.totals-this.coupons[index].valueDesc
            this.$store.dispatch("updatecoupon",{couponid:this.coupons[index].id}).then(success=>{
              if(success.result)
              {
                this.$alert(success.msg);
              }
              else{
                this.$alert(success.msg);
              }
            })

          }
        }
        
        

      },
     
      //减少
      subtract(index)
      {
        if(this.cartlist[index].foodnum > 0)
        {
          this.cartlist[index].foodnum--;
          var price = parseFloat(this.cartlist[index].foodnum*this.cartlist[index].price).toFixed(2)
          this.cartlist[index].foodprice = price
          var data = {
            'userid':this.user.id,
            'foodid':this.cartlist[index].foodid,
            'foodnum':this.cartlist[index].foodnum
          }
          this.$store.dispatch('cartupdate',data).then(success => {
            if(this.$refs.check[index].checked)
            {
              //选中
              this.totals = parseFloat(this.totals)
              this.totals -= parseFloat(this.cartlist[index].price)
              this.totals = this.totals.toFixed(2)
            }
          })
        }else{
          this.$alert('数量不能小于0')
        }
      },
      //增加
      add(index)
      {
        this.cartlist[index].foodnum++;
        var price = parseFloat(this.cartlist[index].foodnum*this.cartlist[index].price).toFixed(2)
        this.cartlist[index].foodprice = price
        var data = {
            'userid':this.user.id,
            'foodid':this.cartlist[index].foodid,
            'foodnum':this.cartlist[index].foodnum
          }
        this.$store.dispatch('cartupdate',data).then(success => {
          if(this.$refs.check[index].checked)
          {
            //选中
            this.totals = parseFloat(this.totals)
            this.totals += parseFloat(this.cartlist[index].price)
            this.totals = this.totals.toFixed(2)
          }
        })
      },
      selectCart(event,index)
      {
        if(event.target.checked)
        {
          //选中 +
          this.totals = parseFloat(this.totals)
          this.totals += parseFloat(this.cartlist[index].foodprice)
          this.totals = this.totals.toFixed(2)
        }else{
          //减
          if(this.totals > 0)
          {
            this.totals = parseFloat(this.totals)
            this.totals -= parseFloat(this.cartlist[index].foodprice)
            this.totals = this.totals.toFixed(2)
          }
        }
      },
      all(event)
      {
        if(event.target.checked)
        {          
          this.$refs.check.forEach(item => {
            item.checked = true
          })

          this.totals = 0

          this.cartlist.forEach(item => {
            this.totals = parseFloat(this.totals)
            this.totals += parseFloat(item.foodprice)
          })

          this.totals = this.totals.toFixed(2)
          
        }else{
          this.totals = 0

          this.$refs.check.forEach(item => {
            item.checked = false
          })
        }
      },
      selectAddr()
      {
        this.$router.push({name:"addresslist",query:{action:"selected"}});
      },
      order()
      {
        var cartid = []
        this.$refs.check.forEach(item => {
          if(item.checked)
          {
            cartid.push(item.getAttribute('cartid'))
          }
        })

        if(cartid.length <= 0)
        {
          this.$alert('未选中任何商品')
          return false
        }else{
          var data = {
            "userid":this.user.id,
            "addrid":this.addrdefault.id,
            "cartid":cartid.join(',')
          }

          this.$store.dispatch('cartadd',data).then(success => {
            if(success.result)
            {
              this.$alert(success.msg).then(res => {
                this.$router.push("/order/list")
              }).catch(err => {})
              
            }else{
              this.$alert(success.msg)
            }
          })
        }
      },
      
    }
  }
</script>


<style scoped>
  @import url('../../static/css/shoping-cart.css');
</style>
<style scoped>
.coupon{

  z-index: 999;
  position:fixed;
  bottom:95px;
}
</style>
