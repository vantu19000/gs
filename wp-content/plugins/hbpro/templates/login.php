<?php get_header(); ?>

<div id="divlogin" class="container">
    <div class="row">
        <div class="col-sm-5">
            <form action="index.php?hbaction=user&task=">
                <div class="form-group">
                    <label for="usr">Email:</label>
                    <input type="email" class="form-control" id="username" required>
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-cont rol" id="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Đăng nhập</button>
            </form>
        </div>
    </div>
</div>


<?php get_footer(); ?>


<style>
    #divlogin{
        margin-top: 30px;
    }
</style>