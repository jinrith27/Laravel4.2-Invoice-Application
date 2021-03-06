@extends('layouts.default')

	@section('content')
	
	@if($request_type == 'quote')
	 <h1><a class="do_previous" href="{{ URL::to('dashboard') }}">&nbsp;<i class="fa fa-home">&nbsp;</i></a>&raquo; <?php if(isset($searchquery) && $searchquery != ""){ echo "Search results: "; } ?> {{ isset($searchquery) && $searchquery != "" ? '<a href="'.URL::to('quotes').'">Quotes</a>' : 'Quotes' }} <span> - <?php echo $total_records; ?> record<?php echo (int)$total_records == 0 || (int)$total_records > 1 ? "s": ""; ?></span></h1>
	
	@elseif($request_type == 'invoice')
	 <h1><a class="do_previous" href="{{ URL::to('dashboard') }}">&nbsp;<i class="fa fa-home">&nbsp;</i></a>&raquo; <?php if(isset($searchquery) && $searchquery != ""){ echo "Search results: "; } ?> {{ isset($searchquery) && $searchquery != "" ? '<a href="'.URL::to('invoices').'">Invoices</a>' : $filter_label.' Invoices' }} <span> - <?php echo $total_records; ?> record<?php echo (int)$total_records == 0 || (int)$total_records > 1 ? "s": ""; ?></span></h1>
	
	@endif 
	
	<?php if(isset($search_terms) && $num_results == 0): ?>
		<p class="messagewarning">You search term(s): <?php echo $search_terms; ?> returned no result. <a href="<?php // echo site_url('invoices'); ?>">go back</a></p>
		
		<div class="simple_search">
		<?php // echo form_open('invoices/search'); ?>
		<input type="text" class="search_term" name="search_term" value="search..." />
		<input type="submit" class="search_submit" name="search_submit" value="" />
		<p class="tinytext">Invoice ID, Client name or item name.</p>
		<?php // echo form_close(); ?>
	   </div><!-- END search -->
	   
	<?php endif; ?>
	
	@if($request_type == 'quote')
	   <span class="page_newinvoice_dropdown">
          <a class="btn page_menu_newinvoice" data="quote" href="{{ URL::Route('create_quote') }}"><?php echo $total_records >= 1 ? "Create quote" : "Create your first quote"; ?></a>
            <div class="page_menu_newinvoice_submenu page_popup">
					  <?php $preferences = Preference::where('tenantID', '=', Session::get('tenantID'))->first(); ?>
						{{ Form::open(array('url' => 'settings/invoice_update', 'method' => 'PUT')) }}
						  	
						  	<div class="option_section">
								<p><strong>What is this <span class="form_type"></span> for?</strong> <br />
								<label for="option_service2"><input id="option_service2" type="radio" class="" name="business_model" value="1" {{ $preferences->business_model == 1 ? 'checked' : '' }}> services</label> &nbsp;&nbsp;
								<label for="option_product2"><input id="option_product2" type="radio" class="" name="business_model" value="0" {{ $preferences->business_model == 0 ? 'checked' : '' }}> products</label> <br>
								</p>
							</div>
							
							<div id="bill_option2" class="option_section {{ $preferences->business_model == 0 ? 'hide_section' : '' }}">
								<p><strong>Billing method (for services)</strong> <br />
								<label for="option_bill_project2"><input id="option_bill_project2" type="radio" name="bill_option" value="1" {{ $preferences->bill_option == 1 ? 'checked' : '' }}> per project</label> &nbsp;&nbsp;
								<label for="option_bill_hour2"><input id="option_bill_hour2" type="radio" name="bill_option" value="0" {{ $preferences->bill_option == 0 ? 'checked' : '' }}> per hour</label><br>
								</p>
							</div>
							
							<div class="option_section">
							<p> 
							<label for="option_disc2"> <input id="option_disc2" type="checkbox" name="enable_discount" value="1" {{ $preferences->enable_discount == 1 ? 'checked' : '' }}> enable discount</label> &nbsp;&nbsp;			  
							 @if($preferences->tax_perc1 > 0 || $preferences->tax_perc2 > 0)
							<label for="option_tax2"> <input id="option_tax2" type="checkbox" name="enable_tax" value="1" {{ $preferences->enable_tax == 1 ? 'checked' : '' }}> enable tax</label>
							 @endif
						    </p>
						    </div>
						    <input type="hidden" id="form_type" name="form_type" value="">
					     <br />	         
					    <button class="btn btn-default cancelBtn cancel_newinvoce">Cancel</button> <button id="go_invoice_form2" class="gen_btn" name="" value="Next step" />Next step</button>
					 
			   		{{ Form::close() }}
					 
	        </div><!-- END page_menu_newinvoice_submenu -->					
	 </span><!-- END page_newinvoice_dropdown -->
	 
	 @elseif($request_type == 'invoice')
	  
	  <span class="page_newinvoice_dropdown">
	  	<a class="btn page_menu_newinvoice" data="invoice" href="{{ URL::Route('create_invoice') }}"><?php echo $total_records >= 1 ? "Create invoice" : "Create your first invoice"; ?></a>
            <div class="page_menu_newinvoice_submenu page_popup">
					  <?php $preferences = Preference::where('tenantID', '=', Session::get('tenantID'))->first(); ?>
						{{ Form::open(array('url' => 'settings/invoice_update', 'method' => 'PUT')) }}
						  	
						  	<div class="option_section">
								<p><strong>What is this <span class="form_type"></span> for?</strong> <br />
								<label for="option_service2"><input id="option_service2" type="radio" class="" name="business_model" value="1" {{ $preferences->business_model == 1 ? 'checked' : '' }}> services</label> &nbsp;&nbsp;
								<label for="option_product2"><input id="option_product2" type="radio" class="" name="business_model" value="0" {{ $preferences->business_model == 0 ? 'checked' : '' }}> products</label> <br>
								</p>
							</div>
							
							<div id="bill_option2" class="option_section {{ $preferences->business_model == 0 ? 'hide_section' : '' }}">
								<p><strong>Billing method (for services)</strong> <br />
								<label for="option_bill_project2"><input id="option_bill_project2" type="radio" name="bill_option" value="1" {{ $preferences->bill_option == 1 ? 'checked' : '' }}> per project</label> &nbsp;&nbsp;
								<label for="option_bill_hour2"><input id="option_bill_hour2" type="radio" name="bill_option" value="0" {{ $preferences->bill_option == 0 ? 'checked' : '' }}> per hour</label><br>
								</p>
							</div>
							
							<div class="option_section">
							<p> 
							<label for="option_disc2"> <input id="option_disc2" type="checkbox" name="enable_discount" value="1" {{ $preferences->enable_discount == 1 ? 'checked' : '' }}> enable discount</label> &nbsp;&nbsp;			  
							 @if($preferences->tax_perc1 > 0 || $preferences->tax_perc2 > 0)
							<label for="option_tax2"> <input id="option_tax2" type="checkbox" name="enable_tax" value="1" {{ $preferences->enable_tax == 1 ? 'checked' : '' }}> enable tax</label>
							 @endif
						    </p>
						    </div>
						    <input type="hidden" id="form_type" name="form_type" value="">
					     <br />	         
					    <button class="btn btn-default cancelBtn cancel_newinvoce">Cancel</button> <button id="go_invoice_form2" class="gen_btn" name="" value="Next step" />Next step</button>
					 
			   		{{ Form::close() }}
					 
	        </div><!-- END page_menu_newinvoice_submenu -->					
	 </span><!-- END page_newinvoice_dropdown -->
	 
     <a class="btn" href="{{ URL::Route('exportInvoices') }}">Export</a>
    @endif 
	
	<?php if($total_records >= 1):  ?>
		
		<?php if(isset($search_terms) && $total_records != 0): ?>
		<p class="messageboxok">Search result on: <?php echo $search_terms; ?></p>
	
	    <?php endif; ?>
	    
	    	<table class="table">
           		<thead>
           			<tr>
           				<th width="5%"class="sorting">View</th>
           				<th width="10%"class="sorting displayNone"><i class=""></i>Date</th>    
           				<th width="20%" class="sorting invoice_client_width"><i class=""></i>Client &amp; Purpose</th>
           				<th width="17%" class="sorting"><i class=""></i>Amount</th>   
           				<th width="3%" class="sorting">PDF</th>        				 
           				<th width="6%" class="displayNone">Email</th>
           				<?php if($request_type == 'invoice'): ?>
				        <th width="5%" class="sorting">Status</th>				       
				        <?php endif; ?>
           			</tr>
           		</thead>
           		 
			    <tbody>
				<?php $row = 2;  foreach($invoices as $invoice): ?>
				<?php if ($row % 2) {$colour = "light_g1";}else{$colour = "light_g2"; }; $row += 1; ?>
				<tr class="<?php echo $colour; ?>">
				<td> <?php if($request_type == 'invoice'){$tenant_type_id = $invoice->tenant_invoice_id; }else{$tenant_type_id = $invoice->tenant_quote_id; } ?><a class="invoice_number" href="{{ URL::to($request_type.'s/'.$tenant_type_id) }}">{{ $preferences->invoice_prefix != "" ? $preferences->invoice_prefix : "" }}
						<?php if($request_type == 'invoice'){echo IntegrityInvoice\Utilities\AppHelper::invoiceId($invoice->tenant_invoice_id); }elseif($request_type == 'quote'){ echo IntegrityInvoice\Utilities\AppHelper::quoteId($invoice->tenant_quote_id); } ?></a>
                </td>
				<td class="displayNone"><?php echo IntegrityInvoice\Utilities\AppHelper::date_to_text($invoice->created_at, $preferences->date_format); ?>
                    @if($invoice->recurring == 1)
                    <br /><small><i class="fa fa-repeat"></i> Recurring</small>
                    @endif
                </td>
				<td><a class="invoice_client_company" href="{{ URL::route('edit_client', $invoice->client_id) }}">{{ $invoice->client->company }}</a> <br /><span class="invoice_subject"><?php echo $invoice->subject; ?></span></td>
		 
				<td><?php echo IntegrityInvoice\Utilities\AppHelper::dumCurrencyCode($invoice->currency_code).number_format($invoice->balance_due, 2, '.', ','); ?></td>
				<td class="centerTd"><a title="Download PDF" href="{{ URL::to($request_type.'s/'.$tenant_type_id.'/download') }}"><i class="fa fa-file-pdf-o "></a></td>
				<td class="displayNone centerTd">
					<?php if($invoice->status == 1): ?>
						<i class="status_info makePass status-bar done-status" title="Invoice sent">Sent</i>					 
					<?php else: ?>
						<a title="Not sent" href="{{ URL::to($request_type.'s/'.$tenant_type_id.'/send') }}"><i class="status_info status-bar not-sent-status" title="Not sent - click to send now">Not sent</i></a>
					<?php endif; ?>
				</td>
				<?php if($request_type == 'invoice'): ?>
				<td class="forpayment centerTd">
					<?php if($invoice->payment == 2): ?>
						<i class="status_info makePass status-bar done-status">Paid</i>
					<?php elseif($invoice->payment == 1): ?>
						<a class="markaspaid_popup_open" title="Mark as paid" href="{{ URL::to('payments/'.$invoice->tenant_invoice_id.'/paid') }}" tinvId="{{ $invoice->tenant_invoice_id }}">					 
							<i class="status_info status-bar" title="Click to mark as paid">Part paid</i>	
							</a>
					<?php elseif($invoice->payment == 0 ): ?>
						<a class="markaspaid_popup_open" title="Mark as paid" href="{{ URL::to('payments/'.$invoice->tenant_invoice_id.'/paid') }}" tinvId="{{ $invoice->tenant_invoice_id }}"><i class="status_info status-bar" title="Not paid - click to mark as paid">Not paid</i></a>
					<?php endif; ?>					 
				</td>
				 
				<?php endif; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
      
      </table>
  
	
	<div class="simple_search">
		{{ Form::open(array('url' => $request_type.'s', 'method' => 'GET')) }}
		<input type="text" class="search_term" name="q" value="search..." />
		<input type="submit" class="search_submit" value="Go" />
		<!-- <p class="tinytext">Invoice ID, Client name or item name.</p> -->
		{{ Form::close() }}
		
	</div><!-- END search -->
	 
	 <?php else: ?>
	 	
	 	<?php if(isset($searchquery) && is_null($searchquery) || $searchquery == ""): ?>
	 		
	    <?php if($total_records >= 1):  ?>
		  <!-- NO Items yet -->
	     <div class="no_item">
	 	  <div class="msg">
	 		<h4>You haven't created any {{$request_type}}s yet</h4>
	    	<p>To start creating {{ $request_type}}s right away, click the button below. You’ll be surprised how quick and easy it can be to generate an {{ $request_type }}, track and manage it.</p>
	    	 
	    </div>    
	    </div><!-- End no item -->
	    
	    <?php endif; ?>
	    
	    <?php else: ?> 
	    	<p>No records found in the search result.</p>
	    	<a class="btn" href="{{ URL::previous() }}">Back</a>
	    <?php endif; ?> 
	 
	 <?php endif; ?> 
  

	{{ $invoices->links() }}
  
  <?php if($total_records >= 1):  ?>
    <!-- Add content to the popup -->
    @if($request_type == "invoice")
    <div id="markaspaid_popup" class="page_popup well">
		<h2>Mark as paid</h2> <br />
		
		{{ Form::open(array('url' => 'payments/'.$invoice->tenant_invoice_id.'/store', 'method' => 'POST')) }}
		
				<label>Date of payment<span></span></label>
	            <input type="text" name="date" class="txt issuedate" id="issuedate" autocomplete="off" />
	            
	 			<label>Payment method</label>
	            <select id='payment_method' name='payment_method' class="sel">
					<option value="" selected="selected">Select</option>
				    <option value="Bank transfer">Bank Transfer</option>
		            <option value="Cheque">Cheque</option>
		            <option value="Cash">Cash</option>
		            <option value="Online">Online</option>
			    </select>
			    
	      		<div class="cheque_section"> 
				 <label>Cheque number</label>
		            <input type="text" name="cheque_number" class="txt" id="cheque_number" value="{{ Input::old('cheque_number') }}" autocomplete="off" />
		        </div> 
		        
		        <div class="bank_transfer_section"> 
				 <label>Bank Transfer Reference</label>
		            <input type="text" name="bank_transfer_ref" class="txt" id="bank_transfer_ref" value="{{ Input::old('bank_transfer_ref') }}" autocomplete="off" />
		        </div> 
		        <br />
		        <button class="markaspaid_popup_close btn btn-default cancelBtn">Cancel</button>
		        <input type="submit" id="record_payment" class="gen_btn" name="record_payment" value="Record payment" />
			    
		 {{ Form::close() }}
   		 
   		 
   </div> <!-- END markaspaid_popup -->
   @endif
  
  <?php endif; ?>
		
  @stop
	
	
	@section('footer')
 
	<script src="{{ URL::asset('assets/js/jquery.datetimepicker.js') }}"></script>			 
	<script src="{{ URL::asset('assets/js/jquery.popupoverlay.js') }}"></script>
	 
	<script>
   		 $(document).ready(function() {
   		 	
	 		if($('#appmenu').length > 0){
  				// Check if ULR Contain invoice
  				if(window.location.href.indexOf("invoice") > -1){
  					
  					$('.manage_all_menu').addClass('selected_group'); 		 
			  		$('.menu_all_invoices').addClass('selected');		  		
			  		$('.manage_all_menu ul').css({'display': 'block'});
  					 
			  		
  				}else if(window.location.href.indexOf("quote") > -1){
  					
  					$('.manage_all_menu').addClass('selected_group'); 		 
			  		$('.menu_all_quotes').addClass('selected');		  		
			  		$('.manage_all_menu ul').css({'display': 'block'});
			   		
  				}				   
		     }

   		      $('#issuedate').datetimepicker({			 
					lang:'en',
					timepicker:false,
					format:'d/m/Y',
					formatDate:'Y/m/d',
					closeOnDateSelect:true
					  
				});
   		 	
   			
   			$.fn.popup.defaults.pagecontainer = '.page-panel';
   			 
   			// Initialize the plugin
  			$('#markaspaid_popup').popup({
  				opacity: 0.8,
  				vertical: 'top',
  				transition: 'all 0.3s',			    
			    outline: true, // optional
    			focusdelay: 300, // optional
    			onopen: function(e) {
				   
				}
			});
			
			
			  $('input[name=business_model]').on('change', function() {
					
				   if($(this).val() == 1){
				   		
				   		$('#bill_option2').fadeIn();
				   		
				   }else{
				   	
				   		$('#bill_option2').fadeOut();
				   }
				 
				});
			
			 
				$('.cheque_section').hide();
				$('.bank_transfer_section').hide();
				
				$('#payment_method').on('change', function() {
					
				   if($(this).val() == "Cheque"){
				   		
				   		$('.cheque_section').fadeIn();
				   		
				   }else{
				   	
				   		$('.cheque_section').fadeOut();
				   }
				   
				   
				   if($(this).val() == "Bank transfer"){
				   		
				   		$('.bank_transfer_section').fadeIn();
				   		
				   }else{
				   	
				   		$('.bank_transfer_section').fadeOut();
				   }
				   
				});
				
				
				// Get the clicked item
				var $target_clicked;
				$('.forpayment').on('click', function(e) {
			       var target = $(e.target);			     
			        // if(target.is('.markaspaid_popup_open')) { // }
			        $target_clicked = $(target).parent();			         		  
				 });
			 
				
				$('#record_payment').on('click', function(){	
				 
					if($.trim($('#issuedate').val()) == ""){						
						alert('Enter the date of payment');						
						return false;
					}
				 
					
					if($.trim($('#payment_method').val()) == ""){						
						alert('Select the payment method');						
						return false;
					}
					
					
					  $tenant_invoice_id = $target_clicked.attr('tinvId');
					  $issuedate = $('#issuedate').val();
					  $payment_method = $('#payment_method').val();
					  $cheque_number = $('#cheque_number').val();
					  $bank_transfer_ref = $('#bank_transfer_ref').val();
			  
				 	   var $data = "date="+$issuedate+"&payment_method="+$payment_method+"&cheque_number="+$cheque_number+"&bank_transfer_ref="+$bank_transfer_ref;
				 	   var jqxhr = $.ajax({ url: "../payments/" + $tenant_invoice_id + "/paid",
										 type: "POST",	
										 data: $data
						}).success(function($response) {
					 
						    alert("Invoice successfully marked as paid");
								
						})
						.error(function() { alert("error"); })
						.complete(function() {						 								
						    $(".markaspaid_popup_close").trigger("click");
						    window.location.reload(true);
			
					     });
			 	 
			 		return false;
			 	 
				});
				
		 
		});
 
    </script>
 
   @stop
