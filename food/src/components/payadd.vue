<template>
  <div class="near-box">
    <div class="header">
      <router-link to="/pay/list" class="left"></router-link>
      充值记录
    </div>
    <div class="bigbox">
        <form @submit.prevent="payadd">
          <div class="receiv-text1">充值信息</div>
          <div class="receiv-box1">
            <input type="text" v-model="pay.price" class="receiv-input1" placeholder="请输入充值金额" required>
          </div>
          <button class="set-text1">保存</button>
        </form>
    </div>
  </div>
</template>

<script>
  //省
  var province = []
  var city = []
  var district = []
  export default {
    name:"addressadd",
    created()
    {
      this.user = this.$cookies.get('user')
    },
    data()
    {
      return {
        user:null,
        pay:{
        },
      }
    },
    methods:{
      payadd()
      {
        this.pay.userid = this.user.id
        this.$store.dispatch('payadd',this.pay).then(success => {
          if(success.result)
          {
            this.$alert(success.msg).then(res => {
              this.$router.push('/pay/list')
            }).catch(err => {})
            
          }else{
            this.$alert(success.msg)
          }
        })
      }
    }
  }
</script>


<style scoped>
  @import url('../../static/css/receiving-adress.css');
</style>