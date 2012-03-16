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

    if (!$this->CheckPermission('Use Fontr')
          || !$this->CheckPermission('Set Fontr Prefs')
          || !$this->CheckPermission('Modify Site Preferences'))
    {
        echo $this->ShowErrors($this -> Lang('accessdenied', array('Use Fontr')));
        return;
    }
    
    if (!empty($params['active_tab'])) {
    $tab = $params['active_tab'];
    } else {
        $tab = 'general';
    }   
    /* TabHeaders */
    echo $this->StartTabHeaders();
        echo $this->SetTabHeader('fonts_used', $this -> Lang('title_fonts_used'), ($tab == 'used'));
        echo $this->SetTabHeader('font_services', $this -> Lang('title_font_services'), ($tab == 'services'));
    if ($this->CheckPermission('Set Fontr Prefs') || $this->CheckPermission('Modify Site Preferences')) {
        echo $this->SetTabHeader('preferences', $this -> Lang('title_general_prefereneces'), ($tab == 'preferences'));
    }
    echo $this->EndTabHeaders();
    
    /* TabContent */
    echo $this->StartTabContent();
        echo $this->StartTab('fonts_used', $params);
        include(dirname(__FILE__).'/function.admin_used.php');
        echo $this->EndTab();

        echo $this->StartTab('font_services', $params);
        include(dirname(__FILE__).'/function.admin_services.php');
        echo $this->EndTab();        
        
   if ($this->CheckPermission('Set Fontr Prefs') || $this->CheckPermission('Modify Site Preferences')) {
       echo $this->StartTab('preferences', $params);
       include(dirname(__FILE__).'/function.admin_preferences.php');
       echo $this->EndTab();
        }
    echo $this->EndTabContent();
?>