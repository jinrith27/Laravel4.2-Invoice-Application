@extends('layouts.default')

	@section('content')
	 
	<h1><a class="do_previous" href="{{ URL::to('dashboard') }}">&nbsp;<i class="fa fa-home">&nbsp;</i></a>&raquo; <a href="{{URL::to('help') }}">Help</a> &raquo; Getting started</h1>
	
	<div id="quick_start">
		 
		 <div class="guide_section">
			
			<p>The following is a short, simple introductory guide to Sighted invoicing and expense tracking application. 
		 It is meant to walk you through the basic steps needed to understand how Sighted works.</p>		 
		</div><!-- END Quide section -->
		
		<div class="guide_section">
			
			<h2>1. Welcome Video - Quick Tour</h2>
			 
			<div class="quick_start_video">				 
				<iframe src="//player.vimeo.com/video/104409267" width="565" height="318" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			</div>
			
			<p>Can't watch video? <a href="#">click here</a> for slides</p>
		 
		</div><!-- END Quide section -->
	  
		<div class="guide_section">
			
			<h2>2. Creating and sending an invoice</h2>
			
			<div class="quick_start_video">				 
				<iframe src="//player.vimeo.com/video/104409270" width="565" height="318" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			</div>
			
			<p>Can't watch video? <a href="#">click here</a> for slides</p>
			
		</div><!-- END Quide section -->
		
		<div class="guide_section">
			
			<h2>3. Recording an expense</h2>
			
			<div class="quick_start_video">				 
				<iframe src="//player.vimeo.com/video/104409271" width="565" height="318" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			</div>
			
			<p></p>
			
		</div><!-- END Quide section -->
		
		
		<div class="guide_section">
			
			<h2>4. Creating a Client </h2>
			
			<div class="quick_start_video">				 
				<iframe src="//player.vimeo.com/video/104409272" width="565" height="318" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			</div>
			
			<p>Can't watch video? <a href="#">click here</a> for slides</p>
			
		</div><!-- END Quide section -->
		
		
		
		<div class="guide_section">
			
			<h2>5. Customization / Settings </h2>
			
			<div class="quick_start_video">				 
				<iframe src="//player.vimeo.com/video/104409269" width="565" height="318" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			</div>
			
			<p>Can't watch video? <a href="#">click here</a> for slides</p>
			
		</div><!-- END Quide section -->
		
		
		<div class="guide_section">
			
			<h2>Weldone! you're now up to speed with your Sighted.</h2>
			 
			<p> Need Help? Find the answers you're looking for in the <a class="alink" href="{{ URL::to('help') }}">Help Center</a>. If you need further assistance please send us a <a class="alink" href="{{ URL::to('support') }}">quick message</a> 
			<?php if (Config::get('app.support_phone')): ?>
				or call us now on {{ Config::get('app.support_phone') }},	
			<?php endif ?>
			
			 we are here to support you all the way!</p>
			
			<a class="getting_started_link bigButton" href="{{ URL::route('dashboard') }}">Go to HomePage<span class="">Time to do some work!</span></a>
			
		</div><!-- END Quide section -->
		
	</div><!-- END QUICK START-->
 
 		 
	@stop
	

@section('footer')

    <script src="{{ URL::asset('assets/js/jquery.fitvids.js') }}"></script>

	<script>
	
		$(function(){
		 
		 	 if($('#appmenu').length > 0){
				    
				    $('.more_all_menu').addClass('selected_group'); 		 
			  		$('.menu_help').addClass('selected');		  		
			  		$('.more_all_menu ul').css({'display': 'block'});
			  }
			  
			  
			  $("#page-container").fitVids();
		 
		});
		
	</script>
	
@stop