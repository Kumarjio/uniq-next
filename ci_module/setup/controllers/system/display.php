<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class SetupSystemDisplay
{

    function __construct()
    {}

    function index()
    {
        start_form();
        box_start("");

        $this->form();

        box_end();
        end_form(2);
    }

    private function form()
    {
        bootstrap_set_label_column(5);

        // start_outer_table(TABLESTYLE2);

        // table_section(1);
        row_start('card-panel');
          // col_start(4, 'col l12');
          echo "<div class='col l12'>";
            fieldset_start(_("Decimal Places"));
            echo "<div class='col l6'>";
            numbers_list(_("Prices"), 'prices_dec', user_price_dec(), 0, 10);
            echo "</div>";
            echo "<div class='col l6'>";
            numbers_list(_("Amounts"), 'amount_dec', user_amount_dec(), 0, 10);
            echo "</div>";
            echo "<div class='col l6'>";
            numbers_list(_("Quantities"), 'qty_dec', user_qty_dec(), 0, 10);
            echo "</div";
            echo "<div class='col l6'>";
            numbers_list(_("Exchange Rates"), 'rates_dec', user_exrate_dec(), 0, 10);
            echo "</div>";
            echo "<div class='col l6'>";
            numbers_list(_("Percentages"), 'percent_dec', user_percent_dec(), 0, 10);
            echo "</div>";
          // col_end();
          echo "</div>";
          //
          echo "<div class='col l12'>";
          // col_start(4, 'col l12');
            fieldset_start(_("Date format and Separators"));
            echo "<div class='col l6'>";
            dateformats_list(_("Dateformat"), "date_format", user_date_format());
            echo "</div>";
            echo "<div class='col l6'>";
            dateseps_list(_("Date Separator"), "date_sep", user_date_sep());
            echo "</div>";
          /*
           * The array $dateseps is set up in config.php for modifications
           * possible separators can be added by modifying the array definition by editing that file
           */
            echo "<div class='col l6'>";
            thoseps_list(_("Thousand Separator"), "tho_sep", user_tho_sep());
            echo "</div>";
          /*
           * The array $thoseps is set up in config.php for modifications
           * possible separators can be added by modifying the array definition by editing that file
           */
            echo "<div class='col l6'>";
            decseps_list(_("Decimal Separator"), "dec_sep", user_dec_sep());
            echo "</div>";
          // col_end();
          echo "</div>";

          /*
           * The array $decseps is set up in config.php for modifications
           * possible separators can be added by modifying the array definition by editing that file
           */
          echo "<div class='col l12'>";
          // col_start(4, 'col l12');
            fieldset_start(_("Miscellaneous"));
            echo "<div class='col l4'>";
            check_bootstrap("Show hints for new users", 'show_hints', user_hints());
            echo "</div>";
            echo "<div class='col l4'>";
            check_bootstrap(_("Show GL Information"), 'show_gl', user_show_gl_info());
            echo "</div>";
            echo "<div class='col l4'>";
            check_bootstrap(_("Show Item Codes"), 'show_codes', user_show_codes());
            echo "</div>";

          // themes_list_row(_("Theme:"), "theme", user_theme());

          /*
           * The array $themes is set up in config.php for modifications
           * possible separators can be added by modifying the array definition by editing that file
           */
            echo "<div class='col l12'>";
            pagesizes_list(_("Page Size"), "page_size", user_pagesize());
            echo "</div>";
            echo "<div class='col l12'>";
            tab_list(_("Start-up Tab"), 'startup_tab', user_startup_tab());
            echo "</div>";

          /*
           * The array $pagesizes is set up in config.php for modifications
           * possible separators can be added by modifying the array definition by editing that file
           */

          if (! isset($_POST['print_profile']))
              $_POST['print_profile'] = user_print_profile();
            
            echo "<div class='col l12'>";
            print_profiles(_("Printing profile"), 'print_profile', null, _('Browser printing support'));
            echo "</div>";
            echo "<div class='col l4'>";
            check_bootstrap(_("Use popup window to display reports"), 'rep_popup', user_rep_popup(), false, _('Set this option to on if your browser directly supports pdf files'));
            echo "</div>";
            echo "<div class='col l6'>";
            check_bootstrap(_("Use icons instead of text links"), 'graphic_links', user_graphic_links(), false, _('Set this option to on for using icons instead of text links'));
            echo "</div>";
            echo "<div class='col l12'>";
            input_text(_("Query page size"), 'query_size', 5, 5, '', user_query_size());
            echo "</div>";
            echo "<div class='col l6'>";
            check_bootstrap(_("Remember last document date"), 'sticky_doc_date', sticky_doc_date(), false, _('If set document date is remembered on subsequent documents, otherwise default is current date'));
            echo "</div>";
          // col_end();
          echo "</div>";

          if (! isset($_POST['language']))
              $_POST['language'] = $_SESSION['language']->code;

          col_start(4, 'col l12');
            fieldset_start(_("Language"));
            echo "<div class='col l12'>";
            languages_bootstrap(_("Language"), 'language', $_POST['language']);
            echo "</div>";
            box_footer_start();
            submit('setprefs', _("Update"), true, '', 'default','save');
            box_form_end();
          col_end();
        row_end();
    }
}
