<?php
namespace backend\libs;

use Yii;
use PHPExcel;
use PHPExcel_Writer_Excel2007;
use PHPExcel_IOFactory;
use PHPExcel_Cell;

class ExcelLibrary
{

    CONST HEADER_ROW        =   'A1';//标题开始行号

    public static function getExcel($header=[], $data=[], $filename='report.xls', $is_zip=false)
    {
        $objPHPExcel = new PHPExcel();

        //header
        $objPHPExcel->getActiveSheet()->fromArray(
            $header,
            NULL,
            self::HEADER_ROW
        );

        //data
        $column = 2;

        $objActSheet = $objPHPExcel->getActiveSheet();

        foreach($data as $key => $rows)  //行写入
        {
            $span = 0;

            foreach($rows as $keyName => $value) // 列写入
            {
                $j = PHPExcel_Cell::stringFromColumnIndex($span);

                $objActSheet->setCellValue($j.$column, $value);

                $span++;
            }

            $column++;
        }

        //是否压缩
        if ($is_zip)
        {
            //生成文件
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save($filename);
        }
        else
        {
            ob_end_clean();//清除缓存,避免乱码
            //下载
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }


    }

    /**
     * 生成压缩文件
     * @param $file_path
     * @param $uid
     * @param string $zipFileName
     * @return bool
     */
    public static function getZip($file_path, $uid, $zipFileName = 'report.zip')
    {
        //实例化
        $zip = new \ZipArchive();

        //打开压缩文件,不存在就创建
        $res = $zip->open($zipFileName, \ZipArchive::CREATE);

        //创建压缩文件失败
        if ($res !== true) return false;

        //文件路径
        $file_path = rtrim($file_path, '/') . '/';

        //获取目录下的文件
        $files = scandir($file_path);

        foreach ($files as $file)
        {
            if ($file == '.' || $file == '..') continue;

            $zip->addFile($file_path . $file, $uid . '/'.$file);

        }

        //关闭资源
        $zip->close();

        return true;
    }

    /**
     * 下载zip文件
     * @param $filename
     */
    public static function downloadZip($filename)
    {
        //获取文件名
        $base_name = pathinfo($filename, PATHINFO_BASENAME);

        //清除缓存,避免乱码
        ob_end_clean();

        //文件类型 zip格式的
        header("Content-Type: application/zip");

        //返回文件大小
        header('Accept-Length:' . filesize($filename));

        //这里对客户端的弹出对话框，对应的文件名
        header("Content-Disposition: attachment; filename=". $base_name);

        @readfile($filename);

    }

    /**
     * 删除文件或目录
     * @param $file_path
     * @return bool
     */
    public static function delFile($file_path)
    {
        if (is_dir($file_path))
        {
            exec('rm -Rf ' . $file_path);
        }
        else
        {
            unlink($file_path);
        }

        return true;
    }

    public static function excelToArray($file_path = '')
    {
        if ( empty( $file_path ) || !file_exists($file_path) )
        {
            return 'file not exists';
        }
    }

    /**
     * @param $file
     * @param $name
     * @return array|bool
     */
    public static function getUploadExcelData( $file, $name )
    {
        if ( empty( $file ) || empty( $name ) )
        {
            return [];
        }

        if ( empty( $file[$name]['tmp_name'] ) )
        {
            return false;
        }

        $data   = self::getExcelData( $file['upload_file']['tmp_name'] );

        return !empty( $data ) ? $data : [];
    }

    /**
     * 读取excel表格中的数据
     * @author xxx
     * @dateTime 2017-06-12T09:39:01+0800
     * @param    string $filePath excel文件路径
     * @param    integer $startRow 开始的行数
     * @return   array
     */
    public static function getExcelData($filePath, $startRow = 1)
    {

        $PHPExcel = new PHPExcel();

        // 默认用excel2007读取excel，若格式不对，则用之前的版本进行读取
        $PHPReader = new \PHPExcel_Reader_Excel2007();

        //setReadDataOnly Set read data only 只读单元格的数据，不格式化 e.g. 读时间会变成一个数据等
        $PHPReader->setReadDataOnly(TRUE);

        if (!$PHPReader->canRead($filePath))
        {
            $PHPReader = new \PHPExcel_Reader_Excel5();

            $PHPReader->setReadDataOnly(TRUE);

            if (!$PHPReader->canRead($filePath))
            {
                return 'can not read this file';
            }
        }

        $PHPExcel = $PHPReader->load($filePath);

        //获取sheet的数量
        $sheetCount = $PHPExcel->getSheetCount();

        //获取sheet的名称
        $sheetNames = $PHPExcel->getSheetNames();

        //获取所有的sheet表格数据
        $excelData = array();

        $emptyRowNum = 0;
        for ($i = 0; $i < $sheetCount; $i++)
        {
            // 读取excel文件中的第一个工作表
            $currentSheet = $PHPExcel->getSheet($i);

            // 取得最大的列号
            $allColumn = $currentSheet->getHighestColumn();

            // 取得一共有多少行
            $allRow = $currentSheet->getHighestRow();

            $arr = array();

            for ($currentRow = $startRow; $currentRow <= $allRow; $currentRow++)
            {
                // 从第A列开始输出
                for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++)
                {
                    $val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65, $currentRow)->getValue();
                    $arr[$currentRow][] = trim($val);
                }

                $arr[$currentRow] = array_filter($arr[$currentRow]);

                //统计连续空行
                if(empty($arr[$currentRow]) && $emptyRowNum <= 50)
                {
                    $emptyRowNum++ ;
                }
                else
                {
                    $emptyRowNum = 0;
                }

                //防止坑队友的同事在excel里面弄出很多的空行，陷入很漫长的循环中，设置如果连续超过50个空行就退出循环，返回结果
                //连续50行数据为空，不再读取后面行的数据，防止读满内存
                if($emptyRowNum > 50)
                {
                    break;
                }
            }
            $excelData[$i] = $arr; //多个sheet的数组的集合
        }

        // 这里我只需要用到第一个sheet的数据，所以只返回了第一个sheet的数据
        $returnData = $excelData ? array_shift($excelData) : [];

        // 第一行数据就是空的，为了保留其原始数据，第一行数据就不做array_fiter操作；
        $returnData = $returnData && isset($returnData[$startRow]) && !empty($returnData[$startRow]) ? array_filter($returnData) : $returnData;

        return $returnData;
    }

}