/*syncard js*/
var allText = '';
$("html").attr('style', 'opacity:1');

$(function(){

// Modal
input_fiscal_year();
finishsetup();
 // $('.modal').modal();
 createmodal();
 getdatapicture();
 deletedatapicture();
/* title button */
$(".fa.fa-plus").attr({
            "title" : "Add New"
        });
$('.tabs').tabs();
$("select[name=customer_tax_id]").val(26).attr("selected");
getItemSelect();
autocomplete();
getAccountSelect();
// hideBranch();
getGlAcc();
noSelect();
noSelectActive();
//noSelectGl();
//noSelectActiveGl();
SetupJav();
update_time_login();
log_out_useronline();
getAllLanguage();
selLang();
// popitup();

//---------------document printing
print_invoice();
print_creditnote();
print_deliverynote();
print_salesorder();
print_salesquot();
print_remittance();
print_paymentvoucher();
print_depositvoucher();
print_transfervoucher();
print_statements();
print_reconcile();
print_payment();
print_purchaseorder();

dropdown_menu();
//ui hack
// filter_hack();
operation_button_hack();
pasloadQuotation();
selectOnQuotation();
selectOnTableQuotation();
additemOnQuotation();
//limit checkbox
selectlimit();

});

function SetupJav(){
	if($('body [name=domicile]').val() != ""){
		$('body [name=domicile]').attr({
			'readonly':'true',
			'style':'background-color:#ddd'
		});
	}
}
function popitup(url) {
	window.open(url,'name','height=600,width=850');
	// if (window.focus) {newwindow.focus();}
	return false;
}

function getItemSelect(){
	$('body').on("keyup",'tr [rel=stock_id]',function(e){
		if(e.keyCode == 13){
		var value = $(this).val();
		value = value.toUpperCase();
		var opt;
		$('table tbody tr [rel=_stock_id_edit] option:contains('+value+')').prop({selected: true});
		opt = $('table tbody tr [rel=_stock_id_edit]').find(":selected").text();
		$('table tbody tr #_stock_id_sel span.filter-option').html(opt);
		$('#d-id').remove();
		$('table tbody tr #AddItem').removeAttr('disabled');
		}
	});
}
function noSelect(){
	html = '-- Select --';
	var nah ='';
	ini  = '<option selected value=no>-- Select -- </option>';
	setTimeout(function(){
		$('table tbody tr #_stock_id_sel span.filter-option').html(html);
		// $('table tbody tr [rel=_stock_id_edit]').prepend(ini);
		nah = $('table tbody tr #_stock_id_sel span.filter-option').text();
		if( nah == '-- Select --'){
			$('table tbody tr #AddItem').attr('disabled','disabled');
		}
	},1000);
}
function noSelectActive(){
	$('body').on('click','table tbody tr #AddItem',function(){
		setTimeout(function(){
			noSelect();
		},500);
	});

}
function noSelectGl(){
	var opt ='';
	var nah = '';
	setTimeout(function(){
		$('table tbody tr [name=_code_id_edit]').val('');
		$('table tbody tr [name=code_id] option:eq(0)').attr('selected','selected').val('no');
		nah = $('table tbody tr [name=code_id]').find(":selected").text();
		$('table tbody tr #_code_id_sel span.filter-option').html(nah);
		$('table tbody tr #AddItem').attr('disabled','disabled');
		},1000);
}
function noSelectActiveGl(){

	$('body').on('change','table tbody tr [name=code_id]',function(){
		id = $('table tbody tr [name=code_id]').val();
		if(id != ''){
			$('table tbody tr #AddItem').removeAttr('disabled');
		}else{
			$('table tbody tr #AddItem').attr('disabled','disabled');
		}
	})
	$('body').on('click','table tbody tr #AddItem',function(){
		setTimeout(function(){
			// noSelectGl();
		},500);
	});

}

function hideBranch(){
	$('body').on("change",'[rel=_customer_id_edit]',function(e){
		var len = $('[name=branch_id] option').length;
		// if(len <= 2){
			// $('body').on('change','[name=branch_id]',function(){
				setTimeout(function(){
				$('#_branch_id_sel').parent().parent().hide();
				},2000);
			// });
			// return false;
		// }
	});
}

function getGlAcc(){
	$('body').on("keyup",'tr [name=_gl_code_edit]',function(e){
		if(e.keyCode == 13){
		var value = $(this).val();
		var opt;
		$('table tbody tr [name=gl_code] option:contains('+value+')').prop({selected: true});
		opt = $('table tbody tr [name=gl_code]').find(":selected").text();
		$('table tbody tr #_gl_code_sel span.filter-option').html(opt);
		}
	});
}

function autocomplete(){
	$('body').on('keyup','[rel=stock_id]',function(e){
		if(e.keyCode != 13){
			var value = $(this).val();
			if(value !=''){
			var res;
			value = value.toUpperCase();
			var options = $('table tbody tr [rel=_stock_id_edit] option');
			var values = $.map(options ,function(option) {
			    return option.value+'%'+option.text ;
			});
			var sel;
			var relevantSelects = [];
			// var relevantSelects2 = [];
			for(var z=0; z<values.length; z++){
			     sel = values[z];
			     if(sel.indexOf(value) === 0){
			         relevantSelects.push(sel);
			     }
			}
			var html =  '<div class=syncard-dropdown id=d-id>'+
							'<ul>';
								for(var a = 0; a < relevantSelects.length; a++){
									var nah = relevantSelects[a].split('%');
									html = html + '<li syncard-id='+nah[0]+'>'+nah[1]+'</li>';
								}
							html = html + '</ul></div>';
			$('table tbody tr [rel=stock_id]').parent().attr('style','position:relative');
			$('#d-id').remove();
			$('table tbody tr [rel=stock_id]').parent().append(html);
			}else{
			$('#d-id').remove();
			}
		}
	});

	$('body').on('click','#d-id li',function(){
		var value = $(this).attr('syncard-id');
		$('table tbody tr [rel=stock_id]').val(value);
		var opt;
		$('table tbody tr [rel=_stock_id_edit] option:contains('+value+')').prop({selected: true});
		opt = $('table tbody tr [rel=_stock_id_edit]').find(":selected").text();
		$('table tbody tr #_stock_id_sel span.filter-option').html(opt);
		$('#d-id').remove();
		$('table tbody tr #AddItem').removeAttr('disabled');
	});
}

function getAccountSelect(){
	/*show account after select*/
	$('body').on('change','table tbody tr [name=code_id]',function(){
		var opt;
		opt = $('table tbody tr [name=code_id]').find(":selected").text();
		var nah = opt.split(/(\s+\s+\s+\s+)/);
		$('table tbody tr [name=_code_id_edit]').val(nah[0]);
	});
	$('body').on("keyup",'tr [name=_code_id_edit]',function(e){
		if(e.keyCode == 13){
		var value = $(this).val();
		value = value.toUpperCase();
		var opt;
		$('table tbody tr [name=code_id] option:contains('+value+')').prop({selected: true});
		opt = $('table tbody tr [name=code_id]').find(":selected").text();
		$('table tbody tr #_code_id_sel span.filter-option').html(opt);
		$('#d-id').remove();
		$('table tbody tr #AddItem').removeAttr('disabled');
		}
	});

	/*autocomplete*/

	$('body').on('keyup','[name=_code_id_edit]',function(e){
		if(e.keyCode != 13){
			var value = $(this).val();
			if(value !=''){
			var res;
			value = value.toUpperCase();
			// var opt;
			var options = $('table tbody tr [name=code_id] option');
			var values = $.map(options ,function(option) {
			    return option.value+'%'+option.text ;
			});
			var sel;
			var relevantSelects = [];
			for(var z=0; z<values.length; z++){
			     sel = values[z];
			     if(sel.indexOf(value) === 0){
			         relevantSelects.push(sel);
			     }
			}
			var html =  '<div class=syncard-dropdown id=d-id>'+
							'<ul>';
								for(var a = 0; a < relevantSelects.length; a++){
									var nah = relevantSelects[a].split('%');
									html = html + '<li syncard-id='+nah[0]+'>'+nah[1]+'</li>';
								}
							html = html + '</ul></div>';
			$('table tbody tr [name=_code_id_edit]').parent().attr('style','position:relative');
			$('#d-id').remove();
			$('table tbody tr [name=_code_id_edit]').parent().append(html);
			}else{
			$('#d-id').remove();
			}
		}
	});

	$('body').on('click','#d-id li',function(){
		var value = $(this).attr('syncard-id');
		$('table tbody tr [name=_code_id_edit]').val(value);
		var opt;
		$('table tbody tr [name=code_id] option:contains('+value+')').prop({selected: true});
		opt = $('table tbody tr [name=code_id]').find(":selected").text();
		$('table tbody tr #_code_id_sel span.filter-option').html(opt);
		$('#d-id').remove();
		$('table tbody tr #AddItem').removeAttr('disabled');
	});
}

function getAllLanguage(){
	/*see data from cookie*/
	/*get lang from csv*/
	// allText = localStorage['visited'];
	// if(!allText){

	base_url = window.location.origin;
	 $.ajax({
       	//url: base_url+'/assets/lang/vocab.csv',
        url: 'https://docs.google.com/spreadsheets/d/e/2PACX-1vTcrfEd2hJCdSjtUWznLj_D_b1tF8IY-80BXEbgV-A52ORqsbN9vpWuhxRqaT1M90H8l5qKHvCHgPCl/pub?gid=0&single=true&output=tsv',
	type: 'GET',
        dataType : 'text',
        async: false,
        success: function (data){
            // localStorage['visited'] = data;
            allText = data;
        }
    });
	// }

	splitText = allText.split('\n');
	var flag = splitText[0].split('\t');
	var def_lang = $('[name="lang_session"]').val();
	// if (def_lang == null){def_lang=''}
	for(var a = 0; a < flag.length; a++){
		if(a == def_lang){
			$('#selLang').append('<option  selected value='+ a +'>'+ flag[a] + '</option>');
		}else{
			$('#selLang').append('<option value='+ a +'>'+ flag[a] + '</option>');
		}

		if(a == $('[name="default_language"]').val()){
			$('[name="coy_def_language"]').append('<option selected value='+ a +'>'+ flag[a] + '</option>');
		}else{
			$('[name="coy_def_language"]').append('<option value='+ a +'>'+ flag[a] + '</option>');
		}
	}
	// $('[name="select_language"] option[value="2"]').prop('selected',true);
	var lang_cookie = r_getCookie('uniq365_langIndex');
	if(lang_cookie == ''){
		processLang(def_lang);
		// console.log(def_lang);
		return false;
	}else{
		processLang(lang_cookie);
		// console.log(lang_cookie);
		return false;
	}
}

function selLang(){
	$( 'body').on('change','#selLang', function(){
		var ie = $(this).val();
		processLang(ie);
		return false;
	});
}

function processLang(newLang){
	if(newLang==''){newLang = 0}
	var withFind = [];
	var nah = [];
	var withFindText = [];
	var indexNa;
	var str = '';
	var splitSplitText = [];
	var ini = [];
	var newText = [];
	var oldText = [];
	var oldTextSort = [];
	var lastLang = r_getCookie('uniq365_langIndex');
	if(lastLang == ''){lastLang = 0}
	lastLang = (newLang == lastLang) ? 0 : lastLang;

	splitText = allText.split('\n');
	for(var a = 1; a < splitText.length -1 ; a++){
		tempString = splitText[a].split('\t');
		splitSplitText.push(tempString);
	}

	for(var b = 0; b < splitSplitText.length; b++){
		if(splitSplitText[b][lastLang].trim() == ''  || splitSplitText[b][newLang].trim() == '' || splitSplitText[b][newLang].trim() == null){
			temp = newLang;
			tempLast = lastLang;
			if(splitSplitText[b][lastLang].trim() == '') { lastLang = 0; }
			if(splitSplitText[b][newLang].trim() == '' || splitSplitText[b][newLang].trim() == null) { newLang = 0; }
			tempSringLang = splitSplitText[b][lastLang];
			tempNewSringLang = splitSplitText[b][newLang];
			newLang = temp;
			lastLang = tempLast;
			oldText.push(tempSringLang);
			newText.push(tempNewSringLang);

		}else{
			tempSringLang = splitSplitText[b][lastLang];
			tempNewSringLang = splitSplitText[b][newLang];
			oldText.push(tempSringLang);
			oldTextSort.push(tempSringLang);
			newText.push(tempNewSringLang);
		}
	}
	oldTextSort.sort(function (a,b){
		return b.length - a.length;
	});

	withFind = $('[synlang=syncard-language]');
	// if(!withFind)
		for(var a = 0; a < withFind.length; a++){
			// console.log(withFind.text());
			withFindText.push(withFind.eq(a).html());
		}
		for(var b = 0; b < withFindText.length; b++){
			indexNa = oldText.indexOf(withFindText[b].trim());
				$( "[synlang=syncard-language]:eq("+b+")" ).html(newText[indexNa]);
		// nah.push(newText[indexNa]);
		}
		// var ininih = $("[name=syncard-language]:eq(0)").html();
		// console.log(ininih);

	if(newLang == 1){
		// document.body.innerHTML = document.body.innerHTML.replace('To', 'Hingga');
		document.body.innerHTML = document.body.innerHTML.replace('No records', 'Data kosong');
	}

	$("#selLang").val(newLang);
	r_setCookie('uniq365_langIndex', newLang, 1);
	// loadingAnimation('remove');
	$("html").attr('style', 'opacity:1');
	// console.log('proses');
	return false;
}

function r_setCookie(cname,cvalue,exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function r_getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

var loadFile = function (url, callback) {
        JSZipUtils.getBinaryContent(url, callback);
    }
function print_out(data, front){
	var currentdate = new Date();
	var datetime = " Print @"+currentdate.getDate() + "-"
	+ (currentdate.getMonth()+1)  + "-"
	+ currentdate.getFullYear();

	loadFile("../company/words/"+data.template, function (err, content) {
        if (err) {
            throw e
        };
        console.log(content);
        doc = new Docxtemplater(content);
        doc.setData(data);
        doc.render()
        out = doc.getZip().generate({type: "blob"})
        saveAs(out, front+datetime+".docx")
    });
}

function print_invoice(){
	var print_data;
	$('#btninvoice').click(function(){
		var datasend = new FormData();
        datasend.append('PARAM_0', $("[name='PARAM_0']").val());
        datasend.append('PARAM_1', $("[name='PARAM_1']").val());
        datasend.append('PARAM_2', $("[name='PARAM_2']").val());
        datasend.append('PARAM_3', $("[name='PARAM_3']").val());
        datasend.append('PARAM_4', $("[name='PARAM_4']").val());
        datasend.append('PARAM_5', $("[name='PARAM_5']").val());
        datasend.append('PARAM_6', $("[name='PARAM_6']").val());
        datasend.append('PARAM_7', $("[name='PARAM_7']").val());
        datasend.append('PARAM_8', $("[name='PARAM_8']").val());
        datasend.append('PARAM_9', $("[name='PARAM_9']").val());
        datasend.append('PARAM_10', $("[name='PARAM_10']").val());

        $.ajax({
            url: "../report/report/print_invoice",
            type: "POST",
            data: datasend,
            processData: false,
            contentType: false,
            dataType:"json",
            async : false,
            success: function(data){
            	console.log(data);
            	if (data == "no data"){
            		window.alert("data not found!");
            	}else{
            		if (data.template === "null"){
		        		var currentdate = new Date();
						var datetime = " Print @"+currentdate.getDate() + "-"
						+ (currentdate.getMonth()+1)  + "-"
						+ currentdate.getFullYear();
						var front = "Tax Invoice";

						loadFile("../company/words/template/tax_invoice_default.docx", function (err, content) {
					        if (err) {
					            throw e
					        };
					        console.log(content);
					        doc = new Docxtemplater(content);
					        doc.setData(data);
					        doc.render()
					        out = doc.getZip().generate({type: "blob"})
					        saveAs(out, front+datetime+".docx")
					    });
		        	}else{
		        		var front = "Tax Invoice";
		        		print_out(data, front);
		        	}
            	}
            },
            complete: function(xhr,status) { },
            error: function(xhr,status,error) { console.log(xhr) }
        });

        return false;
	});
}

function print_creditnote(){
	$('#btncreditnote').click(function(){
		var datasend = new FormData();
        datasend.append('PARAM_0', $("[name='PARAM_0']").val());
        datasend.append('PARAM_1', $("[name='PARAM_1']").val());
        datasend.append('PARAM_2', $("[name='PARAM_2']").val());
        datasend.append('PARAM_3', $("[name='PARAM_3']").val());
        datasend.append('PARAM_4', $("[name='PARAM_4']").val());
        datasend.append('PARAM_5', $("[name='PARAM_5']").val());
        datasend.append('PARAM_6', $("[name='PARAM_6']").val());
        datasend.append('PARAM_7', $("[name='PARAM_7']").val());
        datasend.append('PARAM_8', $("[name='PARAM_8']").val());
        datasend.append('PARAM_9', $("[name='PARAM_9']").val());
        datasend.append('PARAM_10', $("[name='PARAM_10']").val());

        $.ajax({
            url: "../report/report/print_creditnote",
            type: "POST",
            data: datasend,
            processData: false,
            contentType: false,
            dataType:"json",
            async : false,
            success: function(data){
            	console.log(data);
            	if (data == "no data"){
            		window.alert("data not found!");
            	}else{
            		if(data.template === "null"){
            			var currentdate = new Date();
						var datetime = " Print @"+currentdate.getDate() + "-"
						+ (currentdate.getMonth()+1)  + "-"
						+ currentdate.getFullYear();
						var front = "CreditNote";

						loadFile("../company/words/template/credit_note_default.docx", function (err, content) {
					        if (err) {
					            throw e
					        };
					        console.log(content);
					        doc = new Docxtemplater(content);
					        doc.setData(data);
					        doc.render()
					        out = doc.getZip().generate({type: "blob"})
					        saveAs(out, front+datetime+".docx")
					    });
            		}else{
            			var front = "CreditNote, ";
		        		print_out(data, front);
		        	}
            	}
            },
            complete: function(xhr,status) { },
            error: function(xhr,status,error) { console.log(xhr) }
        });

        return false;
	});
}

function print_deliverynote(){
	$('#btndeliverynote').click(function(){
		var datasend = new FormData();
        datasend.append('PARAM_0', $("[name='PARAM_0']").val());
        datasend.append('PARAM_1', $("[name='PARAM_1']").val());
        datasend.append('PARAM_2', $("[name='PARAM_2']").val());
        datasend.append('PARAM_3', $("[name='PARAM_3']").val());
        datasend.append('PARAM_4', $("[name='PARAM_4']").val());
        datasend.append('PARAM_5', $("[name='PARAM_5']").val());
        datasend.append('PARAM_6', $("[name='PARAM_6']").val());
        datasend.append('PARAM_7', $("[name='PARAM_7']").val());
        datasend.append('PARAM_8', $("[name='PARAM_8']").val());
        datasend.append('PARAM_9', $("[name='PARAM_9']").val());
        datasend.append('PARAM_10', $("[name='PARAM_10']").val());

        $.ajax({
            url: "../report/report/print_deliverynote",
            type: "POST",
            data: datasend,
            processData: false,
            contentType: false,
            dataType:"json",
            async : false,
            success: function(data){
            	console.log(data);
            	if (data == "no data"){
            		window.alert("data not found!");
            	}else{
            		if(data.template === "null"){
            			var currentdate = new Date();
						var datetime = " Print @"+currentdate.getDate() + "-"
						+ (currentdate.getMonth()+1)  + "-"
						+ currentdate.getFullYear();
						var front = "DeliveryNote, ";

						loadFile("../company/words/template/delivery_note_default.docx", function (err, content) {
					        if (err) {
					            throw e
					        };
					        console.log(content);
					        doc = new Docxtemplater(content);
					        doc.setData(data);
					        doc.render()
					        out = doc.getZip().generate({type: "blob"})
					        saveAs(out, front+datetime+".docx")
					    });
            		}else{
	            		var front = "DeliveryNote, ";
			        	print_out(data, front);

            		}
            	}

            },
            complete: function(xhr,status) { },
            error: function(xhr,status,error) { console.log(xhr) }
        });

        return false;
	});
}

function print_statements(){
	$('#btnstate').click(function(){
		var datasend = new FormData();
        datasend.append('customer', $("[name='customer']").val());
        datasend.append('start_date', $("[name='start_date']").val());
        datasend.append('end_date', $("[name='end_date']").val());
        datasend.append('currency', $("[name='currency']").val());
        datasend.append('report_type', $("[name='report_type']").val());
        datasend.append('show_allocated', $("[name='show_allocated']").val());
        datasend.append('email', $("[name='email']").val());
        datasend.append('comments', $("[name='comments']").val());
        datasend.append('orientation', $("[name='orientation']").val());

        $.ajax({
            url: "../../report/report/print_statements",
            type: "POST",
            data: datasend,
            processData: false,
            contentType: false,
            dataType:"json",
            async : false,
            success: function(data){
            	console.log(data);
            	var currentdate = new Date();
				var datetime = " Print @"+currentdate.getDate() + "-"
				+ (currentdate.getMonth()+1)  + "-"
				+ currentdate.getFullYear();

            	if (data == "no customer"){
            		window.alert("No Selected Customer!");
            	}else if (data == "no data"){
            		window.alert("data not found!");
            	}else{

            		if(data.template === "null"){
						var front = "StatementsAccount, ";
						loadFile("../../company/words/template/statement_account_default.docx", function (err, content) {
					        if (err) {
					            throw e
					        };
					        console.log(content);
					        doc = new Docxtemplater(content);
					        doc.setData(data);
					        doc.render()
					        out = doc.getZip().generate({type: "blob"})
					        saveAs(out, front+datetime+".docx")
					    });
            		}else{
	            		var front = "StatementsAccount, ";
		            	loadFile("../../company/words/"+data.template, function (err, content) {
					        if (err) {
					            throw e
					        };
					        doc = new Docxtemplater(content);
					        doc.setData(data);
					        doc.render()
					        out = doc.getZip().generate({type: "blob"})
					        saveAs(out, front+datetime+".docx")
					    });

            		}
            	}


            },
            complete: function(xhr,status) { },
            error: function(xhr,status,error) {
            	console.log(xhr);
            }
        });

        return false;
	});
}

function print_salesorder() {
	$('#btnsalesorder').click(function(){
		var datasend = new FormData();
        datasend.append('PARAM_0', $("[name='PARAM_0']").val());
        datasend.append('PARAM_1', $("[name='PARAM_1']").val());
        datasend.append('PARAM_2', $("[name='PARAM_2']").val());
        datasend.append('PARAM_3', $("[name='PARAM_3']").val());
        datasend.append('PARAM_4', $("[name='PARAM_4']").val());
        datasend.append('PARAM_5', $("[name='PARAM_5']").val());
        datasend.append('PARAM_6', $("[name='PARAM_6']").val());
        datasend.append('PARAM_7', $("[name='PARAM_7']").val());
        datasend.append('PARAM_8', $("[name='PARAM_8']").val());
        datasend.append('PARAM_9', $("[name='PARAM_9']").val());
        datasend.append('PARAM_10', $("[name='PARAM_10']").val());

        $.ajax({
            url: "../report/report/print_salesorder",
            type: "POST",
            data: datasend,
            processData: false,
            contentType: false,
            dataType:"json",
            async : false,
            success: function(data){
            	console.log(data);
            	if (data == "no data"){
            		window.alert("data not found!");
            	}else{
            		if(data.template === "null"){
            			var currentdate = new Date();
						var datetime = " Print @"+currentdate.getDate() + "-"
						+ (currentdate.getMonth()+1)  + "-"
						+ currentdate.getFullYear();
						var front = "SalesOrder, ";

						loadFile("../company/words/template/sales_order_default.docx", function (err, content) {
					        if (err) {
					            throw e
					        };
					        console.log(content);
					        doc = new Docxtemplater(content);
					        doc.setData(data);
					        doc.render()
					        out = doc.getZip().generate({type: "blob"})
					        saveAs(out, front+datetime+".docx")
					    });
            		}else{
	            		var front = "SalesOrder, ";
			        	print_out(data, front);

            		}
            	}

            },
            complete: function(xhr,status) { },
            error: function(xhr,status,error) { console.log(xhr) }
        });

        return false;
	});
}

function print_salesquot() {
	$('#btnsalesquot').click(function(){
		var datasend = new FormData();
        datasend.append('PARAM_0', $("[name='PARAM_0']").val());
        datasend.append('PARAM_1', $("[name='PARAM_1']").val());
        datasend.append('PARAM_2', $("[name='PARAM_2']").val());
        datasend.append('PARAM_3', $("[name='PARAM_3']").val());
        datasend.append('PARAM_4', $("[name='PARAM_4']").val());
        datasend.append('PARAM_5', $("[name='PARAM_5']").val());
        datasend.append('PARAM_6', $("[name='PARAM_6']").val());
        datasend.append('PARAM_7', $("[name='PARAM_7']").val());
        datasend.append('PARAM_8', $("[name='PARAM_8']").val());
        datasend.append('PARAM_9', $("[name='PARAM_9']").val());
        datasend.append('PARAM_10', $("[name='PARAM_10']").val());

        $.ajax({
            url: "../report/report/print_salesquot",
            type: "POST",
            data: datasend,
            processData: false,
            contentType: false,
            dataType:"json",
            async : false,
            success: function(data){
            	console.log(data);
            	if (data == "no data"){
            		window.alert("data not found!");
            	}else{
            		if(data.template === "null"){
            			var currentdate = new Date();
						var datetime = " Print @"+currentdate.getDate() + "-"
						+ (currentdate.getMonth()+1)  + "-"
						+ currentdate.getFullYear();
						var front = "SalesQuotation, ";

						loadFile("../company/words/template/sales_quotation_default.docx", function (err, content) {
					        if (err) {
					            throw e
					        };
					        console.log(content);
					        doc = new Docxtemplater(content);
					        doc.setData(data);
					        doc.render()
					        out = doc.getZip().generate({type: "blob"})
					        saveAs(out, front+datetime+".docx")
					    });
            		}else{
	            		var front = "SalesQuotation, ";
			        	print_out(data, front);

            		}
            	}

            },
            complete: function(xhr,status) { },
            error: function(xhr,status,error) { console.log(xhr) }
        });

        return false;
	});
}

function print_payment() {
	$('#btnpayment').click(function(){
		var datasend = new FormData();
        datasend.append('PARAM_0', $("[name='PARAM_0']").val());
        datasend.append('PARAM_1', $("[name='PARAM_1']").val());
        datasend.append('PARAM_2', $("[name='PARAM_2']").val());
        datasend.append('PARAM_3', $("[name='PARAM_3']").val());
        datasend.append('PARAM_4', $("[name='PARAM_4']").val());
        datasend.append('PARAM_5', $("[name='PARAM_5']").val());
        datasend.append('PARAM_6', $("[name='PARAM_6']").val());
        datasend.append('PARAM_7', $("[name='PARAM_7']").val());
        datasend.append('PARAM_8', $("[name='PARAM_8']").val());
        datasend.append('PARAM_9', $("[name='PARAM_9']").val());
        datasend.append('PARAM_10', $("[name='PARAM_10']").val());

        $.ajax({
            url: "../report/report/print_payment",
            type: "POST",
            data: datasend,
            processData: false,
            contentType: false,
            dataType:"json",
            async : false,
            success: function(data){
            	console.log(data);
            	if (data == "no data"){
            		window.alert("data not found!");
            	}else{
            		if(data.template === "null"){
            			var currentdate = new Date();
						var datetime = " Print @"+currentdate.getDate() + "-"
						+ (currentdate.getMonth()+1)  + "-"
						+ currentdate.getFullYear();
						var front = "Payment, ";

						loadFile("../company/words/template/payment_recipt_default.docx", function (err, content) {
					        if (err) {
					            throw e
					        };
					        console.log(content);
					        doc = new Docxtemplater(content);
					        doc.setData(data);
					        doc.render()
					        out = doc.getZip().generate({type: "blob"})
					        saveAs(out, front+datetime+".docx")
					    });
            		}else{
	            		var front = "Payment, ";
			        	print_out(data, front);

            		}
            	}

            },
            complete: function(xhr,status) { },
            error: function(xhr,status,error) { console.log(xhr) }
        });

        return false;
	});
}

function print_purchaseorder() {
	$('#btnpurchaseorder').click(function(){
		var datasend = new FormData();
        datasend.append('PARAM_0', $("[name='PARAM_0']").val());
        datasend.append('PARAM_1', $("[name='PARAM_1']").val());
        datasend.append('PARAM_2', $("[name='PARAM_2']").val());
        datasend.append('PARAM_3', $("[name='PARAM_3']").val());
        datasend.append('PARAM_4', $("[name='PARAM_4']").val());
        datasend.append('PARAM_5', $("[name='PARAM_5']").val());
        datasend.append('PARAM_6', $("[name='PARAM_6']").val());
        datasend.append('PARAM_7', $("[name='PARAM_7']").val());
        datasend.append('PARAM_8', $("[name='PARAM_8']").val());
        datasend.append('PARAM_9', $("[name='PARAM_9']").val());
        datasend.append('PARAM_10', $("[name='PARAM_10']").val());

        $.ajax({
            url: "../report/report/print_purchaseorder",
            type: "POST",
            data: datasend,
            processData: false,
            contentType: false,
            dataType:"json",
            async : false,
            success: function(data){
            	console.log(data);
            	if (data == "no data"){
            		window.alert("data not found!");
            	}else{
            		if(data.template === "null"){
            			var currentdate = new Date();
						var datetime = " Print @"+currentdate.getDate() + "-"
						+ (currentdate.getMonth()+1)  + "-"
						+ currentdate.getFullYear();
						var front = "Purchase Order, ";

						loadFile("../company/words/template/purchase_order_default.docx", function (err, content) {
					        if (err) {
					            throw e
					        };
					        console.log(content);
					        doc = new Docxtemplater(content);
					        doc.setData(data);
					        doc.render()
					        out = doc.getZip().generate({type: "blob"})
					        saveAs(out, front+datetime+".docx")
					    });
            		}else{
            		var front = "Purchase Order, ";
	            	print_out(data, front);

            		}
            	}

            },
            complete: function(xhr,status) { },
            error: function(xhr,status,error) { console.log(xhr) }
        });

        return false;
	});
}

function print_remittance() {
	$('#btnremittance').click(function(){
		var datasend = new FormData();
        datasend.append('PARAM_0', $("[name='PARAM_0']").val());
        datasend.append('PARAM_1', $("[name='PARAM_1']").val());
        datasend.append('PARAM_2', $("[name='PARAM_2']").val());
        datasend.append('PARAM_3', $("[name='PARAM_3']").val());
        datasend.append('PARAM_4', $("[name='PARAM_4']").val());
        datasend.append('PARAM_5', $("[name='PARAM_5']").val());
        datasend.append('PARAM_6', $("[name='PARAM_6']").val());
        datasend.append('PARAM_7', $("[name='PARAM_7']").val());
        datasend.append('PARAM_8', $("[name='PARAM_8']").val());
        datasend.append('PARAM_9', $("[name='PARAM_9']").val());
        datasend.append('PARAM_10', $("[name='PARAM_10']").val());

        $.ajax({
            url: "../report/report/print_remittance",
            type: "POST",
            data: datasend,
            processData: false,
            contentType: false,
            dataType:"json",
            async : false,
            success: function(data){
            	console.log(data);
            	if (data == "no data"){
            		window.alert("data not found!");
            	}else{
            		if(data.template === "null"){
            			var currentdate = new Date();
						var datetime = " Print @"+currentdate.getDate() + "-"
						+ (currentdate.getMonth()+1)  + "-"
						+ currentdate.getFullYear();
						var front = "Remittance, ";

						loadFile("../company/words/template/remittance_default.docx", function (err, content) {
					        if (err) {
					            throw e
					        };
					        console.log(content);
					        doc = new Docxtemplater(content);
					        doc.setData(data);
					        doc.render()
					        out = doc.getZip().generate({type: "blob"})
					        saveAs(out, front+datetime+".docx")
					    });
            		}else{
	            		var front = "Remittance, ";
		            	print_out(data, front);

            		}
            	}

            },
            complete: function(xhr,status) { },
            error: function(xhr,status,error) { console.log(xhr) }
        });

        return false;
	});
}

function print_paymentvoucher() {
	$('#btn801').click(function(){
		var datasend = new FormData();
        datasend.append('start_date', $("[name='start_date']").val());
        datasend.append('end_date', $("[name='end_date']").val());
        datasend.append('account', $("[name='account']").val());
        datasend.append('ref', $("[name='ref']").val());
        datasend.append('comment', $("[name='comment']").val());
        datasend.append('type', $("[name='type']").val());
        datasend.append('PARAM_0', $("[name='PARAM_0']").val());
        datasend.append('trans_no', $("[name='trans_no']").val());

        $.ajax({
            url: "../report/report/print_paymentvoucher",
            type: "POST",
            data: datasend,
            processData: false,
            contentType: false,
            dataType:"json",
            async : false,
            success: function(data){
            	console.log(data);
            	if (data == "no data"){
            		window.alert("data not found!");
            	}else{
            		if(data.template === "null"){
            			var currentdate = new Date();
						var datetime = " Print @"+currentdate.getDate() + "-"
						+ (currentdate.getMonth()+1)  + "-"
						+ currentdate.getFullYear();
						var front = "PaymentVoucher, ";

						loadFile("../company/words/template/bank_payment_voucher_default.docx", function (err, content) {
					        if (err) {
					            throw e
					        };
					        console.log(content);
					        doc = new Docxtemplater(content);
					        doc.setData(data);
					        doc.render()
					        out = doc.getZip().generate({type: "blob"})
					        saveAs(out, front+datetime+".docx")
					    });
            		}else{
	            		var front = "PaymentVoucher, ";
			        	print_out(data, front);

            		}
            	}

            },
            complete: function(xhr,status) { },
            error: function(xhr,status,error) { console.log(xhr) }
        });

        return false;
	});
}

function print_depositvoucher() {
	$('#btn802').click(function(){
		var datasend = new FormData();
        datasend.append('start_date', $("[name='start_date']").val());
        datasend.append('end_date', $("[name='end_date']").val());
        datasend.append('account', $("[name='account']").val());
        datasend.append('ref', $("[name='ref']").val());
        datasend.append('comment', $("[name='comment']").val());
        datasend.append('type', $("[name='type']").val());
        datasend.append('PARAM_0', $("[name='PARAM_0']").val());
        datasend.append('trans_no', $("[name='trans_no']").val());

        $.ajax({
            url: "../report/report/print_depositvoucher",
            type: "POST",
            data: datasend,
            processData: false,
            contentType: false,
            dataType:"json",
            async : false,
            success: function(data){
            	console.log("deposit");
            	console.log(data);
            	if (data == "no data"){
            		window.alert("data not found!");
            	}else{
            		if(data.template === "null"){
            			var currentdate = new Date();
						var datetime = " Print @"+currentdate.getDate() + "-"
						+ (currentdate.getMonth()+1)  + "-"
						+ currentdate.getFullYear();
						var front = "DepositVoucher, ";

						loadFile("../company/words/template/bank_deposit_voucher_default.docx", function (err, content) {
					        if (err) {
					            throw e
					        };
					        console.log(content);
					        doc = new Docxtemplater(content);
					        doc.setData(data);
					        doc.render()
					        out = doc.getZip().generate({type: "blob"})
					        saveAs(out, front+datetime+".docx")
					    });
            		}else{
	            		var front = "DepositVoucher, ";
			        	print_out(data, front);

            		}
            	}

            },
            complete: function(xhr,status) { },
            error: function(xhr,status,error) { console.log(xhr) }
        });

        return false;
	});
}

function print_transfervoucher() {
	$('#btn803').click(function(){
		var datasend = new FormData();
        datasend.append('start_date', $("[name='start_date']").val());
        datasend.append('end_date', $("[name='end_date']").val());
        datasend.append('account', $("[name='account']").val());
        datasend.append('ref', $("[name='ref']").val());
        datasend.append('comment', $("[name='comment']").val());
        datasend.append('type', $("[name='type']").val());
        datasend.append('PARAM_0', $("[name='PARAM_0']").val());
        datasend.append('trans_no', $("[name='trans_no']").val());

        $.ajax({
            url: "../report/report/print_transfervoucher",
            type: "POST",
            data: datasend,
            processData: false,
            contentType: false,
            dataType:"json",
            async : false,
            success: function(data){
            	console.log("transfer");
            	console.log(data);
            	if (data == "no data"){
            		window.alert("data not found!");
            	}else{
            		if(data.template === "null"){
            			var currentdate = new Date();
						var datetime = " Print @"+currentdate.getDate() + "-"
						+ (currentdate.getMonth()+1)  + "-"
						+ currentdate.getFullYear();
						var front = "TransferVoucher, ";

						loadFile("../company/words/template/bank_transfer_voucher_default.docx", function (err, content) {
					        if (err) {
					            throw e
					        };
					        console.log(content);
					        doc = new Docxtemplater(content);
					        doc.setData(data);
					        doc.render()
					        out = doc.getZip().generate({type: "blob"})
					        saveAs(out, front+datetime+".docx")
					    });
            		}else{
	            		var front = "TransferVoucher, ";
			        	print_out(data, front);

            		}
            	}

            },
            complete: function(xhr,status) { },
            error: function(xhr,status,error) { console.log(xhr) }
        });

        return false;
	});
}

function print_reconcile(){
	$('#btnreconcile').click(function(){
		var datasend = new FormData();
        datasend.append('bank_account', $("[name='bank_account']").val());
        datasend.append('reconcile_date', $("[name='reconcile_date']").val());
        datasend.append('orientation', $("[name='orientation']").val());

        $.ajax({
            url: "../../report/report/print_reconcile",
            type: "POST",
            data: datasend,
            processData: false,
            contentType: false,
            dataType:"json",
            async : false,
            success: function(data){
            	console.log(data);
            	var front = "BankReconcile, ";

            	var currentdate = new Date();
				var datetime = " Print @"+currentdate.getDate() + "-"
				+ (currentdate.getMonth()+1)  + "-"
				+ currentdate.getFullYear();

            	if (data == "no data"){
            		window.alert("Please Select Bank Account!");
            	}else{
            		if (data.template === "null"){
            			loadFile("../../company/words/template/bank_reconcile_default.docx", function (err, content) {
					        if (err) {
					            throw e
					        };
					        doc = new Docxtemplater(content);
					        doc.setData(data);
					        doc.render();
					        out = doc.getZip().generate({
					        	type: "blob",
					        });
					        saveAs(out, front+datetime+".pdf");
					    });

            		}else{
            			loadFile("../../company/words/"+data.template, function (err, content) {
					        if (err) {
					            throw e
					        };
					        doc = new Docxtemplater(content);
					        doc.setData(data);
					        doc.render()
					        out = doc.getZip().generate({type: "blob"})
					        saveAs(out, front+datetime+".docx")
					    });
            		}
            	}
            },
            complete: function(xhr,status) { },
            error: function(xhr,status,error) {
            	console.log(xhr);
            }
        });

        return false;
	});
}

//----------------------------------- limit login area ------------------------------------------

function update_time_login(){
	// base_url = window.location.origin;
    setInterval(function() {
		base_url = window.location.origin;
		var ajaxRequest;
		var values = $('.username').html();

		$.ajax({
	        url: base_url+"/admin/users.php",
	        type: "post",
	        data: {data : values, call : 'update_time_useronline'} ,
	        success: function (response) {
	        	// you will get response from your php page (what you echo or print)
	        	// console.log(response);
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	           console.log(textStatus, errorThrown);
	        }

	    });
	}, 10000);
	// console.log(values);
}
function log_out_useronline(){

	$('body').on('click','[name="log_out"]', function(){
		base_url = window.location.origin;
		var ajaxRequest;
		var values = $('.username').html();

		$.ajax({
	        url: base_url+"/admin/users.php",
	        type: "post",
	        data: {data : values, call : 'logout_time_useronline'} ,
	        success: function (response) {
	        	// you will get response from your php page (what you echo or print)
	        	// console.log(response);
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	           console.log(textStatus, errorThrown);
	        }

	    });
	});
}


function dropdown_search(){
	// $("body").on('click', '#dropdown_search', function(){
 //        $(".dropdown_search").slideToggle();
 //        // console.log('asdf');
 //    });
 	$("body").on('click', '#dropdown_search', function(){
        $(".dropdown_search").toggle('slide');
        // console.log('asdf');
        if(table_flex == ''){
        	$('#table-flex').addClass('col-md-12');
        	$('#table-flex #dropdown_search span').html('Show search');
        	table_flex = '1';
        }else{
        	$('#table-flex').removeClass('col-md-12');
        	$('#table-flex #dropdown_search span').html('Hide search');
        	table_flex = '';
        }
        // console.log(table_flex);
    });
    // alert('asdf');

}
function dropdown_menu(){
	$('.dropdown-menu .dropdown-submenu').on("click", function(e){
	    $('.dropdown-menu .dropdown-submenu').removeClass('open');
	    $(this).toggleClass('open');
	    e.stopPropagation();
	    //e.preventDefault();
 	});
	$('body').on("click", function(e){
	    $('.dropdown-menu .dropdown-submenu').removeClass('open');
 	});
}

function filter_hack(){
	if($(".inquiry-filter").length > 0){
		var button =
		'<div class="sync-filter">' +
			'<button type="button" class="btn btn-xs" id="filterToggle">Show filter</button>' +
		'</div><div class="clearfix"></div>';
		$(".inquiry-filter").attr('style', "display:none");
		$(".page-head .container .page-title h1").append(button);

		$('#filterToggle').unbind().on('click', function(){
			show_filter();
		});
	}
	// else if($("[level=level_1].row").length > 0){
	// 	var button =
	// 	'<div class="col-xs-4 col-xs-offset-4 text-center margin-top margin-bottom" style="border-bottom:1px solid #CCC">' +
	// 		'<button type="button" class="btn btn-xs" id="filterToggle">Show filter</button>' +
	// 	'</div><div class="clearfix"></div>';
	// 	$("[level=level_1].row").attr('style', "display:none");
	// 	$("[level=level_1].row").before(button);

	// 	$('#filterToggle').unbind().on('click', function(){
	// 		show_filter_2();
	// 	});
	// }
}

function show_filter(){
	$(".inquiry-filter").slideToggle();
	if($("#filterToggle").html() == "Hide Filter"){
		$("#filterToggle").html("Show Filter");
	}else{
		$("#filterToggle").html("Hide Filter");
	}
}

function show_filter_2(){
	$("[level=level_1].row").slideToggle();
	if($("#filterToggle").html() == "Hide Filter"){
		$("#filterToggle").html("Hide Filter");
	}else{
		$("#filterToggle").html("Show Filter");
	}
}

//operation button hack
function operation_button_hack(){
		$("body").on('click', '.operation-button', function(){
			operation_modal_show($(this));
		});
}

function operation_modal_show(elem){

	$('.operation-modal').unbind().on('click', function(){
		operation_modal_hide();
	});

	$(elem).next().removeClass('active').addClass('active');
}

function operation_modal_hide(){
	$('.operation-modal').removeClass('active');
}


//function limit selectbox users
function selectlimit(){
	var a = window.location.pathname;
	var locat = a.split('/');
	var limit = $('#activelimit').val();

	if(locat[2] == "users.php" ){
		$('body').on('click', 'div .bootstrap-switch', function(){
			setTimeout(function(){
				var	checked = parseInt($('td input:checkbox:not(":checked")').length);
				if(checked >= limit){
					$('td input:checkbox:checked').attr('disabled',true);
				}
			},1000);
		});

		$('body').on('click','td [type=checkbox]' ,function(){
			var	numberOfChecked = parseInt($('td input:checkbox:not(":checked")').length);
			if( numberOfChecked >= limit){
				$('td input:checkbox:checked').attr('disabled',true);
			}else{
				$('td input:checkbox:checked').removeAttr('disabled');
			}

		});


	}
}

function selectOnQuotation(){

	$("body").on("change", "[name=customer_id]", function(){
		setTimeout(function(){
			$("[name=customer_id] option[value='']").html("Select Customer");
		},500);
		additemOnQuotation();
	});
}
function additemOnQuotation(){
	data  = $("[name=customer_id] option:selected").val();
	data2 = $("[name=stock_id] option:selected").val();
	if(data == "" || data2 == ""){
		setTimeout(function(){
			$('table #AddItem').attr('disabled',true);
		},700);
	}else{
		$('table tbody tr #AddItem').removeAttr('disabled');
	}
}

function selectOnTableQuotation(){

	$("[name=stock_id]").on("change", function(){
	// 	setTimeout(function(){
	// 		$("[name=stock_id]").prepend("<option value=''>Select Item</option>");
	// 	},500);
		additemOnQuotation();
	});
}


function pasloadQuotation(){
	// iki selectbox customer//
	$("[name=customer_id] option[value='']").html("Select Customer");

	// iki selecbox item desc //
	$("[name=stock_id] optgroup option").removeAttr("selected");
	$("[name=stock_id]").prepend("<option value='' selected></option>");

	// iki selectbox tax //
	$("[name=tax_type_id] optgroup option").removeAttr("selected");
	$("[name=tax_type_id]").prepend("<option value='' selected></option>");
}

// for modal view modal mobile
function viewmodal(data){
  console.log(data);
}
function createmodal(){
    $('form').append("<input type='hidden' name='dataid' id='dataid' value=0>");
    html = '<div id="modal1" class="modal">'+
            '<div class="modal-content">'+
            '<h4>Picture</h4>'+
            '<p></p>'+
            '</div>'+
            '<div class="modal-footer">'+
            '</div>'+
            '</div>'+

            '<div id="modal2" class="modal modal-fixed-footer">'+
            '<div class="modal-content">'+
            '<h4>Delete Data</h4>'+
            '<p>Do you want to delete this data?</p>'+
            '</div>'+
            '<div class="modal-footer">'+

            '</div>'+
            '</div>';
    $(".main").append(html);
}
function getdatapicture(){
  $(".showimage").on("click",function(e){
    // e.preventDefault();
    //  alert('it works!');
    //  return  false;
  var url = window.location.hostname;

  var url1 = window.location;
  var id = $(this).val();
     $.ajax({
          // url: "./bookkeepers/getdata",
          url: url1+"/getdata",
          type: 'POST',
          dataType : 'json',
          async: false,
          data:({
                  datana : id
          }),
          error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr);
          },
          success: function (data){
              $('#modal1 p').html("");
              $('#modal1 p').append("<img src='"+data+"'>");
              $(".modal").modal();
              $('#modal1').modal('open');
          }
      });
   });
}
function deletedatapicture(){
  $(".deletedata").on("click",function(e){
  var url = window.location.hostname;
  var url1 = window.location;
  var id = $(this).val();
  console.log("ada");
  var buttonna = '<a class="modal-close waves-effect waves-green btn-flat " onclick="deletedatapicture_exe('+id+')">yes</a>';
      $("#modal2 .modal-footer").html("");
      $("#modal2 .modal-footer").append(buttonna);
      $(".modal").modal();
      $("#modal2").modal("open");
   });
}
function deletedatapicture_exe(id){
  var url1 = window.location;
  $.ajax({
       // url: "./bookkeepers/getdata",
       url: url1+"/deldata",
       type: 'POST',
       dataType : 'json',
       async: false,
       data:({
               datana : id
       }),
       error: function (xhr, ajaxOptions, thrownError) {
         console.log(xhr);
       },
       success: function (data){
         if(data == 'ok'){
           location.reload();
         }
         // M.toast({html: 'I am a toast!'});
       }
   });
}
function input_fiscal_year(){
  $("[name=ok_fiscal_years]").on("click",function(){
  // var url = window.location.hostname;
  // var url1 = window.location;
  dbegin = $("[name=date-from]").val();
  dbegint = new Date(dbegin.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
  // dendt  = Date.parse(dend);
  dend = $("[name=date-end]").val();
  dendt = new Date(dend.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));

// change Format date
  dbegin_2 = dbegin.split("-");
  dbegin = dbegin_2[2] + "-" + dbegin_2[1] + "-" + dbegin_2[0];

  dend_2 = dend.split("-");
  dend = dend_2[2] + "-" + dend_2[1] + "-" + dend_2[0];
// change Format date end


  if(dbegint > dendt){
    $("[name=msg-alert]").html("BEGIN date cannot less than END date");
    console.log("gaboleh");
  }else if(dbegin == dend){
    $("[name=msg-alert]").html("BEGIN date and END date cannot be same");
    console.log("date cannot same");
  }else{
    $("[name=msg-alert]").html("");
     $.ajax({
          // url: "./bookkeepers/getdata",
          url: "./admin/fiscal_years/addfiscalyear",
          type: 'POST',
          dataType : 'json',
          async: false,
          data:{
                  d_begin : dbegin,
                  d_end   : dend
          },
          error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr);
          },
          success: function (data){
              console.log(data);
              // console.log("sok");
          }
      });
   }
     // console.log(dbegin+" "+dend);
  });
}

function finishsetup(){
  $("[name=finishsetup]").on("click", function(){
    $.ajax({
         // url: "./bookkeepers/getdata",
         url: "./admin/fiscal_years/updatecoafinish",
         type: 'GET',
         dataType : 'json',
         async: false,
         error: function (xhr, ajaxOptions, thrownError) {
           console.log(xhr);
         },
         success: function (data){
             console.log(data);
             if(data != null){
               $("[id=setup-wizard]").modal("close");
             }
             // console.log("sok");
         }
     });
  });
}
