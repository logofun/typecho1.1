<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<script>function tg_c(id,nc){var e=document.getElementById(id);var c=e.className;if(!c){e.className=nc}else{var classArr=c.split(' ');var exist=false;for(var i=0;i<classArr.length;i++){if(classArr[i]===nc){classArr.splice(i,1);e.className=Array.prototype.join.call(classArr," ");exist=true;break}}if(!exist){classArr.push(nc);e.className=Array.prototype.join.call(classArr," ")}}}</script>
<?php function threadedComments($comments, $options) {
    $cl = $comments->levels > 0 ? 'c_c' : 'c_p';
    $author = $comments->url ? '<a href="' . $comments->url . '"'.'" target="_blank"' . ' rel="external">' . $comments->author . '</a>' : $comments->author;
?>
<li id="li-<?php $comments->theId();?>" class="<?php echo $cl;?>">
<div id="<?php $comments->theId(); ?>">
<?php $a = 'https://s.gravatar.com/avatar/' . md5(strtolower($comments->mail)) . '?s=80';?>
    <img class="avatar" src="<?php echo $a ?>" alt="<?php echo $comments->author; ?>" />
    <div class="cp">
    <?php $comments->content(); ?>
    <div class="cm"><span class="ca"><?php echo $author ?></span> <?php $comments->date(); ?><span class="cr"><?php $comments->reply(); ?></span></div>
    </div>
</div>
<?php if ($comments->children){ ?><div class="children"><?php $comments->threadedComments($options); ?></div><?php } ?>
</li>
<?php } ?>
<div id="comments" class="cf">
<?php $this->comments()->to($comments); ?>
<?php if ($comments->have()): ?>
    <h5><?php $this->commentsNum(_t('暂无评论'), _t('仅有 1 条评论'), _t('已有 %d 条评论')); ?></h5>
    <?php $comments->listComments(); ?><?php $comments->pageNav('&laquo;', '&raquo;'); ?>
<?php endif; ?>
<div id="<?php $this->respondId(); ?>" class="respond">
    <div class="ccr"><?php $comments->cancelReply(); ?></div>
    <h5 class="response">发表新评论</h5>
<form method="post" action="<?php $this->commentUrl() ?>" id="cf" role="form">
<?php if($this->user->hasLogin()): ?>
    <span>已登入<a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout">退出 &raquo;</a></span>
<?php else: ?>
    <?php if($this->remember('author',true) != "" && $this->remember('mail',true) != "") : ?>
        <span>欢迎<?php $this->remember('author'); ?>回来 | <small style="cursor: pointer;" onclick = "tg_c('ainfo','hinfo');">修改资料</small></span>
        <div id ="ainfo" class="ainfo hinfo">
    <?php else : ?>
        <div class="ainfo">
        <?php endif ; ?>
        <div class="tbox" style="width: 50%;float: left;">
        <input type="text" name="author" id="author" class="ci" placeholder="称呼 ｛英雄请留下姓名 | 留空是不能留言的啊}" value="<?php $this->remember('author'); ?>" required>
        <input type="email" name="mail" id="mail" class="ci" oninput="showAva(this.value)" placeholder="邮箱 ｛调用Gravatar头像 | 留空或未注册则显示随机头像｝" value="<?php $this->remember('mail'); ?>" <?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?>>
        <input type="url" name="url" id="url" class="ci" placeholder="网址" value="<?php $this->remember('url'); ?>" <?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?>>
        </div>
        <div id="showAvatar" style="float: left;width: 50%;text-align: center;margin: 0 auto;position: relative;padding-top: 10px;">
            <span style="color: #999;">Gravatar图片显示区</span>
        </div>
        </div>
    <?php endif; ?>
    <div class="tbox"><textarea name="text" id="textarea" class="ci" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};" placeholder="请在这里输入你的评论内容" required ><?php $this->remember('text',false); ?></textarea></div>
    <button type="submit" class="submit btn btn-primary" id="submit">提交评论 (Ctrl + Enter)</button>
</form>
</div>
</div>

<script type="text/javascript">
//获取Gravatar头像
function showAva(str) {
    //实例化 XMLHttpRequest对象
    if(window.XMLHttpRequest){
        //非IE
        var xhr = new XMLHttpRequest();
    }else{
        var xhr = new ActiveXobject('Microsoft.XMLHTTP');
    }
    //给xhr 绑定事件 检测请求的过程
    xhr.onreadystatechange = function(){
        //console.log(xhr.readyState);
        //如果成功接收到响应
        if( xhr.readyState == 4 && xhr.status == 200){
            document.getElementById('showAvatar').innerHTML = xhr.responseText;
        }else{
            document.getElementById('showAvatar').innerHTML ="";
        }
    }
    //进行请求的初始化
    xhr.open('get', '../usr/themes/Gege/show_avatar.php?n1='+str, true);
    //正式发送请求
    xhr.send();
}
</script>
