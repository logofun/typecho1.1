<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/** 输出文章缩略图 */ 
function showThumbnail($widget)
{ 
    $attach = $widget->attachments(1)->attachment;
    $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i'; 
    
if (preg_match_all($pattern, $widget->content, $thumbUrl)) {
         echo $thumbUrl[1][0];
    } else     if ($attach->isImage) {
      echo $attach->url; 
    } else {
        echo $random;
    }
}

// myself code by crab 
// 
function img_postthumb($cid) {
   $db = Typecho_Db::get();
   $rs = $db->fetchRow($db->select('table.contents.text')
       ->from('table.contents')
       ->where('table.contents.cid=?', $cid)
       ->order('table.contents.cid', Typecho_Db::SORT_ASC)
       ->limit(1));
$img_src='';
   preg_match_all("/\<img.*?src\=\"(.*?)\"[^>]*>/i", $rs['text'], $thumbUrl);  //通过正则式获取图片地址
   $img_src = $thumbUrl[1][0];  //将赋值给img_src
   if (empty ($img_src)){
     $img_src ="http://cfskr.img48.wal8.com/img48/557301_20160918094046/147565611504.jpg";
   };
   echo $img_src;

   // $img_counter = count($thumbUrl[0]);  //一个src地址的计数器


   // switch ($img_counter > 0) {
   //     case $allPics = 1:
   //         echo $img_src;  //当找到一个src地址的时候，输出缩略图
   //         break;
   //     default:
   //         echo "http://cfskr.img48.wal8.com/img48/557301_20160918094046/147565611504.jpg";  //没找到(默认情况下)，不输出任何内容
   //};
}


function themeConfig(Typecho_Widget_Helper_Form $form) {

        $Compress= new Typecho_Widget_Helper_Form_Element_Radio('Compress',
        array('able' => _t('启用'),
            'disable' => _t('禁止'),
        ),
        'disable', _t('是否启用HTML代码压缩功能'), _t('默认禁止，启用则会gzip压缩HTML代码'));
    $form->addInput($Compress);
    
    $Instantclick= new Typecho_Widget_Helper_Form_Element_Radio('Instantclick',
        array('able' => _t('启用'),
            'disable' => _t('禁止'),
        ),
        'disable', _t('是否启用页面预加载功能'), _t('默认禁止，启用则会提升网站访问速度'));
    $form->addInput($Instantclick);

    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('你的头像地址【必填】'), _t('在这里填入一个图片URL地址, 以在网站标题/文章内页底部前加上一个自己的头像'));
    $form->addInput($logoUrl); 

    $gyw = new Typecho_Widget_Helper_Form_Element_Textarea('gyw', NULL, NULL, _t('关于我'), _t('在这里填入你的个人介绍，默认显示在文章内页底部'));
    
    $form->addInput($gyw);

    $glink = new Typecho_Widget_Helper_Form_Element_Text('glink', NULL, NULL, _t('你的github库'), _t('在这里填入你的github库地址'));
    $form->addInput($glink);
    
    $wlink = new Typecho_Widget_Helper_Form_Element_Text('wlink', NULL, NULL, _t('你的微博主页'), _t('在这里填入你的微博主页地址'));
    $form->addInput($wlink);

    $ico = new Typecho_Widget_Helper_Form_Element_Text('ico', NULL, NULL, _t('你的ico图标地址【必填】'), _t('在这里填入你的ICO图标地址，若没有你可以自行制作ico图标后放到站点根目录，在此处填入链接即可'));
    $form->addInput($ico);

    $thumbDefaultUrl = new Typecho_Widget_Helper_Form_Element_Text('thumbDefaultUrl',null, _t('http://cfskr.img48.wal8.com/img48/557301_20160918094046/147565611504.jpg'), _t('文章的默认缩略图'), _t('这里填入了一个默认图片URL地址，是我比较喜欢的图，如没有设置缩略图的，则将自动启用这个默认缩略图'));
    $form->addInput($thumbDefaultUrl);
}

function compressHtml($html_source) {
    $chunks = preg_split('/(<!--<nocompress>-->.*?<!--<\/nocompress>-->|<nocompress>.*?<\/nocompress>|<pre.*?\/pre>|<textarea.*?\/textarea>|<script.*?\/script>)/msi', $html_source, -1, PREG_SPLIT_DELIM_CAPTURE);
    $compress = '';
    foreach ($chunks as $c) {
        if (strtolower(substr($c, 0, 19)) == '<!--<nocompress>-->') {
            $c = substr($c, 19, strlen($c) - 19 - 20);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 12)) == '<nocompress>') {
            $c = substr($c, 12, strlen($c) - 12 - 13);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 4)) == '<pre' || strtolower(substr($c, 0, 9)) == '<textarea') {
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 7)) == '<script' && strpos($c, '//') != false && (strpos($c, "\r") !== false || strpos($c, "\n") !== false)) {
            $tmps = preg_split('/(\r|\n)/ms', $c, -1, PREG_SPLIT_NO_EMPTY);
            $c = '';
            foreach ($tmps as $tmp) {
                if (strpos($tmp, '//') !== false) {
                    if (substr(trim($tmp), 0, 2) == '//') {
                        continue;
                    }
                    $chars = preg_split('//', $tmp, -1, PREG_SPLIT_NO_EMPTY);
                    $is_quot = $is_apos = false;
                    foreach ($chars as $key => $char) {
                        if ($char == '"' && $chars[$key - 1] != '\\' && !$is_apos) {
                            $is_quot = !$is_quot;
                        } else if ($char == '\'' && $chars[$key - 1] != '\\' && !$is_quot) {
                            $is_apos = !$is_apos;
                        } else if ($char == '/' && $chars[$key + 1] == '/' && !$is_quot && !$is_apos) {
                            $tmp = substr($tmp, 0, $key);
                            break;
                        }
                    }
                }
                $c .= $tmp;
            }
        }
        $c = preg_replace('/[\\n\\r\\t]+/', ' ', $c);
        $c = preg_replace('/\\s{2,}/', ' ', $c);
        $c = preg_replace('/>\\s</', '> <', $c);
        $c = preg_replace('/\\/\\*.*?\\*\\//i', '', $c);
        $c = preg_replace('/<!--[^!]*-->/', '', $c);
        $compress .= $c;
    }
    return $compress;
}

function themeFields($layout) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('站点LOGO地址'), _t('在这里填入一个图片URL地址, 以在网站标题前加上一个LOGO'));
    $thumbUrl = new Typecho_Widget_Helper_Form_Element_Text('thumbUrl',null,null, _t('文章的首页缩略图'), _t('在这里填入一个图片URL地址，将在首页显示每个文章的缩略图'));
    // $thumbDefaultUrl = new Typecho_Widget_Helper_Form_Element_Text('thumbDefaultUrl',null, 'kkk', _t('文章的默认缩略图'), _t('这里填入了一个默认图片URL地址，是我比较喜欢的图，如没有设置缩略图的，则将自动启用这个默认缩略图'));
    $layout->addItem($logoUrl);
    $layout->addItem($thumbUrl);
    // $layout->addInput($thumbDefaultUrl);

}
