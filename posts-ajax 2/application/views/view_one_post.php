<!-- We require id and description -->
<?php $id=$data["id"]; $d = $data["d"]; ?>
<div id="<?php echo $id; ?>" class="block">
	<p class="description"><?php echo $d; ?></p>
	<form class="delete_post_form" action="/posts/delete_post" method="post">
		<input type="hidden" name="idpost" value="<?php echo $data["id"]; ?>">
	</form>
	<div class="button_area">
		<button id="edit<?php echo $id;?>" class="btn btn-primary btn edit_button" data-toggle="modal" data-target="#button<?php echo $id; ?>">Edit</button>
		<button class="btn btn-primary btn delete_button" id="delete<?php echo $id;?>">Delete</button>
	</div>
	<div class="modal fade" id="<?php echo "button".$id;?>">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">x</span>
						<span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title">Please give a new description</h4>
				</div>
				<form class="change_post_form" action="/posts/change_post" method="post">
					<input type="hidden" name="idpost" value=<?php echo $id;?>>
					<textarea name="description" rows="10" cols="50"></textarea>
					<input type="submit" class="btn btn-primary" value="change post">
				</form>
			</div>
		</div>
	</div>
</div>