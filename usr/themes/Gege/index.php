<?php
/**
 * 初学者，在一定网页摄取的基础上，通过自学和模仿，设计而成的一个Theme of Typecho. 如果要命名的话，就叫GeGe吧
 *
 * @package Typecho Theme GeGe 
 * @author GeGe's Dad 
 * @version 2018.11.11
 * @link https://logofun.tk/
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('header.php');
 ?>

<div class="content-cards">
<?php while($this->next()): ?>
  <article class="content-card post">
    <div class="card">
      <a href="<?php $this->permalink() ?>" class="card-image lazyload"  data-original="<?php if (array_key_exists('img',unserialize($this->___fields()))): ?><?php $this->fields->img(); ?><?php else: ?><?php showimg($this);?><?php endif; ?>" style="background-image: url(<?php $this->options->themeUrl('images/loading.gif'); ?>)">
      </a>
      <header class="card-header">
        <div class="card-title" >
          <h1 id="<?php $this->slug()?>" class="post-title"><a href="javascript:dd('<?php $this->permalink()?>?sm')"><?php $this->title() ?></a></h1>
        </div>
      </header>
      <section class="card-body">
        <div class="card-body-text">
          <?php $this->excerpt(120, ' ...'); ?>
        </div>
      </section>
      <footer class="card-footer">
        <time class="post-date" datetime="<?php $this->date('Y-m-d'); ?>"><?php $this->date(); ?></time>
         · <?php $this->category(', '); ?>
      </footer>
    </div>
  </article>
<?php endwhile; ?>
</div>

<nav class="pagination" role="navigation">
<?php $this->pageLink('<x aria-label="Previous" class="btn btn-primary">上一页</x>'); ?>
<?php $this->pageLink('<x aria-label="Next" class="btn btn-primary">下一页</x>','next'); ?>
</nav>


<?php $this->need('footer.php'); ?>
