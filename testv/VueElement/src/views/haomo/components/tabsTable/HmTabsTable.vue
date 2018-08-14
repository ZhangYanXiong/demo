<template>
  <el-tabs v-model="activeName" @tab-click="handleClick"  type="card">
    <el-tab-pane :label="item.name" :name="item.type + ''" v-for="item in tabTitles">
      <el-table
        :data="dataList[item.type]"
        style="width: 100%">
        <el-table-column
          prop="id"
          label="用户ID"
          width="200">
        </el-table-column>
        <el-table-column
          prop="username"
          label="用户名称"
          width="200">
        </el-table-column>
        <el-table-column
        prop="mobile"
        label="联系电话"
        width="200">
        </el-table-column>
        <el-table-column
          prop="email"
          label="邮箱"
          width="200">
        </el-table-column>
        <el-table-column
          prop="type"
          label="登录状态"
          width="200">
        </el-table-column>
      </el-table>
    </el-tab-pane>
  </el-tabs>
</template>
<script>
  import request from '@/utils/request'
  import _ from 'lodash'

  export default {
    name: 'HmTabsTable',
    extends: {},
    components: {},
    mixins: [],
    props: {
      schema: {
        type: Object,
        require: true
      },
      tabTypes: {
        type: String,
        require: true
      },
      tabTitles: {
        type: Array,
        require: true
      }
    },
    data() {
      return {
        activeName: '',
        dataList: []
      }
    },
    methods: {
      handleClick(tab, event) {
      },
      getList() {
        const self = this
        request(self.schema.modelUnderscorePlural, {
          params: {}
        }).then(resp => {
          self.dataList['0'] = []
          self.dataList['1'] = []
          self.dataList['2'] = []
          self.dataList['3'] = []
          self.dataList['4'] = []
          _.each(resp.data, (item, index) => {
            switch (item[self.tabTypes]) {
              case 0:
                self.dataList['0'].push(item)
                break
              case 1:
                self.dataList['1'].push(item)
                break
              case 2:
                self.dataList['2'].push(item)
                break
              case 3:
                self.dataList['3'].push(item)
                break
              case 4:
                self.dataList['4'].push(item)
                break
            }
          })
          self.activeNames = '0'
          console.log(self.dataList[0])
          console.log(self.dataList[1])
        })
      }
    },
    created() {
      this.getList()
    }
  }
</script>
