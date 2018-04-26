<?php
class HtmlInquiryActionsSmarty{
    function __construct(){

    }

    static function inquiry_addnew_button($template=null, $params=null){
        if ( !empty($params->tpl_vars) AND array_key_exists('button_add_new', $params->tpl_vars)){
            $button_add_new = $params->tpl_vars['button_add_new']->value;

            $icon = '<i class="material-icons">add</i>';
            // return anchor($button_add_new['uri'],$icon,'class="btn green ajaxsubmit waves-effect"');

            $html = '<div class="fixed-action-btn">';
            $html .= anchor($button_add_new['uri'],$icon,'class="btn-floating yellow darken-3 btn-large waves-effect waves-light"');
            $html .= '</div>';
            return $html;
        }
    }

    static function inquiry_addnew_button_fixed($template=null, $params=null){
        if ( !empty($params->tpl_vars) AND array_key_exists('button_add_new', $params->tpl_vars)){
            $button_add_new = $params->tpl_vars['button_add_new']->value;

            $icon = '<i class="material-icons">add</i>';
            // return anchor($button_add_new['uri'],$icon,'class="btn green ajaxsubmit waves-effect"');
            return anchor($button_add_new['uri'],$icon,'class="btn-floating blue btn-large waves-effect waves-light"');
        }
    }

    static function page_button_back(){
        return anchor(get_instance()->url_back,'<i class="fa fa-rotate-left">&nbsp</i><span synlang="syncard-language">Back</span>','class="btn green btn_left" ');
    }
}
