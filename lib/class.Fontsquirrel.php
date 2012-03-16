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
class Fontsquirrel {

    var $config;
    var $db;

    const DB_NAME = 'module_fontrrr_fonts';

    public function __construct() {
        $config = cms_utils::get_config();
        $db = cms_utils::get_db();
    }
  
    /**
     * Get Font information from Fontsquirrel API
     */
    public function fs_get_font() {
        $api_all = file_get_contents('http://www.fontsquirrel.com/api/fontlist/all');
        $decoded = json_decode($api_all);

        foreach ($decoded as $font_import) {
            $metadata = array(
                'id' => $font_import->id, 
                'path' => $font_import->foundry_urlname, 
                'font_filename' => $font_import->font_filename, 
                );

            $font = new StdClass;
            $font->provider = 'fontsquirrel';
            $font->font_id = $font_import->id;
            $font->family_name = $font_import->family_name;
            $font->is_monocase = $font_import->is_monocase;
            $font->url = 'http://www.fontsquirrel.com/fonts/' . $font_import->family_urlname;
            $font->foundry_name = $font_import->foundry_name;
            $font->foundry_url = 'http://www.fontsquirrel.com/foundry/' . $font_import->foundry_urlname;
            $font->font_filename = $font_import->font_filename;
            $font->tags = array($font_import->classification);
            $font->metadata = serialize($metadata);
            $font->family_count = $font_import->family_count;
            $font->license = 'See Font Squirrel license page';
            $font->license_url = 'http://www.fontsquirrel.com/fonts/' . $font_import->family_urlname . '#eula';

        }
        return $font;
    }

    /**
     * Generate preview from Font information
     */
    public function fs_preview($font, $text = NULL, $size = 18) {
        $output = '';
        $metadata = unserialize($font->metadata);
        
        if ($text == NULL) {
            $text = $font->family_name;
        }        
        if ($size == 'all') {
            $sizes = array(32, 24, 18, 14, 12, 10);            
            foreach ($sizes as $size) {
                $output = '<img src="http://www.fontsquirrel.com/utils/makeFont.php?font=' . $metadata['id'] . '/' . $metadata['font_filename'] . '&width=550&size=' . $size . '&text=' . urlencode($text) . '" />';
            }
            $output .= '<div><img src="http://www.fontsquirrel.com/utils/makeSolotypeSample.php?font=' . $metadata['id'] . '/' . $metadata['font_filename'] . '&case=all" /></div>';
        } else {
            $output = '<img src="http://www.fontsquirrel.com/utils/makeFont.php?font=' . $metadata['id'] . '/' . $metadata['font_filename'] . '&width=550&size=' . ($size - 10) . '&text=' . urlencode($text) . '" />';
        }
        return $output;
    }
}
?>