<?php


class StockRequest extends DatabaseObject
{
    protected static $table_name = "stock_request";
    protected static $db_fields = array('id', 'sync', 'sub_clinic_id', 'nurse_id', 'items_no', 'not_available', 'nurse_com', 'store_com', 'status', 'date');


    public $id;
    public $sync;
    public $sub_clinic_id;
    public $nurse_id;
    public $items_no;
    public $not_available;
    public $nurse_com;
    public $store_com;
    public $status;
    public $date;


    public static function find_requests_by_patientIdForBilledDrug( $patient_id){
        $result_array = static::find_by_sql("SELECT * FROM " .static::$table_name. " WHERE patient_id = $patient_id  and status='COSTED'" );
        return !empty($result_array) ? $result_array : FALSE;
    }

    public static function find_all_requests_by_id_scan_for_drug($ids){
        return static::find_by_sql("SELECT * FROM " .static::$table_name. " WHERE id = '$ids' " );
    }


    public static function find_awaiting_costing(){
        return static::find_by_sql("SELECT * FROM " .static::$table_name. " WHERE status = 'awaiting_costing' ORDER BY date DESC" );
    }

    public static function find_returned_prescription(){
        return static::find_by_sql("SELECT * FROM " .static::$table_name. " WHERE status = 'RETURNED' ORDER BY date DESC" );
    }

    public static function count_awaiting_costing(){
        global $database;
        $sql = "SELECT COUNT(*) FROM " .static::$table_name . " WHERE status = 'awaiting_costing'  " ;
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }

    public static function count_cleared(){
        global $database;
        $sql = "SELECT COUNT(*) FROM " .static::$table_name . " WHERE status = 'OPEN' ";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }

    public static function find_cleared(){
        return static::find_by_sql("SELECT * FROM " .static::$table_name. " WHERE status = 'OPEN' ORDER BY date DESC " );
    }

    public static function find_by_waiting_list_id($id=0){
        global $database;
        $result_array = static::find_by_sql("SELECT * FROM " .static::$table_name. " WHERE waiting_list_id=".$database->escape_value($id));
        return !empty($result_array) ? array_shift($result_array) : FALSE;
    }

    public static function find_requests($waiting_list, $patient_id){
        $result_array = static::find_by_sql("SELECT * FROM " .static::$table_name. " WHERE waiting_list_id = $waiting_list AND patient_id = $patient_id " );
        return !empty($result_array) ? array_shift($result_array) : FALSE;
    }

    public static function find_costed_bill_dept($bill_id=0){
        global $database;
        $result_array = static::find_by_sql("SELECT * FROM " .static::$table_name. " WHERE bill_id =".$database->escape_value($bill_id));
        return !empty($result_array) ? array_shift($result_array) : FALSE;
    }







    public static function find_by_encounter_id($encounter = 0)
    {
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE encounter_id = $encounter");
    }

    public static function find_unavailable()
    {
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE status = 'NA' ORDER BY date DESC");
    }

    public function find_by_bill_id_by_date($bill_id)
    {
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE bill_id = $bill_id ORDER BY date DESC");
    }

    public static function find_all_by_encounter_id($encounter = 0)
    {
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE encounter_id = $encounter");
    }

    public static function find_by_billed($bill_id = 0)
    {
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE bill_id = $bill_id  AND status = 'billed' ");
    }

    public static function find_costed_bill($encounter_id = 0)
    {
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE encounter_id = $encounter_id AND status = 'COSTED' ");
    }

    public static function find_bill_by_cost($bill_id = 0)
    {
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE bill_id = $bill_id AND status = 'COSTED' ");
    }

    public static function find_costed_bill_drug($encounter_id = 0)
    {
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE dept = 'drug' AND encounter_id = $encounter_id  AND status = 'COSTED' ");
    }

    public static function find_costed_bill_lab($encounter_id = 0)
    {
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE dept = 'lab' AND encounter_id = $encounter_id  AND status = 'COSTED' ");
    }

    /*    public static function find_costed_bill_by_dept($bill_id=0){
            return static::find_by_sql("SELECT * FROM " .static::$table_name. " WHERE dept = 'lab' AND bill_id = $bill_id  AND status = 'COSTED' " );
        }*/

    public static function find_costed_bill_by_dept($bill_id = 0)
    {
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE dept = 'lab' AND bill_id = $bill_id ");
    }

    public static function sum_all_billed($bill_id = 0)
    {
        global $database;
        $sql = "SELECT SUM(total_price) FROM " . static::$table_name . " WHERE bill_id = $bill_id AND status = 'billed' ";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }

    public static function find_paid_bill($encounter_id = 0)
    {
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE encounter_id = $encounter_id AND status = 'PAID' ");
    }

    public static function find_cleared_results($encounter_id = 0)
    {
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE encounter_id = $encounter_id AND status = 'CLEARED' ");
    }

    public static function find_by_patient_id_report($patId){
        return static::find_by_sql("SELECT * FROM " .static::$table_name. " WHERE patient_id = $patId" );
    }


    public static function create_table()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS ' . StockRequest::$table_name . '(' .
            'id INT(11) NOT NULL AUTO_INCREMENT, ' .
            'sync VARCHAR(20) NOT NULL, ' .
            'sub_clinic_id INT(11) NOT NULL, ' .
            'nurse_id INT(11) NOT NULL, ' .
            'items_no INT(11) NOT NULL, ' .
            'not_available INT(11) NOT NULL, ' .
            'nurse_com TEXT NOT NULL, ' .
            'store_com TEXT NOT NULL, ' .
            'status VARCHAR(50) NOT NULL, ' .
            'date DATETIME NOT NULL, ' .
            'PRIMARY KEY(id))';

        StockRequest::run_script($sql);
    }


    // Common Database Methods in the Parent class(DatabaseObject)

}

StockRequest::create_table();