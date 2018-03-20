/**********************************************************************
    Copyright (C) FrontAccounting, LLC.
	Released under the terms of the GNU General Public License, GPL,
	as published by the Free Software Foundation, either version 3
	of the License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/
//console.log(localStorage['isipaging']);
//console.log(localStorage['totalpaging']);
//console.log(localStorage['urlsementara']);

$(document).ready(function(){
	$( "[name=bank_account]" ).prepend( "<option selected=''>--Select Bank Account--</option>" );
	//jangpaging(0);
	cleanstorage();
	deletetag();
	jangpaging(0);

    $('body').on('change', function(){
		jangpaging(0);
    });

    if(localStorage['isipaging'] != undefined || localStorage['isipaging'] != ""){	
		var hasil = localStorage['isipaging'];
		setTimeout(function(){
			for(var a=0; a<hasil.length; a++){
				// $('[name='+hasil[a].box+']').val(hasil[a].value);
				price_format(hasil[a].box, hasil[a].value, user.pdec);
			}
			// $('[name=amount]').val(localStorage['totalpaging']);
			price_format('amount', localStorage['totalpaging'], user.pdec);
			// price_format('bank_amount', total, user.pdec);
			
		},2000);
	}

});

// -------------------------------------------------------- JANG DI INSERT KANU DATABASE EH LAIN NYA ETA WE.........

function deletetag(){
	// event.preventDefault();
	$("#ProcessSuppPayment").click(function(event) {
	   	var countfalse = parseInt($("#countnan").val());
	   	console.log(countfalse);
	   	for (var i = 0; i < countfalse; i++) {
	   		tes = $("[name=amount"+i+"]").val();
	   		// console.log(tes);
	   		if (tes == ""){
		   		$("[name=iniaja"+i+"]").remove();
		   	}	
	   	}
	}
	   	// $("#ProcessSuppPayment").submit();
	);
	
	$("#AddPaymentItem").click(function(event) {
		
	    // event.preventDefault();

	   	var countfalse = parseInt($("#countnan").val());
	   	//console.log(countfalse);
	   	for (var i = 0; i < countfalse; i++) {
	   		tes = $("[name=amount"+i+"]").val();
	   		// console.log(tes);
	   		if (tes == ""){
		   		$("[name=iniaja"+i+"]").remove();
		   	}	
	   	}
	}
		// $("#AddPaymentItem").submit();
	);

}

function jangpaging(trigger){
	setTimeout(function(){
    	var isian = $("#countnan").val();
        var a = 0;
        var count = 20;
       
        $('#hideall').hide();

        if(trigger == 'next'){
        	a = parseInt(localStorage['counterna']);
        	countt = a + count;
			
			// ------------ hide 20 item backward
        	for (var i=0; i < a; i++) {
				$("[name=iniaja"+i+"]").hide();
			}
			// ------------ show 20 item forward
			for (var i=a; i < countt; i++) {
				$("[name=iniaja"+i+"]").show();
			}
			localStorage['counterna'] = i; // update status localsotrage

			// ------------ condition button
        	if (a >= parseInt(isian)){
				$('#next').hide();
			}else if(a > 0){
				$('#previous').show();
			}

        }else if(trigger == 'previous'){
        	a = parseInt(localStorage['counterna']) - 20;
        	ab = parseInt(localStorage['counterna']);
        	countt = ab - count;
        	prev = a - count;

        	for (var i=localStorage['counterna']; i >= a; i--) {
				$("[name=iniaja"+i+"]").hide();
			}

			for (var c=prev; c < countt; c++) {
				$("[name=iniaja"+c+"]").show();
			}
			localStorage['counterna'] = c; // update status localsotrage

			if (c <= 20){
				$('#previous').hide();
			}else if (c > 20){
				$('#next').show();
			}

        }else if(trigger == "first"){
        	if (a < 1){
				$('#previous').hide();
			}

        	for (var i=a; i < count; i++) {
				$("[name=iniaja"+i+"]").show();
			}
			localStorage['counterna'] = i;
        
        }else{
        	if (a < 1){
				$('#previous').hide();
			}

        	for (var i=a; i < 20; i++) {
				$("[name=iniaja"+i+"]").show();
			}
			localStorage['counterna'] = i;
        }
        deletetag();
	},2000);
}

function focus_alloc(i) {
    save_focus(i);
	i.setAttribute('_last', get_amount(i.name));
}

function blur_alloc(i) {
		var change = get_amount(i.name);

		if (i.name != 'amount' && i.name != 'charge' && i.name != 'discount')
			change = Math.min(change, get_amount('maxval'+i.name.substr(6), 1))

		price_format(i.name, change, user.pdec);
		if (i.name != 'amount' && i.name != 'charge') {
			if (change<0) change = 0;
			change = change-i.getAttribute('_last');
			if (i.name == 'discount') change = -change;

			var total = get_amount('amount')+change;
			price_format('amount', total, user.pdec, 0);
		}
}

function allocate_all01(doc) {
	
	var amount = get_amount('amount'+doc);
	var unallocated = get_amount('un_allocated'+doc);
	var total = get_amount('amount');
	var left = 0;
	total -=  (amount-unallocated);
	left -= (amount-unallocated);
	amount = unallocated;
	if(left<0) {
		total  += left;
		amount += left;
		left = 0;
	}
	price_format('amount'+doc, amount, user.pdec);
	price_format('amount', total, user.pdec);
	price_format('bank_amount', total, user.pdec);

}

function allocate_all(doc) {
	var total = get_amount('amount');
	var amount = get_amount('amount'+doc);
	var unallocated = get_amount('un_allocated'+doc);
	var left = 0;
	var local = localStorage['isipaging'];
	if(amount == 0){
		$("[name=amount"+doc+"]").val(unallocated);
		total += unallocated;
		$("[name=amount]").val(total);
		localStorage['totalpaging'] = total;
		price_format('amount'+doc, unallocated, user.pdec);
		price_format('amount', total, user.pdec);
		price_format('bank_amount', total, user.pdec);
		
		if(local != undefined && local != "")
		{
			var isipaging = {'box':"amount"+doc,'value':unallocated};
			var hasil = jQuery.parseJSON(localStorage['isipaging']);
			hasil.push(isipaging); 
			var hasilstr = JSON.stringify(hasil);
			localStorage['isipaging'] = hasilstr;
		}else{
			var isipaging = [{'box':"amount"+doc,'value':unallocated}];
			isipagingst = JSON.stringify(isipaging);
			localStorage['isipaging'] = isipagingst;
		}		
	}else{
		$("[name=amount"+doc+"]").val("");
		total -= unallocated;
		$("[name=amount]").val(total);
		localStorage['totalpaging'] = total;
		price_format('amount'+doc, 0, user.pdec);
		price_format('amount', total, user.pdec);
		price_format('bank_amount', total, user.pdec);
		
		if(local != undefined && local != "")
		{
			var isipaging = {'box':"amount"+doc,'value':""};
			var hasil = jQuery.parseJSON(localStorage['isipaging']);
			hasil.push(isipaging); 
			var hasilstr = JSON.stringify(hasil);
			localStorage['isipaging'] = hasilstr;
		}else{
			var isipaging = [{'box':"amount"+doc,'value':""}];
			isipagingst = JSON.stringify(isipaging);
			localStorage['isipaging'] = isipagingst;
		}
	}
	
}

function allocate_none(doc) {
	amount = get_amount('amount'+doc);
	total = get_amount('amount');
	var unallocated = get_amount('un_allocated'+doc);
	var local = localStorage['isipaging'];
	if(amount > 0){	
	localStorage['totalpaging'] = total - unallocated;

	price_format('amount'+doc, 0, user.pdec);
	price_format('amount', total-amount, user.pdec);
	price_format('bank_amount', total-amount, user.pdec);
		if(local != undefined && local != "")
		{
			// console.log(isipaging);
			var isipaging = {'box':"amount"+doc,'value':""};
			var hasil = jQuery.parseJSON(localStorage['isipaging']);
			hasil.push(isipaging); 
			var hasilstr = JSON.stringify(hasil);
			localStorage['isipaging'] = hasilstr;
		}else{
			var isipaging = [{'box':"amount"+doc,'value':""}];
			isipagingst = JSON.stringify(isipaging);
			localStorage['isipaging'] = isipagingst;
		}
	}
}

var allocations = {
	'.amount': function(e) {
 		if(e.name == 'allocated_amount' || e.name == 'bank_amount')
 		{
  		  e.onblur = function() {
			var dec = this.getAttribute("dec");
			price_format(this.name, get_amount(this.name), dec);
		  };
 		} else {
			e.onblur = function() {
				blur_alloc(this);
			};
			e.onfocus = function() {
				focus_alloc(this);
			};
		}
	}
}
function cleanstorage(){
	// console.log('asfd');
	var url = window.location.href;
	var urlsplit = url.split("/");
	var namaurl = localStorage["urlsementara"];

	if(localStorage["urlsementara"] == "" || localStorage["urlsementara"] == null)
	{
		localStorage["urlsementara"] = urlsplit[3];
		
	}
	if(namaurl == 'purchasing')
	{
		localStorage['totalpaging']	= "";
		localStorage['isipaging'] = "";
		localStorage["urlsementara"] = 'sales';
	}else if(namaurl == 'sales')
	{
		localStorage['totalpaging']	= "";
		localStorage['isipaging'] = "";
		localStorage["urlsementara"] = 'purchasing';
	}else{

	}
    
}

Behaviour.register(allocations);