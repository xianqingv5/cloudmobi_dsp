<div class='app'>
  <div class='breadcrumbDocker w100 flex flex-row-flex-start-center'>
    <el-breadcrumb separator-class="el-icon-arrow-right">
      <el-breadcrumb-item><a href="/offer/offer-index">Campaigns</a></el-breadcrumb-item>
      <el-breadcrumb-item>Campaign List</el-breadcrumb-item>
    </el-breadcrumb>
  </div>
  <div class='flex jc-end p0-30'>
    <a v-if='power.offer_create.show' href="/offer/offer-create" class='base-color mt-30'><el-button type="primary">New Campaign</el-button></a>
  </div>
  <div class='content mt-30'>
    <div class='contentBox'>
      <div class='searchBox flex jcsb mb-20'>
        <el-input
          @change='searchFun'
          v-model='search.campaignID'
          class='col-auto-4'
          placeholder="Campaign ID"
          prefix-icon="el-icon-search">
        </el-input>
        <el-select filterable
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
        <el-select filterable
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
          <th v-if='power.offer_delivery_price.show'>Delivery Price</th>
          <th>Status</th>
          <th>Actions</th>
        </thead>
        <tbody is='transition-group' name='list'>
          <tr v-for='(item, index) in list' :key='index'>
            <td v-text='item.show_offer_id'></td>
            <td v-text='item.title'></td>
            <td v-text='item.payout'></td>
            <td  v-if='power.offer_delivery_price.show' v-text='item.delivery_price'></td>
            <td>
              <div class='flex'>
                <div class='flex col-auto-18' :class={jcsb:power.offer_status.show}>
                  <span v-if='item.status === "1"'>Active</span>
                  <span v-if='item.status === "2"'>Inactive</span>
                  <span v-if='item.status === "3"'>under review</span>
                  <template v-if='item.status !== "3" && power.offer_status.show'>
                    <el-switch
                      :disabled='!power.offer_status.operate || userStatus[item.campaign_owner] !== "1"'
                      v-model="item.status"
                      active-value='1'
                      inactive-value='2'
                      @change='changeStatus($event, item)'
                    >
                    </el-switch>
                  </template>
                  <template v-if='item.status === "3"'>
                    <el-button v-if='power.offer_sh.operate' type="success" icon="el-icon-check" circle @click='allowOffer(item)'></el-button>
                  </template>
                </div>
              </div>
            </td>
            <td>
              <div class='flex jc-around'>
                <a :href="'/offer-report/offer-report-index?offer_id=' + item.id">
                  <svg class="icon" aria-hidden="true">
                    <use xlink:href="#icon-chakanbaobiao"></use>
                  </svg>
                </a>
                <a v-if='power.offer_update.show' :href="'/offer/offer-update-info?offer_id=' + item.id">
                  <span class='icon el-icon-edit'></span>
                </a>
                <a v-if='power.offer_see.show' :href="'/offer/offer-update-info?offer_id=' + item.id">
                  <span class='icon el-icon-view'></span>
                </a>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- 分页 -->
      <div class='flex'>
        <el-pagination
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
          :current-page="pagination.currentPage"
          :page-sizes="[50, 100, 200, 500]"
          :page-size="50"
          layout="total, sizes, prev, pager, next, jumper"
          :total="pagination.total">
        </el-pagination>
      </div>
    </div>
  </div>
  <!-- dialog -->
  <el-dialog
  :close-on-click-modal='false'
  title='审核'
  :visible.sync="dialogVisible">
    <div class='flex column'>
      <el-form ref="ruleForm2" :model="ruleForm2" :rules="rules2" label-position="right" label-width="150px">
        <el-form-item label="Price" prop='price'>
          <el-input disabled='disabled' auto-complete="off" v-model.trim="ruleForm2.price" class='inputobj'></el-input>
        </el-form-item>
        <el-form-item label="Delivery Price" prop='deliveryPrice'>
          <el-input disabled='disabled' auto-complete="off" v-model.trim="ruleForm2.deliveryPrice" class='inputobj'></el-input>
        </el-form-item>
        <div class='flex jc-end'>
          <el-button type="primary" @click="submitForm2('ruleForm2')">Submit</el-button>
        </div>
      </el-form>
    </div>
  </el-dialog>
</div>
<script>
var power = JSON.parse('<?= $this->params['view_group'] ?>')
// console.log(power)
  new Vue({
    el: '.app',
    data () {
      var validatePrice = function (rule, value, callback) {
        if (value <= 0.1) {
          callback(new Error("不得小于0.1"))
        } else {
          callback()
        }
      }
      var validateDeliveryPrice = function (rule, value, callback) {
        if (value <= 0.1) {
          callback(new Error("不得小于0.1"))
        } else {
          callback()
        }
      }
      return {
        power: power,
        csrf: '',
        pagination: {
          currentPage: 1,
          total: null,
          size: null,
        },
        dialogVisible: false,
        dialogBus: {
          json: {}
        },
        userStatus: [],
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
        list: [],
        ruleForm2: {
          price: '',
          deliveryPrice: ''
        },
        rules2: {
          price: [
            { required: true, validator: validatePrice, trigger: 'blur' }
          ],
          deliveryPrice: [
            { required: true, validator: validateDeliveryPrice, trigger: 'blur' }
          ]
        }
      }
    },
    mounted () {
      this.csrf = document.querySelector('#spp_security').value
      this.initData()
      this.getList()
    },
    methods: {
      getConfig () {
        var that = this
        var ajaxData = {
          dsp_security_param: this.csrf
        }
        $.ajax({
          url: '/offer/get-offer-config',
          type: 'post',
          data: ajaxData,
          success: function (result) {
            // console.log(result)
            that.userStatus = result.data.user_status
          }
        })
      },
      handleSizeChange(val) {
        console.log(`每页 ${val} 条`)
        this.pagination.size = val
      },
      handleCurrentChange(val) {
        console.log(`当前页: ${val}`)
        this.pagination.page = val
      },
      submitForm2 (formName) {
        var that = this
        this.$refs[formName].validate(function (valid) {
          if (valid) {
            console.log('submit!')
            that.toExamine(that.ruleForm2)
          } else {
            console.log('error submit!!')
            return false
          }
        })
      },
      allowOffer (item) {
        this.dialogVisible = true
        this.dialogBus.json = item
        this.ruleForm2.price = item.payout
        this.ruleForm2.deliveryPrice = item.delivery_price
      },
      // 审核
      toExamine (data) {
        var that = this
        var ajaxData = {
          dsp_security_param: this.csrf,
          payout: data.price,
          delivery_price: data.deliveryPrice,
          offer_id: this.dialogBus.json.id
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
      },
      searchFun () {
        // console.log('search')
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
          // 此处需要添加分页请求的参数
        }
        $.ajax({
          url: '/offer/offer-index',
          type: 'post',
          data: ajaxData,
          success: function (result) {
            // console.log(result)
            if (result.status === 1) {
              that.list = result.data
              that.getConfig()
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
      changeStatus (ev, item) {
        var that = this
        var ajaxData = {
          dsp_security_param: this.csrf,
          status: item.status,
          offer_id: item.id
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