<template>
  <!--<el-row :gutter="20" style="margin-top: 20px;padding: 0 20px;">
    <div width="1000px" height="500px">
      <el-col :span="12" v-for="column in schema['columns']">
        <el-tabs v-model="activeName" @tab-click="handleClick" type="border-card">
          <el-tab-pane :label="column.name" name="first">
            <ul style="list-style: none;margin: 0;padding: 0;">
              <li>第1条数据</li>
              <li>第2条数据</li>
              <li>第3条数据</li>
            </ul>
          </el-tab-pane>
        </el-tabs>
      </el-col>
    </div>
  </el-row> -->
  <swiper :options="swiperOption" style="padding: 0 30px 0">
    <swiper-slide v-for="(tab,index) in tabData" :key="index">
      <el-tabs v-model="activeName" @tab-click="handleClick" type="border-card">
        <!--<el-tab-pane :label="tab.title" name="first" style="min-height: 54px">-->
        <!--<ul style="list-style: none;margin: 0;padding: 0;">-->
        <!--<li v-for="data in tab.column" class="clearfix">-->
        <!--<span style="float: left;">{{data.title}}</span>-->
        <!--<span style="float: right;">{{data.createTime}}</span>-->
        <!--</li>-->
        <!--</ul>-->
        <!--</el-tab-pane>-->
        <el-tab-pane :label="tab.title" name="first" style="height: 440px">
          <hm-complex-table :schema="schema[tab.tableName]"
                            :columns="tab.showUserColumns"
                            :options="tab.userOptions">
          </hm-complex-table>
        </el-tab-pane>
      </el-tabs>
    </swiper-slide>
    <div class="swiper-button-prev" slot="button-prev" style="left: 1px;"></div>
    <div class="swiper-button-next" slot="button-next" style="right: 3px;"></div>
  </swiper>
</template>

<script>
  import _ from 'lodash'
  import request from '@/utils/request'
  // import schema from '../haomo/schemas/hm_org_schema'
  import HmComplexTable from '../tables/HmComplexTable.vue'

  /**
   * 毫末科技的选项卡组件.
   *
   *   demo地址: factory.haomo-studio.com/vue-element/#/haomo/components/tabs
   * @author 王康
   */
  export default {
    name: 'HmTab',
    // 集成其他组件
    extends: {},
    // 使用其它组件
    components: {
      'hm-complex-table': HmComplexTable
    },
    // 混入公共对象
    mixins: [],
    /**
     * 组件所使用的表定义schema。表定义schema，请使用 model2codejs 从pdm文件生成schema。
     * 对于所有毫末科技的组件，必须传schema，以完成数据的交互
     */
    props: {
      schema: {
        type: Object,
        required: false
      },
      tabData: {
        type: Array,
        required: false
      }
    },
    data() {
      return {
        activeName: 'first',
        swiperOption: {
          slidesPerView: 2,
          slidesPerGroup: 2,
          // loop: true,
          spaceBetween: 30,
          grabCursor: true,
          navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
          }
        },
        listQuery: {
          pageNo: 1,
          pageSize: 3,
          sortItem: 'create_time',
          sortOrder: 'desc',
          filters: {}
        }
      }
    },
    created() {
      // this.validate()
      // console.log(this.schema)
      // this.getList()
    },
    methods: {
      handleClick(tab, event) {
        console.log(tab, event)
        console.log(this.schema)
      },
      // 获取数据
      getList() {
        const self = this

        // 处理过滤条件
        const params = JSON.parse(JSON.stringify(self.listQuery))

        // if (self.includes) {
        //   params.includes = self.includes
        // }
        // if (self.refers) {
        //   params.refers = self.refers
        // }
        // self.schema.modelUnderscorePlural
        _.each(self.tabData, function(item, i) {
          request(item.table, {
            params: params
          }).then(resp => {
            console.log(resp.data)
            self.$set(item, 'column', resp.data)
          })
        })
        setTimeout(function() { console.log(self.tabData) }, 3000)
        // request('cc_meetings', {
        //   params: params
        // }).then(resp => {
        //   // if (resp.data.length !== 0 && resp.data[0].superior !== undefined && resp.data[0].includes !== undefined &&
        //   //   resp.data[0].refers !== undefined && resp.data[0].relates !== undefined) {
        //   //   self.list = []
        //   //   _.each(resp.data, function(item, index) {
        //   //     self.list.push(item.superior)
        //   //   })
        //   // } else {
        //   //   self.list = resp.data
        //   // }
        //   // self.list = resp.data
        //   console.log(resp.data)
        //   // 数据库字段转化显示
        //   // if (self.options && self.options.changeValue) {
        //   //   self.list = self.changeValue(self.list)
        //   // }
        // })
      }

    }
  }
</script>
<style scoped>

</style>
