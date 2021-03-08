COinS module for Omeka S
========================

> __New versions of this module and support for Omeka S version 3.0 and above
> are available on [GitLab], which seems to respect users and privacy better
> than the previous repository.__

[![Build Status](https://travis-ci.org/biblibre/omeka-s-module-Coins.svg?branch=master)](https://travis-ci.org/biblibre/omeka-s-module-Coins)

[COinS] is the module for [Omeka S] that allows to appends the COinS metadata
(or [Z39.88-2004]) in the html code of the items, so they can be fetched
automatically in bibliographic tools such as [Zotero].

This [Omeka S] module is a rewrite of [COinS plugin for Omeka] and
intends to provide the same features as the original plugin.

The COinS can be accessed via the api with the module [Api Info] through the url
"/api/infos/coins" + a search query.

This version is a fix / improvement of the module of [BibLibre].


Installation
------------

Uncompress files in the module directory and rename module folder `Coins`.
Check the letter case.

See general end user documentation for [installing a module].


Warning
-------

Use it at your own risk.

It’s always recommended to backup your files and your databases and to check
your archives regularly so you can roll back if needed.


Troubleshooting
---------------

See online issues on the [module issues] page on GitLab.


License
-------

This module is published under the [GNU/GPL] license.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA


Copyright
---------

* Copyrigh Roy Rosenzweig Center for History and New Media, 2007-2012
* Copright BibLibre, 2016-2017
* Copright Daniel Berthereau, 2018-2021 (see [Daniel-KM] on GitLab)


[COinS]: https://github.com/biblibre/omeka-s-module-Coins
[Z39.88-2004]: https://www.niso.org/publications/z3988-2004-r2010
[COinS plugin for Omeka]: http://omeka.org/add-ons/plugins/coins/
[Omeka S]: https://github.com/omeka/omeka-s
[Zotero]: https://zotero.org
[Api Info]: https://gitlab.com/Daniel-KM/Omeka-S-module-ApiInfo
[installing a module]: http://dev.omeka.org/docs/s/user-manual/modules/#installing-modules
[module issues]: https://gitlab.com/Daniel-KM/Omeka-S-module-Coins/-/issues
[GNU/GPL]: https://www.gnu.org/licenses/gpl-3.0.html
[BibLibre]: https://github.com/biblibre/omeka-s-module-Coins
[GitLab]: https://gitlab.com/Daniel-KM
[Daniel-KM]: https://gitlab.com/Daniel-KM "Daniel Berthereau"
