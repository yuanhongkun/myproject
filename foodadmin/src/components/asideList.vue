<template>
    <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li> <router-link class="waves-effect waves-dark" to="/admin" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">用户管理</span></router-link></li>
                        <li> <router-link class="waves-effect waves-dark" to="/goodscate" aria-expanded="false"><i class="mdi mdi-account-check"></i><span class="hide-menu">商品分类</span></router-link></li>
                        <li> <router-link class="waves-effect waves-dark" to="/orderlist" aria-expanded="false"><i class="mdi mdi-table"></i><span class="hide-menu">订单管理</span></router-link></li>
                        <li> <router-link class="waves-effect waves-dark" to="/goodslist" aria-expanded="false"><i class="mdi mdi-emoticon"></i><span class="hide-menu">商品</span></router-link></li>
                        <li> <router-link class="waves-effect waves-dark" to="/activity" aria-expanded="false"><i class="mdi mdi-earth"></i><span class="hide-menu">活动管理</span></router-link></li>
                        <li> <router-link class="waves-effect waves-dark" to="/pay" aria-expanded="false"><i class="mdi mdi-book-open-variant"></i><span class="hide-menu">充值</span></router-link></li>
   
                    </ul>
                    
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
    </aside>
</template>
<script>
export default {
    name:"asideList"
}
</script>
<style scoped>
    @import url("../../static/html/css/colors/default-dark.css");
</style>