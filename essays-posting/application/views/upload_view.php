<?php echo form_open_multipart('/essays/do_upload');?>
<label>Category of Essay<select name=cat>
	<?php $q=$this->db->query("select categories.cid, categories.name from categories"); ?>
	<?php foreach($q->result() as $row) echo "<option value=\"".$row->cid."\">".$row->name."</option>"?>
</select></label><br>
<label>Essay Name<input type="text" name="fn"/></label>
<input type="file" name="userfile" size="20" />
<input type="submit" value="upload" />
</form>