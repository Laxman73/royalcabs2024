<div class="app-header header-shadow">
  <div class="app-header__logo">
    <div class="logo-src ml-auto" style="background-image: url('../images/ctrl-logo.png'); background-size: contain; height: inherit; margin-bottom: 5px;"></div>
    <div class="header__pane ml-auto">
      <div>
        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar"> <span class="hamburger-box"> <span class="hamburger-inner"></span> </span> </button>
      </div>
    </div>
  </div>
  <div class="app-header__mobile-menu">
    <div>
      <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav"> <span class="hamburger-box"> <span class="hamburger-inner"></span> </span> </button>
    </div>
  </div>
  <div class="app-header__menu"> <span>
    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav"> <span class="btn-icon-wrapper"> <i class="fa fa-ellipsis-v fa-w-6"></i> </span> </button>
    </span> </div>
  <div class="app-header__content">
    <div class="app-header-right">
      <div class="header-btn-lg pr-0">
        <div class="widget-content p-0">
          <div class="widget-content-wrapper">
            <div class="widget-content-left  ml-3 header-user-info">
              <div class="widget-heading"> <?php echo $sess_user_name; ?> </div>
              <div class="widget-subheading"> <?php echo $USER_LEVEL_ARR[$sess_user_level]; ?> </div>
            </div>
            <div class="widget-content-left">
              <div class="btn-group"> <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn"> <img width="42" class="rounded-circle" src="<?php echo $sess_user_pic; ?>" alt=""> <i class="fa fa-angle-down ml-2 opacity-8"></i> </a>
                <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                  <div class="dropdown-menu-header">
                    <div class="dropdown-menu-header-inner bg-info">
                      <div class="menu-header-image opacity-2" style="background-image: url('dist/assets/images/dropdown-header/city3.jpg');"></div>
                      <div class="menu-header-content text-left">
                        <div class="widget-content p-0">
                          <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3"> <img width="42" class="rounded-circle" src="<?php echo $sess_user_pic; ?>" alt=""> </div>
                            <div class="widget-content-left">
                              <div class="widget-heading"><?php echo $sess_user_name; ?> </div>
                            </div>
                            <div class="widget-content-right mr-2"> <a href="logout.php" class="btn-pill btn-shadow btn-shine btn btn-focus">Logout </a> </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
