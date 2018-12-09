<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html>
<head>

<style>
  .noshow{display: none!important;}
</style>

<?php if($this->options->jq_min_js_cdn):?><script src="<?php $this->options->jq_min_js_cdn(); ?>"></script><?php else:?><script src="<?php $this->options->themeUrl('js/jquery.min.js'); ?>"></script><?php endif;?>
    <script type="text/javascript">
      $(document).ready(function(){
        if (location.search=='?sm') {
          $("#sidebar").addClass('noshow');
        }
      });
    </script>
<?php if($this->options->layzload_js_cdn):?><script src="<?php $this->options->layzload_js_cdn(); ?>"></script><?php else:?><script src="<?php $this->options->themeUrl('js/lazyload.js'); ?>"></script><?php endif;?>

<?php if($this->options->layer_js_cdn):?><script src="<?php $this->options->layer_js_cdn(); ?>"></script><?php else:?><script src="<?php $this->options->themeUrl('js/layer/layer.js'); ?>"></script><?php endif;?>

  
    <script src="<?php $this->options->themeUrl('js/layopen.js'); ?>"></script>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />

<?php if($this->options->favicon): ?>
    <link rel="shortcut icon" href="<?php $this->options->favicon(); ?>"><?php endif;?>

    <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?>

        <?php if ($this->is('index')): ?> 
            - <?php $this->options->description(); ?>
        <?php endif; ?>
        
    </title>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/style.css'); ?>?20181201">
    <!-- <link rel="stylesheet" href="<?php $this->options->themeUrl('css/font-awesome.min.css'); ?>"> -->


    <?php $this->header(); ?> 
</head>


<body>
    <section class="section">
      <section class="section-sidebar" id="sidebar">
        <div class="sidebar-header">
          <a href="<?php $this->options->siteUrl(); ?>" class="sidebar-header-logo">
            <?php if($this->options->logoUrl): ?>
    <img class="logo" alt="<?php $this->options->title() ?>" src="<?php $this->options->logoUrl();?>"  />
            <?php else : ?>
    <img class="logo" alt="<?php $this->options->title() ?>" src="<?php $this->options->themeUrl('gege.png'); ?>" />
            <?php endif; ?>
            
          </a>
        <p><?php $this->options->description() ?></p>
        
        <ul class="nav">
                    <li><a<?php if($this->is('index')): ?> class="current"<?php endif; ?> href="<?php $this->options->siteUrl(); ?>"><?php _e('【 首页 】'); ?></a></li>
                    <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                    <?php while($pages->next()): ?>
                        <?php if(@in_array($pages->slug,$this->options->side_page_show)): ?>
                        <li><a <?php if($this->is('page', $pages->slug)): ?> class="current"<?php endif; ?> 
                        href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>">
                        【 <?php $pages->title(); ?> 】</a></li>
                        <?php endif;?>
                    <?php endwhile; ?>
        </ul>
        

        <?php if(@count($this->options->side_cate_show)>0): ?>
        <ul class="nav hide-sm">
            <?php $this->widget('Widget_Metas_Category_List')->to($categories); ?>
            <?php while($categories->next()): ?>
                <?php if(@in_array($categories->slug,$this->options->side_cate_show)): ?>
               <li><a href="<?php $categories->permalink(); ?>" rel="section">【 <?php $categories->name(); ?> 】</a></li>
                <?php endif;?>
            <?php endwhile; ?>
        </ul>
        <?php endif; ?>
                
        
        </div>
<!--         <div class="sidebar-footer">

        </div> -->
      </section>


<section class="section-content" id="content" role="main">

    
    
