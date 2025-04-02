<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('config.php'); ?>
<?php require_once('inc/header.php') ?>

<body class="hold-transition layout-top-nav">
    <?php
    $page = isset($_GET['page']) ? $_GET['page'] : 'portal';
    ?>
    <?php require_once('inc/topBarNav.php') ?>

    <?php

    if (!file_exists($page . ".php") && !is_dir($page)) {
        include '404.html';
    } else {
        if ($page == 'packages') {
            include 'packages.php';
        } elseif ($page == 'policy') {
            include 'policy.php';
        } elseif ($page == 'login') {
            include 'login.php';
        } elseif (is_dir($page)) {
            include $page . '/index.php';
        } else {
            include $page . '.php';
        }
    }

    ?>

    <script>
        $(function() {
            if ($('header.masthead').length <= 0)
                $('#mainNav').addClass('navbar-shrink');
        })
    </script>

    <?php require_once('inc/footer.php') ?>

    <!-- Confirm Modal -->
    <div class="modal fade text-dark" id="confirm_modal" role='dialog'>
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                </div>
                <div class="modal-body">
                    <div id="delete_content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Forms -->
    <div class="modal fade text-dark rounded-0" id="uni_modal" role='dialog'>
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Viewer Modal -->
    <div class="modal fade text-dark" id="viewer_modal" role='dialog'>
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
                <img src="" alt="">
            </div>
        </div>
    </div>
</body>

</html>