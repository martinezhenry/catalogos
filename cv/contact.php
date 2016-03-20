<? include('header.php')?>
    <div class="login">
       <div class="wrap">
	    <ul class="breadcrumb breadcrumb__t"><a class="home" href="#">Home</a>  / Contact</ul>
		   <div class="content-top">
			   <form method="post" action="contact-post.html">
					<div class="to">
                     	<input type="text" class="text" value="Name" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = 'Name';}">
					 	<input type="text" class="text" value="Email" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = 'Email';}" style="margin-left: 10px">
					</div>
					<div class="to">
                     	<input type="text" class="text" value="Your Website" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = 'Your Website';}">
					 	<input type="text" class="text" value="Subject" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = 'Subject';}" style="margin-left: 10px">
					</div>
					<div class="text">
	                   <textarea value="Message:" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = 'Message';}">Message:</textarea>
	                </div>
	                <div class="submit">
	               		<input type="submit" value="Submit">
	                </div>
               </form>
                
            </div>
       </div> 
    </div>
   <? include('footer.php')?>
</body>
</html>