<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
// side_cate_show|side_page_show 是一个数组，还需在没有选择时，增加空数组的判断
// 目前是用一个@在head.php中临时解决的，以避免空数组时的判断问题
function themeConfig($form) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL,  _t('页头logo地址'), _t('一般为http://www.yourblog.com/image.png,支持 https:// 或 //,留空则使用站点名称'));
    $form->addInput($logoUrl->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));
    $footerLogoUrl = new Typecho_Widget_Helper_Form_Element_Text('footerLogoUrl', NULL, NULL, _t('页尾logo地址'), _t('一般为http://www.yourblog.com/image.png,支持 https:// 或 //,留空则使用站点名称'));
    $form->addInput($footerLogoUrl->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));
    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, NULL, _t('favicon地址'), _t('一般为http://www.yourblog.com/image.png,支持 https:// 或 //,留空则不设置favicon'));
    $form->addInput($favicon->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));
    $searchPage = new Typecho_Widget_Helper_Form_Element_Text('searchPage', NULL, NULL, _t('搜索页地址'), _t('输入你的 Template Page of Search 的页面地址,记得带上 http:// 或 https://'));
    $form->addInput($searchPage->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));
    $default_thumb = new Typecho_Widget_Helper_Form_Element_Text('default_thumb', NULL, '', _t('默认缩略图'),_t('文章没有图片时的默认缩略图，留空则无，一般为http://www.yourblog.com/image.png'));
    $form->addInput($default_thumb->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));
    

    //本主题使用了4个js，均可用cdn方式代替 
    // jquery.min.js
    $jqminAddress = new Typecho_Widget_Helper_Form_Element_Text('jq_min_js_cdn', NULL, NULL, _t('jquery.min.js文件CDN替换地址'), _t('本主题使用了jquery.min.js 1.12版，可使用新的cdn代替，如https://cdn.bootcss.com/jquery/1.12.3/jquery.min.js,留空则使用本地js'));
    $form->addInput($jqminAddress->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));
    // lazyload.js
    $lazyjsAddress = new Typecho_Widget_Helper_Form_Element_Text('layzload_js_cdn', NULL, NULL, _t('lazyload.js文件CDN替换地址'), _t('本主题使用了lazyload.js，可使用新的cdn代替，如https://cdn.bootcss.com/jquery_lazyload/1.9.7/jquery.lazyload.min.js,留空则使用本地js'));
    $form->addInput($lazyjsAddress->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));
    // layer.js
    $layerjsAddress = new Typecho_Widget_Helper_Form_Element_Text('layer_js_cdn', NULL, NULL, _t('layer.js文件CDN替换地址'), _t('本主题使用了layer.js，可使用新的cdn代替，如https://cdn.bootcss.com/layer/2.3/layer.js,留空则使用本地js'));
    $form->addInput($layerjsAddress->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));
    // typed.js
    $typedjsAddress = new Typecho_Widget_Helper_Form_Element_Text('typed_js_cdn', NULL, NULL, _t('typed.jsy文件 CDN替换地址'), _t('本主题在评论上方使用了typed.js，可使用新的cdn代替，如为https://cdn.bootcss.com/typed.js/2.0.9/typed.min.js,留空则使用本地js'));
    $form->addInput($typedjsAddress->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));



    $sidePageShow = new Typecho_Widget_Helper_Form_Element_Checkbox('side_page_show',
        // array('about' =>_t('关于页面') ,
        //     'cate'=>_t('归档页面'),
        //     'guestbook'=>_t('留言板页面')
        //  ),
        arrayPageList(),
        // array('about','guestbook','search','cate'), 
        arrayPageSlugList(), //这个是用于初始全选的，好象没作用，直接调用后台数据中的数组了
        _t('侧边栏选择是否显示,勾选为显示')
       
    ); 
    $form->addInput($sidePageShow->multiMode());

    $sideCateShow = new Typecho_Widget_Helper_Form_Element_Checkbox('side_cate_show',
    arrayCateList(),
    arrayCateSlugList(), //这个是用于初始全选的，好象没作用，直接调用后台数据中的数组了
    _t('侧边栏选择是否显示,勾选为显示')
       
    ); 
    $form->addInput($sideCateShow->multiMode());
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
        $img =$options->themeUrl('images/'.mt_rand(0,24).'.jpg');
    return $img;
    }
}
function arrayPageList(){
    # code...获得page页，并生成数组
    $pages = Typecho_Widget::widget('Widget_Contents_Page_List');
    $arr = array();
    while($pages->next()){
        $arr[$pages->slug]=$pages->title;
    }
    return $arr;
}
function arrayPageSlugList(){
    # code...获得page页的slug，并生成数组
    $pages = Typecho_Widget::widget('Widget_Contents_Page_List');
    $arr = array();
    while($pages->next()){
        $arr[]=$pages->slug;
    }
    return $arr;
}
function arrayCateList(){
    # code...获得cate页，并生成数组
    $cates = Typecho_Widget::widget('Widget_Metas_Category_List');
    $arr = array();
    while($cates->next()){
        $arr[$cates->slug]=$cates->name;
    }
    return $arr;
}
function arrayCateSlugList(){
    # code...获得cate页的slug，并生成数组
    $cates = Typecho_Widget::widget('Widget_Metas_Category_List');
    $arr = array();
    while($cates->next()){
        $arr[]=$cates->slug;
    }
    return $arr;
}



// 以下几个函数，是否需要，还在考虑中
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
