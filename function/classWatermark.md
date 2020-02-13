simple php class to put watermark

Example
define('ROOT',$_SERVER['DOCUMENT_ROOT']);
$watermark = new Watermark(ROOT.'anim.jpg');
$watermark->setWatermarkImage(ROOT.'watermark3.png');
$watermark->setType(Watermark::CENTER);//BOTTOM_RIGHT_SMALL://BOTTOM_RIGHT:
$a = $watermark->saveAs(ROOT.'test.jpg');
