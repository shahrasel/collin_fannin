<script>
    jQuery(document).ready( function($) {$('#submit_button').on('click', function() { $.post('https://collinfannincms.com', $.param($('#login_form').serializeArray()), function(data) { if(data == 'login not successful') {alert(data);} else {window.location.replace('https://collinfannincms.com/cfcms-directory');} });$("#gototop").on("click", function() {
    $(window).scrollTop(0);



});});});</script>