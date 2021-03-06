@extends('layouts.sendmail')

	@section('email_title')
	 
	@stop

	@section('content')
	  
	<p>Hi, Thank you for signing up for sighted. <p/>
	 
	<p>Confirming your account will give you full access to the Sighted Invoice application. <br /> Please click <a href='{{ $activationUrl }}'>here</a> to confirm.</p>
	
	<p>If you run into any problems using our service we'd be glad to help. Please send an email to support@sighted.com and a member of our customer support staff will respond.</p>
	 
    <p>Happy Invoicing, <br /><strong>Murray Newlands</strong> <br /> Founder | CEO<br />Sighted</p>
 
	@stop