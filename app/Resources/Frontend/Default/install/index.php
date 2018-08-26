<?php
	use App\Common\Utils\StringUtils;

	$sColumn1Classes = "col-sm-5 col-form-label text-right";
	$sColumn1TitleClasses = "col-sm-5 text-right";
	$sColumn2Classes = "col-sm-4";
	$sColumn2WideClasses = "col-sm-7";
?>
<div class="row">
  <div class="col-3 col-md-2"></div>
  <div class="col-12 col-md-8">
	<div class="row justify-content-end" style="padding:10px">
		<div class="col-2">
			<select id="language-selector">
			<?php foreach (config('app.aLanguages') as $sLanguage): ?>
				<option 
					value="<?php echo $sLanguage ?>" 
					<?php if (config('app.locale') == $sLanguage): ?>selected="selected"<?php endif ?>
				>
					<?php echo strtoupper($sLanguage) ?>	
				</option>
			<?php endforeach ?>
			</select>
			<script>
				document
					.getElementById("language-selector")
					.onchange = function() 
					{
						location.href = location.href.split('?')[0] + '?' + 'sLanguage=' + this.value;
					}
			</script>
		</div>
	</div>

	<?php if (isset($aErrors) && !empty($aErrors)): ?>
		<div class="alert alert-danger" role="alert">
			<ul style="margin:0px">
			<?php foreach ($aErrors as $iErrorCode): ?>
		  	<li><?php echo __("exception_$iErrorCode") ?></li>
		  <?php endforeach ?>
		</div>
	<?php endif ?>

	<h1><?php echo __("installation")?></h1>

	<form action="" method="POST">

		<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">

		<hr/>

		<div class="<?php echo $sColumn1TitleClasses ?>">
			<h5><?php echo __("admin_panel")?></h5>
		</div>

	  <div class="form-group row">
	    <label class="<?php echo $sColumn1Classes ?>"><?php echo __("admin_dir")?></label>
	    <div class="<?php echo $sColumn2Classes ?>">
	      <input type="text" class="form-control" placeholder="<?php echo __("admin_dir")?>" name="sAdminDir" value="<?php echo request()->input("sAdminDir", StringUtils::fnRandomString(10)) ?>">
	    </div>
	  </div>

		<hr/>

		<div class="<?php echo $sColumn1TitleClasses ?>">
			<h5><?php echo __("super_administrator")?></h5>
		</div>
	  
	  <div class="form-group row">
	    <label class="<?php echo $sColumn1Classes ?>"><?php echo __("login")?></label>
	    <div class="<?php echo $sColumn2Classes ?>">
	      <input type="text" class="form-control" placeholder="<?php echo __("login")?>" name="sSuperAdministratorLogin" value="<?php echo request()->input("sSuperAdministratorLogin") ?>">
	    </div>
	  </div>

	  <div class="form-group row">
	    <label class="<?php echo $sColumn1Classes ?>"><?php echo __("password")?></label>
	    <div class="<?php echo $sColumn2Classes ?>">
	      <input type="password" class="form-control" placeholder="<?php echo __("password")?>" name="sSuperAdministratorPassword" value="<?php echo request()->input("sSuperAdministratorPassword") ?>">
	    </div>
	  </div>

	  <hr/>

	  <div class="<?php echo $sColumn1TitleClasses ?>">
			<h5><?php echo __("database")?></h5>
		</div>

	  <div class="form-group row">
	    <label class="<?php echo $sColumn1Classes ?>"><?php echo __("database_driver_type")?></label>
	    <div class="<?php echo $sColumn2Classes ?>">
	      <?php 
	      	$aPDODrivers = pdo_drivers();
	      	$aDrivers = array_keys(config("database.connections"));
	      	$aDrivers = array_intersect($aPDODrivers, $aDrivers);
	      ?>
	      <select class="form-control" name="sDatabaseDriver">
	      	<?php foreach ($aDrivers as $sDriver): ?>
	      		<option 
	      			value="<?php echo $sDriver ?>"
	      			<?php if (request()->input("sDatabaseDriver") == $sDriver): ?>
	      				selected="selected"
	      			<?php endif ?>
	      		>
	      			<?php echo $sDriver ?>
	      		</option>
	      	<?php endforeach ?>	
	      </select>
	    </div>
	  </div>

		<div class="form-group row">
			<div class="<?php echo $sColumn1TitleClasses ?>"></div>
	    <div class="<?php echo $sColumn2WideClasses ?> form-check">
	      <input 
	      	class="form-check-input" 
	      	type="checkbox" 
	      	id="create_database_checkbox" 
	      	name="bDatabaseCreate"
	      	<?php if (request()->input("bDatabaseCreate", false)): ?>
	      		checked="checked"
	      	<?php endif ?>
	      >
	      <label class="form-check-label" for="create_database_checkbox">
	        <?php echo __("database_create")?>
	      </label>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label class="<?php echo $sColumn1Classes ?>"><?php echo __("database_name")?></label>
	    <div class="<?php echo $sColumn2Classes ?>">
	      <input type="text" class="form-control" placeholder="<?php echo __("database_name")?>" name="sDatabaseName" value="<?php echo request()->input("sDatabaseName") ?>">
	    </div>
	  </div>

	  <div class="form-group row">
	    <label class="<?php echo $sColumn1Classes ?>"><?php echo __("database_host")?></label>
	    <div class="<?php echo $sColumn2Classes ?>">
	      <input type="text" class="form-control" placeholder="<?php echo __("database_host")?>" name="sDatabaseHost" value="<?php echo request()->input("sDatabaseHost") ?>">
	    </div>
	  </div>

	  <div class="form-group row">
	    <label class="<?php echo $sColumn1Classes ?>"><?php echo __("database_port")?></label>
	    <div class="<?php echo $sColumn2Classes ?>">
	      <input type="text" class="form-control" placeholder="<?php echo __("database_port")?>" name="sDatabasePort" value="<?php echo request()->input("sDatabasePort") ?>">
	    </div>
	  </div>

	  <div class="form-group row">
	    <label class="<?php echo $sColumn1Classes ?>"><?php echo __("database_user_name")?></label>
	    <div class="<?php echo $sColumn2Classes ?>">
	      <input type="text" class="form-control" placeholder="<?php echo __("database_user_name")?>" name="sDatabaseUserName" value="<?php echo request()->input("sDatabaseUserName") ?>">
	    </div>
	  </div>

	  <div class="form-group row">
	    <label class="<?php echo $sColumn1Classes ?>"><?php echo __("database_password")?></label>
	    <div class="<?php echo $sColumn2Classes ?>">
	      <input type="password" class="form-control" placeholder="<?php echo __("database_password")?>" name="sDatabasePassword" value="<?php echo request()->input("sDatabasePassword") ?>">
	    </div>
	  </div>


	  <div class="form-group row">
	    <label class="<?php echo $sColumn1Classes ?>"><?php echo __("database_socket")?></label>
	    <div class="<?php echo $sColumn2Classes ?>">
	      <input type="text" class="form-control" placeholder="<?php echo __("database_socket")?>" name="sDatabaseSocket" value="<?php echo request()->input("sDatabaseSocket") ?>">
	    </div>
	  </div>

	  <hr/>

	  <div class="form-group row">
	  	<div class="<?php echo $sColumn1TitleClasses ?>"></div>
	    <div class="<?php echo $sColumn2Classes ?>">
	      <button type="submit" class="btn btn-primary"><?php echo __("submit")?></button>
	    </div>
	  </div>

	</form>  	
  </div>
  <div class="col-3 col-md-2"></div>
</div>
