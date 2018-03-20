<?php
function set_icon($icon, $title=false)
{
    switch ($icon){
        case ICON_EDIT:
            return '<i class="fa fa-pencil"></i>';
            break;
        case ICON_DELETE:
            return '<i class="fa fa-remove"></i>';
            break;
        case ICON_DOWN:
            return '<i class="fa fa-download"></i>';
            break;
        case ICON_VIEW:
            return '<i class="fa fa-eye"></i>';
            break;
        case ICON_UPDATE:
            return '<i class="fa fa-save"></i>';
            break;
        case ICON_CANCEL:
            return '<i class="fa fa-rotate-left"></i>';
            break;
        case ICON_ALLOC:
            return '<i class="fa fa-chain"></i>';
            break;

        default: return 'button icon'; break;
    }
}

function button($name, $value, $title=false, $icon=false,  $aspect='')
{
    // php silently changes dots,spaces,'[' and characters 128-159
    // to underscore in POST names, to maintain compatibility with register_globals
    $rel = '';
    if ($aspect == 'selector') {
        $rel = " rel='$value'";
        $value = _("Select");
    }
    if (user_graphic_links() && $icon) {
        if ($value == _("Delete")) // Helper during implementation
            $icon = ICON_DELETE;

        return "<button type='submit' class='editbutton table_actions button' name='"
            .htmlentities(strtr($name, array('.'=>'=2E', '='=>'=3D',// ' '=>'=20','['=>'=5B'
            )))
            ."' value='1'" . ($title ? " title='$title'":" title='$value'")
            . ($aspect ? " aspect='$aspect'" : '')
            . $rel
            ." />".set_icon($icon)."</button>\n";
    } else
        $icon = "";
        if($value == "Delete") $icon = "trash";
        if($value == "Edit") $icon = "pencil";
        return "<button type='submit' class='editbutton button' name='"
            .htmlentities(strtr($name, array('.'=>'=2E', '='=>'=3D',// ' '=>'=20','['=>'=5B'
            )))
            ."' value='$value'"
            .($title ? " title='$title'":'')
            . ($aspect ? " aspect='$aspect'" : '')
			. $rel
			." ><i class='fa fa-".$icon."'></i></button>\n";
}
