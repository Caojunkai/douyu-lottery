<template>
    <el-row class="lottery-content">
        <el-col :span="6" :offset="4" class="lottery-content-left">
            <div class="grid-content lottery-content-left-content">
                <ul>
                    <li v-for="lotteryUser in lotteryUsers">
                        {{ lotteryUser.douyu_name }}
                        {{ lotteryUser.vote_time }}
                    </li>
                </ul>
            </div>
        </el-col>
        <el-col :span="10" class="lottery-content-right">
            <div class="block">
                <div class="lottery-content-result">

                </div>
                <div class="lottery-content-right-button">
                    <el-row>
                        <el-col :span="4" :offset="6">
                            <el-button type="warning" size="large" @click="test">去除无用数据</el-button>
                        </el-col>
                        <el-col :span="4" :offset="4">
                            <el-button type="info" size="large">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;开始抽奖&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</el-button>
                        </el-col>
                    </el-row>
                </div>
            </div>
        </el-col>
    </el-row>
</template>

<style scoped>
    .lottery-content{
        margin-top: 5px;
    }
    .el-col{
        background: rgb(84, 74, 144);
    }
    .lottery-content-left {
        height: 500px;
        overflow: auto;
        padding: 5px;
        margin-right: 2px;
    }
    .lottery-content-left-content{
        min-height: 490px;
        border-radius: 10px;
        background: rgb(54, 44, 81);
    }
    .lottery-content-left-content li{
        list-style: none;
        color: white;
    }
    .lottery-content-right{
        height: 500px;
        position: relative;
    }
    .lottery-content-right-button{
        position:absolute;
        bottom: 20px;
        width: 100%;
    }

   ::-webkit-scrollbar {
        width: 12px;
    }

    /* 滚动槽 */
    ::-webkit-scrollbar-track {
        border-radius: 10px;
    }

    /* 滚动条滑块 */
    .lottery-content-left::-webkit-scrollbar-thumb {
        border-radius:15px;
        background:rgb(67, 53, 106);
    }

    ::-webkit-scrollbar-thumb:window-inactive {
        background: rgba(255, 0, 0, 0.4);
    }
</style>

<script>
  export default{
    'name': 'DouyuDrawLottery',
    data() {
      return {
        lotteryUsers:[]
      }
    },
    methods :{
      test:function () {
        this.lotteryUsers.push({'douyu_name':'ssdds','vote_time':'saasas'});
      }
    },
    mounted(){
      let _this = this;
      this.axios.get('/lottery/1').then(function (response) {
        let res = response.data;
        if (res.code){
          _this.lotteryUsers = JSON.parse(res.data);
        }
      })
    }
  }
</script>
