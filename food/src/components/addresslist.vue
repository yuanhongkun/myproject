<template>
  <div class="near-box">
    <div class="header">
      <router-link to="/my" class="left"></router-link>
      收货地址
    </div>
    <div class="bigbox">
      <div v-if="action == 'selected'">
      <div  v-for="item in addresslist" class="sh-adress-box1">
        <router-link :to="{name:'cart',query:{addrid:item.id}}" class="sh-adress-box2">
          <span class="sh-adress-text1">{{item.consignee}} {{item.info}}</span>
          <span class="sh-adress-text1 text-r">{{item.mobile}}</span>
          <span class="sh-adress-text2">{{item.info}}</span>
        </router-link>
        <div class="sh-adress-box3">
          <div class="sh-adress-text3 img2" v-if="item.status=='1'">设为默认地址</div>
          <div class="sh-adress-text3" v-else @click="addrdefault(item.id)">设为默认地址</div>
          <div class="sh-adress-text4" @click="addressdel(item.id)">删除</div>
        </div>
      </div>
      </div>
      <div v-else>
      <div  v-for="item in addresslist" class="sh-adress-box1">
        <router-link :to="{name:'addressedit',params:{addrid:item.id}}" class="sh-adress-box2">
          <span class="sh-adress-text1">{{item.consignee}} {{item.info}}</span>
          <span class="sh-adress-text1 text-r">{{item.mobile}}</span>
          <span class="sh-adress-text2">{{item.info}}</span>
        </router-link>
        <div class="sh-adress-box3">
          <div class="sh-adress-text3 img2" v-if="item.status=='1'">设为默认地址</div>
          <div class="sh-adress-text3" v-else @click="addrdefault(item.id)">设为默认地址</div>
          <div class="sh-adress-text4" @click="addressdel(item.id)">删除</div>
        </div>
      </div>
      </div>
      <router-link to="/address/add" class="set-text1">添加新地址</router-link>
      <!--确认删除弹层-->
      <div class="delete-layer-bg" style="display: none;"></div>
      <div class="delete-layer" style="display: none;">
            <div class="active-a2">确认后地址将被删除！</div>
            <div class="active-a3">
              <span class="other2 other1">取消</span>
              <span class="other2" id="deletebox">确定</span>
              <div class="active-a3-x1"></div>
            </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name:"addresslist",
    created()
    {
      this.action = this.$route.query.action ? this.$route.query.action : ''

      //console.log(this.action)
      this.user = this.$cookies.get('user')
      this.$store.dispatch('addresslist',{userid:this.user.id}).then(success => {
        this.addresslist = success.data
      })
    },
    data()
    {
      return {
        user:null,
        addresslist:null,
        action:''
      }
    },
    methods:{
      addrdefault(addrid)
      {
        this.$store.dispatch('addressdefault',{addrid:addrid,userid:this.user.id}).then(success => {
          if(success.result)
          {
            this.$store.dispatch('addresslist',{userid:this.user.id}).then(success => {
              this.addresslist = success.data
            })
          }
        })
      },
      addressdel(addrid)
      {
        this.$confirm('是否确认删除收货地址').then(confirm => {
          this.$store.dispatch('addressdel',{addrid:addrid}).then(success => {
            if(success.result)
            {
              this.$router.go(0)
            }else{
              this.$alert(success.msg)
            }
          })

        }).catch(err => {})
      }
    }
  }
</script>

<style>
  @import url('../../static/css/receiving-adress.css');
</style>