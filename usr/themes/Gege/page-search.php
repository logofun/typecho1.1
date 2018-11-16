<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * page-search
 *
 * @package custom
 */

  $this->need('header.php'); ?>

<article class="content-post content-page post page" role="main">
  <div class="content-post-title">
    <h1><?php $this->title() ?></h1>
  </div>
  <div class="content-post-body">
    <form method="post" action="<?php $this->options->siteUrl(); ?>" role="search" style="max-width:500px;">
  <div class="input-group">
    <input class="form-input input-lg" type="text" placeholder="关键词" name="s" /> <button class="btn btn-primary input-group-btn btn-lg">SEARCH</button> 
  </div>
</form>
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
