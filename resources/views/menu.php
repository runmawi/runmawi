<style>
  .blink_me {
    animation: blinker 2s linear infinite;
  }
  @keyframes blinker {
    50% {
      opacity: 0;
    }
  }
</style>

<?php
    
//    $will_expire_at = Auth::user()->coupon_expired;
//    $subscriptio_start_at = Auth::user()->subscription_start;
?>

<ul class="nav navbar-nav <?php if ( Session::get('locale') == 'arabic') { echo "navbar-right"; } else { echo "navbar-left";}?>">
  <?php
$stripe_plan = SubscriptionPlan();
$menus = App\Menu::all();
$languages = App\Language::all();
foreach ($menus as $menu) { 
if ( $menu->in_menu == "video") { 
$cat = App\VideoCategory::all();
?>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="<?php echo URL::to('/').$menu->url;?>" data-toggle="dropdown">  
      <?php echo __($menu->name);?> <i class="fa fa-angle-down"></i>
    </a>
    <ul class="dropdown-menu">
      <?php foreach ( $cat as $category) { ?>
      <li>
        <a class="dropdown-item" href="<?php echo URL::to('/').'/category/'.$category->slug;?>"> 
          <?php echo $category->name;?> 
        </a>
      </li>
      <?php } ?>
    </ul>
  </li>
  <?php } else { ?>
  <li>
    <a href="<?php echo URL::to('/').$menu->url;?>">
      <?php echo __($menu->name);?>
    </a>
  </li>
  <?php } } ?>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="<?php echo URL::to('/').$menu->url;?>" data-toggle="dropdown">  
      Movies <i class="fa fa-angle-down"></i>
    </a>
      <ul class="dropdown-menu">
          <?php foreach ( $languages as $language) { ?>
          <li>
            <a class="dropdown-item" href="<?php echo URL::to('/').'/language/'.$language->id.'/'.$language->name;?>"> 
              <?php echo $language->name;?> 
            </a>
          </li>
        
        <?php } ?>
        </ul>
    </li>
  <li class="blink_me">
    <a href="<?php echo URL::to('refferal') ?>" style="color: #fd1b04;list-style: none;
                                                       font-weight: bold;
                                                       font-size: 16px;">
      <?php echo __('Refer and Earn');?>
    </a>
  </li>
</ul>
<script>
  // Prevent closing from click inside dropdown
  $(document).on('click', '.dropdown-menu', function (e) {
    e.stopPropagation();
  });
    
    
  // make it as accordion for smaller screens
  if ($(window).width() < 992) {
    $('.dropdown-menu a').click(function(e){
      e.preventDefault();
      if($(this).next('.submenu').length){
        $(this).next('.submenu').toggle();
      }
      $('.dropdown').on('hide.bs.dropdown', function () {
        $(this).find('.submenu').hide();
      }
                       )
    }
                               );
  }
</script>
