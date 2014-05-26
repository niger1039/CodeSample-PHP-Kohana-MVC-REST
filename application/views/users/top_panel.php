<div id="user-top-panel">
    <div id='user-logged-in'>
        Welcome, <span></span> -
        <a href="javascript: void();" onclick="logout($(this)); return false;">Log out</a>
    </div>
    <div id="user-form">
        <ul>
            <li><a href="#signin">Sign in</a></li>
            <li><a href="#signup">Sign up</a></li>
        </ul>
        <div id="signin">
            <form data-type="signin" action="<?php echo URL::base(true) . 'api/auth' ?>">
                <input type="text" name="username" placeholder="Username" /><br />
                <input type="password" name="password" placeholder="Password" /><br />
                <input type="submit" value="Sign in" data-loading-msg='signing in...' />
            </form>
        </div>
        <div id="signup">
            <form data-type="signup" action="<?php echo URL::base(true) . 'api/users' ?>">
                <input type="text" name="email" placeholder="email" /><br />
                <input type="text" name="username" placeholder="Username" /><br />
                <input type="password" name="password" placeholder="Password" /><br />
                <input type="submit" value="Sign up" data-loading-msg='signing up...' />
            </form>
        </div>
    </div>
</div>