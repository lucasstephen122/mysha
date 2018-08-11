 <?php
    $total_second = getRemainingSeconds($user);
 ?>
 <aside class="left-sidebar">
            <div class="left-sidebar-header d-flex no-block nav-text-box align-items-center">
                <span>
                    <img src="<?php echo $base_url; ?>assets/panel/admin/../assets/images/logo.jpeg" alt="user" width="80">
                </span>

            </div>
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li>
                            <a class=" waves-effect waves-dark" href="<?php echo $base_url ?>user/welcome" aria-expanded="false">
                                <i class="mdi mdi-account-multiple"></i>
                                <span class="hide-menu">Welcome to Shaghaf</span>
                            </a>
                        </li>
                        <li>
                            <a class=" waves-effect waves-dark" href="<?php echo $base_url ?>user/application" aria-expanded="false">
                                <i class="mdi mdi-account-multiple"></i>
                                <span class="hide-menu">My Application</span>
                            </a>
                        </li>
                        <li>
                            <a class=" waves-effect waves-dark" href="http://google.com" target="_blank" aria-expanded="false">
                                <i class="mdi mdi-account-multiple"></i>
                                <span class="hide-menu">About Shaghaf Program

                                </span>
                            </a>
                        </li>
                        <li>
                            <a class=" waves-effect waves-dark" href="<?php echo $base_url ?>user/comments" aria-expanded="false">
                                <i class="mdi mdi-comment"></i>
                                <span class="hide-menu">Comments

                                </span>
                            </a>
                        </li>
                        <li>
                            <a class=" waves-effect waves-dark" href="<?php echo $base_url ?>user/notifications" aria-expanded="false">
                                <i class="mdi mdi-comment"></i>
                                <span class="hide-menu">Updates

                                </span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
                <?php if (!empty($total_second)): ?>
                <label id="countdown" class="timer text-center" style="display:block;color:white;"></label>
                <?php endif; ?>
            </div>
            <!-- End Sidebar scroll-->
        </aside>

<?php if (!empty($total_second)): ?>
<script>
var seconds = <?= $total_second ?>;
function timer() {
    var days        = Math.floor(seconds/24/60/60);
    var hoursLeft   = Math.floor((seconds) - (days*86400));
    var hours       = Math.floor(hoursLeft/3600);
    var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
    var minutes     = Math.floor(minutesLeft/60);
    var remainingSeconds = seconds % 60;
    if (remainingSeconds < 10) {
        remainingSeconds = "0" + remainingSeconds; 
    }
    document.getElementById('countdown').innerHTML = days + ":" + hours + ":" + minutes + ":" + remainingSeconds;
    if (seconds == 0) {
        clearInterval(countdownTimer);
        document.getElementById('countdown').innerHTML = "Time is up";
        const submit_button = document.getElementById('btn_submit');
        if (submit_button)
            submit_button.disabled = true;
    } else {
        seconds--;
    }
}
var countdownTimer = setInterval('timer()', 1000);
</script>
<?php endif; ?>