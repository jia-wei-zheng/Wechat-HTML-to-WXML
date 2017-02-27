<?php 
    namespace WXML;
    /**
        @author yuno
        @time 2017/02/27
        @content html 转 wxml
    */
    class WXML{
        protected static $view;
        protected static $match;
        protected static $image;
        // 图片占位符
        protected static $ImgPlaceholder = '<[image:%u]>';

        protected static $place;

        protected static $patterns;
        protected static $ApiJson;

        // 构造方法
        public function __construct($view){
            self::$patterns = [
                'image'=>'/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i'
            ];

            self::$view = $view;
        }
        // 初始化方法
        public static function _initialize(){
            self::_image();
            self::_imagePlaceholder();
        }
        
        // 获得所有图片
        protected static function _image(){
            preg_match_all(self::$patterns['image'],self::$view,self::$match);
            self::$image = self::$match;
        }
        
        // 将图片替换成占位符
        protected static function _imagePlaceholder(){
            foreach(self::$image[0] as $key=>$val){
                self::$place = vsprintf(self::$ImgPlaceholder,[$key]);
                self::$view = preg_replace($val,self::$place,self::$view);
            }
        }

        // webservice 格式
        public static function _json(){
            self::$ApiJson = [
                'image'=>self::$image[2],
                'matter'=>self::$view
            ];
            return json_encode(self::$ApiJson);
        }

        public function __clone(){
			trigger_error('Clone is not allowed !');
		}
    }
    
    // new class
    $view = new WXML();
    // 初始化
    $view::_initialize();
    echo $view::_json();
    
?>
