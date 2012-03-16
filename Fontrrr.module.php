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
/**
 * @author Goran Ilic
 * @since 0.1
 * @version 0.1
 * @license GPL
 **/ 
class Fontrrr extends CMSModule {

    function GetName() {
        return 'Fontrrr';
    }

    function GetFriendlyName() {
        return $this->Lang('friendlyname');
    }

    function GetVersion() {
        return '0.1';
    }

    function GetHelp() {
        return $this->Lang('help');
    }

    function GetAuthor() {
        return 'Goran Ilic';
    }

    function GetAuthorEmail() {
        return 'uniqu3e@gmail.com';
    }

    function GetChangeLog() {
        return $this->Lang('changelog');
    }

    function IsPluginModule() {
        return true;
    }

    function HasAdmin() {
        return true;
    }

    function GetAdminSection() {
        return 'layout';
    }

    function GetAdminDescription() {
        return $this->Lang('moddescription');
    }

    function VisibleToAdminUser() { {
            return $this->CheckPermission('Use Fontrrr') || $this->CheckPermission('Set Fontrrr Prefs') || $this->CheckPermission('Modify Site Preferences');
        }
    }

    function GetNotificationOutput($priority = 2) {
        $db     = cmsms()->GetDb();
        $rcount = $db->GetOne('select count(*) from ' . cms_db_prefix() . 'module_fontrrr_fonts');
        if ($priority < 4 && $rcount == 0) {
            $ret = new stdClass;
            $ret->priority = 2;
            $ret->html = $this->Lang('alert_no_fonts');
            return $ret;
        }
        return '';
    }

    function GetDependencies() {
        return array();
    }

    function MinimumCMSVersion() {
        return "1.9";
    }

    function MaximumCMSVersion() {
        return "1.10.3";
    }

    public function SetParameters() {
        if (version_compare(CMS_VERSION, '1.10') < 0) {
            $this->InitializeFrontend();
            $this->InitializeAdmin();
        }
    }

    public function InitializeFrontend() {
        $this->RegisterModulePlugin();
        $this->RestrictUnknownParams();

        //$this->SetParameterType('set_id',CLEAN_INT);
        $this->SetParameterType('action', CLEAN_STRING);
    }

    public function InitializeAdmin() {
        //$this->CreateParameter('set_id', '-1', $this->Lang('help_param_set_id'));
        $this->CreateParameter('action', 'default', $this->Lang('help_param_action'));
    }

    function InstallPostMessage() {
        return $this->Lang('postinstall');
    }

    function UninstallPostMessage() {
        return $this->Lang('postuninstall');
    }

    function UninstallPreMessage() {
        return $this->Lang('really_uninstall');
    }  
} //end class
?>
