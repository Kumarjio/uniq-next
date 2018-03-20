<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BankReport {

    function __construct() {
        $ci = get_instance();
        $this->ci = $ci;
        $this->db = $ci->db;

        if( !isset($ci->reporting) ){
            $ci->front_report = true;
            $ci->load_library('reporting');
        }

        $p =  $ci->load_library('pdf');
        $this->tcpdf = $p['tcpdf'];
        $this->pdf = $p;

        $this->bank_trans_model = module_model_load('trans','bank');
        $this->gl_trans_model = module_model_load('trans','gl');
        $this->report = module_control_load('report','report');
        $this->reconciled_model = module_model_load('reconciled','bank');
        $this->bank_account_model = module_model_load('account','bank');
    }
	
	// start new update-------------------------------------------------------------
    function reconcile(){


        if( $this->ci->input->post() ) {
            return $this->reconcile_print();
        }

        // $report = module_control_load(NULL,'report',true);
        $this->report->fields = array(
            'bank_account' => array('type'=>'BANK_ACCOUNTS','title'=>_('Account'),'value'=>null ),
            'reconcile_date' => array('type'=>'qdate','title'=>_('Reconcile Date'),'value'=>begin_month() ),
            'orientation'=>array('type'=>'orientation','title'=>_('Orientation')),
        );

        $this->report->form('Bank Reconcile');
    }

    function get_bank_account($id)
    {
        $result = $this->db->where('id',$id)->get('bank_accounts');
        if( !is_object($result) ){
            check_db_error("could not retreive bank account for", $this->db->last_query());
        } else {
            return $result->row();
        }
    }

    private function reconcile_print(){
        global $Ajax;
        // $destination = input_val('report_type');
        // $orientation = input_val('orientation');
        $bank_acc = input_val('bank_account');
        $reconcile_date = input_val('reconcile_date');
        
        if(input_val('orientation') == "portrait"){
            $orientation = "P";
        }else{
            $orientation = "L";

        }

        $comments = NULL;

        /*$this->bank_account_model->get_bank_account($bank_acc)*/
        $bank_reconcile = $this->reconciled_model->get_bank_account_reconcile($bank_acc, $reconcile_date,false);
        // $bank_account_detail = $this->db->where('id',$bank_acc)->get('bank_accounts')->row();
        $bank_account_detail = $this->get_bank_account($bank_acc);
        if( !is_object($bank_account_detail) OR empty($bank_account_detail) ){
            display_error('Please select Bank Account');
            // $Ajax->activate('bank_account');
            return;
        }
        // if ($destination)
        //     include_once(ROOT . "/reporting/includes/pdf_report.inc");
        // else
        include_once(ROOT . "/reporting/includes/pdf_report.inc");

        $params =   array( $comments, $bank_account_detail->bank_account_name." - ".$bank_account_detail->bank_curr_code);

        $this->rep = new FrontReport(_('BANK RECONCILIATION AS AT '.sql2date($reconcile_date)), "BankReconcile", user_pagesize(), 9, $orientation);

        $this->rep->SetHeaderType('BankReconcile');

        $this->reconcile_report_table['amount'][0] = $this->reconcile_report_table['total'][0] = curr_default();
        list ($headers, $cols, $aligns) = $this->report->report_front_params($this->reconcile_report_table);
        if ($orientation == 'L')
        recalculate_cols($cols);

        $this->rep->Font();
        $this->rep->Info($params, $cols, $headers, $aligns);
        $this->rep->NewPage();

        $summary =  $this->reconciled_model->get_max_reconciled($reconcile_date, $bank_acc);
        $total_check = ($summary->total);

        $this->rep->TextCol3(0, 3, _('Balance as per Bank Account'),1);
        $this->rep->TextCol(4, 5, number_total($summary->total));
        $this->rep->NewLine(2);
        $this->rep->TextCol3(0, 3, _('ADD: Unpresendted Cheque'),1);

        $credit_amount = 0;
        if( count($bank_reconcile) > 0 ) foreach ($bank_reconcile AS $k=>$tran){

            if($tran->amount < 0){
                $this->rep->NewLine();
                $credit_amount += abs($tran->amount);
                $this->reconcile_print_line($tran);
                unset($bank_reconcile[$k]);
            }
        }

        $this->rep->NewLine(1);
        $this->rep->TextNum(4, 5,$credit_amount);
        $this->rep->UnderlineCell(4,5);
        $this->rep->NewLine(2);
        $this->rep->TextNum(4, 5,$total_check += $credit_amount);

        $this->rep->NewLine(1);
        $this->rep->TextCol3(0, 3, _('LESS: Deposit not credited by Bank'),1);

        $debit_amount = 0;
        if( count($bank_reconcile) > 0 ) foreach ($bank_reconcile AS $k=>$tran){

            if($tran->amount > 0){
                $this->rep->NewLine();
                $debit_amount += abs($tran->amount);
                $this->reconcile_print_line($tran);
                unset($bank_reconcile[$k]);
            }
        }
        $this->rep->NewLine();
        $this->rep->TextNum(4, 5,$debit_amount);
        $this->rep->UnderlineCell(4,5);
        $this->rep->NewLine(2);
        $this->rep->TextCol3(0, 3, _('Balance as per Bank statement'),1);
        $this->rep->TextNum(4, 5,$total_check -= $debit_amount);

        $this->rep->NewLine();
        $this->rep->End();
        die();
    }

    var $reconcile_report_table = array(
        'trans_date'            =>array( '',60 ,'left'),
        'cheque'                =>array( '',120 ,'left'),
        'payment_person_name'   =>array( '',400 ,'left'),
        'amount'                =>array( 'amount',450 ,'right'),
        'total'                 =>array( 'total',550 ,'right'),

    );

    private function reconcile_print_line($row){
        $col = 0;
        foreach ($this->reconcile_report_table AS $k=>$val){
            $txt = NULL;
            switch ($k){
                case 'payment_person_name':
                    $txt = payment_person_name($row->person_type_id,$row->person_id);
                    break;
                case 'debit':
                    $number = ( $row->amount > 0 ) ? $row->amount : 0;

                    $txt = $number > 0 ? number_total($number) : null;
                    break;
                case 'credit':
                    $number = ( $row->amount <0 ) ? abs($row->amount) : 0;
                    $txt = $number > 0 ? number_total($number) : null;
                    break;
                case 'amount':
                    $txt = strlen($row->amount) > 0 ? number_total($row->amount,true) : null;
                    break;
                default:
                    if( isset($row->$k) ){
                        $txt = $row->$k;
                    }
                    break;
            }
            if( $k=='trans_date' ){
                $this->rep->DateCol($col, $col += 1,$txt, true);
            } else {
                $this->rep->TextCol($col, $col += 1, $txt);
            }

        }
    }
    // end new update-------------------------------------------------------------

    function payment_print(){

        $trans_no = input_val('trans_no');
        if( !$trans_no ){
            $trans_no = input_val('PARAM_0');
        }

        $trans_type= ST_BANKPAYMENT;


        $trans = $this->bank_trans_model->get_bank_trans($trans_type, $trans_no);



        $tran_item = $trans[0];

        $html = '<table style="width: 100%;"><tr style="height: 70px"><td>'
            .( (isset($pdf->company['logo']) && $pdf->company['logo'] !='')? '<img src="' .$pdf->company['logo'].'" alt="A2000 solusion" height="50" border="0" >' : '<h2>'.$pdf->company['name'].'</h2>' )
        .'</td></tr><tr><td align="right"><h1 style="padding: 0; margin: 0;" >'.$pdf->title.'</h1></td></tr></table>';

        $this->tcpdf->header_bank_trans = $html;
        $this->tcpdf->bank_trans_data = array(
            'trans_date'=>$tran_item->trans_date,
            'trans_no'=>$tran_item->trans_no,
            'ref'=>$tran_item->ref,
//             'payee'=>null,

            'payment_from'=>$tran_item->bank_account_name,
        	'payment_to'=>null,

            'cheque'=>$tran_item->cheque,
        );

        switch ($tran_item->person_type_id) {
        	case 2:
        		$debtor_trans = $this->db->where(array('trans_no'=>$tran_item->trans_no, 'type'=>$trans_type))->get('debtor_trans')->row();
        		$customer = $this->customer_model->customer_detail($debtor_trans->debtor_no);
        		$this->tcpdf->bank_trans_data['payment_to'] = html_entity_decode($customer->debtor_ref);
        		$branch = $this->db->where(array('branch_code'=>$debtor_trans->branch_code))->get('cust_branch')->row();
        		if( $branch && isset($branch->br_name) ){
        			$this->tcpdf->bank_trans_data['payment_to'] .= ' / '.html_entity_decode($branch->branch_ref);
        		}
        		break;
        	case 3:
        		$suppliers = $this->db->where(array('supplier_id'=>$tran_item->person_id))->get('suppliers')->row();
        		if( $suppliers && isset($suppliers->supp_name) ){
        			$this->tcpdf->bank_trans_data['payment_to'] = html_entity_decode($suppliers->supp_name);
        		}
        		break;
        	default:
        		$pdf->tcpdf->bank_trans_data['payment_to'] = html_entity_decode($tran_item->person_id);
        		break;

        }

        if( $trans_type==ST_BANKDEPOSIT ){
        	$pay_to = $pdf->tcpdf->bank_trans_data['payment_to'];
        	$this->tcpdf->bank_trans_data['payment_to'] = $pdf->tcpdf->bank_trans_data['payment_from'];
        	$this->tcpdf->bank_trans_data['payment_from'] = $pay_to;
        }


        $this->tcpdf->item_table_header = '<table class="tablestyle" cellpadding=2 cellspacing=0>

        <tr>
        	<td class="tableheader textcenter" style="width: 20%;" >Account Code</td>
            <td class="tableheader textleft" style="width: 35%;" >Account Name</td>
            <td class="tableheader textright" style="width: 10%;" >Debit</td>
            <td class="tableheader textright" style="width: 10%;" >Credit</td>
            <td class="tableheader"  style="width: 25%;"  >Memo</td>
            </tr>
		</table>';

        $this->tcpdf->AddPage();

        $gl_trans_items = $this->gl_trans_model->get_gl_trans($trans_type, $tran_item->trans_no);

        foreach ($gl_trans_items AS $tran){
            $debit = $credit = 0;

            if ($tran->amount > 0) {
                $debit = $tran->amount;
            } else {
                $credit = abs($tran->amount);
            }


            $lineHTML = '<table cellpadding="3" ><tr>
	        	<td class="textcenter" style="width: 20%;">'.$tran->account.'</td>
	        	<td style="width: 35%;">'.$tran->account_name.'</td>
	        	<td class="textright" style="width: 10%;">'.number_format2($debit,user_amount_dec()).'</td>
	        	<td class="textright" style="width: 10%;">'.number_format2($credit,user_amount_dec()).'</td>
	        	<td style="width: 25%;" >'.$tran->memo_.'</td>
	            </tr></table>';
            $this->tcpdf->SetY($this->tcpdf->GetY() - 4.5);

            if( $this->tcpdf->GetY()  > $this->tcpdf->getPageHeight() - $this->margin_bottom ) {
                $this->tcpdf->AddPage();
            }
            $this->pdf->writeHTML($lineHTML);
//             die('aaa');
//             $pdf->tcpdf->writeHTML($pdf->css.$lineHTML);

        }




        $footer_h = 45;
        if( $this->tcpdf->GetY()  > $this->tcpdf->getPageHeight() -$footer_h ) {
            $this->tcpdf->AddPage();
        }

        $this->tcpdf->SetY( $this->tcpdf->getPageHeight() -$footer_h );
        $this->ci->pdf->writeHTML('<div>AMOUNT IN WORD:'.price_in_words( abs($from_trans['settled_amount']),ST_CUSTPAYMENT).'</div>');
//         $pdf->tcpdf->Write(14,'AMOUNT IN WORD: '.price_in_words( abs($from_trans['settled_amount']),ST_CUSTPAYMENT));
        $this->tcpdf->SetY( $this->tcpdf->GetY()+ 3);
        $this->ci->pdf->write_view('footer/prepared_approve_receive');

    }
}