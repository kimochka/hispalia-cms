<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/*--------------------CSS------------------*/
/* BEGIN GLOBAL MANDATORY STYLES*/
define('FONTS_GOOGLE_OPEN_SANS', 'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all');
define('FONT_AWESOME', 'assets/global/plugins/font-awesome/css/font-awesome.min.css');
define('FONT_SIMPLE_LINE_ICONS', 'assets/global/plugins/simple-line-icons/simple-line-icons.min.css');
define('BOOTSTRAP_MIN', 'assets/global/plugins/bootstrap/css/bootstrap.min.css');
define('UNIFORM_DEFAULT', 'assets/global/plugins/uniform/css/uniform.default.css');
define('BOOTSTRAP_SWITCH_MIN', 'assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');
/* END GLOBAL MANDATORY STYLES */
/* BEGIN PAGE LEVEL STYLES */
define('JQUERY_UI', 'assets/global/plugins/jquery-ui/ui-lightness/jquery-ui-1.10.4.custom.css');
define('JQUERY_UI_MIN', 'assets/global/plugins/jquery-ui/ui-lightness/jquery-ui-1.10.4.custom.min.css');
define('BOOTSTRAP_DIALOG', 'assets/global/plugins/bootstrap-dialog/css/bootstrap-dialog.css');
define('SELECT2', 'assets/global/plugins/select2/select2.css');
define('DATATABLES_SCROLLER', 'assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css');
define('DATATABLES_COLREORDER', 'assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css');
define('DATATABLES_BOOTSTRAP', 'assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');
define('DATATABLES_JQUERY_CSS', 'assets/global/plugins/datatables/media/css/jquery.dataTables.css');
// define('BOOTSTRAP_WYSIHTML5', 'assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css');
// define('BOOTSTRAP_MARKDOWN', 'assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css');
define('BOOTSTRAP_DATEPICKER', 'assets/global/plugins/bootstrap-datepicker/css/datepicker.css');
define('BOOTSTRAP_DATERANGEPICKER', 'assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css');
// define('BOOTSTRAP_DATETIMEPICKER', 'assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
define('MUTISELECT_CSS', 'assets/global/plugins/jquery-multi-select/css/jquery.multiselect.css');


/* END PAGE LEVEL STYLES */
/* BEGIN THEME STYLES */
define('COMPONENTS', 'assets/global/css/components.css');
define('PLUGINS', 'assets/global/css/plugins.css');
define('LAYOUT', 'assets/admin/layout/css/layout.css');
define('LAYOUT_THEMES_DEFAULT', 'assets/admin/layout/css/themes/default.css');
define('LAYOUT_CUSTOM', 'assets/admin/layout/css/custom.css');
/* END THEME STYLES */

/* ------------------ JS --------------------*/
// BEGIN CORE PLUGINS
define('JQUERY_1_11_0_MIN', 'assets/global/plugins/jquery-1.11.0.min.js');
define('JQUERY_MIGRATE_1_2_1_MIN', 'assets/global/plugins/jquery-migrate-1.2.1.min.js');
/* IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip */
define('JQUERY_UI_1_10_3_MIN', 'assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js');
define('BOOTSTRAP_MIN_JS', 'assets/global/plugins/bootstrap/js/bootstrap.min.js');
define('BOOTSTRAP_HOVER_DROPDOWN_MIN', 'assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js');
define('JQUERY_SLIMSCROLL_MIN', 'assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js');
define('JQUERY_BLOCKUI_MIN', 'assets/global/plugins/jquery.blockui.min.js');
define('JQUERY_UNIFORM_MIN', 'assets/global/plugins/uniform/jquery.uniform.min.js');
define('BOOTSTRAP_SWITCH', 'assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js');
// BEGIN PAGE LEVEL PLUGINS
define('JQUERY_VALIDATE_MIN', 'assets/global/plugins/jquery-validation/js/jquery.validate.min.js');
define('VALIDATION_ADDITIONAL_METHODS_MIN', 'assets/global/plugins/jquery-validation/js/additional-methods.min.js');
define('BOOTSTRAP_DATEPICKER_JS', 'assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js');
define('BOOTSTRAP_DATETIMEPICKER_JS', 'assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js');
define('BOOTSTRAP_DATERANGEPICKER_JS', 'assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js');
define('MOMENT_DATEPICKER', 'assets/global/plugins/bootstrap-datetimepicker/js/moment.js');
define('MOMENT_DATERANGEPICKER', 'assets/global/plugins/bootstrap-daterangepicker/moment.min.js');
define('BOOTSTRAP_DIALOG_MIN', 'assets/global/plugins/bootstrap-dialog/js/bootstrap-dialog.min.js');
define('SELECT2_MIN', 'assets/global/plugins/select2/select2.min.js');
// define('SELECT2_MIN', 'assets/global/plugins/select2/select2.js');
define('PLACEHOLDERS', 'assets/global/plugins/placeholders.jquery.min.js');
define('JQUERY_DATATABLES_MIN', 'assets/global/plugins/datatables/media/js/jquery.dataTables.min.js');
define('DATATABLES_TABLETOOLS_MIN', 'assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js');
// define('DATATABLES_COL_REORDER', 'assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js');
// define('DATATABLES_SCROLLER_MIN', 'assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js');
define('DATATABLES_BOOTSTRAP_JS', 'assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');
define('BOOTSTRAP_WIZARD_JS', 'assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js');
define('MUTISELECT_JS', 'assets/global/plugins/jquery-multi-select/js/jquery.multiselect.js');
define('MUTISELECT_FILTER_JS', 'assets/global/plugins/jquery-multi-select/js/jquery.multiselect.filter.js');

// BEGIN PAGE LEVEL SCRIPTS
define('METRONIC', 'assets/global/scripts/metronic.js');
define('LAYOUT_JS', 'assets/admin/layout/scripts/layout.js');
define('QUICK_SIDEBAR', 'assets/admin/layout/scripts/quick-sidebar.js');
define('DEMO', 'assets/admin/layout/scripts/demo.js');
define('DATATABLE', 'assets/global/scripts/datatable.js');

define('FORM_VALIDATION_CLIENTES', 'assets/hispalia/admin/scripts/form-validation-clientes.js');
define('CLIENTES', 'assets/hispalia/admin/scripts/clientes.js');
define('TABLE_GENERAL_CLIENTES', 'assets/hispalia/admin/scripts/general_table_clientes.js');
define('FORM_VALIDATION_HOTELES', 'assets/hispalia/admin/scripts/form-validation-hoteles.js');
define('HOTELES', 'assets/hispalia/admin/scripts/hoteles.js');
define('TABLE_GENERAL_HOTELES', 'assets/hispalia/admin/scripts/general_table_hoteles.js');
// define('DATATABLE', 'assets/global/scripts/datatable.js');
define('TABLE_GENERAL_GRUPOS', 'assets/hispalia/admin/scripts/general_table_grupos.js');
define('GRUPOS', 'assets/hispalia/admin/scripts/grupos.js');
define('TABLE_NEW_GRUPO', 'assets/hispalia/admin/scripts/table_new_grupo.js');
define('FORM_VALIDATION_EVENTOS', 'assets/hispalia/admin/scripts/form-validation-eventos.js');
define('EVENTOS', 'assets/hispalia/admin/scripts/eventos.js');
define('TABLE_GENERAL_EVENTOS', 'assets/hispalia/admin/scripts/general_table_eventos.js');

define('RESERVAS', 'assets/hispalia/admin/scripts/reservas.js');
define('TABLE_GENERAL_RESERVAS', 'assets/hispalia/admin/scripts/general_table_reservas.js');
define('TABLE_RESERVAS_CLIENTES', 'assets/hispalia/admin/scripts/table_reservas_clientes.js');
// define('TABLE_RESERVAS_GENERAL', 'assets/hispalia/admin/scripts/table_general_reservas.js');

$medida_camiseta = Array(
    '0' => 'Escoge Medida',
    '1' => 'S',
    '2' => 'M',
    '3' => 'L',
    '4' => 'XL',
    '5' => 'XXL',
    '6' => 'XXXL'    
   );
define('CAMISETAS', 'return ' . var_export($medida_camiseta, 1) . ';');

$footer = date('Y', time()) . ' &copy Hispalia by Kim del Rio.';
define('FOOTER', 'return' .var_export($footer, 1) . ';');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/* End of file constants.php */
/* Location: ./application/config/constants.php */