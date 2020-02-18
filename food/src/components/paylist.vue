<template>
  <div class="near-box">
    <div class="header">
      <router-link to="/my" class="left"></router-link>
      充值记录
    </div>
    <div class="bigbox">
      <div v-for="item in paylist" class="sh-adress-box1">
        <router-link :to="{name:'addressedit',params:{addrid:item.id}}" class="sh-adress-box2">
          <span class="sh-adress-text1">价格：{{item.price}}</span>
          <span class="sh-adress-text1 text-r" v-if="item.state == 0">审核状态：未审核</span>
          <span class="sh-adress-text1 text-r" v-else-if="item.state == 1">审核状态：已审核</span>
          <span class="sh-adress-text1 text-r" v-else-if="item.state == -1">审核状态：审核未通过</span>
          <span class="sh-adress-text2">时间：{{item.createtime | dateformat}}</span>
        </router-link>
        <div class="sh-adress-box3">
          <div class="sh-adress-text4" @click="paydel(item.id)">删除</div>
        </div>
      </div>
      
      <router-link to="/pay/add" class="set-text1">添加充值记录</router-link>
    </div>
  </div>
</template>

<script>
    export default {
        name:"paylist",
        created()
        {
          this.user = this.$cookies.get('user')
          this.$store.dispatch('paylist',{userid:this.user.id}).then(success => {
            this.paylist = success.data
          })
        },
        data()
        {
          return {
            user:null,
            paylist:null,
          }
        },
        methods:{
            paydel(payid)
            {
              this.$confirm('是否确认删除充值记录').then(confirm => {
                this.$store.dispatch('paydel',{payid:payid}).then(success => {
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

<style scoped>
  @import url('../../static/css/receiving-adress.css');
</style>