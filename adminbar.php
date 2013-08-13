<?php

/**
* Adminbar
*/
class Plugin_Adminbar extends Plugin {

	private $ci;

	private function _auth() {
		return true;
	}

	public function assets() {
		if(!$this->_auth()) return;
		return '<style type="text/css">
			html { margin-top: 28px !important; }
			#pcms_admin_bar {position: fixed; height: 28px; overflow: hidden; background: #464646; background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0,#373737),color-stop(18%,#464646)); background-image: -webkit-linear-gradient(bottom,#373737 0,#464646 5px); background-image: -moz-linear-gradient(bottom,#373737 0,#464646 5px); background-image: -o-linear-gradient(bottom,#373737 0,#464646 5px); background-image: linear-gradient(to top,#373737 0,#464646 5px); color: #dedede; font: normal 13px/28px sans-serif; top: 0; left: 0; width: 100%; min-width: 600px; z-index: 99999; }
			#menu_left {background: url(\'data:image/png;base64,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\') no-repeat 5px center;}
			#menu_left, #menu_right { height: 28px; float:left; list-style: none; margin: 0; padding: 0 10px 0 25px;  }
			#menu_right { float: right; }
			#menu_left  li , #menu_right li { float: left; color: #dedede; font: normal 13px/28px sans-serif; border-right: 1px solid #666; }
			#menu_left li a , #menu_right li a, #menu_right .generic { display: block; padding: 0 15px; border-right: 1px solid #333; color: #dedede; font: normal 13px/28px sans-serif; }
			#menu_left li:hover a, #menu_right li:hover a {background: #222; background-image: -webkit-gradient(linear,left bottom,left top,from(#3a3a3a),to(#222)); background-image: -webkit-linear-gradient(bottom,#3a3a3a,#222); background-image: -moz-linear-gradient(bottom,#3a3a3a,#222); background-image: -o-linear-gradient(bottom,#3a3a3a,#222); background-image: linear-gradient(to top,#3a3a3a,#222); }
		</style>';
	}

	public function show() {
		if(!$this->_auth()) return;
		$wrap = '<div id="pcms_admin_bar"><ul id="menu_left">%s</ul><ul id="menu_right">%s</ul></div>';
		$item = '<li><span class="generic">%s</span></li>';
		$link = '<li><a href="%s" title="%s">%s</a>';
		$left_menu = '';
		$right_menu = '';

		$left_menu .= sprintf($link, site_url('admin'), 'Dashboard', 'Admin-Bereich');
		$left_menu .= sprintf($link, site_url('admin/pages/create'), 'Seite erstellen', 'Neue Seite');
		if($this->template->page) {
			$left_menu .= sprintf($link, site_url('admin/pages/edit/'.$this->template->page->id), '\''.$this->template->page->title.'\' bearbeiten', 'Seite bearbeiten');
		}

		$right_menu .= sprintf($item, 'Hallo, '.$this->current_user->first_name.' '.$this->current_user->last_name);
		$right_menu .= sprintf($link, site_url('admin/logout'), 'Abmelden', 'Abmelden');

		return sprintf($wrap, $left_menu, $right_menu);
	}

	public function debug() {
		// return;
		if(!$this->_auth()) return;
		return sprintf("<pre>%s</pre>", print_r($this->current_user, true));
	}


}