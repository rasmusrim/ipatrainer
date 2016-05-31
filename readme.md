# The IPA Trainer
## History
In 2008 I wrote the IPA Trainer as a part of an exam I was doing in English language at the university in Tromsø. It caught on and had at a point more than 10 000 visitors in a month.

Unfortunately, after the exam was done, I had no time to continue working on it and it "decayed". In 2016 I decided to open-source it to see if it still had the "right to live". I am now looking for contributors to help me keep/make the site [http://www.ipatrainer.com](http://www.ipatrainer.com) the best solution for learning and writing IPA on the web.

I have removed all google ads and any other commercial things. I hardly made enough money that way to pay for the server rent anyway,

## Installation
1. Clone the repository by running
`git clone git@github.com:rasmusrim/ipatrainer.git`

2. Create the mysql database and load the file ``ipatrainer.sql`` into it.

3. Create a file named ``config.php`` in the root ipatrainer directory. This file contains sensitive information, and is in the ``.gitignore`` file. This is what the content of that file should look like. Fill in the information for your local system where specified:
```php
<?PHP

define('APP_VERSION', '1.0');
define('MAIN_SYSTEM_LANGUAGE_ID', 1);

// FILL IN YOUR INFO HERE. START
define('DB_PREFIX', ''); // With trailing _
define("DB_HOST", "localhost");
define("DB_DATABASE", "ipa");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "root");

define('ROOT_PATH', '/var/www/html/ipatrainer'); // Without trailing /
define('ROOT_URL', 'http://localhost/ipatrainer');
define("COOKIE_DOMAIN", 'localhost');
// END.	

define('ADMIN_PATH', ROOT_PATH . '/admin'); // Without trailing /
define('TEMPLATE_PATH', ROOT_PATH . '/user/templates');
define('CACHE_PATH', ROOT_PATH . '/data/cache');
define('DATA_PATH', ROOT_PATH . '/data');
define('LANGUAGES_PATH', DATA_PATH . '/languages');
define('PHP_PATH', DATA_PATH . '/php');
define('USER_PATH', ROOT_PATH . '/user');
define('TEMPLATES_PATH', ROOT_PATH . '/user/templates');
define('SITE_PATH', ROOT_PATH . '/user/site');
define('IPA_WRITER_PATH', ROOT_PATH . '/user/ipawriter');
define('SUPER_ADMIN_PATH', ROOT_PATH . '/superadmin');

define('ADMIN_URL', ROOT_URL . '/admin');
define('DATA_URL', ROOT_URL . '/data');
define('FORUM_URL', ROOT_URL . '/user/forum');
define('GFX_URL', DATA_URL . '/gfx');
define('SND_URL', DATA_URL . '/snd');
define('PDF_URL', DATA_URL . '/pdf');
define('SITE_URL', ROOT_URL . '/user/site');
define('FLASH_URL', DATA_URL . '/flash');
define('IPA_WRITER_URL', ROOT_URL . '/user/ipawriter');
define('SUPER_ADMIN_URL', ROOT_URL . '/superadmin');
define('STYLES_URL', ROOT_URL . '/user/styles');
define('USER_URL', ROOT_URL . '/user');


// To which file should the user be directed after having logged in?
define('AFTER_LOGIN_REDIRECT_TO', ADMIN_URL . '/main/index.php');
?>
```

## TODO:
There are many things that need to be done. These are my priorities:

1. Convert procedural mysql into object oriented mysqli.  
2. Make the IPA Trainer object oriented.  
3. Turn PHP-rendering of consonant tables and vowel trapeziums into JavaScript-rendering.  
4. Make the exercises AJAX-based.
5. Get rid of the flash based sound player and embrace HTML5 100%.




