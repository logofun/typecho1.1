<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<article class="content-post post tag-jian-ti-zhong-wen" role="main">

  <div class="content-post-title">
    <h1><?php $this->title() ?></h1>
  </div>
  <div class="content-post-meta">
    <time class="post-date" datetime="<?php $this->date('Y-m-d'); ?>"><?php $this->date('Y年m月d日'); ?></time> · <?php $this->category(', '); ?></div>
  <div class="content-post-body">
  <?php $this->content(); ?>
  </div>
  <div class="content-post-meta post-meta-tags">
    <?php $this->tags(' &#160; ', true, 'none'); ?>
  </div>
  <div class="content-post-author">
    <div class="tile">
      <div class="tile-icon">
        <figure class="gavatar avatar-lg">
          <img src="https://s.gravatar.com/avatar/c2217dc1e5f7466786f3b7a8b9283200?s=80" />
        </figure>
      </div>
      <div class="tile-content">
        <p class="tile-title"><strong>LogoFun</strong></p>
            <p class="tile-subtitle">一个非盈利性博客站点，主要发布一些自己收藏和一些自己的浅见而已。</p>
      </div>
    </div>
  </div>

  <div class="content-post-comments">
  </div>

  <div class="doc_comments">
  <?php $this->need('comments.php'); ?>
  </div>

</article>


<?php $this->need('footer.php'); ?>
