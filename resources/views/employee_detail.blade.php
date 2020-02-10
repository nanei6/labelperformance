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
          prop="num"
          label="工号"
          width="180">
        </el-table-column>
        <el-table-column
          prop="date"
          label="入职日期">
        </el-table-column>
        <el-table-column
          prop="type"
          label="类型">
        </el-table-column>
        <el-table-column
          prop="groupName"
          label="组名">
        </el-table-column>
      </el-table>
    </el-row>
</br>
    <el-row>
        <div class="sub-title">当前参与的项目：A项目，B项目</div>
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
          prop="price"
          label="单价">
        </el-table-column>
        <el-table-column
          prop="endDate"
          label="结束日期">
        </el-table-column>
        <el-table-column
            prop="startDate"
            label="参与日期">
        </el-table-column>
        <el-table-column
            prop="yesterdayMarkProduce"
            label="前日标注产出">
            </el-table-column>
        <el-table-column
            prop="yesterdayCheckProduce"
            label="前日审核产出">
        </el-table-column>
        <el-table-column
            prop="markBase"
            label="标注基础量">
        </el-table-column>
        <el-table-column
            prop="checkBase"
            label="审核基础量">
        </el-table-column>
        <el-table-column
            prop="yesterdayMarkDayAvg"
            label="前日日均标注量">
        </el-table-column>
        <el-table-column
            prop="yesterdayMarkDayMax"
            label="前日最高标注量">
        </el-table-column>
      </el-table>
    </el-row>
</br>
    <!-- <div id="chart" style="width:100%;height:400px;"></div> -->
    <el-row>
        <div>近两周表现情况</div>
        <el-table
        :data="performence"
        border
        stripe
        style="width: 100%">
        <el-table-column
          prop="name"
          label="项目A"
          width="180">
        </el-table-column>
        <el-table-column
          prop="date1"
          label="12月1日">
        </el-table-column>
        <el-table-column
          prop="date2"
          label="12月2日">
        </el-table-column>
        <el-table-column
          prop="date3"
          label="12月3日">
        </el-table-column>
        <el-table-column
          prop="date4"
          label="12月4日">
        </el-table-column>
        <el-table-column
          prop="date5"
          label="12月5日">
        </el-table-column>
        <el-table-column
          prop="date6"
          label="12月6日">
        </el-table-column>
        <el-table-column
          prop="date7"
          label="12月7日">
        </el-table-column>
        <el-table-column
          prop="date8"
          label="12月8日">
        </el-table-column>
        <el-table-column
          prop="date9"
          label="12月9日">
        </el-table-column>
        <el-table-column
          prop="date10"
          label="12月10日">
        </el-table-column>
        <el-table-column
          prop="date11"
          label="12月11日">
        </el-table-column>
        <el-table-column
          prop="date12"
          label="12月12日">
        </el-table-column>
      </el-table>
    </el-row>
</br>
    <el-row>
        <div>本月情况（截止当前日期）</div>
        <el-table
        :data="data"
        border
        stripe
        style="width: 100%">
        <el-table-column
          prop="name"
          label="名称"
          width="180">
        </el-table-column>
        <el-table-column
          prop="markNum"
          label="标注量"
          width="180">
        </el-table-column>
        <el-table-column
          prop="checkNum"
          label="审核量">
        </el-table-column>
        <el-table-column
          prop="outputValue"
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
        :data="data"
        border
        stripe
        style="width: 100%">
        <el-table-column
          prop="name"
          label="名称"
          width="180">
        </el-table-column>
        <el-table-column
          prop="markNum"
          label="标注量"
          width="180">
        </el-table-column>
        <el-table-column
          prop="checkNum"
          label="审核量">
        </el-table-column>
        <el-table-column
          prop="outputValue"
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
  <script>
    new Vue({
      el: '#app',
      data: function() {
        return { 
            visible: false,
            employeeData:[{name:'张三',date:'2019-10-10',num:'123',type:'A',groupName:'A组'} ],
            projectData:[{name:'张三',startDate:'2019-10-10',endDate:'2019-10-10',price:'100',yesterdayMarkProduce:'100',yesterdayCheckProduce:'100',markBase:'10',checkBase:'10',yesterdayMarkDayAvg:'100',yesterdayMarkDayMax:'100'} ],
            data:[{name:'项目A',markNum:'100',checkNum:'100',outputValue:'100',salary:'10000'}],
            performence:[{name:'标注量',date1:'100框',date2:'100框',date3:'100条',date4:'100',date5:'100',date6:'100',date7:'100',date8:'100',date9:'100',date10:'100',date11:'100',date12:'100'},
            {name:'审核量',date1:'100框',date2:'100框',date3:'100条',date4:'100',date5:'100',date6:'100',date7:'100',date8:'100',date9:'100',date10:'100',date11:'100',date12:'100'},
            {name:'产值',date1:'100元',date2:'100元',date3:'100元',date4:'100',date5:'100',date6:'100',date7:'100',date8:'100',date9:'100',date10:'100',date11:'100',date12:'100'}]
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
<script src="//unpkg.com/vue/dist/vue.js"></script>
<script src="//unpkg.com/element-ui@2.13.0/lib/index.js"></script>
<div id="app">
<template>
    <el-table
      :data="tableData"
      style="width: 100%">
      <el-table-column
        prop="date"
        label="日期"
        width="180">
      </el-table-column>
      <el-table-column
        prop="name"
        label="姓名"
        width="180">
      </el-table-column>
      <el-table-column
        prop="address"
        label="地址">
      </el-table-column>
    </el-table>
  </template>
</div>