<script type="text/html" id="template-post-li">
    <h2 class="ui-widget-header" data-content="title"></h2>
    <div class="tags" data-formatted="false" data-content="tags"></div>
    <div class="user">by <span data-content="username"></span></div>
    <div class="text" data-content="text"></div>
    <div class="comments">
        <h3>Comments</h3>
        <ul></ul>
        <form method="POST" class="add-comment">
            <h4>New Comment</h4>
            <input type="hidden" name="post_id" data-value="post_id" />
            <textarea name="text"></textarea><br />
            <input type="submit" value="Add Comment" />
        </form>
    </div>
</script>
<script type="text/html" id="template-comment-li">
    <span data-content="username"></span>: <span class="comment" data-content="text"></span> 
</script>