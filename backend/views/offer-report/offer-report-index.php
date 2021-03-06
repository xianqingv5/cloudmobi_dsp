<div class='app'>
  <div class='content mt-30'>
    <div class='contentBox'>
      <div >
        <form id='downloadReport' class='searchBox flex jcsb mb-20' action="/offer-report/download-report">
          <div>
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
          <template v-for='obj in search.date'>
            <input type="hidden" name="date[]" :value='obj'>
          </template>
        </div>
        <div>
          <el-select filterable @change='searchFun' v-model="search.campaigns" multiple placeholder="All Campaigns">
            <el-option
              v-for="item in options.campaigns"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
          <template v-for='obj in search.campaigns'>
            <input type="hidden" name="campaigns[]" :value='obj'>
          </template>
        </div>
        <div>
          <el-select filterable @change='searchFun' v-model="search.country" multiple placeholder="All Countries">
            <el-option
              v-for="item in options.country"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
          <template v-for='obj in search.country'>
            <input type="hidden" name="country[]" :value='obj'>
          </template>
        </div>
        <div v-if='power.campaigns_owner.show'>
          <el-select filterable @change='searchFun' v-model="search.campaignsOwner" multiple placeholder="All Campaigns Owner">
            <el-option
              v-for="item in options.campaignsOwner"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
          <template v-for='obj in search.campaignsOwner'>
            <input type="hidden" name="campaigns_owner[]" :value='obj'>
          </template>
        </div>
        <el-button @click='downloadTable' type="primary">Export<i class="el-icon-download el-icon--right"></i></el-button>
        </form>
      </div>
      <div class='chartBox'>
        <div class='tabBox flex'>
          <div class='tab-btn' @click='choiceMain("conversion")' :class='{act:mainChoice === "conversion"}'>Conversion</div>
          <div class='tab-btn' v-if='power.payout.show' @click='choiceMain("payout")' :class='{act:mainChoice === "payout"}'>Payout</div>
          <div class='tab-btn' @click='choiceMain("click")' :class='{act:mainChoice === "click"}'>Click</div>
          <div class='tab-btn' @click='choiceMain("cvr")' :class='{act:mainChoice === "cvr"}'>CVR</div>
        </div>
        <div class='conBox' v-show='flag.main'>
          <div class='mainReport' id='mainReport' style='width: 100%;height: 300px;'></div>
        </div>
        <div  v-show='!flag.main' class='flex m30'>NO Data</div>
      </div>
      <!-- table -->
      <div class='reportTableBox'>
        <el-table
          size='mini'
          border
          height='400'
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
            v-if='power.payout.show'
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
          <h4>TOP 10 Countries</h4>
          <div class='chartBox'>
            <div class='tabBox flex mt-20'>
              <div class='tab-btn' @click='choiceCountris("conversion")' :class='{act:countrisChoice === "conversion"}'>Conversion</div>
              <div class='tab-btn' v-if='power.payout.show' @click='choiceCountris("payout")' :class='{act:countrisChoice === "payout"}'>Payout</div>
              <div class='tab-btn' @click='choiceCountris("click")' :class='{act:countrisChoice === "click"}'>Click</div>
              <div class='tab-btn' @click='choiceCountris("cvr")' :class='{act:countrisChoice === "cvr"}'>CVR</div>
            </div>
            <div class='pt-20' v-show='flag.country'>
              <div class='countrisReport' id='countrisReport' style='width: 100%;height: 500px;'></div>
            </div>
            <div v-show='!flag.country' class='flex m30'>NO Data</div>
          </div>
        </div>
        <div class='col-auto-12 ml-10 border-1 p20'>
          <h4>TOP 5 Campaigns</h4>
          <div class='chartBox'>
            <div class='tabBox flex mt-20'>
              <div class='tab-btn' @click='choiceCampaigns("conversion")' :class='{act:campaignsChoice === "conversion"}'>Conversion</div>
              <div class='tab-btn' v-if='power.payout.show' @click='choiceCampaigns("payout")' :class='{act:campaignsChoice === "payout"}'>Payout</div>
              <div class='tab-btn' @click='choiceCampaigns("click")' :class='{act:campaignsChoice === "click"}'>Click</div>
              <div class='tab-btn' @click='choiceCampaigns("cvr")' :class='{act:campaignsChoice === "cvr"}'>CVR</div>
            </div>
            <div class='pt-20' v-show='flag.campaigns'>
              <div class='campaignsReport' id='campaignsReport' style='width: 100%;height: 500px;'></div>
            </div>
            <div v-show='!flag.campaigns' class='flex m30'>NO Data</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  var power = JSON.parse('<?= $this->params['view_group'] ?>')
  // console.log(power)
  var colorArr = ['#6cb8ff', '#161616', '#65e100', '#cf23de', '#ffc000']
  var mainData = {
    tooltip: {
      trigger: 'axis'
    },
    legend: {},
    grid: {
      containLabel: true,
      left: '2%',
      top: '10',
      right: '5%',
      bottom: '10',
    },
    toolbox: {
      feature: {
        // saveAsImage: {}
      }
    },
    xAxis: {
      type: 'category',
      boundaryGap: false,
      data: [],
      axisLine: {
        lineStyle: {
          color: '#aaa'
        }
      }
    },
    yAxis: {
      type: 'value',
      axisLine: {
        lineStyle: {
          color: '#aaa'
        }
      },
    },
    series: [
      {
        type:'line',
        data:[],
        color: "#409EFF",
        lineStyle:{
          color:'#409EFF'
        }
      }
    ]
  }
  var countryData = {
    tooltip: {
      trigger: 'axis'
    },
    grid: {
      containLabel: true,
      left: '2%',
      top: '60',
      right: '5%',
      bottom: '0',
    },
    legend: {},
    toolbox: {
      feature: {
        // saveAsImage: {}
      }
    },
    xAxis: {
      data: [],
      position: 'bottom',
      axisLabel: { 
        rotate:40  
      },
      axisLine: {
        lineStyle: {
          color: '#aaa'
        }
      },
    },
    yAxis: {
      axisLine: {
        lineStyle: {
          color: '#aaa'
        }
      },
    },
    series: [{
      type: 'bar',
      data: [],
      color: "#409EFF",
      lineStyle:{
        color:'#409EFF'
      },
    }]
  }
  var campaignsData = {
    tooltip: {
      trigger: 'axis'
    },
    grid: {
      containLabel: true,
      left: '2%',
      right: '5%',
      bottom: '35'
    },
    legend: {},
    toolbox: {
      feature: {
        // saveAsImage: {}
      }
    },
    xAxis: {
      type: 'category',
      boundaryGap: false,
      data: [],
      axisLabel: { 
        rotate:40  
      },
      axisLine: {
        lineStyle: {
          color: '#aaa'
        }
      }, 
    },
    yAxis: {
        type: 'value',
        axisLine: {
        lineStyle: {
          color: '#aaa'
        }
      },
    },
    series: []
  }
  var mainReport, countryReport, campaignsReport
  // 
  new Vue({
    el: '.app',
    data () {
      return {
        power: power,
        csrf: '',
        mainChoice: 'conversion',
        mainData: {},
        countrisChoice: 'conversion',
        campaignsChoice: 'conversion',
        options: {
          campaigns: [],
          country: [],
          campaignsOwner: []
        },
        search: {
          date: [],
          campaigns: [],
          country: [],
          campaignsOwner: []
        },
        tableData: [],
        flag: {
          main: true,
          country: true,
          campaigns: true
        }
      }
    },
    created () {
      var that = this
      this.getParams('offer_id', function (data) {
        if (data) that.search.campaigns.push(data)
      })
      this.getParams('campaigns_owner', function (data) {
        if (data) that.search.campaignsOwner.push(data)
      })
    },
    mounted () {
      this.csrf = document.querySelector('#spp_security').value
      mainReport = echarts.init(document.querySelector('#mainReport'))
      countryReport = echarts.init(document.querySelector('#countrisReport'))
      campaignsReport = echarts.init(document.querySelector('#campaignsReport'))
      this.getConfig()
      this.initDate()
      this.initMainData()
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
      // ??????table
      downloadTable () {
        // var that = this
        // var formData = new FormData()
        // formData.append('date', that.search.date)
        // formData.append('campaigns', that.search.campaigns)
        // formData.append('country', that.search.country)
        // formData.append('campaigns_owner', that.search.campaignsOwner)
        // var request = new XMLHttpRequest()
        // request.open("POST", "/offer-report/download-report")
        // request.send(formData)
        var downloadReport = document.querySelector('#downloadReport')
        console.log($(downloadReport).serializeArray())
        downloadReport.submit()
      },
      // ??????????????????
      getParams (key, callback) {
        var url = window.location.href
        var data
        var searchParams = url.split('?')
        for (var iterator of searchParams) {
          if (iterator.indexOf(key) !== -1) {
            data = iterator.split('=')[1]
            break
          }
        }
        callback(data)
      },
      // config
      getConfig () {
        var that = this
        var ajaxData = {
          dsp_security_param: this.csrf
        }
        $.ajax({
          url: '/offer-report/get-offer-search',
          type: 'post',
          data: ajaxData,
          success: function (result) {
            // console.log(result)
            if (result.status === 1) {
              var campaigns = result.data.campaigns
              for (const key in campaigns) {
                if (campaigns.hasOwnProperty(key)) {
                  that.options.campaigns.push({
                    value: campaigns[key].id,
                    label: campaigns[key].name
                  })
                }
              }
              var country = result.data.country
              for (const key in country) {
                if (country.hasOwnProperty(key)) {
                  that.options.country.push({
                    value: key,
                    label: country[key]
                  })
                }
              }
              var campaigns_owner = result.data.campaigns_owner
              for (const key in campaigns_owner) {
                if (campaigns_owner.hasOwnProperty(key)) {
                  that.options.campaignsOwner.push({
                    value: key,
                    label: campaigns_owner[key]
                  })
                }
              }
            }
          }
        })
      },
      // ???????????????
      initDate () {
        var start = moment().add(-7, 'day').format('YYYY-MM-DD')
        var end = moment().add(-1, 'day').format('YYYY-MM-DD')
        this.search.date = [start, end]
      },
      searchFun () {
        // console.log('search')
        this.initMainData()
        this.choiceCountris('conversion')
        this.choiceCampaigns('conversion')
      },
      choiceMain (i) {
        this.mainChoice = i
        mainData.series[0].data = this.mainData[this.mainChoice]
        this.getReport(mainReport, mainData)
      },
      choiceCountris (i) {
        var that = this
        this.countrisChoice = i
        var ajaxData = {
          date: this.search.date,
          campaigns: this.search.campaigns,
          country: this.search.country,
          campaigns_owner: this.search.campaignsOwner,
          field: this.countrisChoice
        }
        // country
        $.ajax({
          url: '/offer-report/country-top-bar',
          type: 'get',
          data: ajaxData,
          success: function (result) {
            that.flag.country = false
            countryData.xAxis.data.splice(0)
            countryData.series.map(function (ele) {
              return ele.data.splice(0)
            })
            if (result.status === 1) {
              if (result.data.length !== 0) {
                that.flag.country = true
                that.countryData = result.data
                countryData.xAxis.data = result.data.name
                countryData.series[0].data = result.data.fields
              }
            }
            that.getReport(countryReport, countryData)
          }
        })
      },
      choiceCampaigns (i) {
        var that = this
        this.campaignsChoice = i
        // campaigns
        var ajaxData = {
          date: this.search.date,
          campaigns: this.search.campaigns,
          country: this.search.country,
          campaigns_owner: this.search.campaignsOwner,
          field: this.campaignsChoice
        }
        $.ajax({
          url: '/offer-report/offer-line',
          type: 'get',
          data: ajaxData,
          success: function (result) {
            // console.log(result)
            that.flag.campaigns = false
            campaignsData.xAxis.data.splice(0)
            campaignsData.series.splice(0)
            if (result.status === 1) {
              if (result.data.length !== 0) {
                that.flag.campaigns = true
                that.campaignsData = result.data
                campaignsData.xAxis.data = result.data.day
                result.data.data.map(function (ele, i) {
                  campaignsData.series.push({
                    name: ele.name,
                    type: 'line',
                    data: ele.data,
                    lineStyle: {
                      color: colorArr[i]
                    },
                    color: colorArr[i],
                  })
                })
              }
            }
            that.getReport(campaignsReport, campaignsData)
          }
        })
      },
      formatter(row, column) {
        return row.address;
      },
      initMainData () {
        var that= this
        // mainReport
        var ajaxData = {
          date: this.search.date,
          campaigns: this.search.campaigns,
          country: this.search.country,
          campaigns_owner: this.search.campaignsOwner
        }
        $.ajax({
          url: '/offer-report/offer-report-data',
          type: 'get',
          data: ajaxData,
          success: function (result) {
            // console.log(result)
            that.flag.main = false
            mainData.xAxis.data.splice(0)
            mainData.series[0].data.splice(0)
            if (result.status === 1) {
              if (result.data.length !== 0) {
                that.flag.main = true
                that.mainData = result.data
                mainData.xAxis.data = result.data.day
                that.choiceMain('conversion')
              }
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
    padding: 20px 0;
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