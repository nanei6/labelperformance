<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <!-- import CSS -->
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
    <!-- import Vue before Element -->
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>
    <!-- <script src="https://cdn.bootcss.com/echarts/4.2.1-rc1/echarts.min.js"></script> -->
</head>
<body>
<div id="app">
    <el-row>
        <el-table
                :data="projectData1"
                border
                stripe
                style="width: 100%">
            <el-table-column
                    prop="name"
                    label="项目名称">
            </el-table-column>
            <el-table-column
                    prop="id"
                    label="项目id">
            </el-table-column>
            <el-table-column
                    prop="source"
                    label="项目来源">
            </el-table-column>
            <el-table-column
                    prop="accuracy_rate"
                    label="准确率要求">
            </el-table-column>
            <el-table-column
                    prop="estimated_count"
                    label="项目总量">
            </el-table-column>
            <el-table-column
                    prop="unit_price"
                    label="项目单价">
            </el-table-column>
        </el-table>
    </el-row>
    </br>
    <el-row>
        <el-table
                :data="projectData1"
                border
                stripe
                style="width: 100%">
            <el-table-column
                    prop="summary"
                    label="项目简介">
            </el-table-column>
        </el-table>
    </el-row>
    </br>
    <el-row>
        <el-table
                :data="projectData1"
                border
                stripe
                style="width: 100%">
            <el-table-column
                    prop="manager"
                    label="项目经理">
            </el-table-column>
            <el-table-column
                    prop="checkers"
                    label="审核员">
            </el-table-column>
            <el-table-column
                    prop="speed_test"
                    label="测速员">
            </el-table-column>
            <el-table-column
                    prop="label_unit_price"
                    label="标注单价">
            </el-table-column>
            <el-table-column
                    prop="check_unit_price"
                    label="审核单价">
            </el-table-column>
        </el-table>
    </el-row>
    </br>
    <el-row>
        <el-table
                :data="projectData1"
                border
                stripe
                style="width: 100%">
            <el-table-column
                    prop="start_time"
                    label="开始时间">
            </el-table-column>
            <el-table-column
                    prop="estimated_time"
                    label="预计结束时间">
            </el-table-column>
            <el-table-column
                    prop="finish_time"
                    label="实际结束时间">
            </el-table-column>
        </el-table>
    </el-row>
    </br>
    时间进度：
    <div>{{$time_progress}}</div>
    <div class="progress" style="height:20px;">
        <div class="progress-bar" style="width:{{$time_progress}};"></div>
    </div>
    </br>
    标注进度：
    <div>{{$label_progress}}</div>
</div>
<div class="progress" style="height:20px;">
    <div class="progress-bar" style="width:{{$label_progress}};"></div>
</div>
</br>
审核进度：
<div>{{$check_progress}}</div>
<div class="progress" style="height:20px;">
    <div class="progress-bar" style="width:{{$label_progress}};"></div>
</div>
</br>
<el-row>
    <div>标注量/天</div>
    <el-table
            :data="daily_total"
            border
            stripe
            style="width: 100%">
        <el-table-column
                prop="name"
                label="标注量/天"
                width="180">
        </el-table-column>
        <el-table-column
                prop="date1"
                label="{{$last_two_weeks[0]}}">
        </el-table-column>
        <el-table-column
                prop="date2"
                label="{{$last_two_weeks[1]}}">
        </el-table-column>
        <el-table-column
                prop="date3"
                label="{{$last_two_weeks[2]}}">
        </el-table-column>
        <el-table-column
                prop="date4"
                label="{{$last_two_weeks[3]}}">
        </el-table-column>
        <el-table-column
                prop="date5"
                label="{{$last_two_weeks[4]}}">
        </el-table-column>
        <el-table-column
                prop="date6"
                label="{{$last_two_weeks[5]}}">
        </el-table-column>
        <el-table-column
                prop="date7"
                label="{{$last_two_weeks[6]}}">
        </el-table-column>
        <el-table-column
                prop="date8"
                label="{{$last_two_weeks[7]}}">
        </el-table-column>
        <el-table-column
                prop="date9"
                label="{{$last_two_weeks[8]}}">
        </el-table-column>
        <el-table-column
                prop="date10"
                label="{{$last_two_weeks[9]}}">
        </el-table-column>
        <el-table-column
                prop="date11"
                label="{{$last_two_weeks[10]}}">
        </el-table-column>
        <el-table-column
                prop="date12"
                label="{{$last_two_weeks[11]}}">
        </el-table-column>
    </el-table>
</el-row>
</br>
<el-row>
    <div>产值最高TOP3</div>
    <el-table
            :data="top3"
            border
            stripe
            style="width: 100%">
        <el-table-column
                prop="name"
                label="姓名"
                width="180">
        </el-table-column>
        <el-table-column
                prop="label_total"
                label="标注量"
                width="180">
        </el-table-column>
        <el-table-column
                prop="label_days"
                label="标注天数">
        </el-table-column>
    </el-table>
</el-row>
</br>
<el-row>
    <div>产值最低TOP3</div>
    <el-table
            :data="bottom3"
            border
            stripe
            style="width: 100%">
        <el-table-column
                prop="name"
                label="姓名"
                width="180">
        </el-table-column>
        <el-table-column
                prop="label_total"
                label="标注量"
                width="180">
        </el-table-column>
        <el-table-column
                prop="label_days"
                label="标注天数">
        </el-table-column>
    </el-table>
</el-row>
</br>
<el-row>
    <el-form :label-position="right" label-width="350px">
        <el-form-item label="项目当前收入:">
            {{$revenue_data['current_total_income']}}
        </el-form-item>
        <el-form-item label="项目当前最大收入:">
            {{$revenue_data['current_total_income_max']}}
        </el-form-item>
        <el-form-item label="标注总人天数:">
            {{$revenue_data['label_total_user_day']}}
        </el-form-item>
        <el-form-item label="审核总人天数:">
            {{$revenue_data['check_total_user_day']}}
        </el-form-item>
        <el-form-item label="标注基础成本支出:">
            {{$revenue_data['label_base_cost']}}
        </el-form-item>
        <el-form-item label="审核基础成本支出:">
            {{$revenue_data['check_base_cost']}}
        </el-form-item>
        <el-form-item label="标注绩效支出:">
            {{$revenue_data['label_performance_cost']}}
        </el-form-item>
        <el-form-item label="审核绩效支出:">
            {{$revenue_data['check_performance_cost']}}
        </el-form-item>
        <el-form-item label="项目当前收益:">
            {{$revenue_data['current_revenue']}}
        </el-form-item>
        <el-form-item label="项目当前最大可能收益:">
            {{$revenue_data['current_revenue_max']}}
        </el-form-item>
        <el-form-item label="项目潜在标注绩效成本:">
            {{$revenue_data['label_potential_cost']}}
        </el-form-item>
        <el-form-item label="项目潜在审核绩效成本:">
            {{$revenue_data['check_potential_cost']}}
        </el-form-item>
        <el-form-item label="剩余标注人天数:">
            {{$revenue_data['surplus_label_user_day']}}
        </el-form-item>
        <el-form-item label="剩余审核人天数:">
            {{$revenue_data['surplus_check_user_day']}}
        </el-form-item>
        <el-form-item label="剩余标注基础成本:">
            {{$revenue_data['surplus_label_base_cost']}}
        </el-form-item>
        <el-form-item label="剩余审核基础成本:">
            {{$revenue_data['surplus_check_base_cost']}}
        </el-form-item>
        <el-form-item label="项目预计最终收益:">
            {{$revenue_data['project_estimated_finial_revenue']}}
        </el-form-item>
    </el-form>
</el-row>
</div>
</body>
<script>
    new Vue({
        el: '#app',
        data: function () {
            return {
                visible: false,
                projectData1: [{!!json_encode($project_data)!!} ],
                // projectData:[{name:'张三',startDate:'2019-10-10',endDate:'2019-10-10',price:'100',yesterdayMarkProduce:'100',yesterdayCheckProduce:'100',markBase:'10',checkBase:'10',yesterdayMarkDayAvg:'100',yesterdayMarkDayMax:'100'} ],
                top3:{!!json_encode($top3)!!} ,
                bottom3:{!!json_encode($bottom3)!!},
                daily_total:{!!json_encode($daily_total_format)!!}
            }
        }
    })
</script>
<!-- <script type="text/javascript">
// 初始化图表标签
var myChart = echarts.init(document.getElementById('chart'));
console.log(myChart)
var options={

  title: {
      text: '近两周表现情况'
  },
  tooltip: {
      trigger: 'axis'
  },
  legend: {
      data: ['邮件营销', '联盟广告', '视频广告',]
  },
  grid: {
      left: '3%',
      right: '4%',
      bottom: '3%',
      containLabel: true
  },
  toolbox: {
      feature: {
          saveAsImage: {}
      }
  },
  xAxis: {
      type: 'category',
      boundaryGap: false,
      data: ['12月1日', '12月2日', '12月3日', '12月4日', '12月5日', '12月6日', '12月7日']
  },
  yAxis: {
      type: 'value'
  },
  series: [
      {
          name: '标注量',
          type: 'line',
          stack: '总量',
          data: [120, 132, 101, 134, 90, 230, 210]
      },
      {
          name: '审核量',
          type: 'line',
          stack: '总量',
          data: [220, 182, 191, 234, 290, 330, 310]
      },
      {
          name: '产值',
          type: 'line',
          stack: '总量',
          data: [150, 232, 201, 154, 190, 330, 410]
      },
  ]

};
myChart.setOption(options);
</script> -->
</html>
