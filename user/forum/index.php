<?PHP
require('../../config.php');


require(TEMPLATES_PATH . '/header.tmpl.php');

?>


<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-comments" data-href="http://www.ipatrainer.com/user/forum" data-num-posts="20" data-width="500"></div>

<?PHP
require(TEMPLATES_PATH . '/footer.tmpl.php');
?>
