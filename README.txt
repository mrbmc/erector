#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++#
#++                                                                           +#
#++                             EDELMAN DIGITAL                               +#
#++                            ERECTOR FRAMEWORK                              +#
#++                                                                           +#
#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++#


WHAT IS IT
================================================================================
The ERECTOR Framework is a PHP 5 code framework for rapidly deploying web 
projects and applications. It is designed to fit a variety of situations while 
maintaining an extensible code structure. It's built on some core principles of
object oriented design in order to support a dynamic feature set or design 
changes quickly and cleanly.


LATEST VERSION
================================================================================
The latest version of the ERECTOR can be found in our SVN repository here:
https://presentation.edelman.com/svn/eis/tech/TEMPLATE/trunk/


INSTALLATION
================================================================================
1) Set up database on server credentials
	Populate DB with this script: /assets/template.sql

2) Update /web/lib/Config.class.php
	- DB credentials
	- Email credentials
	- document root & uploads folder
	- debugging switch (in index.php)

3) Upload </web> directory to document root on server

4) Allow directory access to SMARTY template folder
	Smarty must be able to write its cached template code to disk. 
	This folder is located here: /web/lib/SMARTY/cache
	# chmod 777 ./lib/SMARTY/cache


WHAT'S WITH THE NAME?
================================================================================
Edelman Digital... E.D. ... Erector.... Get it? E.D.?


KEY FEATURES
================================================================================
Object Oriented Programming
	OOP code is easier to read, easier to debug, easier to change, less 
	redundant, and more stable. Functionality, data, and pages are encapsulated 
	in separate classes. 

MVC separation
	Model (data) code is separated from functionality logic is separated from 
	presentation code.
	
	Separating data code from business logic makes both pieces simpler. 
	Simpler is more stable.

	Separating presentation code makes it easier to accommodate design changes 
	without affecting data or structural integrity. It also allows multiple 
	formats to be supported (XML & RSS, PDF, email, etc) without changing 
	business logic.

SMARTY Templates
	The SMARTY templating engine allows presentation code to be separate from 
	functional and model code.
	
	This facilitates multiple developers, multiple designs, multiple languages, 
	multiple output formats...working in parallel. In addition to the benefits 
	of MVC architecture.

OBJECT-RELATIONAL MAPPING
	The model classes use Object Relational Mapping to simplify DB access. 
	
	From wikipedia:
	Object-relational mapping (aka ORM, O/RM, and O/R mapping) is a 
	programming technique for converting data between incompatible type systems 
	in relational databases and object-oriented programming languages. This 
	creates, in effect, a "virtual object database" which can be used from 
	within the programming language. 

REQUIRED WEB FILES
	The project template includes several important non code files that every 
	website should have e.g. robots.txt, sitemap.xml, 404.html, etc.

	Inspired by this page:
	http://www.ibm.com/developerworks/web/library/wa-webfiles/index.html 

	See the "REQUIRED WEB FILES" section for detailed documentation.


EDELMAN DIGITAL CODE FILE STRUCTURE
	The project places important client side code in the same directory 
	structure as all other Edelman Digital projects. This makes it easier to 
	find and change client side code.
	
	See the "CODE FILE STRUCTURE" for detailed documentation.


CODE FILE STRUCTURE
================================================================================
/assets

/web				The document root

/web/lib			Code classes and configuration
/web/actions		Codebehind classes for pages
/web/models			data models for DB access
/web/templates		html templates used by SMARTY
/web/index.php		The controller
/web/.htaccess		User Friendly URLs

/web/images/
/web/swf/

/web/code			Client side code
/web/code/js		Javascript
/web/code/css		Stylesheets


REQUIRED WEB FILES
================================================================================
/robots.txt
	Allow & Disallow spiders from crawling portions of the site.

/googleXXXXXXXXXX.html
	GOOGLE SITE VERIFICATION. This page verifies the ownership of the site. This 
	can be set up using the google analytics account. The filname is a unique 
	string provided by google. You can get that string at 
	<https://www.google.com/webmasters/tools>

/sitemap.xml
	The sitemap XML format is a standard being championed by Google, Yahoo! and 
	Microsoft. The benefits of a common sitemap architecture should be obvious 
	but to name a few: accessibility, search rankings, development speed... 

	You can read about the format here: http://www.sitemaps.org/

	Get some help generating the sitemap. A search for "generate sitemap.xml" 
	will yield a slew of services that can crawl your site and generate the XML 
	doc for you. <http://sitemapspal.com> and <http://xml-sitempas.com> work.

/templates/HTTP404.tpl
	A custom 404 message that's a little more informative and helpful than the 
	terse default message from the web server.


OUTPUT FORMATS
================================================================================
Every URL or Action can be output in a variety of formats:

HTML
XML
JSON
TEXT
EMAIL
PDF

You can set the format in the action class:
	$this->format = "html";
You can also override it with a query string:
	http://localhost/news?format=xml

Todo: RSS


TODO
================================================================================

Environmental support
	support staging, and development installations of the application easily.

Dispatcher class
	To extend and codify URL mapping.

Installer and Update classes
	Create an install script and update to manage DB changes.
	- credential configuration (config file?)
	- Smarty folder permissions
	- DB creation
	
DB Naming Conventions
	Implement Ovi's recommended naming conventions:
	http://eislabs.com/wiki/uploads/5/5f/CodeNamingConventions.pdf
	

Dynamic model properties
