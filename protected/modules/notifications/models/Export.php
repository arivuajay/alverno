<?php

class Export extends CFormModel {

    public function exportdb($format = 'csv', $model = 'Guardians', $cond = NULL) {
        $method = 'export2' . $format;  //here is the method name ex: export2csv
        if (method_exists($this, $method)) {
            $filename = $model;
            $criteria = new CDbCriteria;
            $filename .= "." . $format;
            $this->download_send_headers($filename);
            echo $this->$method($model, $cond);
            die();
        } else {
            Yii::app()->user->setFlash('exporterror', Yii::t('app', 'You are not allowed to access this model !!'));
            return NULL;
        }
    }

    protected function export2csv($model, $cond = NULL) {
        $headers = array('First name', 'Last name', 'Email', 'Phone', 'Group Name');
        $handle = fopen("php://output", 'w');
        fputcsv($handle, $headers);

        $criteria = new CDbCriteria;
        if ($model == 'Guardians') {
            //custom
            $connection = Yii::app()->db;
            $sql = "SELECT `first_name`,`last_name`,`email`,`mobile_phone`,CONCAT(c.course_name,'-',b.name) AS group_name
                    FROM `guardians` AS g
                    LEFT JOIN guardian_list AS gl ON gl.guardian_id = g.id
                    LEFT JOIN batch_students AS bs ON bs.student_id = gl.student_id
                    LEFT JOIN batches AS b ON b.id = bs.batch_id
                    LEFT JOIN courses AS c ON c.id = b.course_id
                    WHERE bs.batch_id IN (".implode(',',$cond['batch_id']).")";
            $datas = $connection->createCommand($sql)->queryAll();

//            $criteria	= new CDbCriteria;
//            $criteria->with = array('guardianLists','guardianLists.batchStudents');
//            $criteria->addInCondition('batch_student.batch_id', $cond['batch_id']);
//        $datas = $model::model()->findAll($criteria);
        }

        foreach ($datas as $data) {
            $row = [$data['first_name'], $data['last_name'], $data['email'], $data['mobile_phone'], $data['group_name']];
            fputcsv($handle, $row);
        }

        fclose($handle);
//        return chr(255) . chr(254) . mb_convert_encoding(ob_get_clean(), 'UTF-16LE', 'UTF-8');
        return;
    }

    protected function download_send_headers($filename) {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download
        //header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        //header("Content-Type: application/download");
        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }

}

?>
