<ul style="width:730px;">
    <li>    
    <?php     
          if(Yii::app()->controller->action->id=='student')
          {
          echo CHtml::link(Yii::t('app','Student'), array('/importcsv/users/student'),array('class'=>'active'));
          }
          else
          {
          echo CHtml::link(Yii::t('app','Student'), array('/importcsv/users/student'));
          }
    ?>
    </li>
    
    <li>    
    <?php     
          if(Yii::app()->controller->action->id=='parent')
          {
          echo CHtml::link(Yii::t('app','Parent'), array('/importcsv/users/parent'),array('class'=>'active'));
          }
          else
          {
          echo CHtml::link(Yii::t('app','Parent'), array('/importcsv/users/parent'));
          }
    ?>
    </li>
    
    <li>    
    <?php     
          if(Yii::app()->controller->action->id=='employee')
          {
          echo CHtml::link(Yii::t('app','Teacher'), array('/importcsv/users/employee'),array('class'=>'active'));
          }
          else
          {
          echo CHtml::link(Yii::t('app','Teacher'), array('/importcsv/users/employee'));
          }
    ?>
    </li>
</ul>