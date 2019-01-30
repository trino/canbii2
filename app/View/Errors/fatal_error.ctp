<h2><?= $message; ?></h2>
<p class="error">
    <strong><?php echo __d('cake', 'Error'); ?>: </strong>
    <?= __d('cake', 'An Internal Error Has Occurred.'); ?>
</p>
<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
if (Configure::read('debug') > 0) {
    echo "<P>Controller: " . $this->params['controller'] . '</P>';
    echo "<P>Action: " . $this->action . '</P>';
    echo "<P>URL: " . $this->here . '</P>';
    echo "<P>View: Pages/" . $this->view . '.ctp</P>';
    echo "<P>Layout: " . $this->layout . '</P>';
    echo "<P>Path: " . APP . '</P>';
    if(isset($GLOBALS["lastsql"])) {
        echo "<P>SQL: " . $GLOBALS["lastsql"] . '</P>';
        echo "<P>Params: " . print_r($GLOBALS["params"], true) . '</P>';
        echo "<P>Options: " . print_r($GLOBALS["options"], true) . '</P>';
    } else {
        echo '<P>Obtain new DBoSource.php from me';
    }
    echo $this->element('exception_stack_trace');

    function human_filesize($bytes, $decimals = 2) {
        $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        if($bytes < 1024){$decimals = 0;}
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
    function printerrorlog($filename, $delete = false){
        $filepath = APP . "/tmp/logs/" . $filename;
        if(file_exists($filepath)){
            $size = filesize($filepath);
            if($size) {
                echo '<P>' . $filename . ": " . human_filesize($size) . '<BR><PRE STYLE="background-color: white; border: 1px solid red;">';
                echo file_get_contents($filepath);
                echo '</PRE></P>';
                if($delete){unlink($filepath);}
            }
        }
    }

    printerrorlog("debug.log", true);
    printerrorlog("error.log", true);
}
?>
