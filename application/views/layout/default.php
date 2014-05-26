<!DOCTYPE html>
<html>
    <head>
        <title>Blog with Kohana</title>
        <meta charset="UTF-8">
        <base href="<?php echo URL::base(true); ?>" />
        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="//code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="public/js/jquery.loadTemplate-1.4.4.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" href="public/css/main.css" />
    </head>
    <body>
        <?php echo View::factory('users/top_panel'); ?>
        <header>
            <h1>Simple Blog with Kohana</h1>
        </header>
        <section>
            <form id="add-post">
                <h3>New Post</h3>
                <input type="text" name="title" placeholder="Title" /><br />
                <textarea name="text" placeholder="Text"></textarea><br />
                <input type="text" name="tags" placeholder="Tags (Comma separated tags)" /><br />
                <input type="submit" value="Add Post" />
            </form>
            <div id="posts">
                <ul></ul>
            </div>
        </section>
    </body>
    <?php echo $templates->render(); ?>
    <script type="text/javascript" src="public/js/app.js"></script>
    <script type="text/javascript" src="public/js/user.js"></script>
</html>