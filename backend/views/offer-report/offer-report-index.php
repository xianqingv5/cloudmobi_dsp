<div class='app'>
  <div class='breadcrumbDocker w100 flex flex-row-flex-start-center'>
    <el-breadcrumb separator-class="el-icon-arrow-right">
      <el-breadcrumb-item><a href="/offer/offer-index">Offer</a></el-breadcrumb-item>
      <el-breadcrumb-item>Index</el-breadcrumb-item>
    </el-breadcrumb>
  </div>
  <div class='flex jcsb p30'>
    <h3>CAMPAIGNS</h3>
    <a href="/offer/offer-create" class='base-color'><el-button type="primary">New Campaign</el-button></a>
  </div>
  <div class='content'>
    <div class='contentBox'>
      <div class='searchBox flex jcsb mb-20'>
        <div>
          <div class='mb-20'>
            <span>Date Range</span>
          </div>
          <el-date-picker
            @change='searchFun'
            v-model="search.date"
            type="daterange"
            range-separator="-"
            start-placeholder="开始日期"
            end-placeholder="结束日期">
          </el-date-picker>
        </div>
        <div>
          <div class='mb-20'>
            <span>Campaigns</span>
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
            <span>Countries</span>
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
            <span>Campaigns Owner</span>
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
      <div>
        <div class='tabBox flex'>
          <div class='tab-btn'>Payout</div>
          <div class='tab-btn'>Conversion</div>
          <div class='tab-btn'>Click</div>
          <div class='tab-btn'>CVR</div>
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
        }
      }
    },
    mounted () {
      this.csrf = document.querySelector('#spp_security').value
    },
    methods: {
      searchFun () {

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
</style>