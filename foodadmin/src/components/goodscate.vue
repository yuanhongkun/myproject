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
                        <h3 class="text-themecolor">商品分类</h3>
                    </div>
                    
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">商品分类列表</h4>
                                <router-link to="/goodscate/add" class="card-subtitle">添加 <code>+</code></router-link>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>商品名称</th>
                                                <th>商品类型</th>
                                                <th>商品图片</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in goodscate">
                                                <td>{{item.id}}</td>
                                                <td>{{item.name}}</td>
                                                <td >{{item.typename}}</td>
                                                
                                                <td>
                                                    <img v-if="item.cover" :src="CDN+item.cover" alt="" width="128" height="54">
                                                    <img v-else src="/static/assets/images/optimization-img2.jpg" alt="" width="128" height="54">
                                                    
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
    name: 'goodscate',
    components:{
        commonHeader,
        asideList
    },
    data()
    {
        return {
            goodscate:null,
            currentPage:1,
            num:0,
            count:5,
            
            CDN:this.CDN,
        }
    },
    created()
    {
        
        this.$store.dispatch("goodscatelist",{page:this.currentPage}).then(success=>{
            if(success.result)
            {
                this.goodscate=success.data.goodscate
                this.num = Number(success.data.num.num)
            
            }else{
                this.$alert(success.msg)
            }
        })
    },
    
    methods:{
        edit(goodscateid)
        {
            this.$router.push({name:"editgoodscate",query:{goodscateid:goodscateid}})
        },
        del(goodscateid)
        {
            this.$store.dispatch("deletegoodscate",{goodscateid:goodscateid}).then(success=>{
                this.$alert(success.msg)
                
                this.$router.go(0)
                     
            })
        },
        onChange()
        {
            
            this.$store.dispatch("goodscatelist",{page:this.currentPage}).then(success=>{
                if(success.result)
                {
                    this.goodscate=success.data.goodscate
                    this.num = Number(success.data.num.num)
                    
                }else{
                    this.$alert(success.msg)
                }
            })
           
        }
    }
}
</script>
<style scoped>
    @import url("../../static/assets/plugins/chartist-js/dist/chartist.min.css");
    @import url("../../static/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css");
    @import url("../../static/assets/plugins/c3-master/c3.min.css");
    @import url("../../static/html/css/pages/dashboard.css");
    @import url("../../static/html/css/colors/default-dark.css");
</style>