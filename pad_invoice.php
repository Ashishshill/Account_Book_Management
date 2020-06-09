<?php include 'init/header.php';

?>


<!-- <div class="daa_employ">
 <div class="container"> 
  	 <form method="post">
		    <div class="form-group">
		      <label for="name">Customer Full Name:</label>
		      <input type="text" class="form-control" id="name" placeholder="Enter Full Name" name="name">
		    </div>
		    <div class="form-group">
		      <label for="number">Invoice Date:</label>
		      <input type="text" class="form-control" id="nid" placeholder="Invoice Date:" name="number">
		    </div>
		    <div class="form-group">
		      <label for="email">Due Date:</label>
		      <input type="email" class="form-control" id="email" placeholder="Due Date:" name="email">
		    </div>
		    <div class="form-group">
		      <label for="website">Invoice Number:</label>
		      <input type="text" class="form-control" id="website" placeholder="Invoice Number:" name="website">
		    </div>
		    <div class="form-group">
		      <label for="address">Product Name:</label>
		      <input type="text" class="form-control" id="address" placeholder="Product Name:" name="address">
		    </div>
		    <div class="form-group">
		      <label for="shop">Unit Cost:</label>
		      <input type="text" class="form-control" id="shop" placeholder="Unit Cost:" name="shop">
		    </div>

            <div class="form-group">
              <label for="shop">Quantity:</label>
              <input type="text" class="form-control" id="shop" placeholder="Quantity:" name="shop">
            </div>
            <div class="form-group">
              <label for="shop">Unit Price:</label>
              <input type="text" class="form-control" id="shop" placeholder="Unit Price:" name="shop">
            </div>
            <div class="form-group">
              <label for="shop">Note:</label>
              <input type="text" class="form-control" id="shop" placeholder="Enter Note:" name="shop">
            </div>
		    <input type="hidden" name="token" value="<?php echo Token::generate();
    ?>" />
     		<button type="submit" class="btn btn-success">Add Customer</button>
     </form>
 </div>
</div>  --> 

<div id="page-content-wrapper">
        <div class="container-fluid">

              <div class="alert alert-warning" style="display:none" id="keepAliveDiv">
                 This page will expire soon, <a href="#" onclick="keepAlive()">click here</a> to keep working
              </div>

            <!-- <script type="text/javascript">
        var redirectTimer = null;
        function startWarnSessionTimeout() {
            var oneMinute = 1000 * 60;
            var threeMinutes = oneMinute * 3;
            var waitTime = oneMinute * 60 * 4; // 4 hours

            setTimeout(function() {
                warnSessionExpring();
            }, (waitTime - threeMinutes));
        }

        function warnSessionExpring() {
            $("#keepAliveDiv").fadeIn();
            redirectTimer = setTimeout(function() {
                NINJA.formIsChanged = false;
                window.location = 'https://app.invoiceninja.com/dashboard';
            }, 1000 * 60);
        }

        // keep the token cookie valid to prevent token mismatch errors
        function keepAlive() {
            clearTimeout(redirectTimer);
            $('#keepAliveDiv').fadeOut();
            $.get('https://app.invoiceninja.com/keep_alive');
            startWarnSessionTimeout();
        }

        $(function() {
            if ($('form.warn-on-exit, form.form-signin').length > 0) {
                startWarnSessionTimeout();
            }
        });
            </script> -->

          
          
          
              <div class="pull-right">
              </div>

             <ol class="breadcrumb">
                <li><a href="https://app.invoiceninja.com/invoices">Invoices</a></li>
                <li class='active'>Create</li>
             </ol>
              
              <form accept-charset="utf-8" class="form-horizontal warn-on-exit main-form search" autocomplete="off" onsubmit="return onFormSubmit(event)" name="lastpass-disable-search" method="POST" action="https://app.invoiceninja.com/invoices">

            <!-- http://stackoverflow.com/a/30873633/497368 -->
            <div style="display: none;">
                <input type="text" id="PreventChromeAutocomplete" name="PreventChromeAutocomplete" autocomplete="address-level4" />
            </div>

        	<input type="submit" style="display:none" name="submitButton" id="submitButton">

            	<div data-bind="with: invoice">
                <div class="panel panel-default">
                <div class="panel-body">

                <div class="row" style="min-height:195px" onkeypress="formEnterClick(event)">
            	<div class="col-md-4" id="col_1">

            		
                    <div class="form-group client_select closer-row required"><label for="client" class="control-label col-lg-4 col-sm-4">Client</label><div class="col-lg-8 col-sm-8"><select required class="form-control client-input" data-bind="dropdown: client, dropdownOptions: {highlighter: comboboxHighlighter}" id="client" name="client"><option value=""></option></select></div></div>

        			<div class="form-group" style="margin-bottom: 8px">
        				<div class="col-lg-8 col-sm-8 col-lg-offset-4 col-sm-offset-4">
        										<a id="createClientLink" class="pointer" data-bind="click: $root.showClientForm, html: $root.clientLinkText"></a>
        					                    <span data-bind="visible: $root.invoice().client().public_id() > 0" style="display:none">|
                                <a data-bind="attr: {href: 'https://app.invoiceninja.com/clients/' + $root.invoice().client().public_id()}" target="_blank">View Client</a>
                            </span>
        				</div>
        			</div>

        			
        			<div data-bind="with: client" class="invoice-contact">
        				<div style="display:none" class="form-group" data-bind="visible: contacts().length > 0, foreach: contacts">
        					<div class="col-lg-8 col-lg-offset-4 col-sm-offset-4">
        						<label class="checkbox" data-bind="attr: {for: $index() + '_check'}, visible: email.display" onclick="refreshPDF(true)">
                                    <input type="hidden" value="0" data-bind="attr: {name: 'client[contacts][' + $index() + '][send_invoice]'}">
        							<input type="checkbox" value="1" data-bind="visible: email() || first_name() || last_name(), checked: send_invoice, attr: {id: $index() + '_check', name: 'client[contacts][' + $index() + '][send_invoice]'}">
        							<span data-bind="visible: first_name || last_name">
        								<span data-bind="text: (first_name() || '') + ' ' + (last_name() || '')"></span>
        								<br/>
        							</span>
        							<span data-bind="visible: email">
        								<span data-bind="text: email"></span>
        								<br/>
        							</span>
                                </label>
                                                        <span data-bind="visible: !$root.invoice().is_recurring()">
                                    <span data-bind="html: $data.view_as_recipient"></span>&nbsp;&nbsp;
                                                            </span>
                                					</div>
        				</div>
        			</div>

        		</div>
		<div class="col-md-4" id="col_2">
			<div data-bind="visible: !is_recurring()">
				<div class="form-group invoice_date required"><label for="invoice_date" class="control-label col-lg-4 col-sm-4">Invoice Date</label><div class="col-lg-8 col-sm-8"><div class="input-group"><input required class="form-control" data-bind="datePicker: invoice_date, valueUpdate: 'afterkeydown'" data-date-format="M d, yyyy" id="invoice_date" type="text" name="invoice_date"><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></div></div>
				<div class="form-group due_date"><label for="due_date" class="control-label col-lg-4 col-sm-4">Due Date</label><div class="col-lg-8 col-sm-8"><div class="input-group"><input class="form-control" data-bind="datePicker: due_date, valueUpdate: 'afterkeydown'" placeholder=" " data-date-format="M d, yyyy" id="due_date" type="text" name="due_date"><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></div></div>

				<div class="form-group partial">
					<label for="partial" class="control-label col-lg-4 col-sm-4">Partial/Deposit</label>
					<div class="col-lg-8 col-sm-8 no-gutter">
						<div data-bind="css: {'col-md-4': showPartialDueDate(), 'col-md-12': ! showPartialDueDate()}" class="partial">
							<input class="form-control" data-bind="value: partial, valueUpdate: 'afterkeydown'" onkeyup="onPartialChange()" id="partial" type="text" name="partial">
						</div>
						<div class="col-lg-8 no-gap">
							<input class="form-control" placeholder="Due Date" style="display: none" data-bind="datePicker: partial_due_date, valueUpdate: 'afterkeydown', visible: showPartialDueDate" data-date-format="M d, yyyy" id="partial_due_date" type="text" name="partial_due_date">
						</div>
					</div>
				</div>
			</div>
            			<div data-bind="visible: is_recurring" style="display: none">
				<div class="form-group frequency_id"><label for="frequency_id" class="control-label col-lg-4 col-sm-4">Frequency</label><div class="col-lg-8 col-sm-8"><div class="input-group"><select class="form-control" data-bind="value: frequency_id" onchange="onFrequencyChange()" id="frequency_id" name="frequency_id"><option value="1">Weekly</option><option value="2">Two weeks</option><option value="3">Four weeks</option><option value="4">Monthly</option><option value="5">Two months</option><option value="6">Three months</option><option value="7">Four months</option><option value="8">Six months</option><option value="9">Annually</option><option value="10">Two years</option></select><span class="input-group-addon"><span class="glyphicon glyphicon-question-sign"></span></span></div></div></div>
				<div class="form-group start_date"><label for="start_date" class="control-label col-lg-4 col-sm-4">Start Date</label><div class="col-lg-8 col-sm-8"><div class="input-group"><input class="form-control" data-bind="datePicker: start_date, valueUpdate: 'afterkeydown'" data-date-format="M d, yyyy" id="start_date" type="text" name="start_date"><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></div></div>
				<div class="form-group end_date"><label for="end_date" class="control-label col-lg-4 col-sm-4">End Date</label><div class="col-lg-8 col-sm-8"><div class="input-group"><input class="form-control" data-bind="datePicker: end_date, valueUpdate: 'afterkeydown'" data-date-format="M d, yyyy" id="end_date" type="text" name="end_date"><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></div></div>
                <div class="form-group recurring_due_date"><label for="recurring_due_date" class="control-label col-lg-4 col-sm-4">Due Date</label><div class="col-lg-8 col-sm-8"><div class="input-group"><select class="form-control" data-bind="value: recurring_due_date" id="recurring_due_date" name="recurring_due_date"><option value="" class="monthly weekly">Use client terms</option><option value="1998-01-01" data-num="1" class="monthly">1st day of month</option><option value="1998-01-02" data-num="2" class="monthly">2nd day of month</option><option value="1998-01-03" data-num="3" class="monthly">3rd day of month</option><option value="1998-01-04" data-num="4" class="monthly">4th day of month</option><option value="1998-01-05" data-num="5" class="monthly">5th day of month</option><option value="1998-01-06" data-num="6" class="monthly">6th day of month</option><option value="1998-01-07" data-num="7" class="monthly">7th day of month</option><option value="1998-01-08" data-num="8" class="monthly">8th day of month</option><option value="1998-01-09" data-num="9" class="monthly">9th day of month</option><option value="1998-01-10" data-num="10" class="monthly">10th day of month</option><option value="1998-01-11" data-num="11" class="monthly">11th day of month</option><option value="1998-01-12" data-num="12" class="monthly">12th day of month</option><option value="1998-01-13" data-num="13" class="monthly">13th day of month</option><option value="1998-01-14" data-num="14" class="monthly">14th day of month</option><option value="1998-01-15" data-num="15" class="monthly">15th day of month</option><option value="1998-01-16" data-num="16" class="monthly">16th day of month</option><option value="1998-01-17" data-num="17" class="monthly">17th day of month</option><option value="1998-01-18" data-num="18" class="monthly">18th day of month</option><option value="1998-01-19" data-num="19" class="monthly">19th day of month</option><option value="1998-01-20" data-num="20" class="monthly">20th day of month</option><option value="1998-01-21" data-num="21" class="monthly">21st day of month</option><option value="1998-01-22" data-num="22" class="monthly">22nd day of month</option><option value="1998-01-23" data-num="23" class="monthly">23rd day of month</option><option value="1998-01-24" data-num="24" class="monthly">24th day of month</option><option value="1998-01-25" data-num="25" class="monthly">25th day of month</option><option value="1998-01-26" data-num="26" class="monthly">26th day of month</option><option value="1998-01-27" data-num="27" class="monthly">27th day of month</option><option value="1998-01-28" data-num="28" class="monthly">28th day of month</option><option value="1998-01-29" data-num="29" class="monthly">29th day of month</option><option value="1998-01-30" data-num="30" class="monthly">30th day of month</option><option value="1998-01-31" data-num="31" class="monthly">Last day of month</option><option value="1998-02-01" data-num="1" class="weekly">1st Sunday after</option><option value="1998-02-02" data-num="2" class="weekly">1st Monday after</option><option value="1998-02-03" data-num="3" class="weekly">1st Tuesday after</option><option value="1998-02-04" data-num="4" class="weekly">1st Wednesday after</option><option value="1998-02-05" data-num="5" class="weekly">1st Thursday after</option><option value="1998-02-06" data-num="6" class="weekly">1st Friday after</option><option value="1998-02-07" data-num="7" class="weekly">1st Saturday after</option><option value="1998-02-08" data-num="8" class="weekly">2nd Sunday after</option><option value="1998-02-09" data-num="9" class="weekly">2nd Monday after</option><option value="1998-02-10" data-num="10" class="weekly">2nd Tuesday after</option><option value="1998-02-11" data-num="11" class="weekly">2nd Wednesday after</option><option value="1998-02-12" data-num="12" class="weekly">2nd Thursday after</option><option value="1998-02-13" data-num="13" class="weekly">2nd Friday after</option><option value="1998-02-14" data-num="14" class="weekly">2nd Saturday after</option><option value="1998-02-15" data-num="15" class="weekly">3rd Sunday after</option><option value="1998-02-16" data-num="16" class="weekly">3rd Monday after</option><option value="1998-02-17" data-num="17" class="weekly">3rd Tuesday after</option><option value="1998-02-18" data-num="18" class="weekly">3rd Wednesday after</option><option value="1998-02-19" data-num="19" class="weekly">3rd Thursday after</option><option value="1998-02-20" data-num="20" class="weekly">3rd Friday after</option><option value="1998-02-21" data-num="21" class="weekly">3rd Saturday after</option><option value="1998-02-22" data-num="22" class="weekly">4th Sunday after</option><option value="1998-02-23" data-num="23" class="weekly">4th Monday after</option><option value="1998-02-24" data-num="24" class="weekly">4th Tuesday after</option><option value="1998-02-25" data-num="25" class="weekly">4th Wednesday after</option><option value="1998-02-26" data-num="26" class="weekly">4th Thursday after</option><option value="1998-02-27" data-num="27" class="weekly">4th Friday after</option><option value="1998-02-28" data-num="28" class="weekly">4th Saturday after</option></select><span class="input-group-addon"><span class="glyphicon glyphicon-question-sign"></span></span></div></div></div>
			</div>
            
            		</div>

		<div class="col-md-4" id="col_2">
            <span data-bind="visible: !is_recurring()">
            <div class="form-group invoice-number required"><label for="invoice_number" class="control-label col-lg-4 col-sm-4">Invoice #</label><div class="col-lg-8 col-sm-8"><input required class="form-control" onchange="checkInvoiceNumber()" data-bind="value: invoice_number, valueUpdate: 'afterkeydown'" id="invoice_number" type="text" name="invoice_number"></div></div>
            </span>
            <span data-bind="visible: is_recurring()" style="display: none">
                <div data-bind="visible: !(auto_bill() == 2 &amp;&amp; client_enable_auto_bill()) &amp;&amp; !(auto_bill() == 3 &amp;&amp; !client_enable_auto_bill())" style="display: none">
                <div class="form-group"><label for="auto_bill" class="control-label col-lg-4 col-sm-4">Auto Bill</label><div class="col-lg-8 col-sm-8"><select class="form-control" data-bind="value: auto_bill, valueUpdate: 'afterkeydown', event:{change:function(){if(auto_bill()==2)client_enable_auto_bill(0);if(auto_bill()==3)client_enable_auto_bill(1)}}" id="auto_bill" name="auto_bill"><option value="1">Off</option><option value="2">Opt-in</option><option value="3">Opt-out</option><option value="4">Always</option></select></div></div>
                </div>
                <input type="hidden" name="client_enable_auto_bill" data-bind="attr: { value: client_enable_auto_bill() }" />
                <div class="form-group" data-bind="visible: auto_bill() == 2 &amp;&amp; client_enable_auto_bill()">
                    <div class="col-sm-4 control-label">Auto Bill</div>
                    <div class="col-sm-8" style="padding-top:10px;padding-bottom:9px">
                        Opted in - <a href="#" data-bind="click:function(){client_enable_auto_bill(false)}">(Disable)</a>
                    </div>
                </div>
                <div class="form-group" data-bind="visible: auto_bill() == 3 &amp;&amp; !client_enable_auto_bill()">
                    <div class="col-sm-4 control-label">Auto Bill</div>
                    <div class="col-sm-8" style="padding-top:10px;padding-bottom:9px">
                        Opted out - <a href="#" data-bind="click:function(){client_enable_auto_bill(true)}">(Enable)</a>
                    </div>
                </div>
            </span>
			<div class="form-group"><label for="po_number" class="control-label col-lg-4 col-sm-4">PO #</label><div class="col-lg-8 col-sm-8"><input class="form-control" data-bind="value: po_number, valueUpdate: 'afterkeydown'" id="po_number" type="text" name="po_number"></div></div>
			<div class="form-group no-padding-or-border"><label for="discount" class="control-label col-lg-4 col-sm-4">Discount</label><div class="col-lg-8 col-sm-8"><div class="input-group"><input class="form-control" data-bind="value: discount, valueUpdate: 'afterkeydown'" min="0" step="any" id="discount" type="number" name="discount"><span class="input-group-addon"><select class="form-control" data-bind="value: is_amount_discount, event:{ change: isAmountDiscountChanged}" id="is_amount_discount" name="is_amount_discount"><option value="0">Percent</option><option value="1">Amount</option></select></span></div></div></div>

            
                        <div class="form-group" style="margin-bottom: 8px">
                <div class="col-lg-8 col-sm-8 col-sm-offset-4 smaller" style="padding-top: 10px;">
                	                </div>
            </div>
            		</div>
</div>




////////////////////////////////////////////////////////////////////////////
<div class="table-responsive" style="padding-top:4px;">

		<table class="table invoice-table product-table">
<thead>
        <tr>
        <th style="min-width:32px;" class="hide-border"></th>
        <th style="min-width:120px;width:25%">Item</th>
        <th style="width:100%">Description</th>
                        <th style="min-width:120px">Unit Cost</th>
        <th style="min-width:120px;display:table-cell">Quantity</th>
        <th style="min-width:120px;display:none">Discount</th>
        <th style="min-width:120px;display:none;" data-bind="visible: $root.invoice_item_taxes.show">Tax</th>
        <th style="min-width:120px;">Line Total</th>
        <th style="min-width:32px;" class="hide-border"></th>
    </tr>
</thead>
<tbody data-bind="sortable: { data: invoice_items_without_tasks, allowDrop: false, afterMove: onDragged} " class="ui-sortable"><tr data-bind="event: { mouseover: showActions, mouseout: hideActions }" class="sortable-row ui-sortable-handle">
        <td class="hide-border td-icon">
            <i style="display: none;" data-bind="visible: actionsVisible() &amp;&amp;
                $parent.invoice_items_without_tasks().length > 1" class="fa fa-sort"></i>
        </td>
        <td>
            <div id="scrollable-dropdown-menu">
                <span class="twitter-typeahead" style="position: relative; display: inline-block;"><input type="text" data-bind="productTypeahead: product_key, items: $root.products, key: 'product_key', valueUpdate: 'afterkeydown', attr: {name: 'invoice_items[' + $index() + '][product_key]'}" class="form-control invoice-item handled tt-hint" readonly="" autocomplete="off" spellcheck="false" tabindex="-1" dir="ltr" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: none 0% 0% / auto repeat scroll padding-box border-box rgb(249, 249, 249);"><input type="text" data-bind="productTypeahead: product_key, items: $root.products, key: 'product_key', valueUpdate: 'afterkeydown', attr: {name: 'invoice_items[' + $index() + '][product_key]'}" class="form-control invoice-item handled tt-input" autocomplete="off" spellcheck="false" dir="auto" style="position: relative; vertical-align: top; background-color: transparent;" name="invoice_items[0][product_key]"><pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: Roboto, sans-serif; font-size: 16px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: auto; text-transform: none;">MObile</pre><div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;"><div class="tt-dataset tt-dataset-data"><div title="good" style="border-bottom: solid 1px #CCC" class="tt-suggestion tt-selectable"><strong class="tt-highlight">MObile</strong></div></div></div></span>
            </div>
        </td>
        <td>
            <textarea data-bind="value: notes, valueUpdate: 'afterkeydown', attr: {name: 'invoice_items[' + $index() + '][notes]'}" rows="1" cols="60" style="resize: vertical;height:42px" class="form-control word-wrap" name="invoice_items[0][notes]"></textarea>
                <input type="text" data-bind="value: task_public_id, attr: {name: 'invoice_items[' + $index() + '][task_public_id]'}" style="display: none" name="invoice_items[0][task_public_id]">
                <input type="text" data-bind="value: expense_public_id, attr: {name: 'invoice_items[' + $index() + '][expense_public_id]'}" style="display: none" name="invoice_items[0][expense_public_id]">
                <input type="text" data-bind="value: invoice_item_type_id, attr: {name: 'invoice_items[' + $index() + '][invoice_item_type_id]'}" style="display: none" name="invoice_items[0][invoice_item_type_id]">
        </td>
                        <td>
            <input data-bind="value: prettyCost, valueUpdate: 'afterkeydown', attr: {name: 'invoice_items[' + $index() + '][cost]'}" style="text-align: right" class="form-control invoice-item" name="invoice_items[0][cost]">
        </td>
        <td style="display:table-cell">
            <input data-bind="value: prettyQty, valueUpdate: 'afterkeydown', attr: {name: 'invoice_items[' + $index() + '][qty]'}" style="text-align: right" class="form-control invoice-item" name="invoice_items[0][qty]">
        </td>
        <td style="display:none">
            <input data-bind="value: discount, valueUpdate: 'afterkeydown', attr: {name: 'invoice_items[' + $index() + '][discount]'}" style="text-align: right" class="form-control invoice-item" name="invoice_items[0][discount]">
        </td>
        <td style="display:none;" data-bind="visible: $root.invoice_item_taxes.show">
                <select class="form-control" data-bind="value: tax1, event:{change:onTax1Change}" id="" name=""><option value=""></option></select>
            <input type="text" data-bind="value: tax_name1, attr: {name: 'invoice_items[' + $index() + '][tax_name1]'}" style="display:none" name="invoice_items[0][tax_name1]">
            <input type="text" data-bind="value: tax_rate1, attr: {name: 'invoice_items[' + $index() + '][tax_rate1]'}" style="display:none" name="invoice_items[0][tax_rate1]">
            <div data-bind="visible: $root.invoice().account.enable_second_tax_rate == '1'" style="display: none;">
                <select class="form-control tax-select" data-bind="value: tax2, event:{change:onTax2Change}" id="-2" name=""><option value=""></option></select>
            </div>
            <input type="text" data-bind="value: tax_name2, attr: {name: 'invoice_items[' + $index() + '][tax_name2]'}" style="display:none" name="invoice_items[0][tax_name2]">
            <input type="text" data-bind="value: tax_rate2, attr: {name: 'invoice_items[' + $index() + '][tax_rate2]'}" style="display:none" name="invoice_items[0][tax_rate2]">
        </td>
        <td style="text-align:right;padding-top:9px !important" nowrap="">
            <div class="line-total" data-bind="text: totals.total">$1,200.00</div>
        </td>
        <td style="cursor:pointer" class="hide-border td-icon">
            <i style="padding-left: 2px; display: none;" data-bind="click: $parent.removeItem, visible: actionsVisible() &amp;&amp; !isEmpty()" class="fa fa-minus-circle redlink" title="Remove item">
        </i></td>
    </tr><tr data-bind="event: { mouseover: showActions, mouseout: hideActions }" class="sortable-row">
        <td class="hide-border td-icon">
            <i style="display: none;" data-bind="visible: actionsVisible() &amp;&amp;
                $parent.invoice_items_without_tasks().length > 1" class="fa fa-sort"></i>
        </td>
        <td>
            <div id="scrollable-dropdown-menu">
                <span class="twitter-typeahead" style="position: relative; display: inline-block;"><input type="text" data-bind="productTypeahead: product_key, items: $root.products, key: 'product_key', valueUpdate: 'afterkeydown', attr: {name: 'invoice_items[' + $index() + '][product_key]'}" class="form-control invoice-item handled tt-hint" readonly="" autocomplete="off" spellcheck="false" tabindex="-1" dir="ltr" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: none 0% 0% / auto repeat scroll padding-box border-box rgb(249, 249, 249);"><input type="text" data-bind="productTypeahead: product_key, items: $root.products, key: 'product_key', valueUpdate: 'afterkeydown', attr: {name: 'invoice_items[' + $index() + '][product_key]'}" class="form-control invoice-item handled tt-input" autocomplete="off" spellcheck="false" dir="auto" style="position: relative; vertical-align: top; background-color: transparent;" name="invoice_items[1][product_key]"><pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: Roboto, sans-serif; font-size: 16px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: auto; text-transform: none;"></pre><div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;"><div class="tt-dataset tt-dataset-data"><div title="good" style="border-bottom: solid 1px #CCC" class="tt-suggestion tt-selectable">MObile</div><div title="This is good quality product" style="border-bottom: solid 1px #CCC" class="tt-suggestion tt-selectable">Product Name</div></div></div></span>
            </div>
        </td>
        <td>
            <textarea data-bind="value: notes, valueUpdate: 'afterkeydown', attr: {name: 'invoice_items[' + $index() + '][notes]'}" rows="1" cols="60" style="resize: vertical; height: 43px;" class="form-control word-wrap" name="invoice_items[1][notes]"></textarea>
                <input type="text" data-bind="value: task_public_id, attr: {name: 'invoice_items[' + $index() + '][task_public_id]'}" style="display: none" name="invoice_items[1][task_public_id]">
                <input type="text" data-bind="value: expense_public_id, attr: {name: 'invoice_items[' + $index() + '][expense_public_id]'}" style="display: none" name="invoice_items[1][expense_public_id]">
                <input type="text" data-bind="value: invoice_item_type_id, attr: {name: 'invoice_items[' + $index() + '][invoice_item_type_id]'}" style="display: none" name="invoice_items[1][invoice_item_type_id]">
        </td>
                        <td>
            <input data-bind="value: prettyCost, valueUpdate: 'afterkeydown', attr: {name: 'invoice_items[' + $index() + '][cost]'}" style="text-align: right" class="form-control invoice-item" name="invoice_items[1][cost]">
        </td>
        <td style="display:table-cell">
            <input data-bind="value: prettyQty, valueUpdate: 'afterkeydown', attr: {name: 'invoice_items[' + $index() + '][qty]'}" style="text-align: right" class="form-control invoice-item" name="invoice_items[1][qty]">
        </td>
        <td style="display:none">
            <input data-bind="value: discount, valueUpdate: 'afterkeydown', attr: {name: 'invoice_items[' + $index() + '][discount]'}" style="text-align: right" class="form-control invoice-item" name="invoice_items[1][discount]">
        </td>
        <td style="display:none;" data-bind="visible: $root.invoice_item_taxes.show">
                <select class="form-control" data-bind="value: tax1, event:{change:onTax1Change}" id="" name=""><option value=""></option></select>
            <input type="text" data-bind="value: tax_name1, attr: {name: 'invoice_items[' + $index() + '][tax_name1]'}" style="display:none" name="invoice_items[1][tax_name1]">
            <input type="text" data-bind="value: tax_rate1, attr: {name: 'invoice_items[' + $index() + '][tax_rate1]'}" style="display:none" name="invoice_items[1][tax_rate1]">
            <div data-bind="visible: $root.invoice().account.enable_second_tax_rate == '1'" style="display: none;">
                <select class="form-control tax-select" data-bind="value: tax2, event:{change:onTax2Change}" id="-2" name=""><option value=""></option></select>
            </div>
            <input type="text" data-bind="value: tax_name2, attr: {name: 'invoice_items[' + $index() + '][tax_name2]'}" style="display:none" name="invoice_items[1][tax_name2]">
            <input type="text" data-bind="value: tax_rate2, attr: {name: 'invoice_items[' + $index() + '][tax_rate2]'}" style="display:none" name="invoice_items[1][tax_rate2]">
        </td>
        <td style="text-align:right;padding-top:9px !important" nowrap="">
            <div class="line-total" data-bind="text: totals.total"></div>
        </td>
        <td style="cursor:pointer" class="hide-border td-icon">
            <i style="padding-left:2px;display:none;" data-bind="click: $parent.removeItem, visible: actionsVisible() &amp;&amp; !isEmpty()" class="fa fa-minus-circle redlink" title="Remove item">
        </i></td>
    </tr></tbody>
</table>
		
		<table class="pull-left subtotals-table" style="margin-right:700px; margin-top:0px;">
			<tbody>

			<tr>
				<td colspan="2">Subtotal</td>
				<td style="text-align: "><span data-bind="text: totals.subtotal">$1,200.00</span></td>
			</tr>

			<tr style="display:none" data-bind="visible: discount() != 0">
				<td colspan="2">Discount</td>
				<td style="text-align: "><span data-bind="text: totals.discounted">$0.00</span></td>
			</tr>

			            
            <tr style="display:none" data-bind="visible: $root.invoice_item_taxes.show &amp;&amp; totals.hasItemTaxes">
                <td>Tax&nbsp;&nbsp;</td>
                <td style="min-width:120px"><span data-bind="html: totals.itemTaxRates"></span></td>
                <td style="text-align: "><span data-bind="html: totals.itemTaxAmounts"></span></td>
            </tr>

			<tr style="display:none" data-bind="visible: $root.invoice_taxes.show">
				<td>Tax&nbsp;&nbsp;</td>
				<td style="min-width:120px">
                    <select class="form-control" id="taxRateSelect1" data-bind="value: tax1, event:{change:onTax1Change}" name=""><option value=""></option></select>
                    <input type="text" name="tax_name1" data-bind="value: tax_name1" style="display:none">
                    <input type="text" name="tax_rate1" data-bind="value: tax_rate1" style="display:none">
                    <div data-bind="visible: $root.invoice().account.enable_second_tax_rate == '1'" style="display: none;">
                    <select class="form-control tax-select" data-bind="value: tax2, event:{change:onTax2Change}" id="-3" name=""><option value=""></option></select>
                    </div>
                    <input type="text" name="tax_name2" data-bind="value: tax_name2" style="display:none">
                    <input type="text" name="tax_rate2" data-bind="value: tax_rate2" style="display:none">
                </td>
				<td style="text-align: right"><span data-bind="text: totals.taxAmount">$0.00</span></td>
			</tr>

            
            
							<tr>
					<td colspan="2">Paid to Date</td>
					<td style="text-align: right" data-bind="text: totals.paidToDate">$0.00</td>
				</tr>
			
			<tr data-bind="style: { 'font-weight': partial() ? 'normal' : 'bold', 'font-size': partial() ? '1em' : '1.05em' }" style="font-size:1.05em;font-weight:bold;">
				<td class="hide-border" data-bind="css: {'hide-border': !partial()}" colspan="2">Balance Due</td>
				<td class="hide-border" data-bind="css: {'hide-border': !partial()}" style="text-align: right"><span data-bind="text: totals.total">$1,200.00</span></td>
			</tr>

			<tr style="font-size:1.05em; display:none; font-weight:bold" data-bind="visible: partial">
				<td class="hide-border" colspan="2">Partial Due</td>
				<td class="hide-border" style="text-align: right"><span data-bind="text: totals.partial">$0.00</span></td>
			</tr>
		</tbody></table>


		<div role="tabpanel" class="pull-left" style="margin-left:40px; margin-top:30px;">

			<ul class="nav nav-tabs" role="tablist" style="border: none">
				<li role="presentation" class="active"><a href="#public_notes" aria-controls="notes" role="tab" data-toggle="tab">Public Notes</a></li>
				<li role="presentation"><a href="#private_notes" aria-controls="terms" role="tab" data-toggle="tab">Private Notes</a></li>
				<li role="presentation"><a href="#terms" aria-controls="terms" role="tab" data-toggle="tab">Terms</a></li>
				<li role="presentation"><a href="#footer" aria-controls="footer" role="tab" data-toggle="tab">Footer</a></li>
							</ul>

			
			

			<div class="tab-content" style="padding-right:12px;max-width:600px;">
				<div role="tabpanel" class="tab-pane active" id="public_notes" style="padding-bottom:44px;">
					<div class="form-group"><div class="col-lg-12 col-sm-12"><textarea class="form-control" data-bind="value: public_notes, valueUpdate: 'afterkeydown'" style="width: 100%" rows="4" id="public_notes" name="public_notes"></textarea></div></div>
				</div>
				<div role="tabpanel" class="tab-pane" id="private_notes" style="padding-bottom:44px">
					<div class="form-group"><div class="col-lg-12 col-sm-12"><textarea class="form-control" data-bind="value: private_notes, valueUpdate: 'afterkeydown'" style="width: 100%" rows="4" id="private_notes" name="private_notes"></textarea></div></div>
				</div>
				<div role="tabpanel" class="tab-pane" id="terms">
					<div class="form-group"><div class="col-lg-12 col-sm-12"><textarea class="form-control" data-bind="value:terms, placeholder: terms_placeholder, valueUpdate: 'afterkeydown'" style="width: 100%" rows="4" id="terms" name="terms"></textarea><span class="help-block"><div class="checkbox">
										<label>
											<input name="set_default_terms" type="checkbox" style="width: 16px" data-bind="checked: set_default_terms">Save as default terms
										</label>
										<div class="pull-right" data-bind="visible: showResetTerms()" style="display: none;">
											<a href="#" onclick="return resetTerms()" title="Reset to the default account terms">Reset terms</a>
										</div>
									</div></span></div></div>
				</div>
				<div role="tabpanel" class="tab-pane" id="footer">
					<div class="form-group"><div class="col-lg-12 col-sm-12"><textarea class="form-control" data-bind="value:invoice_footer, placeholder: footer_placeholder, valueUpdate: 'afterkeydown'" style="width: 100%" rows="4" id="invoice_footer" name="invoice_footer"></textarea><span class="help-block"><div class="checkbox">
										<label>
											<input name="set_default_footer" type="checkbox" style="width: 16px" data-bind="checked: set_default_footer">Save as default footer
										</label>
										<div class="pull-right" data-bind="visible: showResetFooter()" style="display: none;">
											<a href="#" onclick="return resetFooter()" title="Reset to the default account footer">Reset footer</a>
										</div>
									</div></span></div></div>
				</div>
							</div>

			
			

		</div>

    </div>



<?php include 'init/footer.php' ?>


