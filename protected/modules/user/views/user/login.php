<?php
	$lan	= 'en_us';
	if(isset($_SESSION['user-lan'])){
		$lan	= $_SESSION['user-lan'];
	}
	else{
		$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
		if(isset($settings) and $settings!=NULL)
		{
			$lan	= $settings->language;
		}
	}
	
	Yii::app()->translate->setLanguage($lan);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/login.css" />
    <link rel="icon" type="image/ico" href="<?php echo Yii::app()->request->baseUrl; ?>/uploadedfiles/school_logo/favicon.ico"/>
     <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/js/jquery-1.7.1.min.js"></script>
	 <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/capslock.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js_plugins/showpassword/jquery.showPassword.js"></script>
<script type="text/javascript">

  function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';

    else if (field.value == '') field.value = field.defaultValue;
 }

</script> 
<script>
$(document).ready(function() {
  $(':password').showPassword({
    linkRightOffset: 5,
    linkTopOffset: 8,
	linkText: '',
    showPasswordLinkText: '',

  });
});
</script>

<style>

.show-password-link {
  display: block;
  position: absolute;
  z-index: 11;
  background:url(images/psswrd_shwhide_icon.png) no-repeat;
  width:18px;
  height:12px;
  left: 212px !important;
 
 
  
 
 
}
.password-showing {
  position: absolute;
  z-index: 10;
}
</style> 
<title><?php $college=Configurations::model()->findByPk(1); ?><?php echo $college->config_value ; ?></title>
</head>    
<?php
$this->pageTitle=Yii::app()->name . ' - '.Yii::t("app", "Login");
$this->breadcrumbs=array(
	Yii::t("app", "Login"),
);
?>
<!--<div class="loginimg"></div>-->

<div class="loginboxWrapper">
<div class="lw_left">
	<div class="lw_logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/login-logo.png" height="161" /></div>
</div>
<div class="lw_right">
<h1><?php echo Yii::t("app", "Login"); ?></h1>

<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

<div class="success">
	<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>

<?php endif; ?>

<p><?php echo Yii::t("app", "Please fill out the following form with your login credentials:"); ?></p>

<div class="form">

<?php echo CHtml::beginForm(); ?>

	<?php /*?><p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p><?php */?>
	
	<?php if (CHtml::errorSummary($model))
	{
		?>
		<span class="errorSummary"><?php echo Yii::t("app", "The username or password you entered is incorrect.");?></span>
	<?php } ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<?php echo CHtml::activeTextField($model,'username', array('onblur'=>'clearText(this)','onfocus'=>'clearText(this)','value'=>Yii::t("app", 'Username or Email'))) ?></td>
  </tr>
  <tr>
    <td><?php echo CHtml::activePasswordField($model,'password', array('onblur'=>'clearText(this)','onfocus'=>'clearText(this)','value'=>Yii::t("app", 'Password'))) ?></td>
  </tr>
 <tr><td id="pid" style="color:#C60;background:url(<?php  echo Yii::app()->request->baseUrl; ?>/images/warning.png) no-repeat;display:none;padding-left:25px;"></td></tr>
  <tr>
    <td style="padding:0px;">
    <table width="60%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding:0px;"><?php echo CHtml::activeCheckBox($model,'rememberMe'); ?></td>
    <td align="left" style="padding:0px;"><?php echo CHtml::activeLabelEx($model,Yii::t('app','Remember Me')); ?></td>
  </tr>
</table>

	
		</td>
  </tr>
  <tr>
    <td>
    <table width="60%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php echo CHtml::submitButton(Yii::t("app", "Login"),array('class'=>'loginbut')); ?></td>
    <td><?php echo CHtml::link(Yii::t("app", "Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
    	<div class="student_reg">    
			<?php
				$academic_yr=OnlineRegisterSettings::model()->findByAttributes(array('id'=>2));
				$status=OnlineRegisterSettings::model()->findByAttributes(array('id'=>1));
				$show_link=OnlineRegisterSettings::model()->findByAttributes(array('id'=>4));
				$is_academic_yr = AcademicYears::model()->findAllByAttributes(array('is_deleted'=>0));
				if($is_academic_yr!=NULL)
				{
					if($academic_yr->config_value!=0 and $status->config_value!=0 and $show_link->config_value !=0)
					{
							
						echo CHtml::link(Yii::t("app", "Student Registration"),array('/onlineadmission/registration/index')).' <br/> ';		   
					
					}
				}
            ?>
        </div>
    
    </td>
  </tr>
</table>

	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php /*?><?php echo CHtml::activeLabelEx($model,Yii::t('user','username')); ?><?php */?>
<?php /*?><?php echo CHtml::activeLabelEx($model,Yii::t('user','password')); ?><?php */?>

<?php echo CHtml::endForm(); ?>
</div>
</div>
<div class="clear"></div>
</div>
</body>
</html>

<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);
?>
<script type="text/javascript">
$(document).ready(function() {

	var options = {
		caps_lock_on: function() {
			$('#pid').css({"display": "block"});
			$('#pid').html("Caps lock is on");
		},
		caps_lock_off: function() {
			$('#pid').css({"display": "none"});
		},
		
	};

	$("input[type='password']").capslock(options);

});
</script>