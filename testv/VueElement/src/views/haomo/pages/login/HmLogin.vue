<template>
  <el-row type="flex">
    <el-col :span="options.span" class="detail-content" style="margin:0 auto;border: 0.5px solid #e6ebf5" >
      <el-row type="flex">
        <el-col style="height: 45px;background-color: #00BF8B" ></el-col>
      </el-row>
      <el-row type="flex" style="margin-top:30px">
        <el-col style="margin: 0 auto;height: 70px;width:433px;text-align: center;line-height: 70px;font-size: 35px;color:#586C8C;font-weight: bold" >
          <img />张家口人民检察院
        </el-col>
      </el-row>
      <el-form :model="hm_form" status-icon :rules="rules2" ref="hm_form" style="width: 433px;margin: 0 auto;">
        <el-form-item prop="account">
          <el-input class="style" placeholder="请输入账号" v-model="hm_form.account" style="margin-top:25px;display: block;" prefix-icon="el-icon-search" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item prop="pass">
          <el-input type="password" placeholder="请输入密码" v-model="hm_form.pass" style="display: block;border-width: 0px;border-bottom-width: 1px;border-radius: 0px;" prefix-icon="el-icon-search" suffix-icon="el-icon-view" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="success" @click="submitForm('hm_form',options)" style="width: 178px;height: 44px ;font-size:16px;background-color: #00BF8B;margin: 0 auto;display: block">提交</el-button>
        </el-form-item>
      </el-form>
    </el-col>
  </el-row>
</template>

<script>
  export default {
    name: 'HmLogin',
    // 继承其他组件
    extends: {},
    // 使用其它组件
    components: {},
    props: {
      options: {
        type: Object,
        required: false
      }
    },
    data() {
      var account = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请输入账号'))
        } else {
          callback()
        }
      }
      var pass = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请输入密码'))
        } else {
          callback()
        }
      }
      return {
        hm_form: {
          account: '',
          pass: ''
        },
        rules2: {
          account: [
            { validator: account, trigger: 'blur' }
          ],
          pass: [
            { validator: pass, trigger: 'blur' }
          ]
        }
      }
    },
    computed: {
    },
    filters: {
    },
    created() {
    },
    methods: {
      submitForm(formName, callback) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            alert('submit!' + JSON.stringify(callback))
          } else {
            console.log('error submit!!')
            return false
          }
        })
      }
    }
  }
</script>
<style scoped>
</style>
