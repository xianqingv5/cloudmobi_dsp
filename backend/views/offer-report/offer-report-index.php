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
            start-placeholder="Start"
            end-placeholder="End"
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
          <div class='tab-btn' @click='choiceMain("payout")' :class='{act:mainChoice === "payout"}'>Payout</div>
          <div class='tab-btn' @click='choiceMain("conversion")' :class='{act:mainChoice === "conversion"}'>Conversion</div>
          <div class='tab-btn' @click='choiceMain("click")' :class='{act:mainChoice === "click"}'>Click</div>
          <div class='tab-btn' @click='choiceMain("cvr")' :class='{act:mainChoice === "cvr"}'>CVR</div>
        </div>
        <div class='conBox'>
          <div class='mainReport' id='mainReport' style='width: 100%;height: 500px;'></div>
        </div>
      </div>
      <!-- table -->
      <div class='reportTableBox'>
        <el-table
          class='reportTable'
          :data="judeTableData"
          style="width: 100%"
          :default-sort = "{prop: 'date', order: 'descending'}"
          >
          <el-table-column
            prop="day"
            label="Date"
            sortable>
          </el-table-column>
          <el-table-column
            prop="payout"
            label="Payout"
            sortable>
          </el-table-column>
          <el-table-column
            prop="conversion"
            label="Conversion"
            sortable>
          </el-table-column>
          <el-table-column
            prop="click"
            label="Click"
            sortable>
          </el-table-column>
          <el-table-column
            prop="cvr"
            label="CVR"
            sortable>
          </el-table-column>
        </el-table>
      </div>
      <!-- report -->
      <div class='mt-20 flex'>
        <div class='col-auto-12 mr-10 border-1 p20'>
          <h4>TOP 10 Countris</h4>
          <div class='chartBox'>
            <div class='tabBox flex mt-20'>
              <div class='tab-btn' @click='choiceCountris("conversion")' :class='{act:countrisChoice === "conversion"}'>Conversion</div>
              <div class='tab-btn' @click='choiceCountris("payout")' :class='{act:countrisChoice === "payout"}'>payout</div>
              <div class='tab-btn' @click='choiceCountris("click")' :class='{act:countrisChoice === "click"}'>Click</div>
              <div class='tab-btn' @click='choiceCountris("cvr")' :class='{act:countrisChoice === "cvr"}'>CVR</div>
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
              <div class='tab-btn' @click='choiceCampaigns("conversion")' :class='{act:campaignsChoice === "conversion"}'>Conversion</div>
              <div class='tab-btn' @click='choiceCampaigns("click")' :class='{act:campaignsChoice === "click"}'>Click</div>
              <div class='tab-btn' @click='choiceCampaigns("payout")' :class='{act:campaignsChoice === "payout"}'>Payout</div>
              <div class='tab-btn' @click='choiceCampaigns("cvr")' :class='{act:campaignsChoice === "cvr"}'>CVR</div>
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
  var mainData = {
    tooltip: {
      trigger: 'axis'
    },
    legend: {},
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
      data: []
    },
    yAxis: {
        type: 'value'
    },
    series: [
      {
        type:'line',
        data:[]
      }
    ]
  }
  var countryData = {
    tooltip: {},
    legend: {},
    xAxis: {
        data: []
    },
    yAxis: {},
    series: [{
        type: 'bar',
        data: []
    }]
  }
  var campaignsData = {
    title: {
      text: '折线图堆叠'
    },
    tooltip: {
      trigger: 'axis'
    },
    legend: {
      data:['邮件营销']
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
      data: []
    },
    yAxis: {
        type: 'value'
    },
    series: [
      {
        name:'邮件营销',
        type:'line',
        stack: '总量',
        data:[]
      }
    ]
  }
  var mainReport, countryReport, campaignsReport
  // 
  new Vue({
    el: '.app',
    data () {
      return {
        power: power,
        csrf: '',
        mainChoice: 'payout',
        mainData: {},
        countrisChoice: 'conversion',
        campaignsChoice: 'conversion',
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
        tableData: []
      }
    },
    mounted () {
      this.csrf = document.querySelector('#spp_security').value
      mainReport = echarts.init(document.querySelector('#mainReport'))
      countryReport = echarts.init(document.querySelector('#countrisReport'))
      campaignsReport = echarts.init(document.querySelector('#campaignsReport'))
      this.initData()
      this.choiceCountris('conversion')
      this.choiceCampaigns('conversion')
    },
    computed: {
      judeTableData () {
        var that  = this
        var arr = []
        if (this.mainData['day']) {
          this.mainData.day.map(function (ele, i) {
            arr.push({
              day: ele,
              payout: that.mainData.payout[i],
              conversion: that.mainData.conversion[i],
              click: that.mainData.click[i],
              cvr: that.mainData.cvr[i]
            })
          })
        }
        return arr
      }
    },
    methods: {
      searchFun () {

      },
      choiceMain (i) {
        this.mainChoice = i
        mainData.series[0].data = this.mainData[this.mainChoice]
        this.getReport(mainReport, mainData)
      },
      choiceCountris (i) {
        var that = this
        this.countrisChoice = i
        // country
        $.ajax({
          url: '/offer-report/country-top-bar',
          type: 'get',
          data: {
            field: that.countrisChoice
          },
          success: function (result) {
            if (result.status === 1) {
              that.countryData = result.data
              countryData.xAxis.data = result.data.name
              countryData.series[0].data = result.data.fields
              that.getReport(countryReport, countryData)
            }
          }
        })
      },
      choiceCampaigns (i) {
        var that = this
        this.campaignsChoice = i
        // campaigns
        $.ajax({
          url: '/offer-report/offer-line',
          type: 'get',
          data: {
            field: that.campaignsChoice
          },
          success: function (result) {
            console.log(result)
             if (result.status === 1) {
               that.campaignsData = result.data
               campaignsData.xAxis.data = result.data.name
               result.data.data.map(function (ele) {
                 countryData.series.push({
                   name: ele.name,
                   type: 'line',
                   data: ele.data
                 })
               })
               that.getReport(campaignsReport, campaignsData)
             }
          }
        })
      },
      formatter(row, column) {
        return row.address;
      },
      initData () {
        var that= this
        // mainReport
        $.ajax({
          url: '/offer-report/offer-report-data',
          type: 'get',
          success: function (result) {
            // console.log(result)
            if (result.status === 1) {
              that.mainData = result.data
              mainData.xAxis.data = result.data.day
              that.choiceMain('payout')
            }
          }
        })
      },
      getReport (dom, data) {
        dom.setOption(data)
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