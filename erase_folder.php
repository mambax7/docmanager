<?php
// $Id: erase_folder.php,v 1.4 2005/03/14 20:05:43 jsaucier Exp $
//  ------------------------------------------------------------------------ //
//                           Document Manager                                //
//            Copyright (c) 2004 Informatique Strategique IS                 //
//                  <http://www.infostrategique.com/>                        //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //


// Include the module header
include 'header.php';

    
// Set the template
$xoopsOption['template_main'] = 'docmanager_erasefolder.html';    
    

// Include Xoops header
require(XOOPS_ROOT_PATH.'/header.php');



// Set the CSS for the module
$xoops_module_header = "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"".$docmanager_url."/templates/style.css\" />\n";




// Select the current_dir that we are in
if (!empty($_GET['curent_dir'])) {
    $current_dir = (int) $_GET['curent_dir'];
}
else {
    $current_dir = 0;
}



// Test if the folder exist, if the folder is not hidden and if we have the right to delete all sub file and folder
if (if_folder_exist($current_dir) && (is_not_hidden($current_dir) || $is_mod_admin) && check_have_all_erase_right($current_dir)) {


    // Check if we dont try to erase the parent folder
    if ( $current_dir != 1) {
        $sql = "SELECT folders_id, folders_name FROM ".$xoopsDB->prefix("docmanager_folders")." WHERE folders_id = ".$current_dir;
        $result = $xoopsDB->query($sql);
        $myrow = $xoopsDB->fetchArray($result);
        $xoopsTpl->assign('docmanager_folder_id', $myrow['folders_id']);
        
        if ($myrow['folders_id'] == 1) {
            $myrow['folders_name'] = constant($myrow['folders_name']);
        }
    
    
        // If it's an hidden folder, put hidden next to the name
        if ( is_not_hidden($myrow['folders_id']) == false ) {
            $myrow['folders_name'] = $myrow['folders_name']."&nbsp;&nbsp;("._MD_FOLDER_HIDDEN.")";
        }
    
    
        $error = 0;
    }
    else {
        //Display the error
        $xoopsTpl->assign('docmanager_error', _MD_ERASEFOLDER_PARENT);
        $error = 1;
    }
}
else {
    // Display the error
    $xoopsTpl->assign('docmanager_error', _MD_FOLDER_ERROR_RIGHTS);
    $error = 1;
}



// Set langage options
$xoopsTpl->assign('docmanager_title', _MD_DOCMANAGER_ERASEFOLDER);
$xoopsTpl->assign('docmanager_folder_name', $myrow['folders_name']);
$xoopsTpl->assign('docmanager_erasefolder_confirm', _MD_ERASEFOLDER_CONFIRM);
$xoopsTpl->assign('docmanager_erasefolder_submit', _MD_ERASEFOLDER_SUBMIT);
$xoopsTpl->assign('docmanager_erasefolder_cancel', _MD_ERASEFOLDER_CANCEL);


// Set other options
$xoopsTpl->assign('docmanager_main_title', _MD_DOCMANAGER_MAIN_TITLE);
$xoopsTpl->assign('xoops_module_header', $xoops_module_header);
$xoopsTpl->assign('docmanager_url', $docmanager_url);


// Include Xoops footer
include 'footer.php';

?>
