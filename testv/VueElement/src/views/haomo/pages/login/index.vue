<template>
  <div>
    <hm-login :options="options"></hm-login>
  </div>
</template>

<script>
  import HmLogin from './HmLogin.vue'
  export default {
    name: 'login',
    // 继承其他组件
    extends: {},
    // 使用其它组件
    components: {
      'hm-login': HmLogin
    },
    data() {
    },
    computed: {
    },
    filters: {
    },
    created() {
      this.options = {
        spx: function(account, pass) {
          alert(account + pass)
        },
        span: 10
      }
    },
    methods: {
      test: function() {
        alert(4)
      }
    }
  }
</script>
<style scoped>
</style>
