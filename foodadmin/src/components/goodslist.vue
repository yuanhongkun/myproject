<template>
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <common-header></common-header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside-list></aside-list>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor">商品</h3>
                    </div>
                    
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">商品列表</h4>
                                <router-link to="/goodslist/add" class="card-subtitle">添加 <code>+</code></router-link>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>名称</th>
                                                <th>价格</th>
                                                <th>描述</th>
                                                <th>图集</th>
                                                <th>库存数</th>
                                                <th>分类</th>
                                                <th>图像</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in goodslist">
                                                <td>{{item.id}}</td>
                                                <td>{{item.name}}</td>
                                                <td >{{item.price}}</td>
                                                <td>{{item.description}}</td>
                                                <td>{{item.thumb}}</td>
                                                <td >{{item.stock}}</td>
                                                <td >{{item.catename}}</td>
                                                <td>
                                                    <img v-if="item.cover" :src="CDN+item.cover" alt="" width="39" height="39">
                                                    <img v-else src="/static/assets/images/fruits-img4.png" alt="" width="39" height="39">
                                                    
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary" @click="edit(item.id)">编辑</button>
                                                    <button class="btn btn-danger" @click="del(item.id)">删除</button>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                    <van-pagination 
                                    v-model="currentPage" 
                                    :total-items="num" 
                                    :show-page-size="3" 
                                    force-ellipses
                                    :items-per-page="count"
                                    @change="onChange"
                                    
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
           
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
</template>
<script>
import commonHeader from './commonHeader'
import asideList from './asideList'
export default {
    name: 'goodslist',
    components:{
        commonHeader,
        asideList
    },
    data()
    {
        return {
            goodslist:null,
            currentPage:1,
            num:0,
            count:5,
            
            CDN:this.CDN,
        }
    },
    created()
    {
        
        this.$store.dispatch("goodslist",{page:this.currentPage}).then(success=>{
            if(success.result)
            {
                this.goodslist=success.data.goodslist
                this.num = Number(success.data.num.num)
            
            }else{
                this.$alert(success.msg)
            }
        })
    },
    
    methods:{
        edit(foodid)
        {
            this.$router.push({name:"editfood",query:{foodid:foodid}})
        },
        del(foodid)
        {
            this.$store.dispatch("deletefood",{foodid:foodid}).then(success=>{
                this.$alert(success.msg)
                
                this.$router.go(0)
                     
            })
        },
        onChange()
        {
            
            this.$store.dispatch("goodslist",{page:this.currentPage}).then(success=>{
                if(success.result)
                {
                    this.goodslist=success.data.goodslist
                    this.num = Number(success.data.num.num)
                    
                }else{
                    this.$alert(success.msg)
                }
            })
           
        }
    }
}
</script>
<style>
    @import url("../../static/assets/plugins/chartist-js/dist/chartist.min.css");
    @import url("../../static/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css");
    @import url("../../static/assets/plugins/c3-master/c3.min.css");
    @import url("../../static/html/css/pages/dashboard.css");
    @import url("../../static/html/css/colors/default-dark.css");
</style>