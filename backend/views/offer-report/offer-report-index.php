<div class='app'>
  <div class='breadcrumbDocker w100 flex flex-row-flex-start-center'>
    <el-breadcrumb separator-class="el-icon-arrow-right">
      <el-breadcrumb-item><a href="/offer/offer-index">Offer</a></el-breadcrumb-item>
      <el-breadcrumb-item>Index</el-breadcrumb-item>
    </el-breadcrumb>
  </div>
  <div class='flex jcsb p30'>
    <h3>REPORT</h3>
    <a href="/offer/offer-create" class='base-color'><el-button type="primary">New Campaign</el-button></a>
  </div>
  <div class='content'>
    <div class='contentBox'>
      <div class='searchBox flex jcsb mb-20'>
        <div>
          <div class='mb-20'>
            <h4>Date Range</h4>
          </div>
          <el-date-picker
            @change='searchFun'
            v-model="search.date"
            type="daterange"
            range-separator="-"
            start-placeholder="开始日期"
            end-placeholder="结束日期"
            value-format="yyyy-MM-dd"
            >
          </el-date-picker>
        </div>
        <div>
          <div class='mb-20'>
            <h4>Campaigns</h4>
          </div>
          <el-select @change='searchFun' v-model="search.campaigns" multiple placeholder="All Campaigns">
            <el-option
              v-for="item in options.campaigns"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </div>
        <div>
          <div class='mb-20'>
            <h4>Countries</h4>
          </div>
          <el-select @change='searchFun' v-model="search.country" multiple placeholder="All Countries">
            <el-option
              v-for="item in options.country"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </div>
        <div>
          <div class='mb-20'>
            <h4>Campaigns Owner</h4>
          </div>
          <el-select @change='searchFun' v-model="search.campaignsOwner" multiple placeholder="All Campaigns Owner">
            <el-option
              v-for="item in options.campaignsOwner"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </div>
      </div>
      <div class='chartBox'>
        <div class='tabBox flex'>
          <div class='tab-btn' @click='choiceMain(1)' :class='{act:mainChoice == 1}'>Payout</div>
          <div class='tab-btn' @click='choiceMain(2)' :class='{act:mainChoice == 2}'>Conversion</div>
          <div class='tab-btn' @click='choiceMain(3)' :class='{act:mainChoice == 3}'>Click</div>
          <div class='tab-btn' @click='choiceMain(4)' :class='{act:mainChoice == 4}'>CVR</div>
        </div>
        <div class='conBox'>
          <div class='mainReport' id='mainReport' style='width: 100%;height: 500px;'></div>
        </div>
      </div>
      <!-- table -->
      <div class='reportTableBox'>
        <el-table
          class='reportTable'
          :data="tableData"
          style="width: 100%"
          :default-sort = "{prop: 'date', order: 'descending'}"
          >
          <el-table-column
            prop="date"
            label="日期"
            sortable>
          </el-table-column>
          <el-table-column
            prop="name"
            label="姓名"
            sortable>
          </el-table-column>
          <el-table-column
            prop="address"
            label="地址"
            :formatter="formatter">
          </el-table-column>
        </el-table>
      </div>
      <!-- report -->
      <div class='mt-20 flex'>
        <div class='col-auto-12 mr-10 border-1 p20'>
          <h4>TOP 10 Countris</h4>
          <div class='chartBox'>
            <div class='tabBox flex mt-20'>
              <div class='tab-btn' @click='choiceCountris(1)' :class='{act:countrisChoice == 1}'>Conversion</div>
              <div class='tab-btn' @click='choiceCountris(2)' :class='{act:countrisChoice == 2}'>payouot</div>
              <div class='tab-btn' @click='choiceCountris(3)' :class='{act:countrisChoice == 3}'>Click</div>
              <div class='tab-btn' @click='choiceCountris(4)' :class='{act:countrisChoice == 4}'>CVR</div>
            </div>
            <div class='pt-20'>
              <div class='countrisReport' id='countrisReport' style='width: 100%;height: 500px;'></div>
            </div>
          </div>
        </div>
        <div class='col-auto-12 ml-10 border-1 p20'>
          <h4>TOP 10 Campaigns</h4>
          <div class='chartBox'>
            <div class='tabBox flex mt-20'>
              <div class='tab-btn' @click='choiceCampaigns(1)' :class='{act:campaignsChoice == 1}'>Conversion</div>
              <div class='tab-btn' @click='choiceCampaigns(2)' :class='{act:campaignsChoice == 2}'>Click</div>
              <div class='tab-btn' @click='choiceCampaigns(3)' :class='{act:campaignsChoice == 3}'>Payout</div>
              <div class='tab-btn' @click='choiceCampaigns(4)' :class='{act:campaignsChoice == 4}'>CVR</div>
            </div>
            <div class='pt-20'>
              <div class='campaignsReport' id='campaignsReport' style='width: 100%;height: 500px;'></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
var power = JSON.parse('<?= $this->params['view_group'] ?>')
console.log(power)
  new Vue({
    el: '.app',
    data () {
      return {
        power: power,
        csrf: '',
        mainChoice:1,
        countrisChoice: 1,
        campaignsChoice: 1,
        options: {
          campaigns: [],
          country: [],
          campaignsOwner: []
        },
        search: {
          date: '',
          campaigns: [],
          country: [],
          campaignsOwner: []
        },
        tableData: [{
          date: '2016-05-02',
          name: '王小虎',
          address: '上海市普陀区金沙江路 1518 弄'
        }, {
          date: '2016-05-04',
          name: '王小虎',
          address: '上海市普陀区金沙江路 1517 弄'
        }, {
          date: '2016-05-01',
          name: '王小虎',
          address: '上海市普陀区金沙江路 1519 弄'
        }, {
          date: '2016-05-03',
          name: '王小虎',
          address: '上海市普陀区金沙江路 1516 弄'
        }]
      }
    },
    mounted () {
      this.csrf = document.querySelector('#spp_security').value
      this.getReport()
    },
    methods: {
      searchFun () {

      },
      choiceMain (i) {
        this.mainChoice = i
      },
      choiceCountris (i) {
        this.countrisChoice = i
      },
      choiceCampaigns (i) {
        this.campaignsChoice = i
      },
      formatter(row, column) {
        return row.address;
      },
      getReport () {
        option = {
            title: {
                text: '折线图堆叠'
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data:['邮件营销','联盟广告']
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
                data: ['周一','周二','周三','周四','周五','周六','周日']
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    name:'邮件营销',
                    type:'line',
                    stack: '总量',
                    data:[120, 132, 101, 134, 90, 230, 210]
                },
                {
                    name:'联盟广告',
                    type:'line',
                    stack: '总量',
                    data:[220, 182, 191, 234, 290, 330, 310]
                }
            ]
        };
        // mainReport
        var mainReport = echarts.init(document.querySelector('#mainReport')) 
        mainReport.setOption(option)
        // mainReport
        var countrisReport = echarts.init(document.querySelector('#countrisReport')) 
        countrisReport.setOption(option)
        // campaignsReport
        var campaignsReport = echarts.init(document.querySelector('#campaignsReport')) 
        campaignsReport.setOption(option)
      }
    }
  })
</script>
<style>
  .tabBox{
    font-weight: bold;
  }
  .tab-btn{
    width: 100%;
    text-align: center;
    border: 1px solid #dcdfe6;
    border-right: 0;
    padding: 10px 0;
  }
  .tab-btn:last-child{
    border-right: 1px solid #dcdfe6;
  }
  .conBox{
    width:  100%;
    padding: 20px;
    border: 1px solid #dcdfe6;
    border-top: 0;
  }
  .mainReport{
    
  }
  .reportTable{
    border: 1px solid #dcdfe6;
    margin-top: 20px;
  }
  .el-table th{
    text-align: center;
  }
  .act{
    background: #409EFF;
    border-color: #409EFF;
    color: #fff;
  }
</style>