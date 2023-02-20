<script>
	var RefInterval='<?php echo $RefreshInterval; ?>';
	RefInterval=parseInt(RefInterval) * 60 * 1000; //Every RefreshInterval Minutes
	//RefInterval=parseInt(RefInterval) * 10 * 1000; //Every RefreshInterval Minutes
	
	//RefInterval=10000;
	
	var Interval=2;
	Interval=parseInt(Interval) * 60 * 1000; //Every Interval Minutes
	
	var options = {
		autostart: true,
		property: 'value',
		onComplete:function(){},
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
		}, RefInterval);
			
		function RefreshPrice()
		{
			try
			{
				$.ajax({
					url: '<?php echo site_url('admin/Dashboard/GetPricesAndStatus'); ?>',
					type: 'POST',
					dataType: 'json',
					cache:false,
					success: function(response,status,xhr) {				
						if ($(response).length > 0)
						{
							MarketStatus=response.MarketStatus;
							ScrollingPrices=response.ScrollingPrices;
							
							//alert(MarketStatus);
							if ($.trim(response.MarketStatus).toUpperCase() == 'OPEN')
							{
								response.MarketStatus='<font color="#82E99B">'+response.MarketStatus+'</font>';
							}else
							{
								response.MarketStatus='<font color="#FF5858">'+response.MarketStatus+'</font>';
							}
							
							//$('#idMarquee').html(response.ScrollingPrices);
							$('#spnClientMarketStatus').html(response.MarketStatus);							
							
							ChangeScrollText(response.ScrollingPrices);
						}
					}
				});
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
				alert('ChangeScrollText In ui: '+e);
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
					url: '<?php echo site_url('admin/Dashboard/GetMessages'); ?>',
					type: 'POST',
					data: {email:'<?php echo $email; ?>',usertype:'<?php echo $usertype; ?>'},
					dataType: 'json',
					cache:false,
					success: function(response,status,xhr) {
						if ($(response).length > 0)
						{
							if ($(response).length == 1)
							{
								$('#uiMsgCount').html(number_format(response.length,0,'',',')).prop('title','You have '+number_format(response.length,0,'',',')+' message. Click to view the headline.');	
							}else
							{
								$('#uiMsgCount').html(number_format(response.length,0,'',',')).prop('title','You have '+number_format(response.length,0,'',',')+' messages. Click to view the headlines.');	
							}
							
							var ms='<ul id="uiMessages" class="dropdown-menu notifications">';
							
							$.each($(response), function(i,e)
							{
								if (e.header && e.msgid)
								{
									e.header = $.trim(e.header).replace(new RegExp("'", 'g'), '`');
									
									if (e.details) e.details =$.trim(e.details).replace(new RegExp("'", 'g'), '`');
								
									ms += '<li title="Click To View Details Of This '+e.category+'"><a style="cursor:pointer;" onclick="LocateMesssage('+e.msgid+',\''+urlencode(e.header)+'\',\''+urlencode(e.details)+'\',\''+e.msgdate+'\',\''+e.category+'\')"  class="notification-item"><span class="dot bg-warning"></span>'+e.header+'</a></li>';							
								}
							});
							
							ms += '</ul>';							
							
							var element =  document.getElementById('uiMessages');
							
							if (typeof(element) != 'undefined' && element != null)//Remove existing element
							{
							 	$("#uiMessages").remove();
							}
							
							$("#ancMsg").after(ms);
						}else
						{
							$('#uiMsgCount').html(0).prop('title','You have 0 message.');
							//$('#uiMessages').html(response.MarketStatus);	
						}
					}//uiMsgCount,   uiMessages
				});
			}catch(e)
			{

			}
		}
		
	});
	
	function LocateMesssage(mid,hd,det,dt,cat)
	{
		try
		{
			$.redirect("<?php echo base_url(); ?>ui/Messages", {msgid:mid, header:hd, details:det, msgdate:dt,category:cat}, "POST");	
		}catch(e)
		{

		}
	}
</script>