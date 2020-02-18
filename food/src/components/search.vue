<template>
    <div class="d7-sousuo-wear">
        <form class="d7-sousuo-top" @submit.prevent="soushuo()">
            <router-link to="/" class="d7-sousuo-t1"></router-link>
            <span class="d7-sousuo-t2">
                <input type="text" placeholder="搜索品牌 店铺..." name="keywords" v-model="search.keywords">
            </span>
            <button type="submit" class="d7-sousuo-t3"></button>
        </form>
    
        <div class="d7-sousuo-mid">
            <span class="d7-sousuo-tit">最近搜索</span>
            <span class="d7-sousuo-jl1">太古里</span>
            <span class="d7-sousuo-jl1">Kenzo 男士</span>
            <span class="d7-sousuo-tit">热门搜索</span>
            <span class="d7-sousuo-jl1">Kenzo 男士</span>
            <span class="d7-sousuo-jl1">Kenzo 男士</span>
            <span class="d7-sousuo-jl1">Kenzo 男士</span>
            <span class="d7-sousuo-jl1">Kenzo 男士</span>
        </div>
    </div>
</template>
<script>
export default {
    name:"search",
    data()
    {
        return {
            search:{},
            action:''
        }
    },
    methods:{
        soushuo()
        {
            this.$router.push({name:"home",query:{action:"search",keywords:this.search.keywords}})
            
        }
    }
}
</script>
<style scoped>
    @import url("../../static/css/d7-isousuo.css");
</style>