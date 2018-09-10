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
            <td v-text='item.channel+"_offline"+item.id'></td>
            <td v-text='item.title'></td>
            <td v-text='item.payout'></td>
            <td>
              <div class='flex'>
                <div class='flex jcsb col-auto-18'>
                  <span v-if='item.status === "1"'>Active</span>
                  <span v-if='item.status === "2"'>Inactive</span>
                  <span v-if='item.status === "3"'>under review</span>
                  <template v-if='item.status !== "3"'>
                    <el-switch
                      v-model="item.status"
                      active-value='1'
                      inactive-value='2'
                      @change='changeStatus($event, item.id)'
                    >
                    </el-switch>
                  </template>
                  <template v-if='item.status === "3"'>
                    <el-button type="success" icon="el-icon-check" circle @click='allowOffer(item, item.id)'></el-button>
                  </template>
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
                <a :href="'/offer/offer-update-info?offer_id=' + item.id">
                  <span class='icon el-icon-edit'></span>
                </a>
                <span class='icon el-icon-view'></span>
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
      this.initData()
      this.getList()
    },
    methods: {
      allowOffer (item, offerID) {
        item.status = '1'
        this.changeStatus(item.status, offerID)
      },
      searchFun () {

        this.getList()
      },
      getList () {
        var that = this
        var ajaxData = {
          offer_id: this.search.campaignID,
          sponsor: this.search.advertiser,
          status: this.search.status,
          title: this.search.title,
          dsp_security_param: this.csrf
        }
        $.ajax({
          url: '/offer/offer-index',
          type: 'post',
          data: ajaxData,
          success: function (result) {
            console.log(result)
            if (result.status === 1) {
              that.list = result.data
            } else {
              that.$message.error(result.info)
            }
          }
        })
      },
      initData () {
        var that = this
        var ajaxData = {
          dsp_security_param: this.csrf
        }
        $.ajax({
          url: '/offer/get-offer-config',
          type: 'post',
          data: ajaxData,
          success: function (result) {
            // advertiser
            result.data.ads.map(function (ele) {
              that.search.advertiserOptions.push({
                value: ele.id,
                label: ele.ads
              })
            })
          }
        })
      },
      changeStatus (status, offerID) {
        var that = this
        var ajaxData = {
          dsp_security_param: this.csrf,
          status: status,
          offer_id: offerID
        }
        $.ajax({
          url: '/offer/offer-update-status',
          type: 'post',
          data: ajaxData,
          success: function (result) {
            if (result.status === 1) {
              that.$message({
                message: result.info,
                type: 'success'
              })
            } else {
              that.$message.error(result.info)
              window.location.reload()
            }
          }
        })
      }
    }
  })
</script>