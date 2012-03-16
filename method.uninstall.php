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

$db = cmsms()->GetDb();

// remove the database table
$dict = NewDataDictionary($db);
/* fonts */
$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_fontrrr_fonts" );
$dict->ExecuteSQLArray($sqlarray);
/* sets */
$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_fontrrr_sets" );
$dict->ExecuteSQLArray($sqlarray);
// remove the sequence
$db->DropSequence( cms_db_prefix()."module_fontrrr_seq" );
// remove the permissions
$this->RemovePermission('Use Fontrrr');
$this->RemovePermission('Set Fontrrr Prefs');
// remove the preference
$this->RemovePreference("allow_add");
// remove the event
$this->RemoveEvent( 'OnFontrrrPreferenceChange' );
// put mention into the admin log
$this->Audit( 0, 
        $this->Lang('friendlyname'), 
        $this->Lang('uninstalled'));

?>