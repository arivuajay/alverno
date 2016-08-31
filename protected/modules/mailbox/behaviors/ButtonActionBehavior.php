<?php

class ButtonActionBehavior extends CBehavior
{
	
	public $controller;
	public $module;
	public $buttons = array();
	public $arclass;
	public function buttonAction($box='inbox' , $buttonset='default')
	{
		if(!$_POST['button']) {
			if($_GET['ajax'])
				die('{"error":"Action not found?"}');
			Yii::app()->user->setFlash('error', Yii::t('app',"Action not found?"));
			$this->controller->redirect(array($this->controller->getId().'/'.$box));
		}
		$action = key($_POST['button']);
		if(!array_key_exists($action,$this->buttons[$buttonset]))
			throw new Exception(Yii::t('app','Button action not found?'));
		
		$partialmsg = Yii::t('app',$this->buttons[$buttonset][$action]);
		
		$count=0;
		foreach($_POST['convs'] as &$conversation_id)
		{
			//rahul..........
			$delete_ever = NULL;
			if($_POST['button']['delete'] == 'Delete forever')
				$delete_ever = Yii::t('app','Delete forever');
			/*
			* None of the following errors should happen unless the user 
			* tampers with the input vars, so we ignore them and continue
			*/
			if(!is_int($conversation_id=(int)$conversation_id))
				continue;
			$conv = call_user_func(array($this->arclass, 'model'))->findByPk($conversation_id);

			if(!$conv->belongsTo($this->module->getUserId()))
				continue;
			if(!$conv->$action($this->module->getUserId(),$delete_ever) || !$conv->validate())
				continue;
			if($conv->save())
				$count++;
		}
		
		if($count)
		{
			$title = ucfirst($partialmsg);
			$message = $count.Yii::t('app'," message(s) have been"). "{$partialmsg}!";
			if(isset($_GET['ajax']))
			{
				$tinydesc = isset($_GET['dragdrop'])? ',"tinydesc":"+'.$count.' deleted!","dragdrop":"'.$_GET['dragdrop'].'"' : null;
				die('{"success":"'.$message.'"'.$tinydesc.',"title":"'.$title.'"}');
			}
			Yii::app()->user->setFlash('success', $message);
			$this->controller->redirect(array($this->controller->getId().'/'.$box));
		}
		else
		{
			$title = Yii::t('app',"Error occured?");
			$message = Yii::t('app',"Message could not be")."{$partialmsg}!";
			if(isset($_GET['ajax']))
			{
				$tinydesc = isset($_GET['dragdrop'])? ',"tinydesc":"Error deleting?","dragdrop":"'.$_GET['dragdrop'].'"' : null;
					die('{"error":"Error deleting?"'.$tinydesc.'}');
				die('{"error":"'.$message.'"}');
			}
			Yii::app()->user->setFlash('error', $message);
			$this->controller->redirect(array($this->controller->getId().'/'.$box));
		}
	}
}