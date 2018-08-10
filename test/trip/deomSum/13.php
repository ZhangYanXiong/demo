<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/29
 * Time: 21:25
 */
header('Content-type:image/png');//设置mime type
$img = imagecreate(400,300);//设置图片像素
imagecolorallocate($img,255,255,255);//给图片上色
imageellipse($img,200,200,500,50,imagecolorallocate($img,255,0,0));//在图片上绘制图形，中心点200,200；宽高50,50
imagepng($img);//设置图片格式为PNG