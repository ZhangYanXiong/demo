<template>
    <el-transfer
      v-model="value1"
      :data="data"
      :titles="title"
      :button-texts="buttonTexts"
      :filterable="filterable"
      filter-placeholder="请输入关键字"
      @change="handleChange"
    ></el-transfer>
</template>

<script>
  import request from '@/utils/request'
  import _ from 'lodash'

  /**
   * 毫末科技的穿梭框组件.
   *
   *   demo地址: factory.haomo-studio.com/vue-element/#/haomo/components/transfer
   * @author 索光旭
   */
  export default {
    name: 'HmTransfer',
    props: {
      /**
       * 必传,组件所使用的表定义schema。表定义schema，请使用 model2codejs 从pdm文件生成schema。
       * 对于所有毫末科技的组件，必须传schema，以完成数据的交互
       */
      schema: {
        type: Object,
        required: true
      },
      /**
       * 必传,项用于控制是否启用过滤功能
       */
      filterable: {
        type: Boolean,
        required: true
      },
      /**
       * 非必传,用于修改穿梭框标题显示
       * 若不传,则显示默认文字list1,list2
       */
      title: {
        type: Array
      },
      /**
       * 非必传,用于修改穿梭框按钮文字显示
       * 若不传，则默认显示为左右箭头
       */
      buttonTexts: {
        type: Array
      }
    },
    methods: {
      // 获取所有用户信息
      getUser: function() {
        const self = this
        const params = {}
        request(self.schema.modelUnderscorePlural, {
          params: params
        }).then(resp => {
          self.list = resp.data
          // 重新格式化用户信息
          _.forIn(self.list, function(item, index) {
            self.data.push({
              key: index,
              label: item.username
              // disabled: index % 4 === 0    //需要禁止选择时设置
            })
            // 通过type类型判断左右显示
            if (item.type !== 0) {
              self.value1.push(index)
            }
          })
        })
      },
      // 更改用户type字段值(入库操作)
      changeType: function(val, userObj) {
        const self = this
        request(self.schema.modelUnderscorePlural + '/' + userObj.id + '/edit', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8' },
          params: { type: val }
        }).then(data => {})
      },
      // 监测两侧列表改变事件
      handleChange(value, directions, moveKey) {
        const self = this
        // 判断移动方向
        if (directions === 'left') {
          _.each(moveKey, function(key) {
            const userObj = self.list[key]
            self.changeType(0, userObj)
          })
        } else {
          _.each(moveKey, function(key) {
            const userObj = self.list[key]
            self.changeType(1, userObj)
          })
        }
      }
    },
    created: function() {
      this.getUser()
    },
    data() {
      return {
        data: [],
        list: null,
        value1: [] // 右侧列表显示内容，必须项，否则穿梭功能无法实现
      }
    }
  }
</script>

<style>
  .el-transfer{
    width: 33rem;
    margin: 10rem auto;
  }
</style>
