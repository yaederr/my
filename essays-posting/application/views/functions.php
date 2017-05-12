<div id="functions">
	<div id="left_hand">
		<button id="select_latest">Latest</button>
		<button id="select_faves">Faves</button>
		<!-- <div id="select_search">Search</div> -->
	</div>
	<div id="right_hand">
		<!-- <div id="select_dl">DL</div> -->
		<!-- <div id="select_share">Share</div> -->
		<button id="select_upload">upload</button>
		<!-- <button id="select_fave">+Fave</button> -->
		<div id="fave_buttons"></div>
		<?php if(!$this->session->userdata("auth")){?>
		<button id="select_login">Login</button>
		<?php } ?>
		<?php if($this->session->userdata("auth")){ ?>
		<span class="functions_greeting">Hi, <?php echo $name; ?></span><button id="select_logout"> (Logout)</button>
		<?php } ?>
	</div>
</div>