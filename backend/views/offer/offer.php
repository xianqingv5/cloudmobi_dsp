<div class='app' data-type="<?php echo $type; ?>">
  <!-- <div
    v-loading.fullscreen.lock="loading"
    element-loading-text="资源上传中"
    element-loading-spinner="el-icon-loading"
  ></div> -->
  <div class='breadcrumbDocker w100 flex flex-row-flex-start-center'>
    <el-breadcrumb separator-class="el-icon-arrow-right">
      <el-breadcrumb-item><a href="/offer/offer-index">Campaigns</a></el-breadcrumb-item>
      <el-breadcrumb-item v-if='pageType === "create"'>Create New Campaigns</el-breadcrumb-item>
      <el-breadcrumb-item v-if='pageType === "update"'>Edit Campaigns</el-breadcrumb-item>
    </el-breadcrumb>
  </div>
  <div class='flex jc-end p30'>
    <div>
      <!-- <el-button  @click='resetForm("ruleForm")'>Reset</el-button> -->
      <el-button type="primary" @click='submitForm("ruleForm")'>Save</el-button>
    </div>
  </div>
  <div class='content'>
    <div class='contentBox'>
      <el-form enctype="multipart/form-data" ref='ruleForm' :rules='rules' :model='ruleForm' label-width="240px" label-position="right">
        <!-- 1 -->
        <div class='content-li'>
          <div class='flex jc-start content-li-title'>
            <div class='num-circle'>1</div>
            <h5>Campaign Basic Info</h5>
          </div>
          <div class='content-con flex column'>
            <el-form-item v-if='pageType === "update"' label="Campaign ID:" prop="offerID">
              <div class='form-one' v-text='showOfferID'></div>
            </el-form-item>
            <el-form-item label="Campaign Owner" prop="campaignOwner">
              <el-select class='form-one' :disabled='groupID === "3" || judePowerOperate'
                v-model="ruleForm.campaignOwner" clearable placeholder="">
                <el-option
                  v-for="item in options.campaignOwner"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="Advertiser" prop="advertiser">
              <el-select class='form-one' :disabled='judePowerOperate'
                v-model="ruleForm.advertiser" clearable placeholder="">
                <el-option
                  v-for="item in options.advertiser"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="Attribute Provider" prop="attributeProvider">
              <el-select class='form-one' @change='judeChannel' :disabled='judePowerOperate'
                v-model="ruleForm.attributeProvider" clearable placeholder="">
                <el-option
                  v-for="item in options.attributeProvider"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                  :disabled="item.disabled"
                  >
                </el-option>
              </el-select>
            </el-form-item>
          </div>
        </div>
<template v-if='judeOne'>
        <!-- 2 -->
        <div class='content-li'>
          <div class='flex jc-start content-li-title'>
            <div class='num-circle'>2</div>
            <h5>Campaign Detail Info</h5>
          </div>
          <div class='content-con flex column'>
            <el-form-item label="Targeting Platform" prop="platform">
              <el-select class='form-one' @change='changePlatform' :disabled='judePowerOperate'
                v-model="ruleForm.platform" clearable placeholder="">
                <el-option
                  v-for="item in options.platform"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="App Store or Google Play URL" prop="storeUrl">
              <el-input :disabled='judePowerOperate' @change='changeStoreUrl' class='form-one' type='textarea' v-model.trim="ruleForm.storeUrl" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="">
              <div class='judeUrl-box form-one' v-if='spaceShowStoreUrlFlag'>
                <span class='judeUrl-span' v-html='spaceShowStoreUrl'></span>
              </div>
            </el-form-item>
            <transition name='fade'>
              <div class='w100 center mb-30 of-h' v-if='messageVisible'>
              <span class='messageVisibleShow db'>APP Apple Store or Google Play URL may be wrong, please <a class='color_dangers' @click='spiderAgain'>fill in again</a> or <a class='color_dangers'@click='spiderUse'>use the current one</a>. </span>
            </div>
            </transition>
            <el-form-item label="Campaign Title" prop="title">
              <el-input :disabled='judePowerOperate' class='form-one' v-model="ruleForm.title" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="Campaign Description" prop="desc">
              <el-input :disabled='judePowerOperate' type='textarea' class='form-one' v-model="ruleForm.desc" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="Package Name" prop="name">
              <el-input :disabled='judePowerOperate' class='form-one' v-model="ruleForm.name" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="Campaign Category" prop="category">
              <el-select class='form-one' :disabled='!judePlatform || judePowerOperate'
                v-model="ruleForm.category" clearable placeholder="">
                <el-option
                  v-for="item in options.category"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="Tracking Link" prop="trackingUrl" 
              :rules="[
                {
                  required: true,
                  validator: validatorUrl,
                  trigger: ['blur', 'change']
                }
              ]"
            >
              <div>
                <el-input :disabled='judePowerOperate' class='form-one' type='textarea' v-model.trim="ruleForm.trackingUrl" placeholder=''></el-input>
              </div>
              <div class='judeUrl-box form-one mt-10' v-if='spaceShowUrlFlag("trackingUrl")'>
                <span class='judeUrl-span' v-html='spaceShowUrl("trackingUrl")'></span>
              </div>
            </el-form-item>
            <template v-for='(obj, i) in ruleForm.impressionUrl'>
                <el-form-item :label='"Impression Link (" + (i + 1) + ")"' :prop="'impressionUrl.' + i + '.value'"
                :rules="[
                  { required: false, validator: validatorUrl, trigger: ['blur', 'change'] }
                ]"
                >
                  <div>
                    <el-input :disabled='judePowerOperate' class='form-one' type='textarea' v-model.trim="obj.value" placeholder=''></el-input>
                  </div>
                  <div class='judeUrl-box form-one mt-10' v-if='spaceShowUrlFlag("impressionUrl", i)'>
                  <span class='judeUrl-span' v-html='spaceShowUrl("impressionUrl", i)'></span>
                </div>
              </el-form-item>
            </template>
            <el-form-item label="">
              <el-button class='dn' type="primary" @click='addImpressionUrl'>Add</el-button>
            </el-form-item>
            <el-form-item label="Schedule" prop="schedule">
              <el-radio-group :disabled='judePowerOperate' class='form-one' v-model="ruleForm.schedule">
                <el-radio label="2">OFF</el-radio>
                <el-radio label="1">ON</el-radio>
              </el-radio-group>
            </el-form-item>
            <template v-if='ruleForm.schedule === "1"'>
              <el-form-item  prop="deliveryDate">
                <el-date-picker :disabled='judePowerOperate'
                  ref='thisDatePicker'
                  class='form-one'
                  v-model="ruleForm.deliveryDate"
                  type="daterange"
                  align="right"
                  unlink-panels
                  range-separator="-"
                  start-placeholder="Start"
                  end-placeholder="End"
                  value-format="yyyy-MM-dd"
                  >
                </el-date-picker>
              </el-form-item>
              <el-form-item prop="deliveryWeek">
                <div class='form-one checkbox-docker'>
                  <div class='p10-30 flex jcsb'>
                    <el-button type="primary" @click='addAllDeliveryWeek'>Select all</el-button>
                    <el-button type="primary" @click='delAllDeliveryWeek'>Deselect all</el-button>
                  </div>
                  <el-checkbox-group :disabled='judePowerOperate' v-model="ruleForm.deliveryWeek">
                    <el-checkbox :label="item.value" :key=item.value v-for='item in options.deliveryWeek'>{{item.label}}</el-checkbox>
                  </el-checkbox-group>
                </div>
              </el-form-item>
              <el-form-item prop="deliveryHour">
                <div class='form-one checkbox-docker'>
                  <div class='p10-30 flex jcsb'>
                    <el-button type="primary" @click='addAllDeliveryHour'>Select all</el-button>
                    <el-button type="primary" @click='delAllDeliveryHour'>Deselect all</el-button>
                  </div>
                  <el-checkbox-group :disabled='judePowerOperate' v-model="ruleForm.deliveryHour">
                    <el-checkbox :label="item" :key='item' v-for='(item, index) in options.deliveryHour'>{{item}}</el-checkbox>
                  </el-checkbox-group>
                </div>
              </el-form-item>
            </template>
            <el-form-item label="Comment" prop="comment">
              <el-input :disabled='judePowerOperate' class='form-one mt-20' type='textarea' v-model="ruleForm.comment" placeholder=''></el-input>
            </el-form-item>
          </div>
        </div>
        <!-- 3 -->
        <div class='content-li'>
          <div class='flex jc-start content-li-title'>
            <div class='num-circle'>3</div>
            <h5>Budget Info</h5>
          </div>
          <div class='content-con flex column'>
            <el-form-item v-if='judePowerPayoutShow' label="Price($)" prop="payout">
              <el-input :disabled='judePowerOperate || !judePowerPayoutOperate' class='form-one' v-model.number="ruleForm.payout" placeholder=''></el-input>
            </el-form-item>
            <el-form-item v-if='power.delivery_price.show' label="Delivery Price($)" prop="deliveryPrice">
              <el-input :disabled='judePowerOperate || !power.delivery_price.operate' class='form-one' v-model.trim.number="ruleForm.deliveryPrice" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="Daily Cap" prop="dailyCap">
              <el-input :disabled='judePowerOperate' class='form-one' v-model.trim.number="ruleForm.dailyCap" placeholder=''></el-input>
            </el-form-item>
            <el-form-item class='dn' label="Total Cap" prop="totalCap">
              <el-input :disabled='judePowerOperate' class='form-one' v-model.trim.number="ruleForm.totalCap" placeholder=''></el-input>
            </el-form-item>
          </div>
        </div>
        <!-- 4 -->
        <div class='content-li'>
          <div class='flex jc-start content-li-title'>
            <div class='num-circle'>4</div>
            <h5>Targeting Info</h5>
          </div>
          <div class='content-con flex column'>
            <el-form-item label="Device Type" prop="deviceType">
              <el-select class='form-one' :disabled='!judePlatform || judePowerOperate'
                v-model="ruleForm.deviceType" @change='changeDeviceType' clearable placeholder="">
                <el-option
                  v-for="item in options.deviceType"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="Specific Device" prop="specificDevice" v-if='judeDeviceType'>
              <el-select class='form-one' multiple filterable :disabled='ruleForm.deviceType === "" || judePowerOperate'
                v-model="ruleForm.specificDevice" clearable placeholder="">
                <el-option
                  v-for="item in options.specificDevice"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="Min OS Version" prop="minOSversion">
              <el-select class='form-one'
                v-model="ruleForm.minOSversion" :disabled='!judePlatform || judePowerOperate' clearable placeholder="">
                <el-option
                  v-for="item in options.minOSversion"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="Network Status" prop="networkStatus">
              <el-radio-group :disabled='judePowerOperate' class='form-one' v-model="ruleForm.networkStatus">
                <el-radio label="3">WIFI & 4G</el-radio>
                <el-radio label="1">WIFI</el-radio>
                <el-radio label="2">4G</el-radio>
              </el-radio-group>
            </el-form-item>
            <el-form-item label="Targeting Countries" prop="countryType">
              <el-select :disabled='judePowerOperate' class='form-one'
                v-model="ruleForm.countryType" @change='changeCountryType' clearable placeholder="">
                <el-option
                  v-for="item in options.countryType"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item v-show='showCountry' label="select Country" prop="country">
              <el-select :disabled='judePowerOperate' class='form-one' multiple filterable 
                v-model="ruleForm.country" clearable placeholder="">
                <el-option
                  v-for="item in options.country"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
          </div>
        </div>
        <!-- 5 -->
        <div class='content-li'>
          <div class='flex jc-start content-li-title'>
            <div class='num-circle'>5</div>
            <h5>Creatives</h5>
          </div>
          <div class='content-con'>
            <!-- icon -->
            <el-form-item label="icon" prop="iconList" class='imgDocker'>
              <div class='flex' v-if='!judePowerOperate'>
                <div class='flex flex-start mr-20'>
                  <el-input class='form-one' v-model="ruleForm.icon" placeholder=''></el-input>
                  <el-button type="primary" @click='previewAddFile("icon")'>Upload via url</el-button>
                </div>
                <el-button v-if='!ruleForm.iconLoading' type="primary" @click='uploadFile("icon")'/>Upload creatives</el-button>
                <input class='iconfile dn' type="file" name="iconfile">
                <el-button v-if='ruleForm.iconLoading' type="primary" :loading="true">Uploading</el-button>
              </div>
            </el-form-item>
            <div class='tooltipMsg' v-if='!judePowerOperate'>
              Please upload an icon of any format (png, jpg, jpeg, gif), make sure the image ratio is 1:1 and it is less than 500 KB.
            </div>
            <div class='flex flex-wrap'>
              <div class='imgBox showImgBox' v-for='(item, index) in ruleForm.iconList'>
                <div v-if='!judePowerOperate' class='close icon el-icon-close' @click='deleteFun(item, index, ruleForm.iconList)'></div>
                <a class='db' :href='item.url' target='_black'>
                  <div class='showImg flex'>
                    <img src="" alt="" :src='item.url'>
                  </div>
                </a>
                <!-- <div class='showImgTitle' v-text='item'></div> -->
              </div>
            </div>
            <!-- image -->
            <el-form-item label="image" prop="imageList" class='imgDocker'>
              <div class='flex' v-if='!judePowerOperate'>
                <div class='flex flex-start mr-20'>
                  <el-input class='form-one' v-model="ruleForm.image" placeholder=''></el-input>
                  <el-button type="primary" @click='previewAddFile("image")'>Upload via url</el-button>
                </div>
                <el-button v-if='!ruleForm.imageLoading' type="primary" @click='uploadFile("image")'>Upload creatives</el-button>
                <input class='imagefile dn' type="file" name="imagefile">
                <el-button v-if='ruleForm.imageLoading' type="primary" :loading="true">Uploading</el-button>
              </div>
            </el-form-item>
            <div class='tooltipMsg' v-if='!judePowerOperate'>
              Please upload one or more image of any format (png, jpg, jpeg, gif), make sure the image ratio is between 1:1.7～2.1, 1.7～2.1:1 or 1:1 and it is less than 500 KB.
            </div>
            <div class='flex flex-wrap'>
              <div class='imgBox showImgBox' v-for='(item, index) in ruleForm.imageList'>
                <div v-if='!judePowerOperate' class='close icon el-icon-close' @click='deleteFun(item, index, ruleForm.imageList)'></div>
                <a class='db' :href='item.url' target='_black'>
                  <div class='showImg flex'>
                    <img src="" alt="" :src='item.url'>
                  </div>
                </a>
                <!-- <div class='showImgTitle' v-text='item'></div> -->
              </div>
            </div>
            <!-- video -->
            <el-form-item label="video" prop="video" class='imgDocker'>
              <div class='flex' v-if='!judePowerOperate'>
                <div class='flex flex-start mr-20'>
                  <el-input class='form-one' v-model="ruleForm.video" placeholder=''></el-input>
                  <el-button type="primary" @click='previewAddFile("video")'>Upload via url</el-button>
                </div>
                <el-button v-if='!ruleForm.videoLoading' type="primary" @click='uploadFile("video")'>Upload creatives</el-button>
                <input class='videofile dn' type="file" name="videofile">
                <el-button v-if='ruleForm.videoLoading' type="primary" :loading="true">Uploading</el-button>
              </div>
            </el-form-item>
            <div class='tooltipMsg' v-if='!judePowerOperate'>
              Please upload an video of mp4 format, make sure video is less than 5 MB.
            </div>
            <div class='flex flex-wrap'>
              <div class='imgBox showImgBox' v-for='(item, index) in ruleForm.videoList'>
                <div v-if='!judePowerOperate' class='close icon el-icon-close' @click='deleteFun(item, index, ruleForm.videoList)'></div>
                <a class='db' :href='item.url' target='_black'>
                  <div class='showImg flex'>
                    <video src="" controls='controls' :src='item.url'></video>
                  </div>
                </a>
                <!-- <div class='showImgTitle' v-text='item'></div> -->
              </div>
            </div>
          </div>
        </div>
</template>
        <div class='flex p30'>
          <!-- <el-button  @click='resetForm("ruleForm")'>Reset</el-button> -->
          <el-button type="primary" @click='submitForm("ruleForm")'>Save</el-button>
        </div>
      </el-form>
    </div>
  </div>
</div>
<script>
  // 权限
  var power = JSON.parse('<?= $this->params['view_group'] ?>')
  console.log(power)
  // s3
  var albumBucketName = 'cloudmobi-resource'
  var bucketRegion = 'ap-southeast-1'
  var IdentityPoolId = 'ap-southeast-1:c0fbf555-2ba8-4dab-8ad2-733d41ef2ae7'
  var s3 = new AWS.S3({
    params: {
      Bucket: albumBucketName
    }
  })
  // 上传图片和视频的尺寸规范
  var minRatio = 1.7
  var maxRatio = 2.1
  var baseRatio = 1.9 / 1
  var maxImageSize = 500 * 1024
  var maxVideoSize = 5 * 1024 * 1024
  // 正则
  var regHref = new RegExp('(https?|ftp|file)://[-A-Za-z0-9+&@#/%?=~_|!:,.;]+[-A-Za-z0-9+&@#/%=~_|]')
  var iOSReg = new RegExp('https://itunes.apple.com/')
  var androidReg = new RegExp('https://play.google.com/')
  var spaceReg = new RegExp('\\s', 'g')
  // issues #989
  var ruleLanguagePackage = {
    // 必填
    required: "This can't be empty.",
    // 必须是数字
    shouldNumber: 'This must be numbers.',
    // 不是网址
    notWWW: 'Please enter a valid url.',
    // 不能有空格
    notSpace: 'There are spaces in the url, please enter a valid url.',
    // 不是商店地址
    notStore: 'APP Apple Store or Google Play URL may be wrong.',
    // 平台不符
    notEqualToPlatform: 'Please enter a valid url, which matches to the platform.',
    // 应输入商店地址
    shouldInputPlatform: 'Please select platform first.',
    // 上传图片错误
    uploadImageError: 'Upload pictures failed.',
    // 上传视频错误
    uploadVideoError: 'Upload videos failed.',
    // 文件类型错误
    fileTypeError: 'The type of file can not be accepted.',
    // 图片小于500k
    uploadImageSizeMax: 'Size of picture must be less than 500kb.',
    // 视频小于5M
    uploadVideoSizeMax: 'Size of video must be less than 5M.',
    // icon不是一比一
    uploadIconSizeError: 'The width-length ratio of picture must be 1:1.',
    // 图片尺寸不对
    uploadImageSizeError: 'The width-length ratio of picture only can be 1:1.9/1.9:1/1:1.',
    // 视频尺寸不对
    uploadVideoSizeError: 'The width-length ratio of video only can be 16:9/9:16.',
    // s3上传成功
    s3UploadFile: 'Upload pictures success.',
    // s3上传失败
    s3DeleteFile: 'Delete pictures failed.',
    // 必须选择一个
    shouldChoiceOne: 'This can not be empty.',
    // 点击preview按钮
    clickPreview: 'Please enter a valid url, and click preview to add the creative.'
  }
  // 初始化vue对象
  new Vue({
    el: '.app',
    data () {
      var vm = this
      var validatorStoreUrl = function (rule, value, callback) {
        var platform = null
        var vmPlatform = null
        var judeFlag = value.match(spaceReg)
        callback()
        if (judeFlag === null) {
          // console.log('没有空格')
          if (regHref.test(value)) {
            vm.messageVisible = false
            if (vm.ruleForm.platform) {
              if (iOSReg.test(value)) {
                // ios
                platform = 'ios'
                vmPlatform = '2'
              } else if (androidReg.test(value)) {
                // android
                platform = 'android'
                vmPlatform = '1'
              } else {
                vm.messageVisible = true
                callback()
              }
              if (vmPlatform) {
                if (vmPlatform === vm.ruleForm.platform) {
                  if (platform) {
                    vm.judeHref(platform, value, function (flag) {
                      if (flag) {
                        callback()
                      } else {
                        // console.log('没有查询到商店')
                        callback(new Error(ruleLanguagePackage.notStore))
                      }
                      vm.dialogVisible = true
                    })
                  }
                } else {
                  // console.log('与所填平台不符')
                  callback(new Error(ruleLanguagePackage.notEqualToPlatform))
                }
              } else {
                // console.log('是网址但不是苹果或者安卓')
                callback()
              }
            } else {
              // console.log('应该填写平台')
              callback(new Error(ruleLanguagePackage.shouldInputPlatform))
            }
          } else {
            // console.log('不是网址')
            callback(new Error(ruleLanguagePackage.notWWW))
          }
        } else {
          // console.log('有空格')
          vm.messageVisible = false
          callback(new Error(ruleLanguagePackage.notSpace))
        }
      }
      var validatorPayout = function (rule, value, callback) {
        if (value <= 0.1) {
          callback(new Error("不得小于0.1"))
        } else {
          callback()
        }
      }
      var validatorDailyCap = function (rule, value, callback) {
        if (value) {
          if (Number(value) !== value) {
            callback(new Error(ruleLanguagePackage.shouldNumber))
          } else {
            callback()
          }
        } else {
          callback()
        }
      }
      var validatorTotalCap = function (rule, value, callback) {
        if (value) {
          if (Number(value) !== value) {
            callback(new Error(ruleLanguagePackage.shouldNumber))
          } else if (!vm.judeTotalCap()) {
            callback(new Error('Total Cap >= Daily Cap'))
          } else {
            callback()
          }
        } else {
          callback()
        }
      }
      var validatorDeliveryPrice = function (rule, value, callback) {
        if (value) {
          if (value <= 0.1) {
            callback(new Error("不得小于0.1"))
          } else {
            if (value.toString().length <= Number(value).toFixed(3).length) {
              callback()
            } else {
              callback(new Error("小数点后不大于3位"))
            }
          }
        } else {
          callback()
        }
      }
      return {
        loading: false,
        power: power,
        requestUid: "<?= $this->params['request_uid'] ?>",
        groupID: "<?= $this->params['group_id'] ?>",
        offerID: "<?php echo $offer_id; ?>",
        offerStatus: null,
        showOfferID: null,
        pageType: "<?php echo $type; ?>",
        channel: null,
        messageVisible: false,
        csrf: '',
        showCountry: true,
        spiderFlag: false,
        options: {
          campaignOwner: [],
          advertiser: [],
          attributeProvider: [],
          platform: [
            {
              value: '1',
              label: 'Android'
            },
            {
              value: '2',
              label: 'iOS'
            }
          ],
          deviceType: [],
          deviceTypeBase: {
            ios: ['phone', 'ipad', 'unlimited'],
            android: ['phone', 'tablet', 'unlimited']
          },
          minOSversionBase: {},
          minOSversion: [],
          countryType: [
            {
              value: '1',
              label: 'select all countries'
            },
            {
              value: '2',
              label: 'select countries to add'
            },
            {
              value: '3',
              label: 'select countries to exclude'
            }
          ],
          country: [],
          category: [],
          categoryBase: {},
          specificDevice: [],
          specificDeviceBase: {},
          deliveryWeek: [
            {value: '0', label: 'Sun'},
            {value: '1', label: 'Mon'},
            {value: '2', label: 'Tues'},
            {value: '3', label: 'Weds'},
            {value: '4', label: 'Thu'},
            {value: '5', label: 'Fri'},
            {value: '6', label: 'Sat'},
          ],
          deliveryHour: ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23']
        },
        ruleForm: {
          // 1
          campaignOwner: '',
          advertiser: '',
          attributeProvider: '',
          // 2
          storeUrl: '',
          platform: '',
          title: '',
          desc: '',
          name: '',
          category: '',
          trackingUrl: '',
          impressionUrl: [
            {value: ''}
          ],
          schedule: '2',
          deliveryDate: [],
          deliveryWeek: [],
          deliveryHour: [],
          comment: '',
          // 3
          payout: null,
          dailyCap: null,
          totalCap: null,
          deliveryPrice: null,
          // 4
          deviceType: '',
          specificDevice: [],
          minOSversion: '',
          networkStatus: '3',
          countryType: '',
          country: [],
          // 5
          icon: '',
          iconList: [],
          iconLoading: false,
          image: '',
          imageList: [],
          imageLoading: false,
          video: '',
          videoList: [],
          videoLoading: false,
        },
        rules: {
          // 1
          campaignOwner: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          advertiser: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          attributeProvider: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          // 2
          storeUrl: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' },
            { validator: validatorStoreUrl, trigger: ['blur', 'change'] }
          ],
          platform: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          title: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          desc: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          name: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          category: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          trackingUrl: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          impressionUrl: [
            { required: false, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          schedule: [
            { required: true, message: ruleLanguagePackage.shouldChoiceOne, trigger: 'blur' }
          ],
          // 3
          payout: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' },
            { type: 'number', message: ruleLanguagePackage.shouldNumber , trigger: 'blur' },
            { required: true, validator: validatorPayout, trigger: 'blur' }
          ],
          dailyCap: [
            { required: false, validator: validatorDailyCap, trigger: ['blur', 'change'] }
          ],
          totalCap: [
            { required: false, validator: validatorTotalCap, trigger: ['blur', 'change'] }
          ],
          deliveryPrice: [
            { required: false, validator: validatorDeliveryPrice, trigger: ['blur', 'change'] }
          ],
          // 4
          deviceType: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          minOSversion: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          networkStatus: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          countryType: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          country: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          // 5
          iconList: [
            { required: true, message: ruleLanguagePackage.clickPreview, trigger: 'change' }
          ],
          imageList: [
            { required: true, message: ruleLanguagePackage.clickPreview, trigger: 'change' }
          ]
        }
      }
    },
    computed: {
      // 权限判断
      judePowerOperate () {
        if (!this.power.operate && this.pageType === 'update') return true
        return false
      },
      // payout
      judePowerPayoutShow () {
        if (this.power.payout) {
          if (this.power.payout.show) return true
          return false
        } else {
          return true
        }
      },
      judePowerPayoutOperate () {
        if (this.power.payout) {
          if (this.power.payout.operate) return true
          return false
        } else {
          return true
        }
      },
      spaceShowStoreUrl () {
        if (this.spaceShowStoreUrlFlag) {
          var str = this.ruleForm.storeUrl
          return str.replace(spaceReg, '<span class="judeUrl-font">&nbsp;</span>')
        }
      },
      spaceShowStoreUrlFlag () {
        if (this.ruleForm.storeUrl.indexOf(' ') !== -1) return true
        return false
      },
      judeOne () {
        if (this.ruleForm.campaignOwner !== '' && this.ruleForm.advertiser !== '' && this.ruleForm.attributeProvider !== '') {
          return true
        }
        return false
      },
      judeDeviceType () {
        var that = this
        // 置空
        that.options.specificDevice.splice(0)
        // 
        if (this.ruleForm.platform === '1') {
          // android
          return false
        }
        if (this.ruleForm.platform === '2') {
          // ios
          if (this.ruleForm.deviceType === 'phone' || this.ruleForm.deviceType === 'unlimited') {
            this.options.specificDeviceBase.ios.phone.map(function (ele) {
              that.options.specificDevice.push({
                value: ele,
                label: ele
              })
            })
          }
          if (this.ruleForm.deviceType === 'ipad'|| this.ruleForm.deviceType === 'unlimited') {
            this.options.specificDeviceBase.ios.tablet.map(function (ele) {
              that.options.specificDevice.push({
                value: ele,
                label: ele
              })
            })
          }
          if (this.ruleForm.deviceType === 'unlimited') {
            this.options.specificDeviceBase.ios.other.map(function (ele) {
              that.options.specificDevice.push({
                value: ele,
                label: ele
              })
            })
          }
          return true
        }
      },
      judePlatform () {
        var that = this
        var flag = false
        if (this.ruleForm.platform === '') {
          flag = false
        }
        if (this.ruleForm.platform === '1') {
          flag = true
          // android
          this.options.deviceTypeBase.android.map(function (ele) {
            that.options.deviceType.push({
              value: ele,
              label: ele
            })
          })
          this.options.categoryBase.android.map(function (ele) {
            that.options.category.push({
              value: ele.id,
              label: ele.name
            })
          })
          this.options.minOSversionBase.android.map(function (ele) {
            that.options.minOSversion.push({
              value: ele,
              label: ele
            })
          })
        }
        if (this.ruleForm.platform === '2') {
          flag = true
          // ios
          this.options.deviceTypeBase.ios.map(function (ele) {
            that.options.deviceType.push({
              value: ele,
              label: ele
            })
          })
          this.options.categoryBase.ios.map(function (ele) {
            that.options.category.push({
              value: ele.id,
              label: ele.name
            })
          })
          this.options.minOSversionBase.ios.map(function (ele) {
            that.options.minOSversion.push({
              value: ele,
              label: ele
            })
          })
        }
        return flag
      }
    },
    mounted () {
      var that = this
      this.csrf = document.querySelector('#spp_security').value
      if (this.groupID === '3') {
        this.ruleForm.campaignOwner = this.requestUid
      }
      this.$watch('ruleForm.platform', function (newVal, oldVal) {
        this.$refs['ruleForm'].validateField('storeUrl')
        // android
        if (newVal === '1') {
          that.ruleForm.deviceType = 'unlimited'
          that.ruleForm.minOSversion = '4.1'
        }
        // ios
        if (newVal === '2') {
          that.ruleForm.deviceType = 'unlimited'
          that.ruleForm.minOSversion = '6.0'
        }
      }, {
        deep: false
      })
      this.$watch('ruleForm.dailyCap', function (newVal, oldVal) {
        // 每次改变都会验证totalCap
        this.$refs['ruleForm'].validateField('totalCap')
      }, {
        deep: false
      })
      this.$watch('ruleForm.countryType', function (newVal, oldVal) {
        if (newVal === '1') {
          that.ruleForm.country.push('-1')
        }
      }, {
        deep: false
      })
      // initData
      // this.initData()
      // 就是这么嚣张
      const fn = async _ => {
        try {
          await this.initData()
          await this.initDate()
          await this.getUpdateInfo()
        } catch (error) {
          console.log(error)
        }
      }
      fn().then( _ => {
        console.log('init success')
      })
      // 默认全选
      this.addAllDeliveryWeek()
      this.addAllDeliveryHour()
      // 判断国家select是否显示
      this.showCountryFun()
    },
    methods: {
      validatorUrl (rule, value, callback) {
        if (rule.required) {
          if (value.match(spaceReg) !== null) {
            callback(new Error(ruleLanguagePackage.notSpace))
          } else if (!regHref.test(value)) {
            callback(new Error(ruleLanguagePackage.notWWW))
          } else {
            callback()
          }
        } else {
          callback()
        }
      },
      spaceShowUrlFlag (obj, i) {
        var object = {}
        if (i !== undefined) {
          object = this.ruleForm[obj][i].value
        } else {
          object = this.ruleForm[obj]
        }
        if (object.indexOf(' ') !== -1) return true
        return false
      },
      spaceShowUrl (obj, i) {
        var object = {}
        if (i !== undefined) {
          object = this.ruleForm[obj][i].value
        } else {
          object = this.ruleForm[obj]
        }
        if (this.spaceShowUrlFlag(obj, i)) {
          var str = object
          return str.replace(spaceReg, '<span class="judeUrl-font">&nbsp;</span>')
        }
      },
      addImpressionUrl () {
        var date = new Date()
        this.ruleForm.impressionUrl.push({
          value: '',
          key: date.getTime()
        })
      },
      // 20181009 1-5 | 6
      judeAttributeProviderOptionsDisabled () {
        if (this.ruleForm.attributeProvider === '6') {
          this.options.attributeProvider.map(function (ele) {
            if (ele.value !== '6') {
              ele.disabled = true
            }
          })
        } else {
          this.options.attributeProvider.map(function (ele) {
            if (ele.value === '6') {
              ele.disabled = true
            }
          })
        }
      },
      // 获取已经保存的信息
      getUpdateInfo () {
        var that = this
        if (this.pageType === 'update') {
          var ajaxData = {
            offer_id: this.offerID,
            dsp_security_param: this.csrf
          }
          $.ajax({
            url: '/offer/offer-update-info',
            data: ajaxData,
            type: 'post',
            success: function (result) {
              // console.log(result)
              that.offerStatus = result.data.status
              that.showOfferID = result.data.show_offer_id
              that.channel = result.data.channel
              // 1
              that.ruleForm.campaignOwner = result.data.campaign_owner
              that.ruleForm.advertiser = result.data.sponsor
              that.ruleForm.attributeProvider = result.data.att_pro
              that.judeAttributeProviderOptionsDisabled()
              // 2
              that.ruleForm.platform = result.data.platform
              that.ruleForm.storeUrl = result.data.final_url
              that.ruleForm.title = result.data.title
              that.ruleForm.desc = result.data.desc
              that.ruleForm.name = result.data.pkg_name
              that.ruleForm.category = result.data.category_id
              that.ruleForm.trackingUrl = result.data.tracking_url
              if (result.data.impression_url) {
                result.data.impression_url.map(function (ele, i) {
                  that.ruleForm.impressionUrl.push({
                    key: i,
                    value: ele
                  })
                })
              }
              that.ruleForm.schedule = result.data.delivery_status
              var deliveryDate = []
              deliveryDate.push(result.data.delivery_start_day)
              deliveryDate.push(result.data.delivery_end_day)
              that.ruleForm.deliveryDate = deliveryDate
              if (result.data.delivery_week !== '""') {
                var weekarr = JSON.parse(result.data.delivery_week)
                that.ruleForm.deliveryWeek.splice(0)
                weekarr.map(function (ele) {
                  that.ruleForm.deliveryWeek.push(ele.toString())
                })
              }
              if (result.data.delivery_hour !== '""') {
                var hourArr = result.data.delivery_hour
                that.ruleForm.deliveryHour.splice(0)
                hourArr.map(function (ele) {
                  that.ruleForm.deliveryHour.push(ele.toString())
                })
              }
              that.ruleForm.comment = result.data.comment
              // 3
              that.ruleForm.payout = Number(result.data.payout)
              var daily_cap = Number(result.data.daily_cap)
              if (daily_cap === -1) daily_cap = null
              that.ruleForm.dailyCap = daily_cap
              var total_cap = Number(result.data.total_cap)
              if (total_cap === -1) total_cap = null
              that.ruleForm.totalCap = total_cap
              that.ruleForm.deliveryPrice = result.data.delivery_price
              // 4
              that.ruleForm.deviceType = result.data.device_target.toString()
              var specificDevice = JSON.parse(result.data.specific_device)
              if (specificDevice !== null) {
                that.ruleForm.specificDevice = specificDevice
              }
              that.ruleForm.minOSversion = result.data.min_os_version
              that.ruleForm.networkStatus = result.data.network_environment
              that.ruleForm.countryType = result.data.country_type.toString()
              that.ruleForm.country = result.data.country
              // 5
              that.ruleForm.iconList.push(result.data.icon)
              that.ruleForm.imageList = result.data.image
              var videoList = result.data.video
              if (videoList) {
                that.ruleForm.videoList = videoList
              }
              // 
              that.showCountryFun()
            }
          })
        }
      },
      changeStoreUrl () {
        this.spiderFlag = true
      },
      showCountryFun () {
        this.showCountry = false
        if (this.ruleForm.countryType !== '') {
          if (this.ruleForm.countryType !== '1') {
            this.showCountry = true
          }
        }
      },
      changeDeviceType () {
        this.ruleForm.specificDevice.splice(0)
      },
      changePlatform () {
        // 置空
        var that = this
        that.options.deviceType.splice(0)
        that.options.category.splice(0)
        that.options.minOSversion.splice(0)
        that.ruleForm.deviceType = ''
        that.ruleForm.category = ''
        that.ruleForm.minOSversion = ''
      },
      changeCountryType () {
        this.ruleForm.country.splice(0)
        this.showCountryFun()
      },
      judeChannel (newval) {
        var that = this
        this.options.attributeProvider.map(function (ele) {
          if (newval.toString() === ele.value) {
            that.channel = ele.channel
          }
        })
      },
      spiderAgain () {
        // 再次爬虫
      },
      spiderUse () {
        // 手动添加name和category
      },
      // 验证商店地址
      judeHref (platform, url, callback) {
        var that = this
        if (this.spiderFlag) {
          var ajaxData = {
            url: url,
            country: null,
            platform: platform,
            dsp_security_param: this.csrf
          }
          $.ajax({
            url: '/offer/get-url-info',
            data: ajaxData,
            type: 'post',
            success: function (result) {
              var result = JSON.parse(result)
              if (result.status === 1) {
                that.ruleForm.title = result.data.offer_title
                that.ruleForm.name = result.data.pkg_name
                var category_id = result.data.category_id
                that.options.category.map(function (ele) {
                  if (result.data.category_id === ele.value) {
                    that.ruleForm.category = category_id
                  }
                })
                callback(true)
              } else {
                callback(false)
              }
            }
          })
        } else {
          callback(true)
        }
        
      },
      // 初始化日期
      initDate () {
        var start = moment().add(-2, 'day').format('YYYY-MM-DD')
        var end = moment().add(14, 'day').format('YYYY-MM-DD')
        this.ruleForm.deliveryDate = [start, end]
      },
      // 初始化页面
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
            // Campaign Owner
            if (that.pageType === 'create') {
              result.data.user.map(function (ele) {
                if (ele.status === '1') {
                  that.options.campaignOwner.push({
                    value: ele.id,
                    label: ele.email
                  })
                }
              })
            }
            if (that.pageType === 'update') {
              result.data.user.map(function (ele) {
                that.options.campaignOwner.push({
                  value: ele.id,
                  label: ele.email
                })
              })
            }
            // advertiser
            result.data.ads.map(function (ele) {
              that.options.advertiser.push({
                value: ele.id,
                label: ele.ads
              })
            })
            // attributeProvider
            result.data.tpm.map(function (ele) {
              that.options.attributeProvider.push({
                channel: ele.channel,
                value: ele.id,
                label: ele.tpm,
                disabled: false
              })
            })
            // country
            var country = []
            result.data.country.map(function (ele) {
              country.push({
                value: ele.id,
                label: ele.full_name
              })
            })
            // specificDevice
            that.options.specificDeviceBase = result.data.mobile
            // country
            that.options.country = country
            // version
            that.options.minOSversionBase = result.data.version
            // category
            that.options.categoryBase = result.data.category
            // // initDate
            // that.initDate()
            // // 获取edit信息
            // that.getUpdateInfo()
          }
        })
      },
      addAllDeliveryWeek () {
        var that = this
        this.ruleForm.deliveryWeek.splice(0)
        this.options.deliveryWeek.map(function (ele) {
          that.ruleForm.deliveryWeek.push(ele.value)
        })
      },
      delAllDeliveryWeek () {
        this.ruleForm.deliveryWeek.splice(0)
      },
      addAllDeliveryHour () {
        this.ruleForm.deliveryHour.splice(0)
        this.ruleForm.deliveryHour = JSON.parse(JSON.stringify(this.options.deliveryHour))
      },
      delAllDeliveryHour  () {
        this.ruleForm.deliveryHour.splice(0)
      },
      // 判断totalCap
      judeTotalCap () {
        if (this.ruleForm.totalCap >= this.ruleForm.dailyCap) {
          return true
        } else {
          return false
        }
      },
      // 上传文件
      uploadFile (type) {
        var that = this
        var str = '.' + type + 'file'
        var filesInput = document.querySelector(str)
        filesInput.click()
        var addEventListenerFun = function () {
          filesInput.removeEventListener('change', addEventListenerFun, true)
          // 那么开始上传
          var files = filesInput.files
          var file = files[0]
          if (files.length !== 0) {
            var fileData = {
              file: file,
              fileName: file.name,
              size: file.size,
              type: file.type,
              width: null,
              height: null
            }
            that.judeUploadFile(fileData, type, function () {
              // console.log('judeUploadFile')
              // 上传函数
              that.uploadFun(fileData, type, function (err, result) {
                // 加载状态清除
                if (type === 'icon') {
                  that.ruleForm.iconLoading = false
                }
                if (type === 'image') {
                  that.ruleForm.imageLoading = false
                }
                if (type === 'video') {
                  that.ruleForm.videoLoading = false
                }
                // console.log('uploadFun')
                // 总是清空input file
                filesInput.value = ''
                if (err) {
                  console.log(err)
                  that.$message.error(ruleLanguagePackage.uploadImageError)
                  return
                } else {
                  // console.log(result)
                  var downData = {
                    url: result.Location,
                    width: fileData.width,
                    height: fileData.height,
                    size: fileData.size,
                    type: null,
                    mime_type: type,
                    key: result.key,
                    ratio: fileData.ratio
                  }
                  if (type === 'icon') {
                    downData.type = '1'
                  }
                  if (type === 'image') {
                    downData.type = '2'
                  }
                  if (type === 'video') {
                    downData.type = '3'
                  }
                  that.uploadCallback(downData, type)
                }
              })
            })
          }
        }
        filesInput.addEventListener('change', addEventListenerFun, true)
      },
      uploadRule (ratio) {
        if ((ratio >= minRatio && ratio <= maxRatio) || ratio === baseRatio || ratio === 1 / baseRatio || ratio === 1) return true
        return false
      },
      uploadRule1 (ratio) {
        if (((1 / ratio) >= minRatio && (1 / ratio) <= maxRatio)) return true
        return false
      },
      // 判断上传文件
      judeUploadFile (fileData, type, callback) {
        var that = this
        if (type === 'video') {
          if (fileData.type.indexOf(type) !== -1) {
            that.getOnlineFile(fileData, type, function (bob) {
              // console.log('getOnlineFile')
              var w = bob.videoWidth
              var h = bob.videoHeight
              var ratio = w / h
              fileData.width = w
              fileData.height = h
              fileData.ratio = ratio
              if (fileData.size <= maxVideoSize) {
                callback()
              } else {
                that.$message.error(ruleLanguagePackage.uploadVideoSizeMax)
              }
            })
          } else {
            that.$message.error(ruleLanguagePackage.fileTypeError)
          }
        } else {
          if (fileData.type.indexOf('image') !== -1) {
            that.getOnlineFile(fileData, type, function (bob) {
              // console.log('getOnlineFile')
              var w = bob.width
              var h = bob.height
              var ratio = w / h
              fileData.width = w
              fileData.height = h
              fileData.ratio = ratio
              if (fileData.size <= maxImageSize) {
                if (type === 'icon') {
                  if (w === h) {
                    callback()
                  } else {
                    that.$message.error(ruleLanguagePackage.uploadIconSizeError)
                  }
                }
                if (type === 'image') {
                  if (that.uploadRule(ratio) || that.uploadRule1(ratio)) {
                    callback()
                  } else {
                    that.$message.error(ruleLanguagePackage.uploadImageSizeError)
                  }
                }
              } else {
                that.$message.error(ruleLanguagePackage.uploadImageSizeMax)
              }
            })
          } else {
            that.$message.error(ruleLanguagePackage.fileTypeError)
          }
        }
      },
      // 上传s3函数
      uploadFun (data, type, callback) {
        var that = this
        // console.log('开始上传')
        // 加载
          if (type === 'icon') {
            that.ruleForm.iconLoading = true
          }
          if (type === 'image') {
            that.ruleForm.imageLoading = true
          }
          if (type === 'video') {
            that.ruleForm.videoLoading = true
          }
        var that = this
        var date = new Date()
        var fileName = date.getTime() + '_' + data.fileName
        console.log(fileName)
        // 上传状态
        s3.upload({
          Key: fileName,
          Body: data.file,
          ACL: 'public-read',
          ContentType: 'image/jpeg'
        }, function (err, result) {
          callback(err, result)
        })
      },
      // 删除s3函数
      deleteFun (data, index, list) {
        var that = this
        var photoKey = data.key
        // 权宜之策，暂时不删除s3文件
        photoKey = null
        if (photoKey) {
          s3.deleteObject({ Key: photoKey }, function (err, result) {
            if (err) {
              // console.log(err)
              that.$message.error(ruleLanguagePackage.s3DeleteFile)
            } else {
              // console.log(result)
              list.splice(index, 1)
            }
          })
        } else {
          list.splice(index, 1)
        }
      },
      // 上传s3成功之后的回调
      uploadCallback (data, type) {
        // console.log('uploadCallback')
        var flag = this.duplicateRemoval(this.ruleForm[type + 'List'], data)
        if (type === 'icon' && this.ruleForm[type + 'List'].length !== 1) {
          var icon0 = this.ruleForm[type + 'List'][0]
          this.deleteFun(icon0, 0, this.ruleForm[type + 'List'])
        }
        // clear
        this.ruleForm[type] = ''
      },
      // 去重函数
      duplicateRemoval (list, data) {
        // console.log('duplicateRemoval')
        var flag = true
        list.map(function (ele) {
          if (ele.url === data.url) {
            flag = false
          }
        })
        if (flag) {
          list.push(data)
        }
        return flag
      },
      // 验证本地文件
      getOnlineFile (data, type, callback) {
        var that = this
        var reader = new FileReader()
        reader.onload = function (theFile) {
          var url = theFile.target.result
          that.getOnline(type, url, callback)
        }
        reader.readAsDataURL(data.file)
      },
      // 预处理文件地址信息
      getOnline (type, src, callback, errorcallback) {
        if (type !== 'video') {
          var media = new Image()
          media.src = src
          media.onload = function () {
            callback(this)
          }
          media.error = function () {
            errorcallback(this)
          }
        } else {
          var videoDom = document.createElement('video')
          videoDom.classList.add('testVideo', 'dn')
          videoDom.src = src
          document.body.appendChild(videoDom)
          videoDom.onloadeddata = function () {
            callback(this)
          }
          videoDom.error = function () {
            errorcallback(this)
          }
        }
      },
      // 点击preview按钮
      previewAddFile (type) {
        var that = this
        var ajaxData = {
          width: null,
          height: null,
          key: null,
          size: null,
          type: type,
          url: null
        }
        if (type === 'icon') {
          var src = this.ruleForm.icon
          this.getOnline(type, src, function (obj) {
            var w = obj.width
            var h = obj.height
            var ratio = w / h
            if (w === h) {
              ajaxData = {
                width: w,
                height: h,
                key: null,
                size: null,
                type: '1',
                mime_type: type,
                url: src,
                ratio: ratio
              }
              that.uploadCallback(ajaxData, type)
            } else {
              that.$message.error(ruleLanguagePackage.uploadIconSizeError)
            }
          })
        }
        if (type === 'image') {
          var src = this.ruleForm.image
          this.getOnline(type, src, function (obj) {
            var w = obj.width
            var h = obj.height
            var ratio = w / h
            ajaxData = {
              width: w,
              height: h,
              key: null,
              size: null,
              type: '2',
              mime_type: type,
              url: src,
              ratio: ratio
            }
            if (that.uploadRule(ratio) || that.uploadRule1(ratio)) {
              that.uploadCallback(ajaxData, type)
            } else {
              that.$message.error(ruleLanguagePackage.uploadImageSizeError)
            }
          })
        }
        if (type === 'video') {
          var src = this.ruleForm.video
          this.getOnline(type, src, function (obj) {
            var w = obj.videoWidth
            var h = obj.videoHeight
            var ratio = w / h
            ajaxData = {
              width: w,
              height: h,
              key: null,
              size: null,
              type: '3',
              mime_type: type,
              url: src,
              ratio: ratio
            }
            that.uploadCallback(ajaxData, type)
          })
        }
      },
      // 表单提交
      submitForm (formName) {
        // console.log('提交表单')
        var that = this
        this.spiderFlag = false
        // that.submitAjax()
        this.$refs[formName].validate(function (valid) {
          if (valid) {
            console.log('submit!')
            that.submitAjax()
          } else {
            console.log('error submit!!')
            return false
          }
        })
      },
      // 重置表单
      resetForm(formName) {
        this.$refs[formName].resetFields()
        window.scrollTo(0, 0)
      },
      submitAjax () {
        var that = this
        var impressionUrlArr = that.ruleForm.impressionUrl.map(function (ele) {
          return ele.value
        })
        var ajaxData = {
          status: that.offerStatus,
          offer_id: that.offerID,
          channel: that.channel,
          dsp_security_param: that.csrf,
          // 1
          campaign_owner: that.ruleForm.campaignOwner,
          sponsor: that.ruleForm.advertiser,
          att_pro: that.ruleForm.attributeProvider,
          // 2
          platform: that.ruleForm.platform,
          final_url: that.ruleForm.storeUrl,
          title: that.ruleForm.title,
          desc: that.ruleForm.desc,
          pkg_name: that.ruleForm.name,
          category_id: that.ruleForm.category,
          tracking_url: that.ruleForm.trackingUrl,
          impression_url: impressionUrlArr,
          delivery_status: that.ruleForm.schedule,
          delivery_start_data: that.ruleForm.deliveryDate[0],
          delivery_end_data: that.ruleForm.deliveryDate[1],
          delivery_week: that.ruleForm.deliveryWeek,
          delivery_hour: that.ruleForm.deliveryHour,
          comment: that.ruleForm.comment,
          // 3
          payout: that.ruleForm.payout,
          daily_cap: that.ruleForm.dailyCap,
          total_cap: that.ruleForm.totalCap,
          delivery_price: that.ruleForm.deliveryPrice,
          // 4
          device_target: that.ruleForm.deviceType,
          specific_device: that.ruleForm.specificDevice,
          min_os_version: that.ruleForm.minOSversion,
          network_environment: that.ruleForm.networkStatus,
          country_type: that.ruleForm.countryType,
          // 这里是个坑
          country: JSON.parse(JSON.stringify(that.ruleForm.country)),
          // 5
          icon: that.ruleForm.iconList,
          image: that.ruleForm.imageList,
          video: that.ruleForm.videoList
        }
        if (that.ruleForm.countryType === '1') {
          ajaxData.country.splice(0)
        }
        console.log(ajaxData)
        // that.pageType = 'test'
        if (that.pageType === 'create') {
          $.ajax({
            url: '/offer/offer-create',
            type: 'post',
            data: ajaxData,
            success: function (result) {
              if (result.status === 1) {
                window.location.href = '/offer/offer-index'
              } else {
                that.$message.error(result.info)
              }
            },
            error: function (result) {
              // console.log(result)
            }
          })
        }
        if (that.pageType === 'update') {
          $.ajax({
            url: '/offer/offer-update',
            type: 'post',
            data: ajaxData,
            success: function (result) {
              if (result.status === 1) {
                window.location.href = '/offer/offer-index'
              } else {
                that.$message.error(result.info)
              }
            },
            error: function (result) {
              // console.log(result)
            }
          })
        }
      }
    },
    watch: {}
  })
</script>
<style>
  .contentBox{
    padding: 0 20px;
  }
  .content-li{
    border-bottom: 1px solid #ccc;
    overflow: hidden;
  }
  .content-li:last-child{
    border: 0;
  }
  .content-li-title{
    font-weight: bold;
    margin-top: 20px;
  }
  .num-circle{
    width: 20px;
    height: 20px;
    color: #1a8eff;
    border: 2px solid #1a8eff;
    border-radius: 50%;
    text-align: center;
    line-height: 17px; 
    margin-right: 20px;
  }
  .content-con{
    padding: 20px 0;
  }
  .imgDocker{
    margin-top: 20px;
  }
  .showImgBox{
    width: 200px;
    height: 200px;
    overflow: hidden;
    border: 1px solid #ccc;
    margin: 10px;
    background: #efedef;
    box-shadow: 5px 5px 10px 0 #ccc;
    box-sizing: content-box;
    border-radius: 10px;
    position: relative;
  }
  .showImg{
    width: 200px;
    height: 200px;
    padding: 10px;
  }
  .showImgTitle{
    padding: 10px;
    word-break: break-all;
  }
  .showImg img,video{
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    background: #fff;

  }
  .close{
    position: absolute;
    right: 0;
    top: 0;
    background: #fff;
    opacity: 1;
    border-radius: 50%;
    font-size: 14px;
  }
  .messageVisibleShow{
    background: #efefef;
    padding: 10px 20px;
  }
  .el-checkbox{
    margin-left: 30px;
  }
  .checkbox-docker {
    margin-top: 20px;
    padding: 20px 0;
    border: 1px solid #dcdfe6;
    border-radius: 4px;
  }
  .judeUrl-box{
    line-height: 22px;
    padding: 10px 14px;
    border: 1px solid #dcdfe6;
    border-radius: 4px;
    word-wrap: break-word;
  }
  .judeUrl-font{
    border: 1px solid red;
  }
  .tooltipMsg{
    background: #efefef;
    margin-top: 20px;
    padding: 10px;
    text-align: center;
  }
</style>