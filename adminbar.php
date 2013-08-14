<?php

/**
* Adminbar
*/
class Plugin_Adminbar extends Plugin {

	private $ci;

	private function _auth() {
		if(!isset($this->current_user->active)) return false;
		$this->lang->load('global');
		$this->lang->load('pages/pages');
		$this->lang->load('blog/blog');
		return true;
	}

	public function debug() {
		return;
		# return sprintf("<pre>%s</pre>", print_r($this->template, true));
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
					break 1;
				default:
					break 1;
			}
		}
		$right_menu .= sprintf($item, 'Hallo, '.$this->current_user->first_name.' '.$this->current_user->last_name);
		$right_menu .= sprintf($link, site_url('admin/logout'), lang('logout_label'), lang('logout_label'), '');
		return sprintf($wrap, $left_menu, $right_menu);
	}

	public function assets() {
		if(!$this->_auth()) return;
		return '<style type="text/css">
			html { margin-top: 28px !important; }
			#pcms_admin_bar {position: fixed; height: 28px; background: #464646; background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0,#373737),color-stop(18%,#464646)); background-image: -webkit-linear-gradient(bottom,#373737 0,#464646 5px); background-image: -moz-linear-gradient(bottom,#373737 0,#464646 5px); background-image: -o-linear-gradient(bottom,#373737 0,#464646 5px); background-image: linear-gradient(to top,#373737 0,#464646 5px); color: #dedede; font: normal 13px/28px sans-serif; top: 0; left: 0; width: 100%; min-width: 600px; z-index: 9999; }
			#menu_left {}
			.favicon { height: 28px; width: 28px; background: url(\'data:image/x-icon;base64,'.base64_encode(file_get_contents(site_url('favicon.ico'))).'\') no-repeat center center; float: left; margin-right: 5px; }
			#menu_left, #menu_right { height: 28px; float:left; list-style: none; margin: 0; padding: 0 5px; position: relative; }
			#menu_right { float: right; }
			#menu_left  li , #menu_right li { position: relative; float: left; color: #dedede; font: normal 13px/28px sans-serif; border-right: 1px solid #666; }
			#menu_left li a , #menu_right li a, #menu_right .generic { display: block; padding: 0 15px; border-right: 1px solid #333; color: #dedede; font: normal 13px/28px sans-serif; }
			#menu_left > li:hover a, #menu_right > li:hover a {background: #222; background-image: -webkit-gradient(linear,left bottom,left top,from(#3a3a3a),to(#222)); background-image: -webkit-linear-gradient(bottom,#3a3a3a,#222); background-image: -moz-linear-gradient(bottom,#3a3a3a,#222); background-image: -o-linear-gradient(bottom,#3a3a3a,#222); background-image: linear-gradient(to top,#3a3a3a,#222); }
			#menu_left .submenu, #menu_right .submenu { float: none; display: block; position: absolute; top: 28px; left: 0; padding: 5px 0 10px 0; margin: 0; background: #fff;  z-index: 99999; box-shadow: 0 0 5px #555; width: 200px; }
			#menu_left .submenu li, #menu_right .submenu li { float: none; display: block; height: 28px; border: none;}
			#menu_left .submenu li a, #menu_right .submenu li a { color: #333; border: none; background: #fff; height: 28px; line-height: 28px;}
			#menu_left .submenu li a:hover, #menu_right .submenu li a:hover { color: #000; background: #efefef; }
			#menu_left .submenu, #menu_right .submenu { display: none; }
			#menu_left li:hover .submenu , #menu_right li:hover .submenu { display: block; }
		</style>';
	}
}