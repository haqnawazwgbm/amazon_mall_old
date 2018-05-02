<style>
	.file{
		height: 160px;
	}
	.file p{
		line-height: 110px;
		background: red;
		text-align: center;
		font-weight: bold;
		margin: 0;
		color: #fff;
	}
	.image{
		height: 160px;
	}
</style>
<div class="col-md-12">
	<?php if (!empty($allfiles)): ?>
		<?php foreach ($allfiles as $list): ?>
			<?php if ($list->extension != 'png' && $list->extension != 'jpeg' && $list->extension != 'jpg' && $list->extension != 'gif'): ?>
			  	<div class="col-md-2 file">
			  		<p><?php echo $list->extension; ?></p>
			  		<div class="btn-group">
			  			<a href="<?php echo $list->url.$list->filename; ?>" download class="btn btn-success btn-sm"> <i class="fa fa-download"></i></a>
			  			<a onclick="deleteFile(<?php echo $list->id; ?>)" class="btn btn-danger btn-sm"><i class="fa fa-times-circle"></i></a>
			  		</div>
			  	</div>
			<?php else: ?>
				<div class="col-md-2 image">
					<a href="<?php echo $list->url.$list->filename?>">
				  		<img width="100%" src="<?php echo $list->url.$list->filename?>" alt="<?php echo $list->orignal_name; ?>">
			  		</a>
			  		<div class="clearfix"></div>
			  		<div class="btn-group">
			  			<a href="<?php echo $list->url.$list->filename; ?>" download class="btn btn-success btn-sm"> <i class="fa fa-download"></i></a>
			  			<a  onclick="deleteFile(<?php echo $list->id; ?>)" class="btn btn-danger btn-sm"><i class="fa fa-times-circle"></i></a>
			  		</div>
			  	</div>
			<?php endif ?>
		<?php endforeach ?>
	<?php endif ?>
</div>