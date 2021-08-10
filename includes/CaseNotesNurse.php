<?php


require_once("initialize.php");

class CaseNotesNurse extends DatabaseObject
{
    protected static $table_name = "case_notes_nurse";
    protected static $db_fields = array('id', 'sync', 'subject', 'comment', 'patient_id', 'date');
    public $id;
    public $sync;
    public $subject;
    public $comment;
    public $patient_id;
    public $date;
    

    public static function find_all_by_nurse_patient_id($pat_id){
        return static::find_by_sql("SELECT * FROM " .static::$table_name. " WHERE patient_id = '$pat_id' ORDER BY date DESC " );
    }

    public static function create_table()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS ' . CaseNotesNurse::$table_name . '(' .
            'id INT NOT NULL AUTO_INCREMENT, ' .
            'sync VARCHAR(20) NOT NULL, ' .
            'subject VARCHAR(250) NOT NULL, ' .
            'comment text NOT NULL, ' .
            'patient_id VARCHAR(100) NOT NULL, ' .
            'date DATETIME NOT NULL, ' .
            'PRIMARY KEY(id))';        
            CaseNotesNurse::run_script($sql);
    }


}

CaseNotesNurse::create_table();




