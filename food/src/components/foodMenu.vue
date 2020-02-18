<template>
  <div class="kaola-bottom">
    <router-link to="/" class="kaola-bottom-box1">
      <span class="kaola-bottom-img1"><img src="/static/images/home.png"></span>
      <span class="kaola-bottom-text1 text2">首页</span>
    </router-link>
    <router-link to="/cate" class="kaola-bottom-box1">
      <span class="kaola-bottom-img1"><img src="/static/images/search3.png"></span>
      <span class="kaola-bottom-text1">分类</span>
    </router-link>
    <router-link to="/cart" class="kaola-bottom-box1">
      <span class="kaola-bottom-img1"><img src="/static/images/shop-cart1.png"></span>
      <span class="kaola-bottom-text1">购物车</span>
    </router-link>
    <router-link to="/my" class="kaola-bottom-box1">
      <span class="kaola-bottom-img1"><img src="/static/images/people1.png"></span>
      <span class="kaola-bottom-text1">我的</span>
    </router-link>
  </div>
</template>

<script>
  export default {
    name:"foodMenu"
  }
</script>

