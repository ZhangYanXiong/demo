<? 
//http://www.jb51.net 
class upLoad{ 
public $length; //限定文件大小 
public $file; //判断此类是用于图片上传还是文件上传 
public $fileName; //文件名 
public $fileTemp; //上传临时文件 
public $fileSize; //上传文件大小 
public $error; //上传文件是否有错,php4没有 
public $fileType; //上传文件类型 
public $directory; // 
public $maxLen; 
public $errormsg; 
function __construct($length,$file=true,$directory) 
{ 
$this->maxLen=$length; 
$this->length=$length*1024; 
$this->file=$file; //true为一般文件，false为图片的判断 
$this->directory=$directory; 
} 
public function upLoadFile($fileField) 
{ 
$this->fileName=$fileField['name']; 
$this->fileTemp=$fileField['tmp_name']; 
$this->error=$fileField['error']; 
$this->fileType=$fileField['type']; 
$this->fileSize=$fileField['size']; 
$pathSign = DIRECTORY_SEPARATOR; // / 
if($this->file) //一般文件上传 
{ 
$path = $this->_isCreatedDir($this->directory);//取得路径 
if($path)//http://www.jb51.net 
{ 
$createFileType = $this->_getFileType($this->fileName);//设置文件类别 
$createFileName=uniqid(rand()); //随机产生文件名 
$thisDir=$this->directory.$pathSign.$createFileName.".".$createFileType; 
if(@move_uploaded_file($this->fileTemp,$thisDir)) //把临时文件移动到规定的路径下 
{ 
return $thisDir; 
} 
} 
}else{ //图片上传 
$path = $this->_isCreatedDir($this->directory);//取得路径 
if($path)//路径存在//http://www.jb51.net 
{ 
$createFileType = $this->_getFileType($this->fileName);//设置文件类别 
$createFileName=uniqid(rand()); 
return @move_uploaded_file($this->fileTemp,$this->directory.$pathSign.$createFileName.".".$createFileType) ? true : false; 
} 
} 
} 
public function _isBig($length,$fsize) //返回文件是否超过规定大小 
{ 
return $fsize>$length ? true : false; 
} 
public function _getFileType($fileName) //获得文件的后缀 
{ 
return end(explode(".",$fileName)); 
} 
public function _isImg($fileType) //上传图片类型是否允许 
{ 
$type=array("jpeg","gif","jpg","bmp"); 
$fileType=strtolower($fileType); 
$fileArray=explode("/",$fileType); 
$file_type=end($fileArray); 
return in_array($file_type,$type);//http://www.jb51.net 
} 
public function _isCreatedDir($path) //路径是否存在，不存在就创建 
{ 
if(!file_exists($path)) 
{ 
return @mkdir($path,0755)?true:false; //权限755// 
} 
else 
{ 
return true; 
} 
} 
public function showError() //显示错误信息 
{//http://www.jb51.net 
echo "<Script Language ='JavaScript'>\n history.back();\n alert(' $this->errormsg');\n </Script> \n"; 
exit(); 
} 
} 
class multiUpLoad extends upLoad{ 
public $FILES; 
function __construct($arrayFiles,$length,$file=true,$directory) 
{ 
$this->FILES=$arrayFiles; 
parent::__construct($length,$file,$directory); 
} 
function upLoadMultiFile() 
{ 
$arr=array(); 
if($this->_judge()||$this->_judge()=="no") //文件全部符合规格,就开始上传 
{ 
foreach($this->FILES as $key=>$value) 
{ 
$strDir=parent::upLoadFile($this->FILES[$key]); 
array_push($arr, $strDir); 
} 
//http://www.jb51.net 
return $arr; 
}else 
{ 
return false; 
} 
} 
function _judge() 
{ 
if($this->file) 
{ 
foreach($this->FILES as $key=>$value) 
{ 
if($this->_isBig($this->length,$value['size'])) 
{ 
$this->errormsg="文件超过 $this->maxLen K"; 
parent::showError(); 
} 
if($value['error']=UPLOAD_ERR_NO_FILE) 
{ 
//$this->errormsg="上传文件出现错误"; 
//parent::showError(); 
return "no"; 
} 
} 
return true; 
}else 
{ 
//http://www.jb51.net 
foreach($this->FILES as $key=>$value) 
{ 
if($this->_isBig($this->length,$value['size'])) 
{ 
$this->errormsg="图片超过$this->maxLen"; 
parent::showError(); 
} 
if($value['error']!=0) 
{ 
$this->errormsg="上传图片出现错误"; 
parent::showError(); 
} 
if(!$this->_isImg($value['type'])) 
{ 
$this->errormsg="图片格式不对"; 
parent::showError(); 
} 
} 
return true; 
} 
} 
} 
?> 