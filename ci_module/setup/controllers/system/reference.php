<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class SetupSystemReference
{

    function __construct()
    {}

    function index()
    {
        global $systypes_array;
        bootstrap_set_label_column(4);
        echo "<div class=card-panel>";
        start_form();
        box_start("Next Reference");

        row_start();
        col_start(6, 'col l6');

        $systypes = get_systypes();
        $i = 0;
        while ($type = db_fetch($systypes)) {
            if ($i ++ == ST_CUSTCREDIT) {
                col_start(6, 'col l6');
            }
            input_text($systypes_array[$type["type_id"]], 'id' . $type["type_id"],  $type["next_reference"]);
        }

        col_end();
        row_end();

        box_footer_start();
        submit('setprefs', _("Update"), true, '', 'default','save');
        box_form_end();
        box_end();
        end_form(2);
        echo "</div>";
    }

    private function form()
    {}
}
