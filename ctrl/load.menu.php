<div class="app-sidebar sidebar-shadow">
  <div class="app-header__logo">
    <div class="logo-src"></div>
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
  <div class="scrollbar-sidebar">
    <div class="app-sidebar__inner">
      <ul class="vertical-nav-menu">
        <?php 
            //active class = mm-active;
			foreach($MENU_ARR as $mKEY=>$mVALUE)
			{
				echo '<li class="app-sidebar__heading">'.$mVALUE['TEXT'].'</li>';
				if($mVALUE['IS_SUB']=='Y' && !empty($mVALUE['SUB_MENU']) && count($mVALUE['SUB_MENU']))
				{
					foreach($mVALUE['SUB_MENU'] as $sKEY=>$sVALUE)
					{
						$drop = ($sVALUE['IS_SUB']=='Y' && !empty($sVALUE['MENU']) && count($sVALUE['MENU']))?'<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>':'';
						
						$active = GetActiveLink(basename($_SERVER['SCRIPT_FILENAME']),$sVALUE);
						//$active = (basename($_SERVER['SCRIPT_FILENAME'])==$sVALUE['HREF'])?' class="mm-active"':'';
						$sVALUE['HREF'] = (!empty($sVALUE['HREF']))?$sVALUE['HREF']:'underconstruction.php';

						echo '<li'.$active.'>';
						echo '<a href="'.$sVALUE['HREF'].'"> <i class="metismenu-icon '.$sVALUE['ICON'].'"></i> '.$sVALUE['TEXT'].' '.$drop.'</a>';
						
						if($sVALUE['IS_SUB']=='Y' && !empty($sVALUE['MENU']) && count($sVALUE['MENU']))
						{
							echo '<ul>';
							foreach($sVALUE['MENU'] as $sKEY2=>$sVALUE2)
							{
								$active2 = GetActiveLink(basename($_SERVER['SCRIPT_FILENAME']),$sVALUE2);
								//$active2 = (basename($_SERVER['SCRIPT_FILENAME'])==$sVALUE2['HREF'])?' class="mm-active"':'';
							
								echo '<li> <a href="'.$sVALUE2['HREF'].'"'.$active2.'> <i class="metismenu-icon"> </i>'.$sVALUE2['TEXT'].'</a> </li>';
							}
							echo '</ul>';
						}
						
						echo '</li>';
					}
				}
			}
            ?>
      </ul>
    </div>
  </div>
</div>
