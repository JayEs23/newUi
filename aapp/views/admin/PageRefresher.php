<script>
		var RefreshInterval='<?php echo $RefreshInterval; ?>';
		RefreshInterval=parseInt(RefreshInterval) * 60 * 1000;
		//RefreshInterval=parseInt(RefreshInterval) * 5 * 1000; //Every RefreshInterval Minutes
		
		var Interval=2;
		Interval=parseInt(Interval) * 60 * 1000; //Every Interval Minutes
		
		var options = {
			autostart: true,
			property: 'value',
			onComplete: null,
			duration: 20000,
			padding: 150,
			marquee_class: '.marquee',
			container_class: '.simple-marquee-container',
			sibling_class: 0,
			hover: true,
			velocity: 0.1,
			direction: 'left'
		}
		
    	$(document).ready(function(e) {
			GetMessages();
			//RefreshPrice();
			ChangeScrollText($('.marquee').html());
			
			setInterval(function(){
				RefreshPrice();
			}, (RefreshInterval));
			
			function RefreshPrice()
			{
				try
				{
					//Get Scrolling prices
					//Initiate POST
					var uri = "<?php echo site_url('admin/Dashboard/GetPricesAndStatus'); ?>";
					var xhr = new XMLHttpRequest();
					
					xhr.open("POST", uri, true);
					
					xhr.onreadystatechange = function() {
						if (xhr.readyState == 4 && xhr.status == 200)
						{
							var res = JSON.parse(xhr.responseText);
							var MarketStatus=res.MarketStatus;
							
							if ($.trim(MarketStatus).toUpperCase() == 'OPEN')
							{
								MarketStatus='<font color="#82E99B">'+MarketStatus+'</font>';
							}else
							{
								MarketStatus='<font color="#FF5858">'+MarketStatus+'</font>';
							}
							
														
							//$('#idMarquee').html(res.ScrollingPrices);
							$('#spnMarketStatus').html(MarketStatus);							
							ChangeScrollText(res.ScrollingPrices);								
						}
					};
																				
					xhr.send();// Initiate a multipart/form-data upload					
					
					//var t = setTimeout(RefreshPrice, 5000);					
				}catch(e)
				{
					
				}
			}
			
			function ChangeScrollText(prices)//In seconds
			{
				try
				{
					$(".simple-marquee-container").find("div").remove();//Remove current prices
		
					var div = document.createElement("div");
					div.className="marquee";
					div.innerHTML = prices;
					
					document.getElementsByClassName("simple-marquee-container")[0].appendChild(div);
		
					$.removeData($('.simple-marquee-container').get(0)); //Destroy old scroller instance			
					$('.simple-marquee-container').SimpleMarquee(options);
				}catch(e)
				{
					alert('ChangeScrollText In Admin: '+e);
				}
			}
			
			setInterval(function(){
				GetMessages();
			}, Interval);//Every 5 minutes
			
			function GetMessages()
			{
				try
				{
					$.ajax({
						url: '<?php echo site_url('admin/Dashboard/GetAdminMessages'); ?>',
						type: 'POST',
						data: {email:'<?php echo $email; ?>',usertype:'<?php echo $usertype; ?>'},
						dataType: 'json',
						cache:false,
						success: function(response,status,xhr) {
							if ($(response).length > 0)
							{//alert($(response).length);
								if ($(response).length == 1)
								{
									$('#adminMsgCount').html(response.length);
									
									$('#adminAlert').prop('title','You have '+number_format(response.length,0,'',',')+' message. Click to view the headline.');
									
									$('#adminMsgHeader').html(number_format(response.length,0,'',',')+' message. Click to view the details.');
								}else
								{
									$('#adminMsgCount').html(response.length);	
									
									$('#adminAlert').prop('title','You have '+number_format(response.length,0,'',',')+' messages. Click to view the headlines.');
									
									$('#adminMsgHeader').html(number_format(response.length,0,'',',')+' messages. Click to view the details.');
								}
								
								var ms='';
								
								$.each($(response), function(i,e)
								{
									if (e.header && e.msgid)
									{
										e.header = $.trim(e.header).replace(new RegExp("'", 'g'), '`');
										
										if (e.details) e.details =$.trim(e.details).replace(new RegExp("'", 'g'), '`');
										
										ms += '<div class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--one-column">' +
											  '<div class="vertical-timeline-item dot-danger vertical-timeline-element">' +
											  '  <div><span class="vertical-timeline-element-icon bounce-in"></span>' +
											  '	  <div title="Click To View Details Of This '+e.category+'" class="vertical-timeline-element-content bounce-in"><h4 class="timeline-title"><a style="cursor:pointer;" onclick="LocateMesssage('+e.msgid+',\''+urlencode(e.header)+'\',\''+urlencode(e.details)+'\',\''+e.sender+'\',\''+e.msgddate+'\',\''+e.expiredate+'\',\''+e.category+'\',\''+e.display_status+'\',\''+e.recipients+'\')">'+e.header+'</a></h4><span class="vertical-timeline-element-date"></span></div>' +
											  '	</div>' +
											'</div>' +
										'</div>';							
									}
								});
															
								
								$("#adminMessages").html(ms);												
							}else
							{
								$('#adminMsgCount').html('');
								
								$('#adminAlert').html(number_format(response.length,0,'',',')).prop('title','You have 0 message. Click to view the headline.');
							}
						}
					});
				}catch(e)
				{
	
				}
			}
        });
		
		function LocateMesssage(mid,hd,det,sn,dt,edt,cat,sta,recs)
		{
			try
			{
				$.redirect("<?php echo base_url(); ?>admin/Messages", {msgid:mid, header:hd, details:det, sender:sn, msgdate:dt, expiredate:edt, category:cat, display_status:sta, recipients:recs}, "POST");	
			}catch(e)
			{
	
			}
		}
    </script>