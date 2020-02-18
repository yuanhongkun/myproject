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
                        <h3 class="text-themecolor">编辑商品</h3>
                    </div>
                    
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form role="form" @submit.prevent="editgoodscate(goodscate.id)">
                                    <div class="form-group">
                                        <label for="name">商品名称</label>
                                        <input type="text" class="form-control" id="name" v-model="goodscate.name" name="name" required placeholder="请输入商店名称">
                                        <label for="password">商品类型</label>
                                        <select name="" id="" v-model="goodscate.typeid">
                                            <template >
                                                <option v-for="item in foodtype" :value="item.id">{{item.name}}</option>
                                            </template>
                                        </select>
                                        <div class="avatar" v-if="goodscate.cover">
                                            <img :src="CDN + goodscate.cover" onclick="avatar.click()" />
                                        </div>
                                        <div class="avatar" v-else onclick="avatar.click()">
                                            <img src="/static/assets/images/optimization-img2.jpg" >
                                        </div>
                                        <input type="file" @change="upload($event)" id="avatar" style="display:none">
                                        
                                    </div>
                                    
                                    <button type="submit" class="btn btn-default">提交</button>
                                </form>
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
        name: 'editgoodscate',
        components:{
            commonHeader,
            asideList
        },
        data()
        {
            return {
                foodtype:[],
                goodscate:{},
                goodscateid:0,
                
            }
        },
        created()
        {
            this.goodscateid = this.$route.query.goodscateid
            //console.log(this.goodscateid)
            this.$store.dispatch("goodscateinfo",{goodscateid:this.goodscateid}).then(success=>{
                if(success.result)
                {
                    this.goodscate = success.data.goodscate
                    this.foodtype = success.data.foodtype
                }else{
                    this.$alert(success.msg)
                }
            })
            

        },
        methods:{
            editgoodscate(editgoodscateid)
            {
                this.$store.dispatch("editgoodscate",this.goodscate).then(success=>{
                    if(success.result)
                    {
                        
                        this.$router.push('/goodscate')
                    }else{
                        this.$alert(success.msg)
                    }
                })
            },
            upload(event)
            {
                //获取到选取的第一张图片
                var cover = event.target.files[0]
                //创建一个表单数据对象
                var data = new FormData()
                data.append("cover",cover)
                data.append("goodscateid",this.goodscate.id)

                console.log(cover)
                //直接传递给actions
                this.$store.dispatch('cover',data).then(success => {
                    if(success.result)
                    {
                        this.goodscate = success.data
                    }else{
                        this.$alert(success.msg)
                        return false
                    }
                })
            },
        }
    }
</script>