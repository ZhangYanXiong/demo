<template>
  <div class="calendarlist">
    <i class="el-icon-date" @click="dialogTableVisible = true" :style="demoEvent.iconStyle"></i>
    <el-dialog :visible.sync="dialogTableVisible">
      <div class="datebook-root" :style='componentW?"width:"+componentW+";":""'>
        <div class='top-panel'>
          <ul>
            <li class='btn left-btn' @click='monthChange(-1)'></li>
            <li class='show-wrap'>{{showTimeStr}}</li>
            <li class='btn right-btn' @click='monthChange(1)'></li>
          </ul>
        </div>
        <div class='item-wrap'>
          <div class="week-day">
            <span>日</span>
            <span>一</span>
            <span>二</span>
            <span>三</span>
            <span>四</span>
            <span>五</span>
            <span>六</span>
          </div>
          <ul class="date-item-wrap">
            <li v-for='(day,index) in dateItems' :class="'date-item '+day.classStr" :key='"day_"+index' @click='dateChange(day)'>
              <span class='item-content'>{{day.content}}</span>
            </li>
          </ul>
        </div>
      </div>
      <div v-if="show" class="incident">
        <p>{{currentDate}}</p>
        <p v-for="event in allEvents">{{event}}</p>
        <span class="close" @click="closeEvent">X</span>
      </div>
    </el-dialog>
  </div>
  
</template>
<style>
  ul li{
    list-style: none;
  }
  .datebook-root{
    box-sizing:border-box;
    width: 280px;
    border:1px solid #ececec;
    display: inline-block;
  }
  .datebook-root .top-panel{
    padding-top: 10px;
    width: 100%;
  }
  .datebook-root .top-panel ul{
    overflow: hidden;
    padding-left: 0px;
  }
  .datebook-root .top-panel li{
    float: left;
  }
  .datebook-root .top-panel li.btn{
    width: 20%;
    height: 40px;
    line-height: 40px;
    cursor: pointer;
  }
  .datebook-root .top-panel li.btn:before{
    content: '';
    display: block;
    width: 10px;
    height: 10px;
    border-style: solid;
    border-width: 1px;
    border-color: #999 #999 transparent transparent ;
    margin:15px auto;
  }
  .datebook-root .top-panel li.left-btn:before{
    transform: rotate(-135deg);
  }
  .datebook-root .top-panel li.right-btn:before{
    transform: rotate(45deg);
  }
  .datebook-root .top-panel li.show-wrap{
    width: 60%;
    height: 40px;
    line-height: 40px;
    color: #999 ;
    font-size: 14px;
    text-align: center;
  }
  .datebook-root .item-wrap{
    box-sizing:border-box;
    width: 100%;
    padding: 6px;
  }
  .datebook-root .week-day{
    width: 100%;
    overflow: hidden;
  }
  .datebook-root .week-day span{
    display: block;
    float: left;
    width: 14.2857%;
    height: 36px;
    line-height: 36px;
    text-align: center;
    font-size: 14px;
    color: #999;
  }
  .datebook-root .date-item-wrap{
    width: 100% ;
    padding:10px 0;
    overflow: hidden;
  }
  .datebook-root .date-item{
    box-sizing:border-box;
    float: left;
    width: 14.2857%;
    height: 0;
    padding-bottom: 14.2857%;
    margin: 2px 0;
    font-size: 14px;
    text-align: center;
    user-select:none;
    position: relative;
    cursor: pointer;
  }
  .datebook-root .date-item .item-content{
    box-sizing:border-box;
    position: absolute;
    width: 20px;
    height: 20px;
    line-height: 20px;
    padding: 0;
    border: none;
    left: 50%;
    top: 50%;
    -webkit-transform:translate(-50%,-50%);
    -moz-transform:translate(-50%,-50%);
    -ms-transform:translate(-50%,-50%);
    -o-transform:translate(-50%,-50%);
    transform:translate(-50%,-50%);
  }
  
  .datebook-root .date-item.empty{
    cursor: auto;
  }
  .datebook-root .date-item.today:before{
    content: '';
    display: block;
    width: 12px;
    height: 5px;
    position: absolute;
    bottom: 3px;
    left: 50%;
    margin-left: -6px;
    background: #2db7f5;
    border-radius: 50%;
    opacity: .5 ;
  }
  .datebook-root .date-item.schedule:after{
    content: '';
    display: block;
    box-sizing:border-box;
    width: 100%;
    height: 100%;
    border:1px solid #2db7f5;
    border-radius: 50%;
    opacity: .5;
    position: absolute;
    left: 0;
    top: 0;
    cursor: pointer;
  }
  .datebook-root .date-item.schedule.active{
    color: #333;
  }
  .datebook-root .date-item.schedule.active:after{
    background: #2db7f5 ;
  }
  .incident{
    vertical-align: top;
    width: 300px;
    display:inline-block;
    background-color:#202020;
    height:428px;
    position: relative;
    overflow: scroll;
    text-align: center;
    /*padding:20px;*/
    color:#CCC;
    /*text-align:center;*/
    /*font-size:14px;*/
    /*font-family:微软雅黑;*/
    /*border-radius:10px;*/
    /*margin:50px;*/
    /*box-shadow:1px 1px 2px #202020;*/
    /*-o-box-shadow:1px 1px 2px #202020;*/
    /*-moz-box-shadow:1px 1px 2px #202020;*/
    /*-webkit-border-shadow:1px 1px 2px #202020;*/
  }
  .close{
    position: absolute;
    top:0;
    cursor: pointer;
    right:0;
  }
  .incident span {
    color: white;
    font-size: 10px;
    padding: 10px 20px;
  }
  .incident:before{
    /*content:'';*/
    /*position:absolute;*/
    /*width:0;*/
    /*height:0;*/
    /*border:15px solid;*/
    /*color:transparent;*/
    /*border-right-color:#202020;*/
    /*left:-30px;*/
    /*top:50%;*/
    /*margin-top:-15px;*/
  }
</style>
<script>
  /**
  /* 选项参数：
		* width: 控制宽度，值为带单位的字符串，例如‘400px’，可不传，默认280px ；
		* schedules：行程安排数据（数组）格式如下：
			* [
			* 	{
			* 		date:12212220000,//日期时间戳
			* 		title:'xxxxxx',//行程标题
			* 		//更多其他字段，随意，事件发生时将全部回传。
			* 	  event:[{
			*
			* 	  }]
			* 	},
			* 	{
			* 		date:12242220000,//日期时间戳
			* 		title:'xxxxxx',//行程标题
			* 		//更多其他字段，随意。
			* 	}
			* ]
			*
		*initTime：初始化时间（时间戳格式），页面载入时展示该时间所在月份的日历，可不传，默认展示当前系统时间
		*dateChange事件：用户点击一个带有日程安排的日期时触发（重复点击同一日期仅触发一次），将返回该日程数据；
		*monthChange事件，切换月份时触发，刷新日历显示，并传回当前月份的数组，包含该月第一天的0:0:0 和 该月最后一天的23:59:59 的时间戳，例如，7月，返回 [1498838400000,1501516799000] ,对应：Sat Jul 01 2017 00:00:00 GMT+0800 (中国标准时间) 和 Mon Jul 31 2017 23:59:59 GMT+0800 (中国标准时间)
	 */
  import request from '@/utils/request'
  import _ from 'lodash'
  import moment from 'moment'
  export default{
    data() {
      return {
        componentW: '', // 组件宽度
        showTimeData: '', // 展示时间,时间戳格式
        dateItems: '', // 当前月份所有日期的数据
        dialogTableVisible: false,
        show: false,
        eventTitle: '',
        currentDate: '',
        allEvents: '',
        schedules: []
      }
    },
    props: {
      schema: {
        type: Object,
        required: true
      },

      initTime: {
        required: false
      },
      demoEvent: {
        type: Object,
        required: false
      }
    },
    computed: {
      showTimeStr() {
        var result = ''
        if (this.showTimeData) {
          var dateObj = new Date(this.showTimeData)
          var year = dateObj.getFullYear()
          var month = dateObj.getMonth() + 1
          var monthStr = month > 9 ? month : '0' + month
          result = year + '-' + monthStr
        }
        return result
      }
    },
    watch: { // 监控showTimeDate和schedules ; 其中任何一个改变，都要执行刷新日历面板的操作。
      showTimeData: {// 负责刷新当前展示的月份数据
        handler() {
          if (this.showTimeData) {
            var dateObj = new Date(this.showTimeData)
            this.madePanel(dateObj)
          }
        },
        deep: true
      },
      schedules: { // 负责刷新当前月份的日程安排
        handler() {
          if (this.schedules) {
            var dateObj = new Date(this.showTimeData)
            this.madePanel(dateObj)
          }
        },
        deep: true
      }
    },
    methods: {
      initData() {
        this.componentW = this.width || ''
        this.showTimeData = this.initTime || new Date().getTime()
      },
      madePanel(dateObj) {
        // console.log('madePanel执行了')
        if (!dateObj) {
          return
        }
        // 今天的年月日
        var now = new Date()
        var nowYear = now.getFullYear()
        var nowMonth = now.getMonth()
        var nowDay = now.getDate()
        // 传入的dateObj的年月日
        var year = dateObj.getFullYear()
        var month = dateObj.getMonth()
        //        var day = dateObj.getDate()
        // 本月拥有的总天数
        var totalDays = new Date(year, month + 1, 0).getDate()
        // 本月第一天是星期几：
        var firstDay = new Date(year, month, 1).getDay()
        // 循环生成本月的日期数据，固定生成42个，即6个星期的；
        var arr = []
        for (var i = 0; i < 42; i++) {
          if (i < firstDay) { // 在第一天之前，为空span占位
            var dayObj = {
              content: null,
              schedule: null,
              active: false,
              today: false,
              classStr: 'empty'
            }
            arr.push(dayObj)
          } else if (i >= firstDay && i < (totalDays + firstDay)) {
            if (year === nowYear && month === nowMonth && (i - firstDay + 1) === nowDay) { // 年月日和now相同，即为‘今天’
              dayObj = {
                content: i - firstDay + 1,
                schedule: null,
                active: false,
                today: true,
                classStr: 'today'
              }
            } else {
              dayObj = {
                content: i - firstDay + 1,
                schedule: null,
                active: false,
                today: false,
                classStr: ''
              }
            }
            // 添加schedules数据
            if (this.schedules && this.schedules.length > 0) {
              for (var j = 0; j < this.schedules.length; j++) {
                var schedule = this.schedules[j]
                var scheduleDate = new Date(schedule.date)
                var scheduleYear = scheduleDate.getFullYear()
                var scheduleMonth = scheduleDate.getMonth()
                var scheduleDay = scheduleDate.getDate()
                if (year === scheduleYear && month === scheduleMonth && (i - firstDay + 1) === scheduleDay) {
                  dayObj.schedule = schedule
                  dayObj.classStr += ' schedule'
                }
              }
            }
            arr.push(dayObj)
          } else { // 余下的还是空span占位
            const dayObj = {
              content: null,
              schedule: null,
              active: false,
              today: false,
              classStr: 'empty'
            }
            arr.push(dayObj)
          }
        }
        this.dateItems = arr
      },
      dateChange(dateItem) {
        this.show = true
        // console.log(dateItem, '-=-=-=-=-=-=-=-=-')
        var dateObj = new Date(this.showTimeData)
        var year = dateObj.getFullYear()
        var month = dateObj.getMonth()
        var day = parseInt(dateItem.content)
        var begin = new Date(year, month, day, 0, 0, 0).getTime()
        var end = new Date(year, month, day, 23, 59, 59).getTime()
        var result = {
          date: [begin, end],
          schedule: dateItem.schedule
        }
        if (!dateItem.schedule) { // 点击没有行程的，不作反应
          // console.log(result,'-=-=-=-=')
          if (result.schedule) {
            const currentTime = this.timestampToTime(result.schedule.date)
            // console.log(currentTime)
            this.currentDate = currentTime
            this.event = result.schedule.title
          }
          // this.$emit('dateChange', result)
          return
        } else {
          if (!dateItem.active) { // 未激活行程提示的，则激活该行程，其他行程不激活
            if (this.showActive) {
              // 循环清除所有的active状态
              for (var i = 0; i < this.dateItems.length; i++) {
                if (this.dateItems[i].active) {
                  this.dateItems[i].active = false
                  this.dateItems[i].classStr = this.dateItems[i].classStr.replace('active', '').replace(/^\s+|\s+$/g, '')
                } else {
                  continue
                }
              }
              // 当前行程添加active状态
              dateItem.active = !dateItem.active
              dateItem.classStr += ' active'
            } else {
              // 不需要展示active类（active状态还是要加的，数据上区分被激活和未被激活，激活的再次点击是无效的）
              for (i = 0; i < this.dateItems.length; i++) {
                if (this.dateItems[i].active) {
                  this.dateItems[i].active = false
                } else {
                  continue
                }
              }
              // 当前行程添加active状态
              dateItem.active = !dateItem.active
            }
            // 向上发送本次点击的行程数据
            // console.log(result, '--------------------')
            if (result.schedule) {
              const currentTime = this.timestampToTime(result.schedule.date)
              this.currentDate = currentTime
              this.eventTitle = result.schedule.title
              this.allEvents = result.schedule.allEvents
            }
            // this.$emit('dateChange', result)
          } else { // 已激活行程提示的，不作反应
            return
          }
        }
      },
      monthChange(step) {
        var curDate = new Date(this.showTimeData)
        var newDate = curDate.setMonth(curDate.getMonth() + step)
        this.showTimeData = newDate
        // 计算开始时间和结束时间
        var dateObj = new Date(newDate)
        var year = dateObj.getFullYear()
        var month = dateObj.getMonth()
        var totalDays = new Date(year, month + 1, 0).getDate() // 该月份共有多少天。
        var begin = new Date(year, month, 1, 0, 0, 0)
        var end = new Date(year, month, totalDays, 23, 59, 59)
        this.$emit('monthChange', [begin.getTime(), end.getTime()])
      },
      closeEvent() {
        this.show = false
      },
      timestampToTime(timestamp) {
        var date = new Date(timestamp) // 时间戳为10位需*1000，时间戳为13位的话不需乘1000
        const Y = date.getFullYear() + '年'
        const M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '月'
        const D = date.getDate() + '日'
        return Y + M + D
      },
      getDailyEvent() {
        const self = this
        var saveTime = ''
        var filterparams = self.demoEvent.filterparams
        request(self.schema.modelUnderscorePlural, {
          params: { 'sortItem': self.demoEvent.timeOrder, 'pageSize': 10000, filters: filterparams }
        }).then(resp => {
          console.log(resp.data, '=========')
          _.each(resp.data, function(item) {
            item.time = moment(item[self.demoEvent.date]).format('YYYY-MM-DD')
            item.date = moment(item[self.demoEvent.date]).format('X') * 1000
            item.title = item[self.demoEvent.title]
            item.allEvents = item[self.demoEvent.events]
            if (saveTime === item.time) {
              self.schedules[self.schedules.length - 1].allEvents.push(item.allEvents)
            } else {
              saveTime = item.time
              self.schedules.push({
                date: item.date,
                title: item.title,
                allEvents: [item.allEvents]
              })
            }
          })
        })
        // console.log(self.schedules, '+++++最终+++++++++')
      }
    },
    created() {
      this.getDailyEvent()
    },
    mounted() {
      this.initData()
    }
  }
</script>
