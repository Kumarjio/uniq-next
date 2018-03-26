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
	//jangpaging(0);
	cleanstorage();
	deletetag();
	jangpaging(0);
    $('body').on('change', $("[name=customer_id]"),function(){
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
			
		},1000);
	}

});

// -------------------------------------------------------- JANG DI INSERT KANU DATABASE EH LAIN NYA ETA WE.........

function deletetag(){
	// event.preventDefault();
	$("#Process").click(function(event) {

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
	   	// $("#ProcessSuppPayment").submit();
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

        	for (var i=a; i < count; i++) {
				$("[name=iniaja"+i+"]").show();
			}
			localStorage['counterna'] = i;
        }
	},1000);
}

function focus_alloc(i) {
    save_focus(i);
	i.setAttribute('_last', get_amount(i.name));
}

function blur_alloc(i) {

	var last = +i.getAttribute('_last')
	var left = get_amount('left_to_allocate', 1); 
	var cur = Math.min(get_amount(i.name), get_amount('maxval'+i.name.substr(6), 1), last+left)

	price_format(i.name, cur, user.pdec);
	change = cur-last;

	var total = get_amount('total_allocated', 1)+change;
		left -= change;
	
	price_format('left_to_allocate', left, user.pdec, 1, 1);
	price_format('total_allocated', total, user.pdec, 1, 1);
}

function allocate_all(doc) {
	var amount = get_amount('amount'+doc);
	var unallocated = get_amount('un_allocated'+doc);
	var total = get_amount('total_allocated', 1);
	var left = get_amount('left_to_allocate', 1);

	left += (amount - unallocated);
	total -=  (amount-unallocated);
	amount = unallocated;

	if(left<0) {
		amount += left;
		total  += left;
		left = 0;
	}
	console.log("amount "+amount);
	console.log("unallocated "+unallocated);
	console.log("total "+total);
	console.log("left "+left);

	price_format('amount'+doc, amount, user.pdec);
	price_format('left_to_allocate', left, user.pdec, 1,1);
	price_format('total_allocated', total, user.pdec, 1, 1);
}

function allocate_none(doc) {
	amount = get_amount('amount'+doc);
	left = get_amount('left_to_allocate', 1);
	total = get_amount('total_allocated', 1);

	price_format('left_to_allocate',(amount+left), user.pdec, 1, 1);
	price_format('amount'+doc, 0, user.pdec);
	price_format('total_allocated', (total-amount), user.pdec, 1, 1);
}

var allocations = {
	'.amount': function(e) {
		e.onblur = function() {
			blur_alloc(this);
		  };
		e.onfocus = function() {
			focus_alloc(this);
		};
	}
}

function cleanstorage(){
	// console.log('asfd');
	var url = window.location.href;
	var urlsplit = url.split("/");
	var namaurl = localStorage["urlsementara"];

	if(localStorage["urlsementara"] == "" || localStorage["urlsementara"] == null)
	{
		localStorage["urlsementara"] = urlsplit[4];
		
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
