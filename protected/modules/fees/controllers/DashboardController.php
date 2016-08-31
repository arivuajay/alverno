<?php
class DashboardController extends RController
{
	public function filters()
	{
		return array(
			'rights', // perform access control for CRUD operations
		);
	}
	
	public function actionIndex()
	{
		//all fee categories
		$total_categories	= FeeCategories::model()->count();
		
		//fee categories
		$page_size			= 10;
		
		$criteria			= new CDbCriteria;		
		$criteria->order	= "`id` DESC";
		$total			= FeeCategories::model()->count($criteria);
		$pages 			= new CPagination($total);
        $pages->setPageSize($page_size);
        $pages->applyLimit($criteria);		
		$categories		= FeeCategories::model()->findAll($criteria);
		
		//invoices generated for
		$criteria		= new CDbCriteria;
		$criteria->compare("invoice_generated", 1);				
		$invoices_for	= FeeCategories::model()->findAll($criteria);
		
		$this->render('index', array('categories'=>$categories, 'pages' => $pages, 'item_count'=>$total, 'page_size'=>$page_size, 'total_categories'=>$total_categories, 'invoices_for'=>$invoices_for));
	}
}