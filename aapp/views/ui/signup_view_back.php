<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>

<head><meta http-equiv="content-type" content="text/html;charset=utf-8" />

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <noscript>False</noscript>
    <title>Naija Art Market - Signup</title>
    
    <link rel="icon" href="<?php echo base_url(); ?>wp-content/uploads/favicon_artsquare_16x16.png" type="image/png" sizes="16x16"/>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
       
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/general.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>loginassets/css/bundle.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>loginassets/css/site.min.css" />
	
    <?php include('scripts.php'); ?>

    
        <!-- Facebook Pixel Code -->
<script>
    !function (f, b, e, v, n, t, s) {
        if (f.fbq) return; n = f.fbq = function () {
            n.callMethod ?
                n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = '2.0';
        n.queue = []; t = b.createElement(e); t.async = !0;
        t.src = v; s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
        '<?php echo base_url(); ?>con_fb/en_US/fbevents.js');
    fbq('init', '402361543686268');
    fbq('track', 'PageView');
    fbq('track', 'Lead');
</script>

<noscript>
    <img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=402361543686268&amp;ev=PageView&amp;noscript=1" />
</noscript>
<!-- End Facebook Pixel Code -->

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-29392430-71"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag('config', 'UA-29392430-71');
</script>

        <!-- Google Tag Manager -->
        <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = '<?php echo base_url(); ?>tagmanager/gtm5445.html?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-K529X6D');</script>
        <!-- End Google Tag Manager -->

<script>
	
var Title='<font color="#AF4442">Naija Art Mart Help</font>';
var m='';

function DisplayMessage(msg,msgtype,msgtitle,theme='AlertTheme')
{
    try
    {//SuccessTheme, AlertTheme
        $('#divAlert').html(msg).addClass(theme);
        
        
        Swal.fire({
              type: msgtype,
              title: '<strong>'+msgtitle+'</strong>',
              background: '#F3D3F2',
              color: '#f00',
              allowEscapeKey: false,
              allowOutsideClick: false,
              html: '<font size="3" face="Arial">'+msg+'</font>',
              showCloseButton: true,
              //footer: '<a href>Why do I have this issue?</a>'
            })
            
        //Swal.showLoading(); Swal.hideLoading() 
        
        //Swal.close()
        setTimeout(function() {
            $('#divAlert').load(location.href + " #divAlert").removeClass(theme);
        }, 10000);
    }catch(e)
    {
        alert('ERROR Displaying Message: '+e);
    }
}

$(document).ready(function(e) {
    $(function() {			
		$.blockUI.defaults.css = {};// clear out plugin default styling
	});
	
	$(document).ajaxStop($.unblockUI);
	
	$('#btnRegister').click(function(e) 
	{
		try
		{
			if (!CheckRegister()) return false;
			
			var ut=$.trim($('#cboUserType').val()).toLowerCase();			
			var nm=$.trim($('#txtUserName').val());			
			var em=$.trim($('#txtEmail').val());
			var ph=$.trim($('#txtPhone').val());
			var mydata,url;
			
			if ((ut=='investor') || (ut=='both'))
			{
				mydata={usertype:ut, name:nm, email:em, phone:ph, pwd:AES256.encrypt($('#txtPwd').val(),'<?php echo ACCESS_STAMP; ?>')};
					
				url="<?php echo site_url('ui/Signup/RegisterInvestor');?>";
			}else if (ut=='issuer')
			{
				url="<?php echo site_url('ui/Signup/RegisterIssuer');?>";
				
				mydata={user_name:nm, email:em, phone:ph, pwd:AES256.encrypt($('#txtPwd').val(),'<?php echo ACCESS_STAMP; ?>')};
			}
			
			$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Signup In Progress. Please Wait....</p>',theme: false,baseZ: 2000});
																							
			$.ajax({
				url: url,
				data: mydata,
				type: 'POST',
				dataType: 'json',
				success: function(data,status,xhr) {	
					$.unblockUI();
					
					if ($(data).length > 0)
					{																								
						$.each($(data), function(i,e)
						{
							m=e.status;
							
							if ($.trim(e.Flag).toUpperCase() == 'OK')
							{
								$('#cboUserType').val('');
								$('#txtUserName').val('');								
								$('#txtPhone').val('');
								$('#txtEmail').val('');
								$('#txtPwd').val('');
								$('#txtConfirm').val('');
								$("#chkAgree").prop("checked", false);
								
								DisplayMessage(m, 'success','SIgnup User','SuccessTheme');
							}else
							{
								DisplayMessage(m, 'error',Title);
							}
							
							return;
						});
					}				
				},
				error:  function(xhr,status,error) {
					$.unblockUI();
					m='Error '+ xhr.status + ' Occurred: ' + error;
					DisplayMessage(m, 'error',Title);
				}
			});
			
		}catch(e)
		{
			$.unblockUI();
			m='Register Button Click ERROR:\n'+e;			
			DisplayMessage(m, 'error',Title);
			return false;
		}
	});//btnRegister Click Ends
	
	function CheckRegister()
	{
		var m;				

		try
		{
			var ut=$.trim($('#cboUserType').val()).toLowerCase();			
			var nm=$.trim($('#txtUserName').val());
			
			var em=$.trim($('#txtEmail').val());
			var ph=$.trim($('#txtPhone').val());
			var pwd=$('#txtPwd').val();
			var cpw=$('#txtConfirm').val();
						
			var chk='0';			
			if ($('#chkAgree').is(':checked')) chk='1';
			
			//User type
			if (!ut)
			{
				m='Please indicate the type of user you want to register as.';
				DisplayMessage(m, 'error',Title);
				$('#cboUserType').focus(); return false;
			}
			
			//Name
			if (!nm)
			{
				m='Name field must not be blank.';
				DisplayMessage(m, 'error',Title);					
				$('#txtUserName').focus(); return false;
			}
			
			if ($.isNumeric(nm))
			{
				m='Name field must not be a number.';					
				DisplayMessage(m, 'error',Title);					
				$('#txtUserName').focus(); return false;
			}
			
			if (nm.length<3)
			{
				m='Please enter a meaningful name.';					
				DisplayMessage(m, 'error',Title);					
				$('#txtUserName').focus(); return false;
			}
			
			
			//Email
			if (!em)
			{
				m='Email address field must not be blank.';
				DisplayMessage(m, 'error',Title);
				return false;
			}				

			//Valid Email?
			if (!isEmail(em))
			{
				m='The email address entered (<b> '+em+'</b>) is not invalid. Please check your entry.';   						
				DisplayMessage(m, 'error',Title);
				return false;
			}
			
			//Phone								
			if (!ph)
			{
				m="Phone number field must not be blank.";
				DisplayMessage(m, 'error',Title);					
				$('#txtPhone').focus(); return false;
			}
			
			if (!$.isNumeric(ph.replace('+','')))
			{
				m="Phone number field must be numeric. Please enter a valid phone number.";
				DisplayMessage(m, 'error',Title);					
				$('#txtPhone').focus(); return false;
			}

			//Pwd
			if (!$.trim(pwd))
			{
				m='Login password field must not be blank.';
				DisplayMessage(m, 'error',Title);					
				return false;
			}
			
			var v=IsValidPassord(pwd,em,8);
			
			if (v != 1)
			{
				DisplayMessage(v, 'error',Title);					
				return false;
			}				
			
			//Confirm Password
			if (pwd != cpw)
			{
				m='Login password and confirming password fields do not match.';
				DisplayMessage(m, 'error',Title);					
				return false;
			}
						
			//Agree To Terms
			if ($.trim(chk)=='0')
			{
				m='You have to agree to Naija Art Market terms and condition before you can register.';				
				DisplayMessage(m, 'error',Title);
				return false;
			}
			
			return true;
		}catch(e)
		{
			$.unblockUI();
			m='CheckRegister ERROR:\n'+e;					
			DisplayMessage(m, 'error',Title);
		}
	}
});//End Document Ready

</script>

</head>


<body class="page-login">
        <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K529X6D"
                    height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>

    
    <main class="page-content">
        <div class="page-inner">
            <div id="main-wrapper">
                <div class="row">
                    <div class="col-md-3 center">
                       <center>
                        <a href="<?php echo site_url('ui/Home'); ?>">
                        		<img class="mobile-logo preload-me" src="<?php echo base_url(); ?>wp-content/uploads/Logo_ArtSquare_mobile.png" width="200" height="33" sizes="200px" alt="Naija Art Market – The new art market. For everyone"/>
                        </a>
                        </center>
                        
                        <div class="login-box">
                            
<br><p><a href="<?php echo site_url('ui/Home'); ?>" class="logo-name text-lg text-center">Register to Naija Art Market</a></p>

<p class="login-info text-center redtext">Create Your Account</p>
<form class="m-t-md" method="post">
    <validation-summary-errors></validation-summary-errors>
    <div class="row">
    	<!--User Type-->
        <div class="col-xs-12">
            <templatefor>
                <div class="form-group">
                    <select title="How do you want to register on the platform? As an Investor, Issuer or both?" class="form-control" id="cboUserType">
                    	<option value="">[Who Are You?]</option>
                        <option title="Select this if you are an investor" value="Investor">Investor</option>
                        <option title="Select this if you have artwork which you want to list on the Naija Art Market" value="Issuer">Issuer (I Have Artwork To List)</option>
                        <option title="Select this if you are an investor and you also have artwork which you want to list on the Naija Art Market" value="Both">Investor And Issuer</option>
                    </select>
                </div>
            </templatefor>
        </div>
                
        
        <!--Issuer Name-->
        <div title="Issuer Name" class="col-xs-12">
            <templatefor>
                <div class="form-group">
                    <input class="form-control" type="text" id="txtUserName" placeholder="Your Name" />
                </div>
            </templatefor>
        </div>
        
        <!--Email-->
        <div title="Your Email" class="col-xs-12">
            <templatefor>
                <div class="form-group">
                     <input class="form-control" type="email" id="txtEmail" placeholder="Your Email" />
                </div>
			</templatefor>
        </div>
        
        <!--Phone-->
        <div title="Your Phone Number" class="col-xs-12">
            <templatefor>
                <div class="form-group">
                    <input class="form-control" type="text" id="txtPhone" placeholder="Your Phone Number" />
                </div>
			</templatefor>
        </div>
        
        <!--Pwd-->
        <div title="Your Login Password" class="col-xs-12">
            <templatefor>
                <div class="form-group">
                    <input autocomplete="new-password" class="form-control" type="password" data-val="true" id="txtPwd" placeholder="Your Login Password" />
                </div>
			</templatefor>
        </div>
        
        <!--Confirm Pwd-->
        <div title="Enter Your Password Again" class="col-xs-12">
            <templatefor>
                <div class="form-group">
                    <input autocomplete="new-password" class="form-control" type="password" id="txtConfirm" placeholder="Confirm Your Password" />
                </div>
			</templatefor>
        </div>
        
    </div>
    
    <div title="Naija Art Market Terms And Conditions" class="row">
        <div class="col-xs-12">
            <label>
                <input id="chkAgree" type="checkbox"> By signing up you accept
            </label>
            <span data-toggle="modal" role="button" data-target="#termsModal">Naija Art Market Terms</span>
        </div>
    </div>
    
   <div id="divAlert"></div>
    
    <div style="margin-top:10px;" class="row">
        <div class="col-xs-12">
            <button id="btnRegister" type="button" class="btn btn-art-green btn-block btn-rounded btn-gradient">Sign up</button>
            
            <p class="text-center m-t-xs text-sm">Already have an account?</p>
            <a title="Click here to go to login page if you already have an account on Naija Art Market." class="btn-primary btn-block m-t-md btn" href="<?php echo site_url('ui/Login'); ?>">Login</a>
        </div>
    </div>
    
</form>


<div class="modal fade terms" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TERMS OF USE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-muted" data-slim="true">
                <p><strong>General</strong></p>
                <p>Welcome to Naija Art Market</p>
                <p>&nbsp;</p>
                <p>NAIJA ART MARKET (referred to as “us” or “we”) is the owner and operator of the Naija Art Market and maintains the <a href="http://www.naijaartmart.com">www.naijaartmart.com</a> website and various related services (together referred to as the “Service”). The following are the terms and conditions of use (“Terms and Conditions of Use”) that govern use of the Service offered on the site. By using the Service you expressly agree to be bound by these Terms and Conditions of Use and Naija Art Market Privacy Policy and to follow these Terms and Conditions of Use and all applicable laws and regulations governing use of the Service.</p>
                <p>&nbsp;</p>
                <p>We reserve the right to change the Terms and Conditions of Use at any time. Such changes, modifications, additions, or deletions shall be effective immediately upon notice thereof, which may be given by means including, but not limited, posting the revised Terms and Conditions of Use on this page. You acknowledge and agree that it is your responsibility to review the Terms and Conditions of Use periodically, and to be aware of any modifications. Your continued use of the Service after such modifications will constitute your acknowledgment of the modified Terms and Conditions of Use and agreement to abide and be bound by the modified Terms and Conditions of Use.</p>
                <p>&nbsp;</p>
                <p>These terms and conditions outline the rules and regulations for the use of NAIJA ART MARKET's &nbsp;Website (Naija Art Market).</p>
                <p>Naija Art Market is located at: 4 Customer Street, CMS, Lagos Island, Lagos, Nigeria</p>
                <p>By accessing this website we assume you accept these terms and conditions in full. Do not continue to use Naija Art Market’s website if you do not accept all of the terms and conditions stated on this page.</p>
                <p>&nbsp;</p>
                <p>The following terminology applies to these Terms and Conditions and any or all Agreements: “Client”, “You” and “Your” refers to you, the person accessing this website and accepting the Company’s terms and conditions. “The Company”, “Ourselves”, “We”, “Our” and “Us”, refers</p>
                <p>to our Company. “Party”, “Parties”, or “Us”, refers to both the Client and ourselves, or either the Client or ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner, whether by formal meetings of a fixed duration, or any other means, for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services/products, in accordance with and subject to, prevailing law of Nigeria. Any use of the above terminology or other words in the singular, plural, capitalisation and/or he/she or they, are taken as interchangeable and therefore as referring to same.</p>
                <p>&nbsp;</p>
                <p><strong>Signing Up Naija Art Market</strong></p>
                <p>&nbsp;</p>
                <p>By clicking on the “Sign Up” button, or by accessing or using Naija Art Market, you acknowledge and agree that you have read, understand and agree to be legally bound by these Terms of Use, and all terms incorporated</p>
                <p>&nbsp;</p>
                <p>We may restrict or limit the use of the Naija Art Market in certain jurisdictions (“Restricted Jurisdictions”) .</p>
                <p>&nbsp;</p>
                <p>You represent and warrant that you: (a) (if you are an individual) have legal capacity and are of legal age to form a binding contract and that you are at least 18 years old, (b) have not previously been rejected for an account or removed/suspended/restricted from using the Naija Art Market, (c) are of sound mind and are capable of taking responsibility for your own actions and have full power and authority to enter into this agreement, (d) are not violating any other agreement to which you are a party in entering in this agreement, (e) you are not a resident or citizen of any Restricted Jurisdiction, (f) all the information you provide to us are accurate, up to date and not misleading and that you will notify us of any changes to any information you have provided (g) any money that you use through Naija Art Market do not originate from any criminal activity that is unlawful or could be considered unlawful by any relevant jurisdiction, (h) will not use Naija Art Market if any applicable laws in your country prohibit you from doing so.</p>
                <p>&nbsp;</p>
                <p>You agree to provide us with the information we request for the purposes of identity verification, know-your-customer (KYC) and detection of money laundering, terrorist financing, fraud, or any other financial crime and permit us to keep a record of such information. You will need to complete certain verification procedures before you are able to use access Naija Art Market services, and in some cases, extra verification or information may be required. Limitations may be applied to your use of Naija Art Market, and these limitations on use may be altered as a result of information collected from you on an ongoing basis.</p>
                <p>&nbsp;</p>
                <p>The information that we request may include certain personal information, including but not limited to, your name, address, telephone number, e-mail address, date of birth, residency, citizenship, identification number, information regarding your bank account and any other personally identifiable information that we may ask for from time to time such as a copy of your passport, proof of addresses or other identifying documentation. In providing such information or other information that may be required, you confirm that the information is accurate and authentic. You agree to update us of any changes in the information you have provided. We may require you to submit additional information about yourself and your business, provide extra records or confirmations.</p>
                <p>&nbsp;</p>
                <p>We reserve the right to limit your use of Naija Art Market or terminate any relationship with you depending on the results of such due diligence. If you do not provide such information within the time frame we require, or provide inaccurate, incomplete or misleading information, we reserve the right to limit, block access or terminate your account.</p>
                <p>&nbsp;</p>
                <p>You authorise us to make inquiries, whether directly or through third parties, that we consider necessary to verify your identity or to protect you and us against fraud or financial crime, and to take action we reasonably deem necessary based on the results of inquiries. When we carry out these inquiries, you acknowledge and agree that your personal information may be disclosed to reference and fraud prevention or financial crime agencies and that these agencies may respond to our inquiries in full.</p>
                <p>&nbsp;</p>
                <p>Data Protection</p>
                <p>You acknowledge that we may process personal data in relation to you (if you are an individual), and personal data that you have provided or in the future provide to us in relation to your employees or other associated individuals, in connection with the Terms of Use (or such other agreements). You represent and warrant that: (a) your disclosure to us of any personal data relating to individuals other than yourself was or will be made in accordance with all applicable data protection and data privacy laws, and those data are accurate, up to date and relevant when disclosed; (b) before providing any personal data to us, you have read and understood our Privacy Policy or have provide such Privacy Policy to such individual other than yourself; (c) from time to time when provided with a replacement version of the Privacy Policy, you will promptly read such notice and provide a copy to the individual whose data you have provided to us.</p>
                <p>&nbsp;</p>
                <p><strong>Privacy Policy &amp; Cookies</strong></p>
                <p>&nbsp;</p>
                <p>Naija Art Market is a company incorporated according to the laws of Nigeria. Accordingly, any information provided will be treated in compliance with the applicable legal provisions applicable, particularly those under the Data Protection Act 1998. You can find more information on our dedicated page Privacy Policy.</p>
                <p>&nbsp;</p>
                <p>We employ the use of cookies. By using Naija Art Market’s website you consent to the use of cookies</p>
                <p>in accordance with Naija Art Market’s privacy policy. Most of the modern day interactive web sites</p>
                <p>use cookies to enable us to retrieve user details for each visit. Cookies are used in some areas of our site to enable the functionality of this area and ease of use for those people visiting. Some of our affiliate/advertising partners may also use cookies.</p>
                <p>&nbsp;</p>
                <p><strong>Limited License</strong></p>
                <p>&nbsp;</p>
                <p>Unless otherwise stated, Naija Art Market and/or it’s licensors own the intellectual property rights for</p>
                <p>all material on Naija Art Market. All intellectual property rights are reserved. You may view and/or print</p>
                <p>pages from <a href="https://naijaartmart.com/">https://naijaartmart.com</a> for your own personal use subject to restrictions set in these terms and conditions.</p>
                <p>You must not:</p>
                <ul>
                    <li>Republish material from <a href="https://naijaartmart.com/">https://naijaartmart.com</a></li>
                    <li>Sell, rent or sub-license material from <a href="https://naijaartmart.com/">https://naijaartmart.com</a></li>
                    <li>Reproduce, duplicate or copy material from <a href="https://naijaartmart.com/">https://naijaartmart.com</a></li>
                    <li>Redistribute content from Naija Art Market (unless content is specifically made for redistribution).</li>
                    <li>Hyperlinking to our Content</li>
                </ul>
                <p>&nbsp;</p>
                <p>The following organizations may link to our Web site without prior written approval:</p>
                <ul>
                    <li>Government agencies;</li>
                    <li>Search engines;</li>
                    <li>News organizations;</li>
                    <li>Online directory distributors when they list us in the directory may link to our Web site in the same manner as they hyperlink to the Web sites of other listed businesses</li>
                    <li>Systemwide Accredited Businesses except soliciting non-profit organizations, charity shopping malls, and charity fundraising groups which may not hyperlink to our Web site.</li>
                </ul>
                <p>&nbsp;</p>
                <p>These organizations may link to our home page, to publications or to other Web site information so long as the link: (a) is not in any way misleading; (b) does not falsely imply sponsorship, endorsement or approval of the linking party and its products or services; and (c) fits within the context of the linking party’s site.</p>
                <p>No use of Naija Art Market’s logo or other artwork will be allowed for linking absent a trademark license agreement.</p>
                <p>&nbsp;</p>
                <p>Reservation of Rights</p>
                <p>We reserve the right at any time and in its sole discretion to request that you remove all links or any particular link to our Web site. You agree to immediately remove all links to our Web site upon such request. We also reserve the right to amend these terms and conditions and its linking policy at any time. By continuing to link to our Web site, you agree to be bound to and abide by these linking terms and conditions.</p>
                <p>&nbsp;</p>
                <p>Removal of links from our website</p>
                <p>If you find any link on our Web site or any linked web site objectionable for any reason, you may contact us about this. We will consider requests to remove links but will have no obligation to do so or to respond directly to you. Whilst we endeavour to ensure that the information on this website is correct, we do not warrant its completeness or accuracy; nor do we commit to ensuring that the website remains available or that the material on the website is kept up to date.</p>
                <p>&nbsp;</p>
                <p>Content Liability</p>
                <p>We shall have no responsibility or liability for any content appearing on your Web site. You agree to indemnify and defend us against all claims arising out of or based upon your Website. No link(s) may appear on any page on your Web site or within any context containing content or materials that may be interpreted as libelous, obscene or criminal, or which infringes, otherwise violates, or advocates the infringement or other violation of, any third party rights.</p>
                <p><strong>DIgital Share of Artworks (or Artwork Token) purchase</strong></p>
                <p>A Digital Share of Artwork (Artwork tokens) is a percentage representing a fraction of the ownership of the Artwork. The sale of the Artwork shall be perfected once a Threshold is reached. Once Digital Share of Artwork or more are sold to you, you will be in a position to transfer them in the secondary market to other users.</p>
                <p>As a result of the purchase of the Digital Share of Artwork the User shall become co-owner of the Artwork. The co-ownership means that the User will share the ownership of the Artwork with other Users who invested in Digital Shares of the same Artworks.</p>
                <p>The purchase of one or more Digital Share of Artworks allows the User to become the co-owner of the digitally fractionalized Artwork; nevertheless, entailed to this purchase is a form of investment that may expose the User to capital losses. In this respect, the User is aware of the economic risk that may arise from this activity.</p>
                <p>Naija Art Market is the only entity and/or body entitled to assess the ownership of the Digital Share of Artwork and how much of the Artwork each of them represents.</p>
                <p>The sale of Digital Shares of Artworks does not require any authorization by the Financial Conduct Authority, as it is not a market of financial instruments.</p>
                <p>The Artworks shall be stored and/or exhibited either in Naija Art Market storage or at any location chosen by the owner of the majority of Digital Shares of Artwork. Naija Art Market will communicate the status of the artworks on its website to the co-owners.</p>
                <p><strong>Disclaimer</strong></p>
                <p>Neither Naija Art Market nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness or suitability of the information and materials found or offered on this website for any particular purpose. You acknowledge that such information and materials may contain inaccuracies or errors and we expressly exclude liability for any such inaccuracies or errors to the fullest extent permitted by law.</p>
                <p>To the maximum extent permitted by applicable law, we exclude all representations, warranties and conditions relating to our website and the use of this website (including, without limitation, any warranties implied by law in respect of satisfactory quality, fitness for purpose and/or the use of reasonable care and skill).</p>
                <p>&nbsp;</p>
                <p>Naija Art Market is not a financial institution and is not licensed by or under the supervision of any financial supervisory authority and does not provide any licensed financial services such as investment services, capital raising, fund management, management of a collective investment scheme or investment advice.</p>
                <p>&nbsp;</p>
                <p>Naija Art Market does not provide any financial advice. None of the information that Naija Art Market provides should be regarded as “investment advice” or “recommendation” regarding a course of action, including without limitation, as those terms are used in any applicable law or regulations. Information provided on Naija Art Market is provided with the understanding that (a) Naija Art Market is not acting in a fiduciary or advisory capacity under any contract with you, or any applicable law or regulation, (b) you will make your own independent decision with respect to any course of action in connection herewith as to whether such course of action is appropriate or proper based on your own judgement and your specific circumstances and objectives, (c) you are capable of understanding and assessing the merits of a course of action and evaluating investment risks independently.</p>
                <p>&nbsp;</p>
                <p>Naija Art Market does not purport to and does not, in any fashion provide tax, accounting, actuarial, recordkeeping, legal, broker/dealer or any related services. You should consult your own advisors with respect to these areas and any material with regards to investment decisions.</p>
                <p>You may not rely on the material contained herein. Naija Art Market shall not have any liability for any damages of any kind whatsoever relating to this material.</p>
                <p>&nbsp;</p>
                <p>The website is provide “as is” and on an “as available” basis and we give no warranty that it will be free from defects and/or faults. We make no warranty or representation (express or implied) that it will be fit for any particular purposes, that it will not infringe the rights of third parties, that it will be compatible with all systems, that it will be secure or that all information provided will be continuous, uninterrupted, timely, accurate or error free.</p>
                <p>&nbsp;</p>
                <p>Naija Art Market &nbsp;may be temporarily unavailable from time to time for maintenance or other reasons. We assume no responsibility for any error, omission, interruption, deletion, defect, delay in operation or transmission, communications line failure, theft or destruction or unauthorised access to, or alteration of your communications.</p>
                <p>&nbsp;</p>
                <p>Naija Art Market reserves the right to change any and all content at any time without notice.</p>
                <p>&nbsp;</p>
                <p><strong>Limitation of Liability</strong></p>
                <p>&nbsp;</p>
                <p>Naija Art Market &nbsp;accepts no liability for any direct or indirect loss or damage, whether or not foreseeable, including any indirect, consequential or other damages arising from your use of Naija Art Market platform or any information contained in it, to the maximum extent permissible by law.</p>
                <p>&nbsp;</p>
                <p>Indemnity</p>
                <p>You agree to indemnify Naija Art Market officers, directors, agents, employees and representatives, in respect of any costs (including legal fees and any fines, fees or penalties imposed by any regulatory or governmental authority) that have been incurred in connection with any claims, demands or damages arising out of or related to your breach and/or our enforcement of these Terms of Use (and any other agreements entered with you) or your violation of any law, rule, regulation or rights of any third party.</p>
                <p>&nbsp;</p>
                <p>Severability</p>
                <p>If any provision of these Terms of Use (or other agreement) is found to be unlawful, invalid or otherwise unenforceable, that provision is deemed to be severed from the Terms of Use (or other agreement) and shall not affect the validity and enforceability of the remaining Terms of Use (or other agreement) which shall continue in full force and effect.</p>
                <p>The limitations and exclusions of liability set out in this Section and elsewhere in this disclaimer: (a) are subject to the preceding paragraph; and (b) govern all liabilities arising under the disclaimer or in relation to the subject matter of this disclaimer, including liabilities arising in contract in tort (including negligence) and for breach of statutory duty.</p>
                <p>&nbsp;</p>
                <p><strong>Electronic Notices</strong></p>
                <p>You consent to electronically receive all notices, communications, agreements, documents and disclosures (“Notices”) that we provide you as a user of Naija Art Market.</p>
                <p>We will provide these Notices by posting on the websites or by sending through at the email address that you have provided us, or through instant messaging chats and/or such other electronic communication.</p>
                <p>&nbsp;</p>
                <p><strong>Changes to Terms of Use</strong></p>
                <p>Amendments may be made to the Terms of Use from time to time, and posted on the websites, with an indication of the date on which the Terms of Use were last revised. You acknowledge, understand and agree that the continued use of Naija Art Market after we have made any such changes constitutes your acceptance of the new Terms of Use.</p>
                <p><strong>Governing Law</strong></p>
                <p>The parties irrevocably submit any controversies arising out of the use of Naija Art Market to the jurisdiction of the courts of England and Wales, venue of London.</p>
                <p>&nbsp;</p>
                <p><em>“Restricted Jurisdictions”</em> will be determined from time to time by Naija Art Market, in accordance with any applicable sanctions regulations or selling restrictions, which is necessary for Naija Art Market to be in compliance with relevant laws and regulations.</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>This list (as at the date of these Terms and Conditions) includes,</p>
                <p>USA, Democratic People’s Republic of Korea (DPRK), Iran, Cuba, Albania, Serbia, Sudan or Syria (or any other countries which are subject to applicable government sanctions).</p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-success " formaction="/Account/SignUp">Close</button>
            </div>
        </div>
    </div>
</div>


                        </div>
                        <p class="text-center m-t-xxl text-sm">&copy; Naija Art Mart <?php echo date('Y'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript">
    var culture = 'en-US';
</script>


    <script src="<?php echo base_url(); ?>loginassets/js/bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>loginassets/js/bundle.en-US.min.js"></script>
    <script src="<?php echo base_url(); ?>loginassets/js/site.min.js"></script>
    <script src="<?php echo base_url(); ?>loginassets/js/locales/site.en-US.min.js"></script>


    <script>
    $(function () {
        $("#agreeTerms").change(function () {
            if ($(this).is(":checked")) {
                $("#btnSignup").removeAttr("disabled");
            }
            else {
                $("#btnSignup").attr("disabled", "disabled");
            }
        }).change();
    });
</script>
</body>

</html>




