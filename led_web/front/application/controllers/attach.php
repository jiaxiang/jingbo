<?php defined('SYSPATH') OR die('No direct access allowed.');

class Attach_Controller extends Template_Controller {

    /**
     * 图片附件显示 
     */
    public function news($img_dir1, $img_dir2, $img_dir3, $img_dir4, $img_filename)
    {
        
        $imgArr = explode('.', $img_filename);
        $img = $imgArr[0];
        $img_type = isset($imgArr[1])?$imgArr[1]:'jpg';
        
        /* $imgArr = explode('_', $img);
        $img_id = isset($imgArr[0])?$imgArr[0]:NULL;
        $w = isset($imgArr[1])?$imgArr[1]:0;
        $h = isset($imgArr[2])?$imgArr[2]:0;
        //兼容格式:40x40
        if(strpos(strtolower($w),'x')){
            $x = explode("x", $w);
            $w = isset($x[0])?$x[0]:0;
            $h = isset($x[1])?$x[1]:0;
        } */
       
        $img_id = $img_dir1.'/'.$img_dir2.'/'.$img_dir3.'/'.$img_dir4.'/'.$imgArr[0];
        $filename = AttService::get_instance('news')->get_img_dir($img_id, 0, 0, $img_type);
       	//d($filename);		
		
        // 尝试通过图片类型判断
        $file_type_current = page::getImageType($filename);
        $file_type_current = (($file_type_current == 'jpg')?'jpeg':'gif');
        ob_end_clean();
        header("Content-type: image/{$file_type_current}");
        @readfile($filename);
        ob_end_flush();
        die();
    }
    
}
