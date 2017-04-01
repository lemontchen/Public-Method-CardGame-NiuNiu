<?php

    /**
     * 数据流图片接收[base64解码]
     * @param   $pic_arr  数组
     * $pic_arr = array(
     *      '0'=>数据流,
     *      '1'=>数据流,
     * )
     * @date    2016-6-1 11:44:13
     */
    public function savePic($pic_arr = '') {
        //新建文件夹
        $new_folder = date('Ymd', time());
        //保存路径
        $path = './Public/Uploads/' . $new_folder;
        // 不存在的保存目录予以创建
        if (!is_dir($path)) {
            mkdir($path);
        }
        //扩展名
        $ext = '.png';
        //写入内容
        $pic_url = array();
        foreach ((array) $pic_arr as $key => $val) {
            $filename = time() . rand(0000, 9999);
            $save = 'Public/Uploads/' . $new_folder . '/' . $filename . $ext; //图片保存用这个路径
            file_put_contents($save, base64_decode($val) . '|');
            $pic[] = '/' . $save; //改变原来编码的数组的值
        }
        $pic_url = implode('|', $pic); //多个图串起来
        return $pic_url;
    }

/**
 * 数据流图片上传
 * $post_img字符串格式，多个用“|”隔开
 * $ext图片后缀
 * 
 */
public function dataImage($post_img, $ext = '.jpg')
 {
        //图片----单张图片(后期根据测试数据满足3张图片)
        if (empty($post_img)) {
            $test_five = '';
        } else {
            $post_img   = explode('|', $post_img);//字符串转成数组
            $post_img_1 = array_filter($post_img);
            $post_img_2 = implode('|', $post_img_1);
            $test_two   = explode('|', $post_img_2);//字符串转成数组
            
            //将一维数组转换成二维数组
            $test_three = array();
            foreach ($test_two as $k => $v) {
                $test_three[] = array('img' => $v);
            }
            //循环图片存储
            foreach ($test_three as $k => $v) {
                //保存图片路径
                $path_one = './Public/Uploads/'.date('Ymd').'/';//存储到项目
                $path_two = '/Public/Uploads/'.date('Ymd').'/';//存储到数据表
                //没有就创建
                if (!file_exists($path_one)){
                    mkdir($path_one);
                }
                $filename = md5(time().mt_rand(10, 9999)).$ext;//要生成的图片名字
                $thumb = $path_one.'thumb_'.$filename;
                $newFilePath_one = $path_one.$filename;//项目地址
                $newFilePath_two = $path_two.'thumb_'.$filename;//数据url--存储路径
                
                $dataIn = base64_decode($v['img']);//解码
				
                //$newFile = fopen($newFilePath_one,"w"); //打开文件准备写入
                //fwrite($newFile,$dataIn); //写入二进制流到文件
                //fclose($newFile); //关闭文件
                
				file_put_contents($newFilePath_one, $dataIn);
				
				//生成缩略图
                $image = new \Think\Image();
                $image->open($newFilePath_one);
                $image->thumb(300, 300,\Think\Image::IMAGE_THUMB_SCALE)->save($thumb);
                $test_three[$k]['image'] = $newFilePath_two;//输出图片路径
            }
            //将二维数组转换为一维数组
            $test_four = array();
            foreach ($test_three as $k => $v){
                $test_four[] = $v['image'];
            }
            //将一维数组转换成字符串
            $test_five = implode('|',$test_four);//3张图片合并--图片url路径
        }
		return $test_five;
 }

?>
