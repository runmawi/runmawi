
<!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css'> -->
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/js/bootstrap.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>

<div id="wrapper_side">
  <div class="sidebar">
    <div class="sb-item-list">
      <div class="sb-item"><i class="sb-icon fa fa-address-card"></i><span class="sb-text">Sidebar Item1</span></div>
      <div class="sb-item"><i class="sb-icon fa fa-address-card"></i><span class="sb-text">Sidebar Item2</span></div>
      <div class="sb-item sb-menu"><i class="sb-icon fa fa-address-card"></i><span class="sb-text">Sidebar Menu</span>
        <div class="sb-submenu">
          <div class="sb-item"><i class="sb-icon fa fa-address-card"></i><span class="sb-text">Level 2</span></div>
          <div class="sb-item sb-menu"><i class="sb-icon fa fa-address-card"></i><span class="sb-text">Level 2</span>
            <div class="sb-submenu">
              <div class="sb-item"><i class="sb-icon fa fa-address-card"></i><span class="sb-text">Level 3</span></div>
              <div class="sb-item"><i class="sb-icon fa fa-address-card"></i><span class="sb-text">Level 3</span></div>
              <div class="sb-item"><i class="sb-icon fa fa-address-card"></i><span class="sb-text">Level 3</span></div>
            </div>
          </div>
        </div>
      </div>
      <div class="sb-item"><i class="sb-icon fa fa-address-card"></i><span class="sb-text">Sidebar Item3</span></div>
      <div class="btn-toggle-sidebar sb-item"><i class="sb-icon fa fa-angle-double-left"></i><span class="sb-text">Collapse Sidebar</span><i class="sb-icon fa fa-angle-double-right"></i></div>
    </div>
  </div>
  <div class="main"></div>
</div>



<script>
    $(function(){
    // toggle sidebar collapse
    $('.btn-toggle-sidebar').on('click', function(){
        $('#wrapper_side').toggleClass('sidebar-collapse');
    });
    // mark sidebar item as active when clicked
    $('.sb-item').on('click', function(){
        if ($(this).hasClass('btn-toggle-sidebar')) {
          return; // already actived
        }
        $(this).siblings().removeClass('active');
        $(this).siblings().find('.sb-item').removeClass('active');
        $(this).addClass('active');
    })
});
</script>

<style>
    #wrapper_side {
  width: 100%;
  padding-left: 200px;
  transition-duration: 0.5s;
}
#wrapper_side .sidebar {
  width: 200px;
  height: 100%;
  position: absolute;
  left: 0px;
  top: 0px;
  background: #333;
  white-space: nowrap;
  transition-duration: 0.5s;
  z-index: 1000;
}
#wrapper_side .sidebar .sb-item-list {
  width: 100%;
  height: calc(100% - 50px);
}
#wrapper_side .sidebar .sb-item-list > .sb-item > .sb-text {
  position: absolute;
  transition-duration: 0.5s;
}
#wrapper_side .sidebar .sb-item {
  display: block;
  width: 100%;
  line-height: 50px;
  color: #ccc;
  background: #333;
  cursor: pointer;
  padding-left: 7px;
}
#wrapper_side .sidebar .sb-item.active {
  border-left: solid 3px green;
  box-sizing: border-box;
}
#wrapper_side .sidebar .sb-item.active > .sb-icon {
  margin-left: -3px;
}
#wrapper_side .sidebar .sb-icon {
  padding-left: 10px;
  padding-right: 20px;
}
#wrapper_side .sidebar .sb-item:hover,
#wrapper_side .sidebar .sb-item.active {
  filter: brightness(130%);
}

#wrapper_side .sb-menu {
  position: relative;
}
#wrapper_side .sb-menu:after {
  content: " ";
  width: 0;
  height: 0;
  display: block;
  float: right;
  margin-top: 19px;
  margin-left: -12px;
  margin-right: 5px;
  border: solid 5px transparent;
  border-left-color: #eee;
}
#wrapper_side .sb-menu > .sb-submenu {
  display: none;
}
#wrapper_side .sb-menu:hover > .sb-submenu {
  position: absolute;
  display: block;
  width: 200px;
  top: 0;
  left: calc(100% + 1px);
}

#wrapper_side .sb-submenu > .sb-item:first-child {
  border-radius: 8px 8px 0px 0px;
}

#wrapper_side .sb-submenu > .sb-item:last-child {
  border-radius: 0px 0px 8px 8px;
}

#wrapper_side .btn-toggle-sidebar {
  position: absolute;
  left: 0;
  bottom: 0;
  border-top: 1px solid #aaa;
  user-select: none;
}
#wrapper_side .btn-toggle-sidebar .sb-icon {
  padding-left: 15px;
}
#wrapper_side .btn-toggle-sidebar .sb-icon.fa-angle-double-left {
  display: inline-block;
}
#wrapper_side .btn-toggle-sidebar .sb-icon.fa-angle-double-right {
  display: none;
}

#wrapper_side.sidebar-collapse {
  padding-left: 60px;
}
#wrapper_side.sidebar-collapse .sidebar {
  width: 60px;
}
#wrapper_side.sidebar-collapse .sb-item-list > .sb-item > .sb-text {
  position: absolute;
  transform: translateX(-200%);
  opacity: 0;
}

#wrapper_side.sidebar-collapse .btn-toggle-sidebar .sb-icon.fa-angle-double-left {
  display: none;
}
#wrapper_side.sidebar-collapse .btn-toggle-sidebar .sb-icon.fa-angle-double-right {
  display: inline-block;
}
</style>