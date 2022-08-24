
<link rel="stylesheet" href="<?= style_sheet_link();?>" />
<link rel="stylesheet" href="<?= typography_link();?>" />
<link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/bootstrap.min.css';?>" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,800&display=swap" rel="stylesheet">
        
{{-- Favicon  --}}
<link rel="shortcut icon" href="<?php echo getFavicon();?>" type="image/gif" sizes="16x16">

<style>
    body {
        background-color: #000405;
    }
    .footer-background-home {
        background-image: url("http://savagestudiosinc.com/wp-content/uploads/2022/07/footerbackground-scaled.jpg");
    }    
    h1{
      color: #fff;
      font-size: 80px;
      font-family: 'poppins';
      font-weight: 800;
      line-height: 1;
     /* text-shadow: 5px 5px #8A0303;*/
    ;
    }
    h2 {
      color: #fff;
      font-size: 50px;
      font-weight: 600;
      font-family: 'poppins';
    }
    h3 {
      color: #8A0303;
      font-size: 50px;
      font-style: italic;
      font-family: 'poppins';
    }
    h4 {
      color: #fff;
      font-size: 20px;
      text-align: center;
      font-family: 'poppins';
    }
    .page_bkgrd_home {
      background-image: url("http://savagestudiosinc.com/wp-content/uploads/2022/07/headerbackgroundhomepage.jpg");
      height: 1400px;
      color: #000;
    }
    .logo {
    width: 350PX;  
        padding: 0px!important;
    }
    .row {
      display: flex;
    }
    
    .buttonClass {
      font-size:20px;
      font-family:poppins;
      padding: 15px 45px;
      text-decoration: none;
      border-width:0px;
      color:#000!important;
      font-weight:bold;
      border-top-left-radius:13px;
      border-top-right-radius:13px;
      border-bottom-left-radius:13px;
      border-bottom-right-radius:13px;
      background:#8A0303;
    }
    
    .buttonClass:hover {
      background: rgba(208, 2, 27, 1)
    }
    .buttonClassLarge {
      font-size:28px !important;
      font-family:poppins;
      padding: 15px 45px;
      text-decoration: none;
      border-width:0px;
      color:#fff;
      font-weight:bold;
      border-top-left-radius:13px;
      border-top-right-radius:13px;
      border-bottom-left-radius:13px;
      border-bottom-right-radius:13px;
      background:#8A0303;
    }
    
    .buttonClassLarge:hover {
      background: rgba(208, 2, 27, 1)
    }
    .center-image {
      display: block;
      margin-left: auto;
      margin-right: auto;
      width: 50%;
    }
    
    </style>