<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
function themeConfig($form) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('页头logo地址'), _t('一般为http://www.yourblog.com/image.png,支持 https:// 或 //,留空则使用站点名称'));
    $form->addInput($logoUrl->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));
    $footerLogoUrl = new Typecho_Widget_Helper_Form_Element_Text('footerLogoUrl', NULL, NULL, _t('页尾logo地址'), _t('一般为http://www.yourblog.com/image.png,支持 https:// 或 //,留空则使用站点名称'));
    $form->addInput($footerLogoUrl->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));
    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, NULL, _t('favicon地址'), _t('一般为http://www.yourblog.com/image.png,支持 https:// 或 //,留空则不设置favicon'));
    $form->addInput($favicon->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));
    $searchPage = new Typecho_Widget_Helper_Form_Element_Text('searchPage', NULL, NULL, _t('搜索页地址'), _t('输入你的 Template Page of Search 的页面地址,记得带上 http:// 或 https://'));
    $form->addInput($searchPage->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));
   $default_thumb = new Typecho_Widget_Helper_Form_Element_Text('default_thumb', NULL, '', _t('默认缩略图'),_t('文章没有图片时的默认缩略图，留空则无，一般为http://www.yourblog.com/image.png'));
    $form->addInput($default_thumb->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));
    $jsAddress = new Typecho_Widget_Helper_Form_Element_Text('js_add', NULL, NULL, _t('js文件CDN替换前地址'), _t('即你的js文件存放链接，一般为http://www.yourblog.com/usr/themes/Gege/js/下的某处'));
    $form->addInput($jsAddress->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));
    $jscdnAddress = new Typecho_Widget_Helper_Form_Element_Text('jscdn_add', NULL, NULL, _t('js文件CDN替换后地址'), _t('即你的七牛云存储域名，一般为http://yourblog.qiniudn.com/，可能也支持其他有镜像功能的CDN服务'));
    $form->addInput($jscdnAddress->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));
    $imgAddress = new Typecho_Widget_Helper_Form_Element_Text('img_add', NULL, NULL, _t('图片CDN替换前地址'), _t('即你的附件存放链接，一般为http://www.yourblog.com/usr/uploads/'));
    $form->addInput($imgAddress->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));
    $imgcdnAddress = new Typecho_Widget_Helper_Form_Element_Text('imgcdn_add', NULL, NULL, _t('图片CDN替换后地址'), _t('即你的七牛云存储域名，一般为http://yourblog.qiniudn.com/，可能也支持其他有镜像功能的CDN服务'));
    $form->addInput($imgcdnAddress->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));
}
function themeInit($archive){
    Helper::options()->commentsMaxNestingLevels = 999;
    if ($archive->is('archive')) {
        $archive->parameter->pageSize = 12;
    }
}
function showimg($obj)
{
    # code...获取第一个img 没有就取随机图片
    $img = '';
    $options = Typecho_Widget::widget('Widget_Options');
    preg_match_all( "/\<img.*?src\=\"(.*?)\"[^>]*>/i", $obj->content, $matches );
    $imgCount = count($matches[0]);
    if ($imgCount >= 1) {
        $img = $matches[1][0];
        echo $img;
    }
    if ($imgCount < 1) {
        $img =$options->themeUrl('images/'.mt_rand(0,9).'.jpg');
    return $img;}
}
function showThumb($obj,$size=null){
    preg_match_all( "/\<img.*?src\=\"(.*?)\"[^>]*>/i", $obj->content, $matches );
    $thumb = '';
    $options = Typecho_Widget::widget('Widget_Options');
    $attach = $obj->attachments(1)->attachment;
    if (isset($attach->isImage) && $attach->isImage == 1){
        $thumb = $attach->url;
        // if(!empty($options->src_add) && !empty($options->cdn_add)){
        //     $thumb = str_ireplace($options->src_add,$options->cdn_add,$thumb);
        // }
    }elseif(isset($matches[1][0])){
        $thumb = $matches[1][0];
        // if(!empty($options->src_add) && !empty($options->cdn_add)){
        //     $thumb = str_ireplace($options->src_add,$options->cdn_add,$thumb);
        // }
    }
    if(empty($thumb) && empty($options->default_thumb)){
        $thumb = $options->themeUrl('images/'.mt_rand(0,9).'.jpg');
    }else{
        $thumb = empty($thumb) ? $options->default_thumb : $thumb;
    }
    return $thumb;
}
function parseFieldsThumb($obj){
    $options = Typecho_Widget::widget('Widget_Options');
    if(!empty($options->src_add) && !empty($options->cdn_add)){
        $fieldsThumb = str_ireplace($options->src_add,$options->cdn_add,$obj->fields->thumb);
        echo trim($fieldsThumb);
    }else{
        return $obj->fields->thumb();
    }
}
function parseContent($obj){
    $options = Typecho_Widget::widget('Widget_Options');
    if(!empty($options->src_add) && !empty($options->cdn_add)){
        $obj->content = str_ireplace($options->src_add,$options->cdn_add,$obj->content);
    }
    $obj->content = preg_replace("/<a href=\"([^\"]*)\">/i", "<a href=\"\\1\" target=\"_blank\">", $obj->content);
    echo trim($obj->content);
}
function getCommentAt($coid){
    $db   = Typecho_Db::get();
    $prow = $db->fetchRow($db->select('parent')
        ->from('table.comments')
        ->where('coid = ? AND status = ?', $coid, 'approved'));
    $parent = $prow['parent'];
    if ($parent != "0") {
        $arow = $db->fetchRow($db->select('author')
            ->from('table.comments')
            ->where('coid = ? AND status = ?', $parent, 'approved'));
        $author = $arow['author'];
        $href   = '<a href="#comment-'.$parent.'">@'.$author.'</a>';
        echo $href;
    } else {
        echo '';
    }
}
function getRecentPosts($obj,$pageSize){
    $db = Typecho_Db::get();
    $rows = $db->fetchAll($db->select('cid')
       ->from('table.contents')
       ->where('type = ? AND status = ?', 'post', 'publish')
       ->order('created', Typecho_Db::SORT_DESC)
       ->limit($pageSize));
    foreach($rows as $row){
        $cid = $row['cid'];
        $apost = $obj->widget('Widget_Archive@post_'.$cid, 'type=post', 'cid='.$cid);
        $output = '<li><a href="'.$apost->permalink .'">'. $apost->title .'</a></li>';
        echo $output;
    }
}
function randBgIco(){
    $bgIco=array('book','game','note','chat','code','image','web','link','design','lock');
    return $bgIco[mt_rand(0,9)];
}
function randBgColor(){
    $bgColor=array('blue','purple','green','yellow','red','orange');
    return $bgColor[mt_rand(0,5)];
}
function theNext($widget, $default = NULL){
    $db = Typecho_Db::get();
    $sql = $db->select()->from('table.contents')
        ->where('table.contents.created > ?', $widget->created)
        ->where('table.contents.status = ?', 'publish')
        ->where('table.contents.type = ?', $widget->type)
        ->where('table.contents.password IS NULL')
        ->order('table.contents.created', Typecho_Db::SORT_ASC)
        ->limit(1);
    $content = $db->fetchRow($sql);
    if ($content) {
        $content = $widget->filter($content);
        $link = '<a href="' . $content['permalink'] . '" title="' . $content['title'] . '">←</a>';
        echo $link;
    } else {
        echo $default;
    }
}
function thePrev($widget, $default = NULL){
    $db = Typecho_Db::get();
    $sql = $db->select()->from('table.contents')
        ->where('table.contents.created < ?', $widget->created)
        ->where('table.contents.status = ?', 'publish')
        ->where('table.contents.type = ?', $widget->type)
        ->where('table.contents.password IS NULL')
        ->order('table.contents.created', Typecho_Db::SORT_DESC)
        ->limit(1);
    $content = $db->fetchRow($sql);
    if ($content) {
        $content = $widget->filter($content);
        $link = '<a href="' . $content['permalink'] . '" title="' . $content['title'] . '">→</a>';
        echo $link;
    } else {
        echo $default;
    }
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