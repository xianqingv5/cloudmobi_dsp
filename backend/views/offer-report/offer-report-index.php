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
        <el-input
          @change='searchFun'
          v-model='search.campaignID'
          class='col-auto-4'
          placeholder="Campaign ID"
          prefix-icon="el-icon-search">
        </el-input>
        <el-select 
          @change='searchFun'
          v-model="search.advertiser" clearable placeholder="Advertiser">
          <el-option
            v-for="item in search.advertiserOptions"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>
        <!-- <el-input
          @change='searchFun'
          v-model='search.campaignOwner'
          class='col-auto-4'
          placeholder="Campaigns Owner"
          prefix-icon="el-icon-search">
        </el-input> -->
        <el-select 
          @change='searchFun'
          v-model="search.status" clearable placeholder="Status">
          <el-option
            v-for="item in search.statusOptions"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>
        <el-input
          @change='searchFun'
          v-model="search.title"
          class='col-auto-4'
          placeholder="Title"
          prefix-icon="el-icon-search">
        </el-input>
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
        search: {
          campaignID: '',
          advertiser: '',
          advertiserOptions: [],
          campaignOwner: '',
          status: '',
          statusOptions: [
            {value: 1, label: 'Active'},
            {value: 2, label: 'Inactive'},
            {value: 3, label: 'under review'}
          ],
          title: ''
        },
        list: []
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