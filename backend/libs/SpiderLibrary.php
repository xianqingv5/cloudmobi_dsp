<?php
namespace backend\libs;

use Yii;
use backend\services\CategoryService;
use common\models\AndroidCategory;
use common\models\IosCategory;

class SpiderLibrary
{
    public static $res = ['status'=>1, 'info'=> '', 'data'=>[]];
    /**
     * 抓取网页内容,匹配标签
     * @return string
     */
    public static function main()
    {
        // 获取参数
        $url = Yii::$app->request->post('url', '');
        $platform = Yii::$app->request->post('platform', '');

        // 获取远程文件内容
        $content = self::_getUrlContent($url);
        $return = [];
        try {
            // 根据不同的平台匹配不同的信息
            if ($platform == 'android') {
                // 获取标签
                $type = self::get_tag_data($content, 'a', 'itemprop', 'genre');
                $android_title = self::get_tag_data($content, 'h1', 'itemprop', 'name');
                if ($type) {
                    $return['type'] = $type[0];
                    if ($android_title) {
                        $return['offer_title'] = htmlspecialchars_decode(filter_var($android_title[0], FILTER_SANITIZE_STRING));
                    }
                    // 获取包名
                    $parse_url = explode('/', parse_url($url)['query']);
                    if (!empty($parse_url) ) {
                        parse_str($parse_url[0], $query);
                        $return['pkg_name'] = $query['id'];
                    }
                    // 获取标签对应的id
                    $return['category_id'] = self::_getCategoryId('US', $type[0], 1);
                }
                self::$res['data'] = $return;
            } else if($platform == 'ios'){
                // 获取链接路径
                $parse_url = explode('/', parse_url($url)['path']);
                // 匹配标签
                $category_arr = self::get_tag_data($content, 'a', 'class', 'link');
                $title_arr = self::get_tag_data($content, 'h1', 'class', 'product-header__title app-header__title');

                // 处理标签数据
                $category = !empty($category_arr) ? $category_arr[1] : '';
                $title = !empty($title_arr) ? explode(' ',trim(filter_var($title_arr[0], FILTER_SANITIZE_STRING)))[0] : '';
                $return['type'] = $category;

                $return['offer_title'] = htmlspecialchars_decode(trim($title));

                // 获取数据库中的标签id
                $return['category_id'] = '';
                if (!empty($parse_url) && isset($parse_url['1'])) {
                    $return['category_id'] = self::_getCategoryId($parse_url[1], $category, 2);
                }

                // 获取包名
                if ( !empty($parse_url) ) {
                    $return['pkg_name'] = substr(array_pop($parse_url), 2);
                }
                self::$res['data'] = $return;
            }
        } catch (\Exception $e) {
            self::$res['status'] = 0;
            self::$res['info'] = $e->getMessage();
        }

        return self::$res;
    }

    /**
     * @param $country
     * @param $category
     * @param $type 1:android 2:ios
     * @return int
     */
    private static function _getCategoryId($country, $category, $type)
    {
        $cid = 0;
        // 数据库中国家缩写对应类型字段
        $c = [
            'US' => 'en_name',
            'CN' => 'zh_cn',
            'JP' => 'ja',
        ];

        // 获取国家缩写
        $short_name = strtoupper($country);
        if (!isset($c[$short_name])) return $cid;

        // 查询APP分类信息
        $where[] = $c[$short_name] . "='" . $category . "'";
        $res = CategoryService::getCategoryData($type, ['id'], $where);

        return $res ? $res[0]['id'] : $cid;
    }

    /**
     * 从url中读取数据
     * @param $url
     * @return string
     */
    private static function _getUrlContent($url)
    {
        $content = '';
        // 打开文件资源
        $handle = @fopen($url, 'r');
        if ($handle) {
            // 读取资源流到一个字符串, -1:读取全部的数据
            $content = stream_get_contents($handle, -1);
            fclose($handle);
        }
        return $content;
    }

    /**
     * 正则匹配标签信息
     * @param $html
     * @param $tag
     * @param $attr
     * @param $value
     * @return mixed
     */
    private static function get_tag_data($html,$tag,$attr,$value){
        $regex = '/<'.$tag.'.*?'.$attr.'=["|\']'. $value . '["|\'].*?>(.*?)<\/'.$tag.'>/is';
        preg_match_all($regex,$html,$matches, PREG_PATTERN_ORDER);
        return $matches[1];
    }
}
