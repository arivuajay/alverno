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
    
        <title><?php $college=Configurations::model()->findByPk(1); ?><?php echo $college->config_value ; ?></title>
        
        <style type="text/css" >
        
        .loginboxWrapper {
            background: none repeat scroll 0 0 #fff;
            border-radius: 0px;
            color: #3e3d3d;
            font-size: 12px;
			min-height: 510px;
            margin: 123px auto 44px;
            width: 353px;
			border-left: 0px solid #ffbb00;
			border-top: 10px solid #ffbb00
        }
        .lw_left {
            border-right: 0px solid #f5f5f5;
            float: left;
            height: 290px;
            position: relative;
            width: 309px;
        }
        .lw_right {
            color: #706f6c;
            float: left;
            font-family: Helvetica;
            font-size: 11px;
            height: auto;
            margin: 43px 0 0 8px;
            padding: 20px;
            position: relative;
            width: 257px !important;
        }
        .formbut {
            background: #979B20;
            border: 1px solid #858914;
            color: #fff;
            cursor: pointer;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 14px;
            height: 40px;
            margin:15px 0;
           width: 252px;}
            
        .formbut:hover{ background-color:#6F720C;
        webkit-transition: all .4s ease-in-out;
        -moz-transition: all .4s ease-in-out;
        -o-transition: all .4s ease-in-out;
        transition: all .4s ease-in-out;}
            
        /*.Newbut{
            background:#5B9A28;
            border: 1px solid #538E22;
            border-radius: 3px;
            text-transform: uppercase;
            color: #fff;
            cursor: pointer;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 14px;
            font-weight: bold;
            height: 43px;
            margin:15px 0;
            width: 252px;
            text-shadow: 1px 1px 1px #417c10;
			}*/
			
			.Newbut{
				
				background: none repeat scroll 0 0 #5b9a28;
				border: 1px solid #538e22;
				color: #fff !important;
				cursor: pointer;
				display: block;
				font-family: Arial,Helvetica,sans-serif;
				font-size: 13px;
				margin: 15px 0;
				padding: 8px 0;
				text-align: center;
				text-decoration: none !important;
				text-transform: uppercase;
				width: 249px;
			}
			
			
			.oldbut{
				
				background: none repeat scroll 0 0 #219e3c;
				border: 1px solid #538e22;
				color: #fff !important;
				cursor: pointer;
				display: block;
				font-family: Arial,Helvetica,sans-serif;
				font-size: 14px;
				margin: 15px 0;
				padding: 8px 0;
				text-align: center;
				text-decoration: none !important;
				text-transform: uppercase;
				width: 249px;
			}
			
			
			.oldbut:hover{ background-color:#0D7724;
        webkit-transition: all .4s ease-in-out;
        -moz-transition: all .4s ease-in-out;
        -o-transition: all .4s ease-in-out;
        transition: all .4s ease-in-out;}
			
            
        .Newbut:hover{ background-color:#326B0C;
        webkit-transition: all .4s ease-in-out;
        -moz-transition: all .4s ease-in-out;
        -o-transition: all .4s ease-in-out;
        transition: all .4s ease-in-out;}
            
        .lw_logo {
            height: 161px;
            left: 51px;
            position: absolute;
            top: 175px;
            margin-bottom:20px;
        }
		
	.old_add {
            height: 161px;
    left: 51px;
    margin-bottom: 20px;
    position: absolute;
    top: 192px;
    z-index: 1001;
        }
		
		
	.lw_2 {
            height: 161px;
            left: 51px;
            position: absolute;
            top: 144px;
            margin-bottom:20px;
        }
        
        input[type="text"], input[type="password"] {
            background: none repeat scroll 0 0 #ededed;
            border: 0 solid #dddddd;
            color: #333;
            font-size: 12px;
            outline: medium none;
            padding: 11px 10px;
        }
        
        .lw_right {
            color: #706f6c;
    float: left;
    font-family: Helvetica;
    font-size: 11px;
    height: auto;
    margin: -59px 0 0 31px;
    position: relative;
    z-index: 1002;
        }
        
        .logo{left: 123px;
            position: absolute;
            top:7px;}
            
        .head{left: 50px;
            position: absolute;
            top:123px;}
            
        h1{
            color: #000;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 24px !important;
            text-transform: uppercase;
            }
			
		.bottom_arrow{ bottom: 2px;
    left: 168px;
    position: absolute;
	cursor:pointer;
	z-index:1003;}
            
        </style>
    </head>
    <body>    
        <div class="loginboxWrapper" style="position: relative;">
           
            <div class="lw_left">
			<?php 
			$subdomain = $_SERVER['SERVER_NAME'];
			if($subdomain == 'demo.skola360.se'){
			?>
            	<div class="logo"><img src="<?php echo Yii::app()->baseURL; ?>/images/skola-logo.png" height="90" ></div>.
			<?php }else{ ?>   
				<div class="logo"><img src="<?php echo Yii::app()->baseURL; ?>/images/login-logo.png" height="90" ></div>.
			<?php } ?>	
 <div class="head">
                <h1><strong><?php echo Yii::t('app','Student Admission'); ?></strong></h1>
            </div>                
            	<div class="old_add">
                	<?php echo CHtml::link(Yii::t('app','Registered Parents'), array('/user/login'),array('class'=>'oldbut')); ?>
                	<!--<input type="submit" value="New Admission" name="yt0" class="Newbut" step="background-color:#393939">-->
				</div>
                
                <div class="lw_2">
                	<?php echo CHtml::link(Yii::t('app','New Admission'), array('step1'),array('class'=>'Newbut')); ?>
                	<!--<input type="submit" value="New Admission" name="yt0" class="Newbut" step="background-color:#393939">-->
				</div>
            </div>
            <div class="lw_right">
            	<p><?php echo Yii::t('app','Enter your application ID and Password to check status'); ?></p>
            	<?php 
                if(CHtml::errorSummary($model))
                { 
                ?>
                	<span class="errorSummary"><?php echo Yii::t('app','Application ID or PIN is incorrect'); ?></span>
                <?php 
                }
                ?>
                <div class="form">
                	<?php echo CHtml::beginForm(); ?>
                        <div style="padding:0px 0 0 0px; text-align:left">
                        <?php echo CHtml::activeTextField($model,'registration_id', array('placeholder'=>Yii::t('app','Application Id'),'style'=>'width:250px;')) ?><br /><br />
                        <?php echo CHtml::activePasswordField($model,'password', array('placeholder'=>Yii::t('app','Password'),'style'=>'width:250px;')) ?>
                        <!--<input type="submit" value=" Check Status /Edit Profile" name="yt0" class="formbut">-->
                        <?php echo CHtml::submitButton(Yii::t('app','Check Status'),array('class'=>'formbut')); ?>    
                        </div>
                    <?php echo CHtml::endForm(); ?>
                </div>
				
        	</div>
            <?php if(Yii::app()->user->id==NULL) { ?>
             <div class="bottom_arrow"><a href="<?php echo Yii::app()->createUrl('/user/login'); ?>"><img src="<?php echo Yii::app()->baseURL; ?>/images/back_reg.png"></a></div>
            <?php  } ?>
            <div class="clear"></div>
        </div> <!-- END div class="loginboxWrapper" -->
        <div class="clear"></div>
       
    </body>
</html>


