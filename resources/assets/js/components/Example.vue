<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component ....</div>
                    <div class="panel-body">
                        I'm an example component!
                        <h1>{{ myMessage }}</h1>
                        <h2>{{ counter }}</h2>
                        <button class="btn" @click="test"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    mounted() {
      console.log(2333)
    },
    data: function () {
      return {
        counter: 0
      }
    },
    props:[
      'myMessage'
    ],
    methods :{
        test:function () {
          axios.get('/home').then(function (response) {
                console.log(response);
          })
        }
    }
  }
</script>
