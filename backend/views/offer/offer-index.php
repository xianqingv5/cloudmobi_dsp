<div class='app'>
  <div class='breadcrumbDocker w100 flex flex-row-flex-start-center'>
    <el-breadcrumb separator-class="el-icon-arrow-right">
      <el-breadcrumb-item><a href="/offer/offer-index">Offer</a></el-breadcrumb-item>
      <el-breadcrumb-item>Index</el-breadcrumb-item>
    </el-breadcrumb>
  </div>
  <div class='flex jcsb p30'>
    <h3>CAMPAIGNS</h3>
    <el-button type="primary"><a href="/offer/offer-create" class='base-color'>New Campaign</a></el-button>
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
        <el-input
          @change='searchFun'
          v-model='search.campaignOwner'
          class='col-auto-4'
          placeholder="Campaigns Owner"
          prefix-icon="el-icon-search">
        </el-input>
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
          v-model="search.search"
          class='col-auto-4'
          placeholder="search"
          prefix-icon="el-icon-search">
        </el-input>
      </div>
      <table class='table table-bordered'>
        <thead>
          <th>Campaign ID</th>
          <th>Campaign Title</th>
          <th>Price</th>
          <th>Status</th>
          <th>Actions</th>
        </thead>
        <tbody is='transition-group' name='list'>
          <tr v-for='(item, index) in list' :key='index'>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>
              <div class='flex'>
                <div class='flex jcsb col-auto-18'>
                  <span>{{item.aa}}</span>
                  <el-switch
                    v-if='item.status !== "3"'
                    v-model="item.status"
                    active-value='1'
                    inactive-value='2'
                  >
                  </el-switch>
                  <el-switch
                    v-else
                    :disabled='item.status === "3"'
                    v-model="item.status"
                    active-value='3'
                    inactive-value='2'
                    active-color="yellow"
                    inactive-color="#ff4949"
                  >
                  </el-switch>
                </div>
              </div>
            </td>
            <td>
              <div class='flex jc-around'>
                <a href>
                  <svg class="icon" aria-hidden="true">
                    <use xlink:href="#icon-chakanbaobiao"></use>
                  </svg>
                </a>
                <a href>
                  <span class='icon el-icon-edit'></span>
                </a>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>
  new Vue({
    el: '.app',
    data () {
      return {
        search: {
          campaignID: '',
          advertiser: '',
          advertiserOptions: [],
          campaignOwner: '',
          status: '',
          statusOptions: [],
          search: ''
        },
        list: [
          {
            status: '1',
            aa: 'Active'
          },
          {
            status: '2',
            aa: 'Inactive'
          },
          {
            status: '3',
            aa: 'under review'
          }
        ]
      }
    },
    methods: {
      searchFun () {
        this.getList()
      },
      getList () {
        console.log("get list")
      }
    }
  })
</script>