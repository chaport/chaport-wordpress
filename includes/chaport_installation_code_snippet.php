<!-- Begin of Chaport Live Chat code -->
<script type="text/javascript">
(function(w,d,v2){
w.chaport = { app_id : '<?php echo $this->appId ?>', visitor: {} };
<?php if ($this->userEmail): ?>
w.chaport.visitor.email = '<?php echo $this->userEmail ?>';
<?php endif; ?>
<?php if ($this->userName): ?>
w.chaport.visitor.name = '<?php echo $this->userName ?>';
<?php endif; ?>
v2=w.chaport;v2._q=[];v2._l={};v2.q=function(){v2._q.push(arguments)};v2.on=function(e,fn){if(!v2._l[e])v2._l[e]=[];v2._l[e].push(fn)};var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://app.chaport.com/javascripts/insert.js';var ss=d.getElementsByTagName('script')[0];ss.parentNode.insertBefore(s,ss)})(window, document);
</script>
<!-- End of Chaport Live Chat code -->
