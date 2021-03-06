@extends('layouts.public_invoice')

	@section('content')
	
	<?php
	
	use IntegrityInvoice\Utilities\AppHelper as AppHelper;
	// Get preferences
	// We have passed in $preferences from the controller
	// We have passed in $invoice from controller
	// We have passed in $company from controller
	// We have passed in $client from the controller

	$lineitems = explode("|", $invoice->items);
 
	$line_item_total = count($lineitems);
	$items = array();
	
	for($i=0; $i < $line_item_total; $i++){
		
	 //${'item_' . $i}[] = explode(',',$lineitems[$i]);
	 $items[] = explode(',',$lineitems[$i]);
	 // remove empty value
	 ($items[$i][0] == ' ') ? array_shift($items[$i]) : "";
	  (count($items[$i]) == 1) ? array_pop($items) : "";
	
		
	}
	//echo $item_0[0][0];
	//echo $items[1];
	
	// replacement for comma
	 $find ="/__/"; 
 	 $replace =","; 
	 
	 
	 // Currency
	 $cur = $invoice->cur;
	 
	 $template_id = $preferences->invoice_template;
	 $l_id = $invoice->tenant_invoice_id;
	  
	 $enable_discount = true;
	 $enable_tax = true;
	  
	  if($invoice->enable_discount == 0) { $enable_discount = false; }else{ $enable_discount = true;}
      if($invoice->enable_tax == 0) { $enable_tax = false; }else{ $enable_tax = true;}
	  
	  // Default with discount and no tax
	  $colspan1 = $invoice->business_model == 0 ? 1 : 3;
	  $colspan2 = $invoice->business_model == 0 ? 4 : 5;
 
	  
	  // Only Discount enabled
	  if($enable_discount == true && $enable_tax == false)
	  {
		  $colspan1 = $invoice->business_model == 0 || ($invoice->business_model == 1 && $invoice->bill_option == 0 ) ? 1 : 3;
		  $colspan2 = $invoice->business_model == 0 || ($invoice->business_model == 1 && $invoice->bill_option == 0 ) ? 3 : 1;
		  
		  if($invoice->business_model == 1 && $invoice->bill_option == 1){
		  	 $colspan1 = 2;
			 $colspan2 = 1;
		  }	
		  
	  }
	  
	  // Only Tax enabled
	  if($enable_discount  == false && $enable_tax  == true)
	  {
		  $colspan1 = $invoice->business_model == 0 || ($invoice->business_model == 1 && $invoice->bill_option == 0 ) ? 1 : 3;
		  $colspan2 = $invoice->business_model == 0 || ($invoice->business_model == 1 && $invoice->bill_option == 0 ) ? 3 : 1;	
		  
		  if($invoice->business_model == 1 && $invoice->bill_option == 1){
		  	 $colspan1 = 2;
			 $colspan2 = 1;
		  }	   
	  }
	  
	   // Discount and tax enabled
	  if($enable_discount  == true && $enable_tax  == true)
	  {
		  $colspan1 = $invoice->business_model == 0 || ($invoice->business_model == 1 && $invoice->bill_option == 0 ) ? 1 : 2;
		  $colspan2 = $invoice->business_model == 0 || ($invoice->business_model == 1 && $invoice->bill_option == 0 ) ? 4 : 3;
		  
		  if($invoice->business_model == 1 && $invoice->bill_option == 1){
		  	 $colspan1 = 3;
			 $colspan2 = 1;
		  }	
		 
	  }
	  
	  // Discount and tax disabled
	  if($enable_discount  == false && $enable_tax  == false)
	  {
		  $colspan1 = $invoice->business_model == 0 || ($invoice->business_model == 1 && $invoice->bill_option == 0 ) ? 2 : 2;
		  $colspan2 = $invoice->business_model == 0 || ($invoice->business_model == 1 && $invoice->bill_option == 0 ) ? 1 : 0;
		  
		  if($invoice->business_model == 1 && $invoice->bill_option == 1){
		  	 $colspan1 = 1;
			 $colspan2 = 1;
		  }
		   
	  }
	 
	?>
 
 	 
<div id="invoicecontainer">
	
	<div class="download_invoice">
		 
		<p class="last_updated">Last updated on<span>{{ $invoice->updated_at->toDayDateTimeString() }}</span></p>
		@if($invoice->payment < 2)		
			@if($stripe_gateway->stripe_publishable_key != NULL && $stripe_gateway->stripe_publishable_key != "" && $stripe_gateway->stripe_secret_key != NULL && $stripe_gateway->stripe_secret_key != "")
			<button id="card_pay" class="yellow_btn paybycard_popup_open" name="card_pay" />Pay by card</button>
			@endif
			@if($stripe_gateway->paypal_email != NULL && $stripe_gateway->paypal_email != "")
		    <button id="card_pay" class="yellow_btn paybypaypal_popup_open" name="card_pay" />Pay by PayPal</button>
		    @endif
	    @endif
	     
	</div><!-- download_invoice -->
	 
  
 	   <div class="headwrap">
  	
		 <div class="pdf_logo_with_margin">
		 	
		 	<?php      
		     function addhttp($url) {
			    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
			        $url = "http://" . $url;
				    }
				    return $url;
			 }
	       
		    $tenantID = $invoice->tenantID; $ext = '.png'; $logo_file =  public_path(). '/te_da/'.$tenantID . '/'.$tenantID.$ext; ?>
				 
			@if (file_exists($logo_file))	
			
				@if($company->website != "" &&  $company->website != null)				 
				<a href="{{ addhttp($company->website) }}" target="_blank"><img class="gen_logo_size" src="{{ Config::get('app.app_main_domain').'/te_da/'.$invoice->tenantID.'/'.$invoice->tenantID.'.png' }}" alt="" /></a>
				@else
				<img class="gen_logo_size" src="{{ Config::get('app.app_main_domain').'/te_da/'.$invoice->tenantID.'/'.$invoice->tenantID.'.png' }}" alt="" />
				@endif
			 
			@endif	
	 	</div><!-- END -->
		 
		<div id="identity" class="company_info">	
			
			<input type="hidden" name="date_format" class="date_format" value="<?php echo $preferences->date_format; ?>" />	
	        <div class="cw" id="address"><p><strong class="cname"><?php echo $company->company_name; ?></strong><br /><?php echo $company->add_1; ?><?php
			if($company->add_2 == ""){
				echo "";
			}else if($company->add_2 == $company->state){
				echo "";
			}else{ echo ", ".$company->add_2 . ", ";} ?> <?php echo $company->state; ?><?php echo "  ".$company->postal_code; ?> 
			<?php echo "<br /> Tel. ". $company->phone; ?></p></div>
	      
		</div> <!-- END identity -->
	
	</div><!-- END headwrap -->
	
	<div class="invoiceTop">
		
		 <h1> Invoice {{ $preferences->invoice_prefix != "" ? $preferences->invoice_prefix : "" }}<span><?php echo AppHelper::invoiceId($l_id); ?></span></h1>
		
		<div class="invoiceTopLeft">
		
	 	<div id="customer" class="invoice_customer">
	 		<h2 id="customer-title_show">To: <?php echo $client->company; ?></h2><p><?php echo $client->add_1 != "" ? $client->add_1 . ", <br />": ""; ?>
            <?php echo $client->add_2 != "" ? $client->add_2 . "<br />": ""; ?>
            <?php echo $client->state != "" ? $client->state . ", ": ""; ?>
            <?php echo $client->postal != "" ? $client->postal . "<br />": ""; ?>
            <?php echo $client->country != "" ? $client->country . "<br />": ""; ?>
            <?php echo $client->email != "" ? $client->email . "<br />": ""; ?>
            <?php echo $client->phone != "" ? $client->phone . "<br />": ""; ?></p>			 
		</div> <!-- END customer -->	 
	
       </div> <!-- END invoiceTopLeft --> 
       
       
       @if($invoice->payment == 1)
       <div class="paidstamp">
       		<img src="{{ Config::get('app.app_domain').'/assets/img/stamp/part_paid1.png' }}">
       		<br /><h4 class="partpaid_amount"><?php echo AppHelper::dumCurrencyCode($invoice->currency_code). number_format($part_paid_amount, 2, '.', ','); ?> received.</h4>
       		<h5 class="stilltopay_amount">Outstanding: <?php echo AppHelper::dumCurrencyCode($invoice->currency_code). number_format($invoice->balance_due - $part_paid_amount, 2, '.', ','); ?></h5>
       </div><!-- END paidstamp -->
       @endif
       
       @if($invoice->payment == 2)
       <div class="paidstamp">
       		<img src="{{ Config::get('app.app_domain').'/assets/img/stamp/paid1.png' }}">
       </div><!-- END paidstamp -->
       @endif
       
        
        <div class="invoiceTopRight" id="invnum">
        	<table id="meta">
                <tr>
                    <td class="meta-head">Invoice ID</td>
                    <td><div class="cw inv_num">{{ $preferences->invoice_prefix != "" ? $preferences->invoice_prefix : "" }}<?php echo AppHelper::invoiceId($l_id); ?></div></td>
                </tr>
                <tr>
                    <td class="meta-head">Issue Date</td>
                    <td><div><?php $inv_date = $invoice->created_at;
					 echo AppHelper::date_to_text($inv_date, $preferences->date_format);?></div>
					 </td>
                </tr>
                <tr>
                    <td class="meta-head">Amount Due</td>
                    <td><div><?php echo AppHelper::dumCurrencyCode($invoice->currency_code). number_format($invoice->balance_due, 2, '.', ','); ?></div></td>
                </tr>
                <tr>
                    <td class="meta-head">Due Date</td>
                    <td><div><?php $inv_date = $invoice->due_date;
					 echo AppHelper::date_to_text($inv_date, $preferences->date_format);?></div></td>
                </tr>
            </table>
            
		</div> <!-- END invnum -->
 
 </div><!-- End Invoice Top -->
 
 <div class="">
		<table id="items">
		
		  <tr>
		      @if($invoice->business_model == 0)
		      <th width="30%" class="th_first alignLeft">Product</th>
		      @elseif($invoice->business_model == 1)
		      <th width="30%" class="th_first alignLeft">Service</th>
		      @endif
		      
		      @if($invoice->business_model == 1 && $invoice->bill_option == 0)		      
		      <th width="10%" class="">Rate</th>
		      @else
		      <th width="10%" class="">Cost</th>
		      @endif
		      
		      @if($invoice->business_model == 0)
		      <th width="5%">Qty</th>
		      @elseif($invoice->business_model == 1 && $invoice->bill_option == 0)
		      <th width="5%">Hour(s)</th>
		      @endif
		      
		      @if($invoice->enable_discount)
		      <th width="10%">Discount</th>
		      @endif
		      
		      @if($invoice->enable_tax)
		      <th width="6%">Tax</th>		      
		      @endif	  
		      	      
		      <th width="10%">Line Total</th>
		  </tr>          
           
          <?php $row = 2; foreach($items as $item): ?>
          	<?php if ($row % 2) {$colour = "light_g1";}else{$colour = "light_g2"; }; $row += 1; ?>
		  <tr class="item-row <?php echo $colour; ?>">
		       
		      <td class="description desc_pdf"><?php echo preg_replace($find, $replace, $item[1]); ?></td>
		      <td class=""><?php echo AppHelper::dumCurrencyCode($invoice->currency_code); ?><?php echo number_format($item[2], 2, '.', ','); ?> </td>
		      
		      @if($invoice->business_model == 0)
		      <td><?php echo $item[3] ?></td>
		      @elseif($invoice->business_model == 1 && $invoice->bill_option == 0)
		      <td><?php echo $item[3] ?></td>
		      @endif
		      
		      @if($invoice->enable_discount)
		      <td><?php echo AppHelper::get_discount_type($item[6], $item[7], $item[2], $item[3]); ?></td>
		      @endif
		      @if($invoice->enable_tax)
		      <td><?php echo AppHelper::get_tax_type(trim($item[4]),$preferences->tax_perc1, $preferences->tax_perc2); ?></td>  
		      @endif 
			  <td><span class="cur_symbol"><?php echo AppHelper::dumCurrencyCode($invoice->currency_code); ?></span><span class="price"><?php echo $item[8]; ?></span></td>
		  </tr>
           <?php endforeach; ?>
 
		 <tr>
		      <td colspan="{{ $colspan1 }}" class="blank "><h5 class="invoice_note_title">Note / Payment Terms</h5><div class="fornote"><textarea style="height:100%; width:98%;" class="cwl notetext"><?php echo $invoice->note; ?></textarea></div>
		      	@if($invoice->bankinfo == 1)
		      		<h5 class="invoice_note_title">Payment information</h5>
		      		 <p class="bank_payment_info">{{ nl2br($preferences->payment_details) }}</p>
		      	@endif
		      </td>
		      <td colspan="{{ $colspan2 }}" class="total-line"><strong>Sub Total</strong></td>
		      <td class="total-value"><div><span class="cur_symbol"><?php echo AppHelper::dumCurrencyCode($invoice->currency_code); ?></span><span class="c_subtotal" id="subtotal"><?php echo number_format($invoice->subtotal, 2, '.', ','); ?></span></div></td>
		  </tr>
		  
		  @if($invoice->enable_discount == 1)
           <tr id="mydiscount">
		      <td colspan="{{ $colspan1 }}" class="blank"> </td>
		      <td colspan="{{ $colspan2 }}" class="vat-line"><strong>Discount </strong></td>
		      <td class="vat-value"><div><span class="cur_symbol"><?php echo AppHelper::dumCurrencyCode($invoice->currency_code); ?></span><span id="discount" class="c_discount"><?php echo  number_format($invoice->discount_val, 2, '.', ','); ?></span></div></td>
		  </tr>
		  @endif
		  
		  @if($invoice->enable_tax == 1)
          <tr id="mytax">
		      <td colspan="{{ $colspan1 }}" class="blank"> </td>
		      <td colspan="{{ $colspan2 }}" class="vat-line"><strong>Tax </strong></td>
		      <td class="vat-value"><div><span class="cur_symbol"><?php echo AppHelper::dumCurrencyCode($invoice->currency_code); ?></span><span id="vat" class="c_vat"><?php echo number_format($invoice->tax_val, 2, '.', ','); ?></span></div></td>
		  </tr>		  
		  @endif	 
		   
		  <tr>
		      <td colspan="{{ $colspan1 }}" class="blank"> </td>
		      <td colspan="{{ $colspan2 }}" class="total-line balance">Total</td>
		      <td class="total-value balance"><div><span class="cur_symbol"><?php echo AppHelper::dumCurrencyCode($invoice->currency_code); ?></span><span class="due"><?php echo number_format($invoice->balance_due, 2, '.', ','); ?></span></div></td>
		  </tr>
		  
		
		</table>
	</div>
	<div id="foot">		
	  <h2><?php echo $preferences->footnote1 != "" ? $preferences->footnote1 : ""; ?></h2>
	   <p><?php echo $preferences->footnote2 != "" ? $preferences->footnote2 : ""; ?></p>
	</div> 
	
	<div class="">
		{{ Form::open(array('url' => 'public_download/'.$invoice->tenantID.'/'.$invoice->tenant_invoice_id, 'method' => 'POST')) }}			
			<input type="submit" id="download_pdf" class="yellow_btn" name="download_pdf" value="Download PDF" />
		{{ Form::close() }}	
		
		<?php if($invoice->file != NULL && $invoice->file != ""): ?>
		 <strong>File attachment: </strong><a class="ordinary_link" href="{{ URL::to('public_invoices/'.$invoice->tenantID.'/'.$invoice->tenant_invoice_id.'/download_file/') }}">{{ AppHelper::decrypt($invoice->file, $invoice->tenantID) }}</a> 		
		<?php endif; ?>
		
	</div><!-- END Download -->
	
	<?php $amount_to_pay = 0; ?>
	
	@if($invoice->payment != 2 && $tenant_paypal_email != "")
	 
		<?php 
			 
		    if($invoice->payment == 1){
			 		(int)$amount_to_pay = $invoice->balance_due - $part_paid_amount; 
			   }else if($invoice->payment == 0){
					(int)$amount_to_pay = $invoice->balance_due;
			  }
		?>
   
 	@endif
  
</div>

<div id="paybycard_popup" class="page_popup well">
 	 
	   {{ Form::open(array('id' => 'billingform', 'url' => 'secure/process_card/'.$invoice->tenantID.'/'.$invoice->tenant_invoice_id, 'method' => 'POST')) }}
		 
	    <div class="paywithcard">
	    	
	    	 <h1>Secure payment</h1>
	    	 
	    	 <div class="credit_card"><img src=" {{ URL::asset('assets/img/icon_store_creditcards.png') }}" alt="" /></div>
	    	 <div class="payment-errors"></div>
	    	
	    	 <?php echo Symfony\Component\Intl\Intl::getCurrencyBundle()->getCurrencySymbol($invoice->currency_code); ?>
	    	 <input class="txt_price" id="token_mount" type="text" name="token_mount" value="<?php echo $amount_to_pay; ?>">
	    	 
	    	<div class="paymentform_wrap">
	    		<label>Card Number: <span>The 16 digits on the front of your card.</span></label>
	    		<input class="txt" type="text" data-stripe="number">
	    	</div><!-- END paymentform_wrap -->
	    	
	    	<div class="paymentform_wrap">
	    		<label>CVC: <span>The last 3 digits displayed on the back of your card.</span></label>
	    		<input class="txt" type="text" data-stripe="cvc">
	    	</div><!-- END paymentform_wrap -->
	    	
	    	<div class="paymentform_wrap">
	    	 <label>Expiry date: <span></span></label>
	    	 {{ Form::selectMonth(null, null, ['data-stripe' => 'exp-month', 'class' => 'sel']) }}
	    	 {{ Form::selectYear(null, date('Y'), date('Y') + 10, null, ['data-stripe' => 'exp-year', 'class' => 'sel']) }}
	    	</div><!-- END paymentform_wrap -->
	    	 
	    	 <input type="hidden" id="publishable_key" value="<?php 
	    	 if($stripe_gateway->stripe_publishable_key != "" &&  $stripe_gateway->stripe_publishable_key != NULL):
	    	 
	    	 ?>{{ AppHelper::decrypt($stripe_gateway->stripe_publishable_key, $invoice->tenantID) }}<?php
	    	 
				endif;

	    	 ?>">	    	 
	    	 <input type="hidden" id="email" name="email" value="{{ $client->email }}">	
	    	 <input type="hidden" id="client_id" name="client_id" value="{{ $client->id }}">
	    	 <input type="hidden" id="client_company" name="client_company" value="{{ $client->company }}">	    	 	    	     	 
	    	 <input type="hidden" id="tenantID" name="tenantID" value="{{ $invoice->tenantID }}">
	    	 <input type="hidden" id="tenant_invoice_id" name="tenant_invoice_id" value="{{ $invoice->tenant_invoice_id }}">
	    	 <input type="hidden" id="currency_code" name="currency_code" value="{{ $invoice->currency_code }}">
	    	 <input type="hidden" id="receiver_email" name="receiver_email" value="{{ $company->email }}">
	    	 <input type="hidden" id="company_name" name="company_name" value="{{ $company->company_name }}">
	    	
	    	 <input type="submit" value="Pay Now" class="yellow_btn2">	    	 
	    	 <div class="secure_message"><img src="/assets/img/safe_secure.png" alt="" /></div>
	   
	    </div><!-- END paywithcard -->
	    
	   {{ Form::close() }}
 
   </div> <!-- END paybycard_popup -->
   
   
   
   
   <div id="paybypaypal_popup" class="page_popup well">
   	
   	<div class="paywithcard">
   		
   			<h1>Secure payment</h1>
   			<div class="credit_card"><img src="/assets/img/icon_store_paypal.png" alt="" /></div>
   	
   		   {{ Form::open(array('url' => 'client_payment/paypal', 'method' => 'POST')) }}
   				
   			<div class="paymentform_wrap">
   				<label>Amount:</label>
			  
			     <input type="hidden" name="item_name" value="Invoice <?php echo AppHelper::invoiceId($l_id); ?> - <?php echo $company->company_name ?>">
			     <input type="hidden" name="item_number" value="<?php echo AppHelper::invoiceId($l_id); ?>">
			     <?php echo Symfony\Component\Intl\Intl::getCurrencyBundle()->getCurrencySymbol($invoice->currency_code); ?>			     
			     <input class="txt_price" type="text" name="amount" value="<?php echo $amount_to_pay; ?>">			      
			     <input type="hidden" id="receiver_email" name="receiver_email" value="{{ $paypal_gateway->paypal_email }}">			    
			     <input type="hidden" id="email" name="email" value="{{ $client->email }}">	
		    	 <input type="hidden" id="client_id" name="client_id" value="{{ $client->id }}">
		    	 <input type="hidden" id="client_company" name="client_company" value="{{ $client->company }}">	    	 	    	     	 
		    	 <input type="hidden" id="tenantID" name="tenantID" value="{{ $invoice->tenantID }}">
		    	 <input type="hidden" id="tenant_invoice_id" name="tenant_invoice_id" value="{{ $invoice->tenant_invoice_id }}">
		    	 <input type="hidden" id="currency_code" name="currency_code" value="{{ $invoice->currency_code }}">		    	
		    	 <input type="hidden" id="company_name" name="company_name" value="{{ $company->company_name }}">		    
			    
			  </div><!-- END paymentform_wrap -->
			  
			  <input type="image" src="/assets/img/paypal_btn.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
			    <br /><br /> 
			 {{ Form::close() }}
			
			<div class="secure_message"><img src="/assets/img/safe_secure.png" alt="" /></div>
 	 
 	      </div><!-- END paywithcard -->
 	  
 
   </div> <!-- END paybypaypal_popup -->
 
@stop


@section('footer')
 		 
	<script src="{{ URL::asset('assets/js/jquery.popupoverlay.js') }}"></script>
	 <script src="https://js.stripe.com/v2/"></script>
	 <script src="{{ URL::asset('assets/js/client_billing.js') }}"></script>
	 
	<script>
	
   		 $(document).ready(function() {  
   		 	 
   			$.fn.popup.defaults.pagecontainer = '.page-panel';
   			 
   			// Initialize the plugin
  			$('#paybycard_popup').popup({
  				opacity: 0.8,
  				vertical: 'top',
  				transition: 'all 0.3s',			    
			    outline: true, // optional
    			focusdelay: 300, // optional
    			onopen: function(e) {
				   
				}
			});
			
			
			// Initialize the plugin
  			$('#paybypaypal_popup').popup({
  				opacity: 0.8,
  				vertical: 'top',
  				transition: 'all 0.3s',			    
			    outline: true, // optional
    			focusdelay: 300, // optional
    			onopen: function(e) {
				   
				}
			});
			
	 
		 
		});
 
    </script>
 
   @stop