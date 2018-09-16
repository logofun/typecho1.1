<?php if(!defined( '__TYPECHO_ROOT_DIR__'))exit;?>
<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset=UTF-8"UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?>
    <?php $this->options->title(); ?><?php if($this->is('index')): ?><?php endif; ?></title>
    <?php $this->header('generator=&template=&pingback=&xmlrpc=&wlw=&atom='); ?>
    <!-- RSS autodiscovery -->
    
    <link rel="shortcut icon" href="<?php $this->options->ico(); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('img/normalize.min.css'); ?>">
    <!-- Stylesheets -->
    <link rel='stylesheet' href="<?php $this->options->themeUrl('img/font.min.css'); ?>"/>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('img/default.min.css'); ?>"> 
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('img/my.css'); ?>">
    <!-- Stylesheet for theme color -->
</head>

<body class="home-template">
<!--top nav begine -->
<div class="topnav" role="topnav">
    <ul>
            <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
            <?php while($pages->next()): ?>
            <li><a <?php if($this->is('page', $pages->slug)): ?><?php endif; ?> href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a></li>
            <!-- <li>|</li> -->
            <?php endwhile; ?>

<div class="site-search col-3 kit-hidden-tb" >
    <form id="search" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
        <label for="s" class="sr-only"><?php _e('搜索关键字'); ?></label>
        <input type="text" id="s" name="s" class="text" placeholder="<?php _e('输入关键字搜索'); ?>" />
        <button type="submit" class="submit"><?php _e('搜索'); ?></button>
    </form>
</div>
<!--top nav end-->
    </ul>
</div>    
    <header id="site-head">

    <a id="blog-logo" href="<?php $this->options->siteUrl(); ?>">
        <div class="bloglogo" style="background: url(<?php $this->options->logoUrl(); ?>)"></div>
    </a>
	
	<h1 class="blog-title">
        <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a>
    </h1>
	
    </header>

<!-- the nav menu begine     -->
<nav class="menu" role="nav">
    <ul>
        <li class="nav nav-current"><a href="<?php $this->options->siteUrl(); ?>">home</a></li>

            <?php $this->widget('Widget_Metas_Category_List')->to($cates); ?>
            <?php while($cates->next()): ?>
                <li>|</li>
            <li class="nav nav-current"><a href="<?php $cates->permalink(); ?>"><?php $cates->name(); ?></a></li>

            <?php endwhile; ?>

                <li>|</li>
        <li class="nav nav-current"><a href="/feed/">rss</a></li>
    </ul>
</nav>
<!-- the nav menu end -->