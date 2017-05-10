<template>
    <el-row class="lottery-content">
        <el-col :span="6" :offset="4" class="lottery-content-left" v-loading="loadingGifts"
                element-loading-text="拼命加载中">
            <div class="grid-content lottery-content-left-content" id="lottery-content-left-content">
                <table>
                    <tbody>
                    <tr v-for="lotteryUser in lotteryUsers" style="width:100%;">
                        <td style="width:20%;">
                            <img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1494331517247&di=da53acca7260e0770a6424779497126b&imgtype=0&src=http%3A%2F%2Fpic2.orsoon.com%2F2016%2F1215%2F20161215100547239.jpg">
                        </td>
                        <td style="width:20%;vertical-align:middle;text-align:center;">{{ lotteryUser.douyu_name }}</td>
                        <td style="width:60%;vertical-align:middle;text-align:center;">{{ lotteryUser.vote_time }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </el-col>
        <el-col :span="10" class="lottery-content-right">
            <div class="block">
                <div class="lottery-content-result">
                    <div class="lottery-content-result-clearup">
                        <h2>本次抽奖已结束,中奖用户为：<span style="color: red">{{luckier}}</span></h2>
                    </div>
                </div>
            </div>
        </el-col>
    </el-row>
</template>


<style scoped>
    .lottery-content {
        margin-top: 5px;
        height: 69%;
    }

    .lottery-content-right {
        background: rgb(84, 74, 144);
    }

    .lottery-content-left {
        min-height: 400px;
        height: 100%;
        padding: 2px;
        margin-right: 2px;
    }

    .lottery-content-left-content {
        height: 100%;
        border-radius: 10px;
        background: rgb(54, 44, 81);
        overflow: auto;
    }

    .lottery-content-left-content table {
        width: 100%;
        color: rgba(255, 255, 255, .7);
    }

    .lottery-content-left-content table tr {
        height: 40px;
    }

    .lottery-content-left-content table img {
        display: block;
        height: 40px;
        width: 40px;
        border-radius: 100%;
        margin-left: 10px;
    }

    .lottery-content-right {
        min-height: 400px;
        height: 100%;
        position: relative;
    }

    .lottery-content-result-clearup {
        border: rgb(255, 255, 255) solid 5px;
        border-radius: 10px;
        background: rgb(255, 241, 192);
        margin-left: 10%;
        margin-right: 10%;
        margin-top: 30%;
        text-align: center;
        color: rgb(86, 77, 141);
    }

    ::-webkit-scrollbar {
        width: 15px;
        background: rgba(54, 44, 81, .2);
    }

    /* 滚动槽 */

    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        border-radius: 10px;
        background-color: rgba(84, 74, 144, 1);
    }

    /* 滚动条滑块 */

    ::-webkit-scrollbar-thumb {
        height: 20 p;
        border-radius: 20px;
        background: rgb(67, 53, 106);
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
    }
</style>

<script>
  export default {
    'name': 'DouyuDrawResult',
    data() {
      return {
        lotteryUsers: [],
        loadingGifts: false,
        scrollContent: null,
        pageId: 1,
      }
    },
    methods: {
      getGifts() {
        let _this = this;
        _this.loadingGifts = true
        this.axios.get('/lotteries/' + _this.voteId, {
          params: {
            page: _this.pageId
          }
        }).then(function (response) {
          let resp = response.data
          if (resp.code) {
            let res = JSON.parse(resp.msg)
            _this.pageId = parseInt(res.current_page) + 1
            _this.lotteryUsers = _this.lotteryUsers.concat(res.data)
          }
          _this.loadingGifts = false
        })
      },
      getMoreGifts() {
        if (this.scrollContent.scrollTop + this.scrollContent.offsetHeight >= this.scrollContent.scrollHeight) {
          this.getGifts()
        }
      }
    },
      props: [
        "voteId",
        "luckier"
      ],
      mounted() {
        this.scrollContent = document.getElementById('lottery-content-left-content')
        this.getGifts(1)
        this.scrollContent.addEventListener('scroll', this.getMoreGifts);
      }
    }
</script>
