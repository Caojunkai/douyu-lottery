<template>
    <el-row>
        <el-col :span="24">
            <div class="grid-content bg-purple-dark">
                <img src="../../images/douyu_lotter_banner.png" alt="">
            </div>
        </el-col>
    </el-row>
</template>

<style scoped>
    .el-row{
        margin-top: -22px;
    }
    .grid-content img{
        width:100%;
        height:auto;
    }
</style>

<script>
  export default{
    name: 'DouyuLotteryBanner'
  }
</script>
