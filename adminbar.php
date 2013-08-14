<?php

/**
* Adminbar
*/
class Plugin_Adminbar extends Plugin {

	private function _auth() {
		if(!isset($this->current_user->active)) return false;
		$this->lang->load(array('global', 'pages/pages', 'blog/blog'));
		return true;
	}

	public function show() {
		if(!$this->_auth()) return;
		$wrap = '<div id="pcms_admin_bar"><ul id="menu_left">%s</ul><ul id="menu_right">%s</ul></div>';
		$item = '<li><span class="generic">%s</span></li>';
		$link = '<li><a href="%s" title="%s">%s</a>%s</li>';
		$submenu = '<ul class="submenu">%s</ul>';

		$left_menu = '';
		$right_menu = '';
		$contents = '';

		$modules = $this->module_m->get_all(array(
				'is_backend' => true,
				'group' => $this->current_user->group,
				'lang' => CURRENT_LANGUAGE
			));
		$active_modules = array();
		foreach ($modules as $module) {
			if((bool) $module['enabled'] === true
				&& (bool) $module['installed'] === true
				&& $module['menu'] === 'content'
				&& (bool) $module['is_backend'] === true) {
				$active_modules[] = $module;
			}
		}
		foreach ($active_modules as $m) {
			$contents .= sprintf($link, site_url('admin/'.$m['slug']), $m['name'], $m['name'], '');
		}

		$contents .= sprintf($link, site_url('admin/settings'), lang('settings_label'), lang('settings_label'), '' );

		$left_menu .= sprintf($link, site_url('admin'), lang('global:control-panel'), '<span class="favicon"></span> '.lang('global:control-panel'),
			sprintf($submenu, $contents)
		);

		$new = sprintf($link, site_url('admin/pages/create'), lang('pages:create_title'), lang('pages:create_title'), '');
		$new .= sprintf($link, site_url('admin/blog/create'), lang('blog:create_title'), lang('blog:create_title'), '');
		$left_menu .= sprintf($link, '#', lang('global:add'), lang('global:add').' …', sprintf($submenu, $new));

		if($this->template->page) {
			$left_menu .= sprintf($link, site_url('admin/pages/edit/'.$this->template->page->id), sprintf(lang('pages:edit_title'), $this->template->page->title), sprintf(lang('pages:edit_title'), $this->template->page->title), '');
		} elseif($this->controller === 'blog') {
			switch($this->method) {
				case 'view':
					$left_menu .= sprintf(
						$link,
						site_url('admin/blog/edit/'.$this->template->post[0]['id']),
						sprintf(lang('blog:edit_title'), $this->template->post[0]['title']),
						sprintf(lang('blog:edit_title'), substr($this->template->post[0]['title'], 0, 25).'…'),
						''
					);
					break 1;
				case 'index':
				case 'category':
				default:
					break 1;
			}
		}
		$right_menu .= sprintf($item, sprintf(lang('logged_in_welcome'), $this->current_user->first_name.' '.$this->current_user->last_name));
		$right_menu .= sprintf($link, site_url('admin/logout'), lang('logout_label'), lang('logout_label'), '');
		return sprintf($wrap, $left_menu, $right_menu);
	}

	public function assets() {
		if(!$this->_auth()) return;
		$css = str_replace(
			'###FAVICON###',
			'data:image/x-icon;base64,'.base64_encode( file_get_contents( site_url('favicon.ico') ) ),
			'html{margin-top:28px !important;}
#pcms_admin_bar{position:fixed;height:28px;background:#464646;background-image:-webkit-gradient(linear, left bottom, left top, color-stop(0, #373737), color-stop(18%, #464646));background-image:-webkit-linear-gradient(bottom, #373737 0, #464646 5px);background-image:-moz-linear-gradient(bottom, #373737 0, #464646 5px);background-image:-o-linear-gradient(bottom, #373737 0, #464646 5px);background-image:linear-gradient(to top, #373737 0, #464646 5px);color:#dedede;font:normal 13px/28px sans-serif;top:0;left:0;width:100%;min-width:600px;z-index:9999;}#pcms_admin_bar a{font-weight:normal;color:#dedede;font:normal 13px/28px sans-serif;}
#pcms_admin_bar a:hover{text-decoration:none;text-shadow:none;}
#pcms_admin_bar .favicon{height:28px;width:28px;background:url(###FAVICON###) no-repeat center center;float:left;margin-right:5px;}
#pcms_admin_bar #menu_left,#pcms_admin_bar #menu_right{height:28px;float:left;list-style:none;margin:0;padding:0;position:relative;}#pcms_admin_bar #menu_left li,#pcms_admin_bar #menu_right li{position:relative;float:left;color:#dedede;font:normal 13px/28px sans-serif;border-right:1px solid #666;padding:0;margin:0;list-style:none;}#pcms_admin_bar #menu_left li a,#pcms_admin_bar #menu_right li a,#pcms_admin_bar #menu_left li .generic,#pcms_admin_bar #menu_right li .generic{display:block;padding:0 15px;border-right:1px solid #333;color:#dedede;font:normal 13px/28px sans-serif;}
#pcms_admin_bar #menu_left>li:hover>a,#pcms_admin_bar #menu_right>li:hover>a{background:#222;background-image:-webkit-gradient(linear, left bottom, left top, from(#3a3a3a), to(#222222));background-image:-webkit-linear-gradient(bottom, #3a3a3a, #222222);background-image:-moz-linear-gradient(bottom, #3a3a3a, #222222);background-image:-o-linear-gradient(bottom, #3a3a3a, #222222);background-image:linear-gradient(to top, #3a3a3a, #222222);}
#pcms_admin_bar #menu_left>li:hover .submenu,#pcms_admin_bar #menu_right>li:hover .submenu{display:block;}
#pcms_admin_bar #menu_left .submenu,#pcms_admin_bar #menu_right .submenu{float:none;display:block;position:absolute;top:28px;left:0;padding:5px 0 10px 0;margin:0;background:#fff;z-index:99999;box-shadow:0 0 5px #555;width:200px;display:none;}#pcms_admin_bar #menu_left .submenu li,#pcms_admin_bar #menu_right .submenu li{float:none;display:block;height:28px;border:none;}
#pcms_admin_bar #menu_left .submenu a,#pcms_admin_bar #menu_right .submenu a{color:#333;border:none;background:#fff;height:28px;line-height:28px;}
#pcms_admin_bar #menu_left .submenu a:hover,#pcms_admin_bar #menu_right .submenu a:hover{color:#000;background:#efefef;}
#pcms_admin_bar #menu_right{float:right;}


'
		);
		return sprintf('<style type="text/css">%s</style>', $css);
	}
}