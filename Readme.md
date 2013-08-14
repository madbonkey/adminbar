# PyroCMS Adminbar

A WordPress-style Frontend-Adminbar for PyroCMS. There are several areas in the bar:

1. Control-panel button: This one has a dropdown with every enabled, installed, 'content'-Module that has a backend.
2. "Add …" button: Dropdown, currently featured pages and blog module, planning on more but no idea how (maybe shortcuts section from module details?)
3. "Edit" button: Currently works with pages and blog posts, on other views/… this is hidden
4. Greeting
5. Logout button: maybe include a dropdown with links to edit profile/user-management?

## Installation

Put `adminbar.php` in `addons/default/plugins`, `addons/<site_ref>/plugins` or `addons/shared_addons/plugins`

## Usage

1. Add `{{ adminbar:assets }}` to your template, preferably inside of `<head>` after all the other styles
2. then put `{{ adminbar:show }}` somewhere into `<body>`, preferably immediately after the opening tag

## Todo

- Make the code nicer
- Add more "New X"
- Make Multilanguage *done*
- Make Module-aware *done*
- Make Permissions-aware (currently the adminbar displays whenever there is an active, logged-in user)
- …

## Screenshots

![Screenshot](http://nicolasschneider.com/work/adminbar/pyro-adminbar-000.png)
![Screenshot](http://nicolasschneider.com/work/adminbar/pyro-adminbar-001.png)
![Screenshot](http://nicolasschneider.com/work/adminbar/pyro-adminbar-002.png)
![Screenshot](http://nicolasschneider.com/work/adminbar/pyro-adminbar-003.png)
![Screenshot](http://nicolasschneider.com/work/adminbar/pyro-adminbar-004.png)
![Screenshot](http://nicolasschneider.com/work/adminbar/pyro-adminbar-005.png)
![Screenshot](http://nicolasschneider.com/work/adminbar/pyro-adminbar-006.png)