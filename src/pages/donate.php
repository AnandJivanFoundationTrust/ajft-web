<?php
$dbname="u423458886_donationndb";
$dbuser="u423458886_donationndb";
$dbpassword="Ajftrust@2024@#$";
$conn = mysqli_connect("localhost",$dbuser,$dbpassword,$dbname);

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

$error=array();
if(isset($_POST['fullname']) && isset($_POST['donationAmount']) && ($_POST['donationAmount']>0)){

    //print_r($_POST);
    $fullname=trim($_POST['fullname']);
    $email=trim($_POST['email']);
    $mobile=trim($_POST['mobile']);
    $certificate=$_POST['certificate'];
    if(isset($_POST['pancard'])){
    $pancard=trim($_POST['pancard']);
    }else{
        $pancard='';
    }
    $address=$_POST['address'];
    $totalAmount=trim($_POST['donationAmount']);
   
    if($fullname==''){
        $error[]="Name is required.";
    }
    
    if($email==''){
        $error[]="Valid email required.";
    }
    if($mobile==''){
        $error[]="Mobile number is required.";
    }

    if($totalAmount==''){
        $error[]="Donation Amount is required.";
    }

    if($address==''){
        $error[]="Full Address is required.";
    }
    
    
if(isset($error) && is_array($error) && count($error)=='0'){

   $merchantId = 'M22GWFWE2UPFH';

$apiKey = 'b371dd3a-6c3b-4e41-9d5b-ca91e9f78b90';
$redirectUrl = 'https://ajftrust.org/paymentconfirm.php';
$order_id = uniqid(); 
/*** end credential *****/

 
$transaction_data = array(
    'merchantId' => "$merchantId",
    'merchantTransactionId' => "$order_id",
    "merchantUserId"=>"viz".$order_id,
    'amount' => $totalAmount*100,
    'redirectUrl'=>"$redirectUrl",
    'redirectMode'=>"POST",
    'callbackUrl'=>"$redirectUrl",
   "paymentInstrument"=> array(    
    "type"=> "PAY_PAGE",
  )
);


                $encode = json_encode($transaction_data);
                $payloadMain = base64_encode($encode);
                $salt_index = 1; //key index 1
                $payload = $payloadMain . "/pg/v1/pay" . $apiKey;
                $sha256 = hash("sha256", $payload);
                $final_x_header = $sha256 . '###' . $salt_index;
                $request = json_encode(array('request'=>$payloadMain));
                
                $curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.phonepe.com/apis/hermes/pg/v1/pay",
//CURLOPT_URL => "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay",
   
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
   CURLOPT_POSTFIELDS => $request,
  CURLOPT_HTTPHEADER => [
    "Content-Type: application/json",
     "X-VERIFY: " . $final_x_header,
     "accept: application/json"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
   $res = json_decode($response);
 // echo "<pre>";
  //print_r($res);
//echo "</pre>";
   
$tablename='phonepe_transaction';

 $myQuery="INSERT INTO `".$tablename."` (`fullname`, `mobile`, `email`,`cerificate`,`pancard`,`fulladdress`,`merchant_id`,`transaction_id`,`amount`,`payment_status`,`response` ) VALUES ( '".$fullname."', '".$mobile."', '".$email."','".$certificate."','".$pancard."','".$address."','".$merchantId."','".$order_id."','".$totalAmount."', 'PAYMENT_PENDING','".$response."')";
$sql = mysqli_query($conn,$myQuery);

if(isset($res->code) && ($res->code=='PAYMENT_INITIATED')){

    

$paymentCode=$res->code;
$paymentMsg=$res->message;
  $payUrl=$res->data->instrumentResponse->redirectInfo->url;
header('Location:'.$payUrl );
exit;
}else{
   //  $payUrl="https://dviz.in/payment/upipay/";
   //header('Location:'.$payUrl );
exit; 
}
}

}
}

?>
<html  lang="en">
    <head>
        <title>Donate Now | Best NGO Orgnization in India</title>
         <meta charset="UTF-8">
      <meta name="description" content="Astro description">
      <meta name="viewport" content="width=device-width">
      <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
      <meta name="generator" content="Astro v4.0.6">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/swiper-bundle.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
       <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500;600;700&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="assets/vendors/bootstrap/css/bootstrap.min.css" />
      <link rel="stylesheet" href="assets/vendors/animate/animate.min.css" />
      <link rel="stylesheet" href="assets/vendors/animate/custom-animate.css" />
      <link rel="stylesheet" href="assets/vendors/fontawesome/css/all.min.css" />
      <link rel="stylesheet" href="assets/vendors/jarallax/jarallax.css" />
      <link rel="stylesheet" href="assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css" />
      <link rel="stylesheet" href="assets/vendors/nouislider/nouislider.min.css" />
      <link rel="stylesheet" href="assets/vendors/nouislider/nouislider.pips.css" />
      <link rel="stylesheet" href="assets/vendors/odometer/odometer.min.css" />
      <link rel="stylesheet" href="assets/vendors/swiper/swiper.min.css" />
      <link rel="stylesheet" href="assets/vendors/oxpins-icons/style.css">
      <link rel="stylesheet" href="assets/vendors/tiny-slider/tiny-slider.min.css" />
      <link rel="stylesheet" href="assets/vendors/reey-font/stylesheet.css" />
      <link rel="stylesheet" href="assets/vendors/owl-carousel/owl.carousel.min.css" />
      <link rel="stylesheet" href="assets/vendors/owl-carousel/owl.theme.default.min.css" />
      <link rel="stylesheet" href="assets/vendors/bxslider/jquery.bxslider.css" />
      <link rel="stylesheet" href="assets/vendors/bootstrap-select/css/bootstrap-select.min.css" />
      <link rel="stylesheet" href="assets/vendors/vegas/vegas.min.css" />
      <link rel="stylesheet" href="assets/vendors/jquery-ui/jquery-ui.css" />
      <link rel="stylesheet" href="assets/vendors/timepicker/timePicker.css" />
      <script src="https://kit.fontawesome.com/429c78efab.js" crossorigin="anonymous"></script><script src="https://kit.fontawesome.com/17f6642d7e.js" crossorigin="anonymous"></script>

      <!-- <ViewTransitions /> -->
      <style>main[data-astro-cid-hu6ywz6e]{background-image:url(/_astro/green-bg.XKTTfVE7.png);background-position:center;background-repeat:no-repeat;background-size:cover;color:var(--free);display:flex;justify-content:center;flex-flow:column nowrap;min-height:100vh}form[data-astro-cid-hu6ywz6e]{flex:1;padding:1rem}.input-container[data-astro-cid-hu6ywz6e]{display:flex;align-items:center;justify-content:center}.input-box[data-astro-cid-hu6ywz6e]{display:flex;flex-direction:column;width:100%}.styled-form[data-astro-cid-hu6ywz6e]{font-family:Arial,sans-serif;margin:0 auto;border-radius:8px;box-shadow:0 0 10px #0000001a;display:flex;flex-direction:column;gap:1rem;box-shadow:#64646f33 0 7px 29px}.input-container[data-astro-cid-hu6ywz6e]{display:flex;justify-content:space-between;flex-wrap:wrap;gap:10px}.input-box[data-astro-cid-hu6ywz6e]{flex:1 1 45%}label[data-astro-cid-hu6ywz6e]{display:block;margin-bottom:5px;font-weight:700;color:#333}input[data-astro-cid-hu6ywz6e],select[data-astro-cid-hu6ywz6e]{width:100%;padding:10px;border-radius:5px;border:.5px solid #ccc;background-color:#f5f5f5;color:#555;resize:none;outline:none}.container[data-astro-cid-hu6ywz6e]{width:800px;margin:0 auto;display:flex;justify-content:center;padding:3rem 2rem}input[data-astro-cid-hu6ywz6e]:hover,section[data-astro-cid-hu6ywz6e]:hover,textarea[data-astro-cid-hu6ywz6e]:hover{border:1px solid var(--yellow)}.text-area[data-astro-cid-hu6ywz6e]{width:100%;padding:10px;border-radius:5px;border:1px solid #ccc;background-color:#f5f5f5;color:#555;font-size:16px;resize:none;outline:none}button[data-astro-cid-hu6ywz6e]{padding:12px;margin-top:15px;border:none;border-radius:5px;background-color:var(--yellow);color:#fff;font-size:18px;font-weight:700;cursor:pointer;width:50%}button[data-astro-cid-hu6ywz6e]:hover{background-color:var(--green)}@media (max-width: 780px){.form[data-astro-cid-hu6ywz6e]{width:100%}.details[data-astro-cid-hu6ywz6e]{padding:1rem}.details[data-astro-cid-hu6ywz6e] p[data-astro-cid-hu6ywz6e]{width:100%;font-size:18px}.image-con[data-astro-cid-hu6ywz6e]{height:auto;width:100%;border-radius:0}main[data-astro-cid-hu6ywz6e]{padding:0}.section2[data-astro-cid-hu6ywz6e],.input-container[data-astro-cid-hu6ywz6e]{flex-direction:column}.styled-form[data-astro-cid-hu6ywz6e]{max-width:100%;margin:1rem .5rem}.container[data-astro-cid-hu6ywz6e]{flex-direction:column-reverse;width:100%;padding:0rem}}
         .header[data-astro-cid-xbstl6g3]{background-image:linear-gradient(to bottom,#000c,#00000080),url(/_astro/headerbg.-uoV1YXS.jpeg);height:50vh;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:1rem;background-repeat:no-repeat;background-size:cover;background-attachment:fixed;background-position:center;color:#fff}.header[data-astro-cid-xbstl6g3] h1[data-astro-cid-xbstl6g3]{font-weight:700;font-size:34px;letter-spacing:.5px;color:#fff}.header[data-astro-cid-xbstl6g3] span[data-astro-cid-xbstl6g3]{color:var(--yellow)}
      </style>
      <link rel="stylesheet" href="/_astro/about.F00v9A6H.css" />
      <link rel="stylesheet" href="assets/css/ajftrust.css" />
      <link rel="stylesheet" href="assets/css/ajftrust-responsive.css" />
      <link rel="stylesheet" href="style.css"/>
      <script type="module">document.querySelector("#copyright").textContent=new Date().getFullYear().toString();</script>
 <style>
          .donate-now__enter-donation-input .donationAmount {
  height: 130px;
  width: 100%;
  border: none;
  outline: none;
  background-color: var(--oxpins-base);
  border-radius: var(--oxpins-bdr-radius);
  padding-left: 150px;
  padding-right: 50px;
  font-size: 50px;
  color: var(--oxpins-white);
  font-family: var(--oxpins-font-two);
  text-align: right;
  font-weight: 900;
  letter-spacing: -0.04em;
}
 h3 {text-align: center;}
 h2 {text-align: right;}
 
      </style>
      </head>
      <nav class="navbar" data-astro-cid-5blmo7yk>
         <div class="content" data-astro-cid-5blmo7yk>
            <div class="logo" data-astro-cid-5blmo7yk>
               <div class="logo-image" data-astro-cid-5blmo7yk> <a href="/" data-astro-cid-5blmo7yk><img src="/_astro/cropped-logo.ZJqh2u2I_RXaQQ.webp" class="" alt="" data-astro-cid-5blmo7yk width="512" height="512" loading="lazy" decoding="async"></a> </div>
               <div class="logo-title" data-astro-cid-5blmo7yk>
                  <a class="name" href="/" data-astro-cid-5blmo7yk><p styel="color:yellow" >Anand Jivan Foundation Trust</p></a> 
                  <div data-astro-cid-5blmo7yk><a class="moto" href="/" data-astro-cid-5blmo7yk>Let's Make Better Life</a></div>
               </div>
            </div>
            <ul class="menu-list" data-astro-cid-5blmo7yk>
               <div class="icon cancel-btn" data-astro-cid-5blmo7yk> <i class="fas fa-times" data-astro-cid-5blmo7yk></i> </div>
               <li data-astro-cid-5blmo7yk><a href="/" data-astro-cid-5blmo7yk>Home</a></li>
               <li data-astro-cid-5blmo7yk><a href="/about" data-astro-cid-5blmo7yk>About Us</a></li>
               <li data-astro-cid-5blmo7yk><a href="/events" data-astro-cid-5blmo7yk>Events</a></li>
               <li data-astro-cid-5blmo7yk><a href="/contact" data-astro-cid-5blmo7yk>Contact Us</a></li>
               <li data-astro-cid-5blmo7yk><a href="/volunteer" data-astro-cid-5blmo7yk>Volunteer</a></li>
               <li data-astro-cid-5blmo7yk> <a style="padding: .9rem 2rem;" class="btn" href="/donate" data-astro-cid-5blmo7yk>Donate Now</a> </li>
            </ul>
            <div class="icon menu-btn" data-astro-cid-5blmo7yk> <i class="fas fa-bars" data-astro-cid-5blmo7yk></i> </div>
         </div>
      </nav>
      <script>
         const body = document.querySelector("body");
         const navbar = document.querySelector(".navbar");
         const menuBtn = document.querySelector(".menu-btn");
         const cancelBtn = document.querySelector(".cancel-btn");
         
         menuBtn.onclick = () => {
           navbar.classList.add("show");
           menuBtn.classList.add("hide");
           body.classList.add("disabled");
         };
         
         cancelBtn.onclick = () => {
           body.classList.remove("disabled");
           navbar.classList.remove("show");
           menuBtn.classList.remove("hide");
         };
         
         window.addEventListener("scroll", () => {
           if (window.scrollY > 0) {
             navbar.classList.add("sticky");
           } else {
             navbar.classList.remove("sticky");
           }
         });
         
         menuItems.forEach((item) => {
           item.addEventListener("click", function () {
             // Remove 'active' class from all menu items
             menuItems.forEach((item) => {
               item.classList.remove("active");
             });
         
             // Add 'active' class to the clicked menu item
             this.classList.add("active");
           });
         });
      </script>  
   <body class="custom-cursor">
       <a
        href="https://wa.me/9155751363"
        class="whatsapp_float"
        target="_blank"
        rel="noopener noreferrer"
      >
        <i class="fa fa-whatsapp whatsapp-icon"></i>
      </a>
<section class="donate-now">
         <div class="container">
            <div class="row">
               
               <div class="col-xl-8 col-lg-7">
                  <?php if(isset($error) && is_array($error) && count($error)>0){
                              foreach($error as $err){
                                 echo "<p style='color:red;font-size:14px;'>".$err."</p>";
                              }
                           }?>
                        <form class="donate-now__payment-info-form" method="post">
                  <div class="donate-now__left">
                     <div class="donate-now__enter-donation">
                        <h2 class="donate-now__title">Donation Amount</h2>
                        <div class="donate-now__enter-donation-input">
                          
                           <input type="text" class="donationAmount" name="donationAmount" required placeholder=".00" onkeypress="return /[0-9]/i.test(event.key)"  required>
                        </div>
                     </div>
                     <div class="donate-now__personal-info-box">
                        <h3 class="donate-now__title">Personal info</h3>
                        <form class="donate-now__personal-info-form">
                           <div class="row">
                              <div class="col-xl-6">
                                 <div class="donate-now__personal-info-input">
                                    <input type="text" placeholder="Enter your name" name="fullname" required>
                                 </div>
                              </div>
                              <div class="col-xl-6">
                                 <div class="donate-now__personal-info-input">
                                    <input type="text" minlength="10" maxlength="12" placeholder="Enter mobile number" name="mobile" required>
                                 </div>
                              </div>
                              <div class="col-xl-12">
                                 <div class="donate-now__personal-info-input">
                                    <input type="email" placeholder="Email address" name="email" required>
                                 </div>
                              </div>
                             
                              
                               <div class="col-xl-6">
                                <label><strong>Do you need 80g Certificate?</strong></label>
                                 <div class="donate-now__personal-info-input">
                                      <input type="radio" name="certificate" value="yes" > Yes &nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="certificate" value="no" checked> No
                                    </div>
                              </div>
                              
                              <div class="col-xl-6" id="pancardDetails" style="display:none;">
                                 <div
                                    class="donate-now__personal-info-input ">
                                   <input type="text" placeholder="Enter Pancard Number" name="pancard" maxlength="10" minlength="10">
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                            <div class="col-xl-12">
                                 <div class="donate-now__personal-info-input">
                                    <input type="text" placeholder="Full Address" name="address" required>
                                 </div>
                              </div>
                              
                           </div>
                               <div class="row">
                              <div class="col-xl-12">
                            <div class="donate-now__personal-info-input donate-now__payment-info-btn-box">
                                        <button type="submit" class="thm-btn donate-now__payment-info-btn">Donate
                                            now</button>
                                    </div>
                                </div></div>
                        </form>
                     </div>
                    
                  </div>
              </form>
               </div>
               <div class="col-xl-4 col-lg-5">
                  <div class="donate-now__right">
                            <div class="causes-one__double">
                                <div class="causes-one__img">
                                    <img src="assets/images/resources/causes1-1.jpg" alt="">
                                    <div class="causes-one__cat">
                                        <p>Education</p>
                                    </div>
                                </div>
                                <div class="causes-one__content">
                                    <h3 class="causes-one__title"><a href="donation-details.html">Let’s education for
                                            Children get good
                                            life</a>
                                    </h3>
                                    <p class="causes-one__text">We are Providing Study Metrial </p>
                                    <div class="causes-one__progress">
                                        <div class="causes-one__progress-shape" style="background-image: url(assets/images/shapes/causes-one-progress-shape-1.png);">
                                        </div>
                                        <div class="bar">
                                            <div class="bar-inner count-bar counted" data-percent="58%" style="width: 36%;">
                                                <div class="count-text">58%</div>
                                            </div>
                                        </div>
                                        <div class="causes-one__goals">
                                            <p><span>₹17,0000</span> Raised</p>
                                            <p><span>₹30,0000</span> Goal</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="donation-details__organizer">
                                <div class="sidebar-shape-1" style="background-image: url(assets/images/shapes/sidebar-shape-1.png);"></div>
                                <div class="donation-details__organizer-img">
                                    <img src="assets/images/resources/organizer-imgs.jpg" alt="">
                                </div>
                                <div class="donation-details__organizer-content">
                                    <p class="donation-details__organizer-date">Created 20 December, 2023</p>
                                    <p class="donation-details__organizer-title">Organizer:</p>
                                    <p class="donation-details__organizer-name">Mr.Guddu Kumar</p>
                                    <ul class="list-unstyled donation-details__organizer-list">
                                        <li>
                                            <div class="icon">
                                                <span class="fas fa-tag"></span>
                                            </div>
                                            <div class="text">
                                                <p>Education</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon">
                                                <span class="fas fa-map-marker-alt"></span>
                                            </div>
                                            <div class="text">
                                                <p>Darbhanga, India</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
               </div>
            </div>
         </div>
      </section>
     <marquee behavior="slide" direction="left"><h2 style="color:blue;">All the Donations to Anand Jivan Foundation Trust are tax exempted under 80G of the Indian Income Tax Act</h2>
        <h2 style="color:blue;">Charity Id: AAJTA9323K</h2></marquee>
        <footer class="footer" data-astro-cid-sz7xmlte>
         <div class="container" data-astro-cid-sz7xmlte>
            <div class="row" data-astro-cid-sz7xmlte>
               <div class="footer-col logo-section" data-astro-cid-sz7xmlte>
                  <div class="logo" data-astro-cid-sz7xmlte> <img src="/_astro/cropped-logo.ZJqh2u2I_RXaQQ.webp" alt="" data-astro-cid-sz7xmlte width="512" height="512" loading="lazy" decoding="async"> </div>
                  <a class="btn" href="/donate" data-astro-cid-sz7xmlte>Donate Now</a> 
               </div>
               <div class="footer-col" data-astro-cid-sz7xmlte>
                  <h4 data-astro-cid-sz7xmlte>Links</h4>
                  <ul data-astro-cid-sz7xmlte>
                     <li data-astro-cid-sz7xmlte><a href="/" data-astro-cid-sz7xmlte>home</a></li>
                     <li data-astro-cid-sz7xmlte><a href="/events" data-astro-cid-sz7xmlte>events</a></li>
                     <li data-astro-cid-sz7xmlte><a href="/about" data-astro-cid-sz7xmlte>about us</a></li>
                     <li data-astro-cid-sz7xmlte><a href="/members" data-astro-cid-sz7xmlte>members</a></li>
                  </ul>
               </div>
               <div class="footer-col" data-astro-cid-sz7xmlte>
                  <h4 data-astro-cid-sz7xmlte>Quick Links</h4>
                  <ul data-astro-cid-sz7xmlte>
                     <li data-astro-cid-sz7xmlte><a href="/donate/donatenow.php" data-astro-cid-sz7xmlte>Donate Now</a></li>
                     <li data-astro-cid-sz7xmlte><a href="/volunteer" data-astro-cid-sz7xmlte>Volunteer</a></li>
                     <li data-astro-cid-sz7xmlte><a href="/privacypolicy" data-astro-cid-sz7xmlte>Privacy Policy</a></li>
                     <li data-astro-cid-sz7xmlte><a href="/contact" data-astro-cid-sz7xmlte>contact</a></li>
                     <li data-astro-cid-sz7xmlte><a href="/faq" data-astro-cid-sz7xmlte>FAQs</a></li>
                  </ul>
               </div>
               <div class="footer-col" data-astro-cid-sz7xmlte>
                  <h4 data-astro-cid-sz7xmlte>Contacts</h4>
                  <p class="address" data-astro-cid-sz7xmlte>
                     Anand Jivan Foundation Trust Mabbi Belauna, Post- Lalshahpur,
                     Darbhanga, Bihar 846005 INDIA
                  </p>
                  <div class="social-links" data-astro-cid-sz7xmlte> <a href="https://www.facebook.com/ajftrust/" data-astro-cid-sz7xmlte><i class="fab fa-facebook-f" data-astro-cid-sz7xmlte></i></a> <a href="#" data-astro-cid-sz7xmlte><i class="fab fa-youtube" data-astro-cid-sz7xmlte></i></a> <a href="#" data-astro-cid-sz7xmlte><i class="fab fa-instagram" data-astro-cid-sz7xmlte></i></a> <a href="#" data-astro-cid-sz7xmlte><i class="fab fa-linkedin-in" data-astro-cid-sz7xmlte></i></a> </div>
               </div>
            </div>
         </div>
      </footer>
      <main data-astro-cid-bvlckhmz>
         <div class="copyrighttext" data-astro-cid-bvlckhmz>
            <p data-astro-cid-bvlckhmz>
               Copyright &copy <span id="copyright" data-astro-cid-bvlckhmz></span> Anand Jivan Foundation Trust.
               All rights reserved.
            </p>
         </div>
      </main>
      <script>
         import Lenis from "@studio-freight/lenis";
         const lenis = new Lenis();
         
         lenis.on("scroll", (e) => {
           console.log(e);
         });
         
         function raf(time) {
           lenis.raf(time);
           requestAnimationFrame(raf);
         }
         
         requestAnimationFrame(raf);
      </script> 
        </body>
        </html>
