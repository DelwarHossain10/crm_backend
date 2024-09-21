<?php

if (!function_exists('selected_theme')) {
    function selected_theme()
    {
        if (!session('theme')) {
            session(['theme' => 'light']);
        }
        $theme = session('theme');
        if ($theme === 'light') {
            $css = '#layout-menu{background:#19212c!important;border-right:1px solid #d3d3d3!important}.layout-wrapper:not(.layout-horizontal) .bg-menu-theme .menu-inner .menu-item .menu-link{background:unset!important;color:lightgrey;font-weight:bold;}.layout-wrapper:not(.layout-horizontal) .bg-menu-theme .menu-inner>.menu-item.active:before{border-radius:unset}.navbar-detached{box-shadow:unset}.bg-navbar-theme{background-color:#1A85AB!important;color:unset}.app-brand .layout-menu-toggle{background-color:#1f2937}span.app-brand-text.menu-text.fw-bolder.ms-2{color:#fff}.content-wrapper{background:#ededed}a.layout-menu-toggle.menu-link.text-large.ms-auto,i.bx.bx-chevron-left.bx-sm.align-middle{display:none}a.layout-menu-toggle.menu-link.text-large.ms-auto{display:none!important}nav#layout-navbar{height:40px}.container-fluid {background: #1A85AB;}a#menudd,i.bx.bx-bell.bx-sm,i.bx.bx-menu.bx-sm{color:#fff}';
            return $css;



        }
        if ($theme === 'dark') {
            $css = "html,iframe,img,video{filter:invert(1) hue-rotate(180deg)}.layout-navbar{background:unset!important}.navbar-detached{box-shadow:unset!important}a.layout-menu-toggle.menu-link.text-large.ms-auto,i.bx.bx-chevron-left.bx-sm.align-middle{display:none}a.layout-menu-toggle.menu-link.text-large.ms-auto{display:none!important}nav#layout-navbar{height:40px}.bg-menu-theme .menu-inner>.menu-item.active:before {background: chartreuse;border-radius: unset !important;}.bg-menu-theme .menu-inner>.menu-item.active>.menu-link {color: chartreuse;background-color: unset !important;}.bg-navbar-theme{background-color:#f5f5f9!important;color:unset}.bg-menu-theme .menu-item.active > .menu-link:not(.menu-toggle){background-color: unset !important}";

            return $css;
        }
        return;
    }
}

if (!function_exists('generate_table_columns')) {
    function generate_table_columns($columns)
    {
        // $modelPath = <<<TEXT
        // App\Models\
        // TEXT;
        // $modelInstance = $modelPath.$model;
        // $columns = Schema::getColumnListing((new $modelInstance)->getTable());

        $HTML  = '';
        $HTML .= "<table class='table data-table'>";
        $HTML .= "<thead><tr><th></th>";
        foreach ($columns as $col) {
            $HTML .= "<th>" . $col . "</th>";
        }
        $HTML .= "</tr></thead>";
        $HTML .= "<tbody class='table-border-bottom-0'></tbody>";
        // $HTML .="<tfoot><tr><th></th>";
        // foreach ($columns as $col){
        //     $HTML .="<th>"."</th>";
        // }
        // $HTML .="</tr></tfoot>";
        $HTML .= "</table>";

        echo $HTML;
    }
}

if (!function_exists('convertQueryStringToArray')) {
    function convertQueryStringToArray($request)
    {
        $filterColumns = [];
        parse_str($request->filterColumn, $filterColumns);

        return $filterColumns;
    }
}
if (!function_exists('action_button')) {
    function action_button(
        $buttonArrays
    ) {
        $button = '';
        $button .= '<div class="d-flex align-items-center">';
        $button .= '<div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></a>';
        $button .= '<div class="dropdown-menu dropdown-menu-end" style="">';
        if (is_array($buttonArrays)) {
            foreach ($buttonArrays as $action) {
                if ($action['is_modal'] && $action['button_text'] == 'Edit') {
                    $button .= '<button data-toggle="modal" data-target="#myDynamicModal" data-link="' . $action['route'] . '" class="dropdown-item ajax-modal-btn">' . $action['button_text'] . '</button>';
                    continue;
                }
                if ($action['is_modal'] && $action['button_text'] == 'File') {
                    $button .= '<button data-toggle="modal" data-target="#myDynamicFileModal" data-link="' . $action['route'] . '" class="dropdown-item ajax-modal-file-btn">' . $action['button_text'] . '</button>';
                    continue;
                }
                if (!$action['is_modal'] && $action['button_text'] != 'Trash' && $action['button_text'] != 'Delete') {
                    $button .= '<a href="' . $action['route'] . '" class="dropdown-item">' . $action['button_text'] . '</a>';
                    continue;
                }
                if ($action['button_text'] == 'Trash' || $action['button_text'] == 'Delete') {
                    $button .= '<form method="POST" action="' . $action['route'] . '">
                    <input type="hidden" name="_token" id="csrf-token" value="' . csrf_token() . '" />
                    <button type="submit" class="dropdown-item delete-record text-danger show_confirm" data-toggle="tooltip" title="Delete">' . $action['button_text'] . '</button>
                    </form>';
                    continue;
                }
            }
        }

        $button .= '</div>';
        $button .= '</div>';
        $button .= '</div>';

        return $button;
    }
}
