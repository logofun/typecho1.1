<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

</section class="section-content" id="content" role="main">
 </section>

      <section class="section-footer">
        <p><strong><a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a></strong> &copy; <?php echo date('Y'); ?></p>
        <p>Published with <strong><a href="https://typecho.me/959.html" title="TYPECHO">Typecho</a></strong>.</p>
		<p>Theme modified by <a href="https://github.com/Showfom/Affinity" title="Ghost Theme Affinity">Gege</a> <span class="text-red">&hearts;</span></p>
      </section>
    
    <script type="text/javascript">
	  // 或加入某些效果
	  $(".lazyload").lazyload({
	      effect : "fadeIn",
	      container: $("#content")
	  });
	</script>

<?php $this->footer(); ?>
</body>
</html>
