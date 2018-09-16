<?php
/**
 * 这是一款极简的单栏Typecho主题。
 * @package 在veryse主题基础上自行修改所得的Theme 
 * @author 在【一夜涕】之上 的 logofun
 * @version 1.0
 * @link https://logofun.tk
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('header.php');
 ?>

<main class="content" role="main">

        <?php while($this->next()): ?>
<!-- the article post cycle begine  -->
<article class="preview">
    <header>
        <h1 class="post-title"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h1>
        <div class="post-meta"><time datetime="<?php $this->date('c'); ?>"><?php $this->date('F j, Y'); ?></time></div>
        
        <img src="<?php echo img_postthumb($this->cid); ?>" />
    </header>
    <section class="post-excerpt">
        <p><?php $this->excerpt(130, '...'); ?></p>
        <p class="readmore"><a href="<?php $this->permalink() ?>">Read more <i class="fa fa-chevron-circle-right" style="padding-left: 5px;"></i></a></p>
    </section>
</article>

        <?php endwhile; ?>
<!-- the article post cycle end  -->

<nav class="pagination" role="pagination">


<?php $this->pageLink('<span class="newer-posts"><i class="fa fa-chevron-circle-left"></i> 前页 </span>'); ?>

    <span class="page-number">
        Page <?php if($this->_currentPage>1) echo $this->_currentPage;  else echo 1;?> of 
        <?php echo ceil($this->getTotal() / $this->parameter->pageSize); ?>
    </span>

<?php $this->pageLink('<span class="older-posts"> 后页 <i class="fa fa-chevron-circle-right"></i></span>','next'); ?>



    
    
</nav>


    </main>
<?php $this->need('footer.php'); ?>