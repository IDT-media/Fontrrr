<?php
#-------------------------------------------------------------------------
# Module: Fontrrr
# Version: 0.1 Goran Ilic
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2010 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/skeleton/
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
if (!is_object(cmsms())) exit;

$db          = cmsms()->GetDb();
$taboptarray = array('mysql' => 'TYPE=MyISAM');
$dict        = NewDataDictionary($db);
/* Fonts */
$flds = "id I KEY AUTO,
         font_name C(255),
         font_url C(255),
         font_provider C(255),
         foundry_name C(255),
         foundry_path C(255),
         font_license C(255),
         font_license_url C(255),
         font_designer C(255),
         font_designer_url C(255),
         font_filename C(255)";
			
$sqlarray = $dict->CreateTableSQL( cms_db_prefix() . "module_fontrrr_fonts", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

/* Sets */
$flds = "id I KEY AUTO,
         font_id C(255),
         set_name C(255),
         set_description C(255)";
        
$sqlarray = $dict->CreateTableSQL(cms_db_prefix() . "module_fontrrr_sets",$flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// create a sequence
$db->CreateSequence(cms_db_prefix()."module_fontrrr_seq");
// create a permission
$this->CreatePermission('Use Fontrrr', 'Use Fontrrr');
$this->CreatePermission('Set Fontrrr Prefs','Set Fontrrr Prefs');
// create a preference
$this->SetPreference("allow_add", true);
// create event
$this->CreateEvent( 'OnFontrrrPreferenceChange' );
// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('installed', $this->GetVersion()) );
	      
?>