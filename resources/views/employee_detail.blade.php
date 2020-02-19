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
        <div class="sub-title">员工信息</div>
        <el-table
                :data="employeeData"
                border
                stripe
                style="width: 100%">
            <el-table-column
                    prop="name"
                    label="姓名"
                    width="180">
            </el-table-column>
            <el-table-column
                    prop="employee_number"
                    label="工号"
                    width="180">
            </el-table-column>
            <el-table-column
                    prop="entry_time"
                    label="入职日期">
            </el-table-column>
            <el-table-column
                    prop="type"
                    label="类型">
            </el-table-column>
            <el-table-column
                    prop="group"
                    label="组名">
            </el-table-column>
        </el-table>
    </el-row>
    </br>
    <el-row>
        <div class="sub-title">当前参与的项目：{{$current_project}}</div>
    </el-row>
    </br>
    <el-row>
        <div class="sub-title">当前项目情况：</div>
        <el-table
                :data="projectData"
                border
                stripe
                style="width: 100%">
            <el-table-column
                    prop="name"
                    label="名称">
            </el-table-column>
            <el-table-column
                    prop="unit_price"
                    label="单价">
            </el-table-column>
            <el-table-column
                    prop="join_time"
                    label="参与日期">
            </el-table-column>
            <el-table-column
                    prop="last_date"
                    label="上次日期">
            </el-table-column>
            <el-table-column
                    prop="last_label"
                    label="上次标注产出">
            </el-table-column>
            <el-table-column
                    prop="last_check"
                    label="上次审核产出">
            </el-table-column>
            <el-table-column
                    prop="last_daily_standard"
                    label="上次标注基础量">
            </el-table-column>
            <el-table-column
                    prop="last_standard_check"
                    label="上次审核基础量">
            </el-table-column>
            <el-table-column
                    prop="last_label_avg"
                    label="上次日均标注量">
            </el-table-column>
            <el-table-column
                    prop="last_label_max"
                    label="上次最高标注量">
            </el-table-column>
        </el-table>
    </el-row>
    </br>
    <!-- <div id="chart" style="width:100%;height:400px;"></div> -->
    <div>近两周表现情况</div>
    @foreach($performance as $key=>$value)
        <el-row>
            <el-table
                    :data="{{'a'.md5($key)}}"
                    border
                    stripe
                    style="width: 100%">
                <el-table-column
                        prop="name"
                        label="{{$key}}"
                        width="180">
                </el-table-column>
                <el-table-column
                        prop="date1"
                        label="{{array_keys($value)[0]}}">
                </el-table-column>
                <el-table-column
                        prop="date2"
                        label="{{array_keys($value)[1]}}">
                </el-table-column>
                <el-table-column
                        prop="date3"
                        label="{{array_keys($value)[2]}}">
                </el-table-column>
                <el-table-column
                        prop="date4"
                        label="{{array_keys($value)[3]}}">
                </el-table-column>
                <el-table-column
                        prop="date5"
                        label="{{array_keys($value)[4]}}">
                </el-table-column>
                <el-table-column
                        prop="date6"
                        label="{{array_keys($value)[5]}}">
                </el-table-column>
                <el-table-column
                        prop="date7"
                        label="{{array_keys($value)[6]}}">
                </el-table-column>
                <el-table-column
                        prop="date8"
                        label="{{array_keys($value)[7]}}">
                </el-table-column>
                <el-table-column
                        prop="date9"
                        label="{{array_keys($value)[8]}}">
                </el-table-column>
                <el-table-column
                        prop="date10"
                        label="{{array_keys($value)[9]}}">
                </el-table-column>
                <el-table-column
                        prop="date11"
                        label="{{array_keys($value)[10]}}">
                </el-table-column>
                <el-table-column
                        prop="date12"
                        label="{{array_keys($value)[11]}}">
                </el-table-column>
            </el-table>
        </el-row>
        </br>
        @endforeach
        </br>
    <el-row>
        <div>本月情况（截止当前日期）</div>
        <el-table
                :data="thisMonth"
                border
                stripe
                style="width: 100%">
            <el-table-column
                    prop="name"
                    label="名称"
                    width="180">
            </el-table-column>
            <el-table-column
                    prop="label_number"
                    label="标注量"
                    width="180">
            </el-table-column>
            <el-table-column
                    prop="check_number"
                    label="审核量">
            </el-table-column>
            <el-table-column
                    prop="output"
                    label="产值">
            </el-table-column>
            <el-table-column
                    prop="salary"
                    label="绩效工资">
            </el-table-column>
        </el-table>
    </el-row>
    </br>
    <el-row>
        <div>上月情况</div>
        <el-table
                :data="lastMonth"
                border
                stripe
                style="width: 100%">
            <el-table-column
                    prop="name"
                    label="名称"
                    width="180">
            </el-table-column>
            <el-table-column
                    prop="label_number"
                    label="标注量"
                    width="180">
            </el-table-column>
            <el-table-column
                    prop="check_number"
                    label="审核量">
            </el-table-column>
            <el-table-column
                    prop="output"
                    label="产值">
            </el-table-column>
            <el-table-column
                    prop="salary"
                    label="绩效工资">
            </el-table-column>
        </el-table>
    </el-row>
</div>
</body>
</html>
<script>
    new Vue({
        el: '#app',
        data: function () {
            return {
                visible: false,
                employeeData: [{!!json_encode($employeeData)!!} ],
                projectData:{!!json_encode($projectData)!!} ,
                thisMonth: {!!json_encode($this_month)!!},
                lastMonth: {!!json_encode($last_month)!!},
            @foreach($performance as $key=>$value)
            {{'a'.md5($key)}}:
            [{
                name: '标注量',
                date1: '{{array_values($value)[0]["daily_label"]}}',
                date2: '{{array_values($value)[1]["daily_label"]}}',
                date3: '{{array_values($value)[2]["daily_label"]}}',
                date4: '{{array_values($value)[3]["daily_label"]}}',
                date5: '{{array_values($value)[4]["daily_label"]}}',
                date6: '{{array_values($value)[5]["daily_label"]}}',
                date7: '{{array_values($value)[6]["daily_label"]}}',
                date8: '{{array_values($value)[7]["daily_label"]}}',
                date9: '{{array_values($value)[8]["daily_label"]}}',
                date10: '{{array_values($value)[9]["daily_label"]}}',
                date11: '{{array_values($value)[10]["daily_label"]}}',
                date12: '{{array_values($value)[11]["daily_label"]}}'
            },
             {
                    name: '审核量',
                    date1: '{{array_values($value)[0]["daily_check"]}}',
                    date2: '{{array_values($value)[1]["daily_check"]}}',
                    date3: '{{array_values($value)[2]["daily_check"]}}',
                    date4: '{{array_values($value)[3]["daily_check"]}}',
                    date5: '{{array_values($value)[4]["daily_check"]}}',
                    date6: '{{array_values($value)[5]["daily_check"]}}',
                    date7: '{{array_values($value)[6]["daily_check"]}}',
                    date8: '{{array_values($value)[7]["daily_check"]}}',
                    date9: '{{array_values($value)[8]["daily_check"]}}',
                    date10: '{{array_values($value)[9]["daily_check"]}}',
                    date11: '{{array_values($value)[10]["daily_check"]}}',
                    date12: '{{array_values($value)[11]["daily_check"]}}'
                },
             {
                    name: '产值',
                    date1: '{{array_values($value)[0]["output"]}}',
                    date2: '{{array_values($value)[1]["output"]}}',
                    date3: '{{array_values($value)[2]["output"]}}',
                    date4: '{{array_values($value)[3]["output"]}}',
                    date5: '{{array_values($value)[4]["output"]}}',
                    date6: '{{array_values($value)[5]["output"]}}',
                    date7: '{{array_values($value)[6]["output"]}}',
                    date8: '{{array_values($value)[7]["output"]}}',
                    date9: '{{array_values($value)[8]["output"]}}',
                    date10: '{{array_values($value)[9]["output"]}}',
                    date11: '{{array_values($value)[10]["output"]}}',
                    date12: '{{array_values($value)[11]["output"]}}'
                }],
            @endforeach
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

