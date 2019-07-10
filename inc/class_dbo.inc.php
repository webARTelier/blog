<?php {

  // data base operations object
  // ---------------------------
  class DBO
  {

    // insert properties
    // -----------------
    protected $insert_valtypes = '';
    protected $insert_fields = '';
    protected $insert_values = [];
    protected $insert_placeholders = '';
    public $insert_lastID = '';

    // update properties
    // -----------------
    protected $update_valtypes = '';
    protected $update_values = [];
    protected $update_placeholders = '';

    // fetch properties
    // ----------------
    protected $fetch_valtypes = '';
    protected $fetch_select = '';
    protected $fetch_from =  '';
    protected $fetch_innerjoin = '';
    protected $fetch_leftjoin = '';
    protected $fetch_where_placeholder = '';
    protected $fetch_where_value = '';
    protected $fetch_and_placeholder = '';
    protected $fetch_and_value = [];
    protected $fetch_or_placeholder = '';
    protected $fetch_or_value = [];
    protected $fetch_groupby = '';
    protected $fetch_orderby = '';
    protected $fetch_limit = '';
    protected $fetch_offset = '';

    // recordset in current object
    // ---------------------------
    public $recordset = [];
    public $rs_totalrows = '';
    public $rs_currow = 0;
    public $EOF = false;

    // rows affected by 'update' or 'delete'
    // -------------------------------------
    public $affectedrows = '';

    // pagination settings
    // -------------------
    public $pagination = false;
    public $pagination_get = 'page';
    public $pagination_cutLR = '';
    public $pagination_entriesPerPage = 10;
    public $pagination_totalEntries = 0;
    public $pagination_totalPages = 0;
    public $pagination_currentPage = 1;
    public $pagination_html = '';

    // js object for prefilling forms
    // ------------------------------
    public $prefillData = '';

    // error messages
    // --------------
    public $errormsg = [];



    // -------------------------------------------------------------------



    // establish connection to database
    // --------------------------------
    function __construct($db_path, $db_user, $db_pass, $db_name)
    {

      try {
        $this->connDB = new mysqli($db_path, $db_user, $db_pass, $db_name);
      }

      catch(Exception $e) {
        error_log($e->getMessage());
        $this->errormsg[] = 'Could not establish data base connection!';
        exit('Wooops! Something weird happened! Sorry &hellip;');
      }

      // be sure to use utf8!
      // --------------------
      $this->connDB->set_charset('utf8');
    }



    // -------------------------------------------------------------------



    // store array into data base
    // class decides insert/update according to key 'ID'
    // NOTE: array keys must match data base column names!
    // ---------------------------------------------------
    public function store($array, string $table)
    {
      // insert or update?
      // -----------------
      if(array_key_exists('ID', $array)) {
        if($array['ID'] != '') {
          $this->update($array, $table, 'ID', $array['ID']);
        }
        else {
          $this->insert($array, $table);
        }
      }
      else {
        $this->insert($array, $table);
      }
    }



    // -------------------------------------------------------------------



    // insert array into new db entry
    // NOTE: array keys must match data base column names!
    // ---------------------------------------------------
    public function insert($array, string $table)
    {
      // reset
      // -----
      $this->insert_valtypes = '';
      $this->insert_fields = '';
      $this->insert_values = [];
      $this->insert_placeholders = '';

      // prepare
      // -------
      $this->xtract_from_array('insert', $array);

      // insert
      // ------
      $insert = $this->connDB->prepare("INSERT INTO $table ($this->insert_fields) VALUES ($this->insert_placeholders)");
      $insert->bind_param($this->insert_valtypes, ...$this->insert_values);
      $insert->execute();

      // store auto generated ID & add to prefill data
      // ---------------------------------------------
      $this->insert_lastID = $insert->insert_id;
      $array['ID'] = $insert->insert_id;

      // prefill data
      // ------------
      $this->set_prefill_data($array);

    }



    // -------------------------------------------------------------------



    // update existing db entry with array
    // NOTE: array keys must match data base column names!
    // ---------------------------------------------------
    public function update($array, string $table, string $condition_column, string $condition_value)
    {
      // reset
      // -----
      $this->update_valtypes = '';
      $this->update_values = [];
      $this->update_placeholders = '';

      // prepare
      // -------
      $this->xtract_from_array('update', $array);

      // statement
      // ---------
      $update = $this->connDB->prepare("UPDATE $table SET $this->update_placeholders WHERE $condition_column = ?");

      // binding
      // -------
      $this->update_valtypes .= 's'; // one more for 'where' value
      $this->update_values[] = $condition_value;
      $update->bind_param($this->update_valtypes, ...$this->update_values);

      $update->execute();

      $this->affectedrows = $update->affected_rows;

      // prefill data
      // ------------
      $this->set_prefill_data($array);

    }



    // -------------------------------------------------------------------



    // helper functions for retrieving data from db
    // --------------------------------------------
    public function _cols( string $cols)
    {
      $execute = true;

      if(is_array($cols)) {
        $sql_cols = implode(',', $cols);
      }
      elseif(is_string($cols)) {
        $sql_cols = $cols;
      }
      else {
        $this->errormsg[] = 'Fields list for record set is neither array nor string!';
        $execute = false;
        return $this;
      }

      if($execute) {
        $this->fetch_select = "SELECT $sql_cols";
        return $this;
      }
    }

    // ----------------------------------

    public function _from(string $table)
    {
      $this->fetch_from = " FROM ".$table;
      return $this;
    }

    // ----------------------------------

    public function _innerjoin(string $table, string $on)
    {
      $this->fetch_innerjoin .= ' INNER JOIN '.$table. ' ON '.$on;
      return $this;
    }

    // ----------------------------------

    public function _leftjoin(string $table, string $on)
    {
      $this->fetch_innerjoin .= ' INNER JOIN '.$table. ' ON '.$on;
      return $this;
    }

    // ----------------------------------

    public function _where(string $placeholder, $value)
    {
      $this->fetch_where_placeholder = " WHERE ".$placeholder;
      $this->fetch_where_value = $value;
      $this->fetch_valtypes .= 's';
      return $this;
    }

    // ----------------------------------

    public function _and(string $placeholder, $value)
    {
      $this->fetch_and_placeholder .= " AND ".$placeholder;
      $this->fetch_and_value[] = $value;
      $this->fetch_valtypes .= 's';
      return $this;
    }

    // ----------------------------------

    public function _or(string $placeholder, $value)
    {
      $this->fetch_or_placeholder .= " OR ".$placeholder;
      $this->fetch_or_value[] = $value;
      $this->fetch_valtypes .= 's';
      return $this;
    }

    // ----------------------------------

    public function _groupby(string $groupby)
    {
      $this->fetch_groupby = " GROUP BY ".$groupby;
      return $this;
    }

    // ----------------------------------

    public function _orderby(string $orderby)
    {
      $this->fetch_orderby = " ORDER BY ".$orderby;
      return $this;
    }

    // ----------------------------------

    public function _limit(string $limit)
    {
      $this->fetch_limit = " LIMIT ".$limit;
      return $this;
    }

    // ----------------------------------

    public function _offset(string $offset)
    {
      $this->fetch_offset = " OFFSET ".$offset;
      return $this;
    }



    // -------------------------------------------------------------------



    // fetch recordset
    // ---------------
    public function fetch()
    {

      // what it needs to fetch a recordset ...
      // --------------------------------------
      $execute = true;

      if(!$this->fetch_select) {
        $this->EOF = true;
        $this->errormsg[] = 'No columns given for fetching recordset!';
        $execute = false;
      }

      if(!$this->fetch_from) {
        $this->EOF = true;
        $this->errormsg[] = 'No table given for fetching recordset!';
        $execute = false;
      }

      if(!$this->fetch_where_placeholder) {
        $this->EOF = true;
        $this->errormsg[] = 'No condition given for fetching recordset!';
        $execute = false;
      }

      // got everything? off we go!
      // --------------------------
      if($execute) {
        $bind_values = [];

        // pagination required?
        // NOTE: modifies recordset 'limit' and 'offset'
        // according to pagination settings if recordset
        // contains more entries than 'entries per page'
        // ---------------------------------------------
        if($this->pagination) {
          $this->create_pagination_count();
        }

        // recordset statement
        // -------------------
        $fetch = $this->connDB->prepare("
          $this->fetch_select
          $this->fetch_from
          $this->fetch_innerjoin
          $this->fetch_leftjoin
          $this->fetch_where_placeholder
          $this->fetch_and_placeholder
          $this->fetch_or_placeholder
          $this->fetch_groupby
          $this->fetch_orderby
          $this->fetch_limit
          $this->fetch_offset
        ");

        // binding & executing
        // -------------------
        $bind_values[] = $this->fetch_where_value;

        foreach($this->fetch_and_value as $fetch_and_value) {
          $bind_values[] = $fetch_and_value;
        }

        foreach($this->fetch_or_value as $fetch_or_value) {
          $bind_values[] = $fetch_or_value;
        }

        $fetch->bind_param($this->fetch_valtypes, ...$bind_values);
        $fetch->execute();

        // recordset & total rows
        // ----------------------
        $temp_recordset = $fetch->get_result()->fetch_all(MYSQLI_ASSOC);
        $this->rs_totalrows = '0';
        foreach($temp_recordset as $counting) { $this->rs_totalrows++; }

        // got a recordset?
        // ----------------
        if($this->rs_totalrows > 0) {

          // prefill data for first row
          // --------------------------
          $this->set_prefill_data($temp_recordset[0]);

          // store & return
          // --------------
          $this->recordset = $temp_recordset;
          return $temp_recordset;
        }
        else {
          $this->EOF = true;
          $this->errormsg[] = 'Recordset is empty!';
          return false;
        }
      }
    }



    // -------------------------------------------------------------------



    // get minimum value from db column
    // --------------------------------
    public function get_min(string $column, string $table, string $where_placeholder, string $where_value)
    {
      $getMin = $this->connDB->prepare('SELECT MIN('.$column.') AS min FROM '.$table.' WHERE '.$where_placeholder);

      $getMin->bind_param('s', $where_value);
      $getMin->execute();

      $result = $getMin->get_result()->fetch_array()['min'];

      return $result;
    }



    // -------------------------------------------------------------------



    // get maximum value from db column
    // --------------------------------
    public function get_max(string $column, string $table, string $where_placeholder,  string $where_value)
    {
      $getMax = $this->connDB->prepare('SELECT MAX('.$column.') AS max FROM '.$table.' WHERE '.$where_placeholder);

      $getMax->bind_param('s', $where_value);
      $getMax->execute();

      $result = $getMax->get_result()->fetch_array()['max'];

      return $result;
    }



    // -------------------------------------------------------------------



    // get field from current row
    // --------------------------
    public function field(string $field)
    {
      if (!($this->EOF)) {

        if(array_key_exists($field, $this->recordset[$this->rs_currow])) {
          return $this->recordset[$this->rs_currow][$field];
        }
        else {
          $this->errormsg[] = 'Field »'.$field.'« not found in recordset!';
          return false;
        }
      }
      else {
        $this->errormsg[] = 'EOF true - got no value for field »'.$field.'«!';
        return false;
      }
    }



    // -------------------------------------------------------------------



    // find rows with given content
    // ----------------------------
    public function find_rows(string $column, string $content)
    {
      $rememberCurrow = $this->rs_currow;
      $rememberEOF = $this->EOF;
      $resultRows = false;

      $this->move_first();

      while(!$this->EOF) {
        if($this->recordset[$this->rs_currow][$column] == $content) {
          $resultRows[] = $this->rs_currow;
        }
        $this->move_next();
      }

      $this->rs_currow = $rememberCurrow;
      $this->EOF = $rememberEOF;

      return $resultRows;
    }



    // -------------------------------------------------------------------



    // set value for given field in row with given ID
    // ----------------------------------------------
    public function set_field(string $table, int $ID, string $field, $value)
    {
      $set = $this->connDB->prepare("UPDATE $table SET $field = ? WHERE ID = ?");
      $set->bind_param("si", $value, $ID);
      $set->execute();

      $this->affectedrows = $set->affected_rows;
    }



    // -------------------------------------------------------------------



    // delete row with given ID
    // ------------------------
    public function delete_row(string $table, int $ID)
    {
      $delete = $this->connDB->prepare("DELETE FROM $table WHERE ID = ?");
      $delete->bind_param("i", $ID);
      $delete->execute();
    }



    // -------------------------------------------------------------------



    // move to first row in recordset
    // ------------------------------
    public function move_first()
    {
      if($this->rs_totalrows > 0) {
        $this->rs_currow = 0;
        $this->EOF = false;
        $this->set_prefill_data($this->recordset[$this->rs_currow]);
      }
    }



    // -------------------------------------------------------------------



    // move to next row in recordset
    // -----------------------------
    public function move_next()
    {
      if($this->rs_currow == $this->rs_totalrows - 1) {
        $this->EOF = true;
      }

      if(!($this->EOF)) {
        $this->rs_currow++;
        $this->set_prefill_data($this->recordset[$this->rs_currow]);
      }
    }



    // -------------------------------------------------------------------



    // move to given row in recordset
    // ------------------------------
    public function move_to(int $row)
    {
      $execute = true;

      if($row < 0) {
        $this->errormsg[] = 'Can not move to negative rows!';
        $execute = false;
      }

      if($row > $this->rs_totalrows - 1) {
        $this->errormsg[] = 'Can not move to not existing row!';
        $execute = false;
      }

      if($execute) {
        $this->EOF = false;
        $this->rs_currow = $row;
        $this->set_prefill_data($this->recordset[$this->rs_currow]);
      }
    }



    // -------------------------------------------------------------------



    // move to last row in recordset
    // -----------------------------
    function move_last()
    {
      if($this->rs_totalrows > 0) {
        $this->rs_currow = $this->rs_totalrows - 1;
        $this->set_prefill_data($this->recordset[$this->rs_currow]);
      }
    }



    // -------------------------------------------------------------------



    // create pagination row count
    // ---------------------------
    protected function create_pagination_count()
    {

      // row count statement
      // -------------------
      $rowCount = $this->connDB->prepare("
        SELECT COUNT(*) as rowCount
        $this->fetch_from
        $this->fetch_innerjoin
        $this->fetch_where_placeholder
        $this->fetch_and_placeholder
        $this->fetch_or_placeholder
      ");

      // binding & executing
      // -------------------
      $bind_values_count = [];
      $bind_values_count[] = $this->fetch_where_value;

      foreach($this->fetch_and_value as $fetch_and_value) {
        $bind_values_count[] = $fetch_and_value;
      }

      foreach($this->fetch_or_value as $fetch_or_value) {
        $bind_values_count[] = $fetch_or_value;
      }

      $rowCount->bind_param($this->fetch_valtypes, ...$bind_values_count);
      $rowCount->execute();

      // recordset & row count result
      // ----------------------------
      $temp_count = $rowCount->get_result()->fetch_all(MYSQLI_ASSOC);
      $this->pagination_totalEntries = $temp_count[0]['rowCount'];
      $this->pagination_totalPages = ceil($this->pagination_totalEntries / $this->pagination_entriesPerPage);

      // do we have more than one page?
      // ------------------------------
      if($this->pagination_totalEntries > $this->pagination_entriesPerPage) {

        // sanitize value for current page
        // -------------------------------
        if($this->pagination_currentPage < 1) {
          $this->pagination_currentPage = 1;
        }

        if($this->pagination_currentPage > $this->pagination_totalPages) {
          $this->pagination_currentPage = $this->pagination_totalPages;
        }

        // re-set limit & offset
        // ---------------------
        $this->fetch_limit = ' LIMIT '.$this->pagination_entriesPerPage;
        $this->fetch_offset = ' OFFSET '.$this->pagination_entriesPerPage * ($this->pagination_currentPage - 1);

        $this->create_pagination_html();
      }
    }



    // -------------------------------------------------------------------



    // create pagination html
    // ----------------------
    protected function create_pagination_html()
    {

      if($this->pagination_currentPage > 1 ) {
        $previousPage = ($this->pagination_currentPage - 1);
        $previousStatus = '';
      }
      else {
        $previousPage = 1;
        $previousStatus = ' is-inactive';
      }

      if($this->pagination_currentPage < $this->pagination_totalPages) {
        $nextPage = ($this->pagination_currentPage + 1);
        $nextStatus = '';
      }
      else {
        $nextPage = $this->pagination_totalPages;
        $nextStatus = ' is-inactive';
      }

      $this->pagination_html = '<div class="c-pagination">';

      // item 'previous'
      // ---------------
      $this->pagination_html .= '<div class="c-pagination__item">';
      $this->pagination_html .= '<a class="c-pagination__link'.$previousStatus.'" ';
      $this->pagination_html .= 'href="'.$_SERVER['PHP_SELF'].'?'.$this->pagination_get.'='.$previousPage.'">';
      $this->pagination_html .= '&#10094;';
      $this->pagination_html .= '</a>';
      $this->pagination_html .= '</div>';

      // items 'page'
      // ------------
      for($pageCounter = 1; $pageCounter <= $this->pagination_totalPages; $pageCounter++) {

        $renderItem = true;

        // mark active page
        // ----------------
        ($pageCounter == $this->pagination_currentPage)
        ? $currentStatus = ' is-active'
          : $currentStatus = '';

        // cut left/right of current page?
        // -------------------------------
        if($this->pagination_cutLR != '') {
          if($pageCounter < ($this->pagination_currentPage - $this->pagination_cutLR)) {
            $renderItem = false;
          }
          if($pageCounter > ($this->pagination_currentPage + $this->pagination_cutLR)) {
            $renderItem = false;
          }
        }

        if($renderItem) {
          $this->pagination_html .= '<div class="c-pagination__item">';
          $this->pagination_html .= '<a class="c-pagination__link'.$currentStatus.'" ';
          $this->pagination_html .= 'href="'.$_SERVER['PHP_SELF'].'?'.$this->pagination_get.'='.$pageCounter.'">';
          $this->pagination_html .= $pageCounter;
          $this->pagination_html .= '</a>';
          $this->pagination_html .= '</div>';
        }
      }

      // item 'next'
      // -----------
      $this->pagination_html .= '<div class="c-pagination__item">';
      $this->pagination_html .= '<a class="c-pagination__link'.$nextStatus.'" ';
      $this->pagination_html .= 'href="'.$_SERVER['PHP_SELF'].'?'.$this->pagination_get.'='.$nextPage.'">';
      $this->pagination_html .= '&#10095;';
      $this->pagination_html .= '</a>';
      $this->pagination_html .= '</div>';

      $this->pagination_html .= '</div>';
    }



    // -------------------------------------------------------------------



    // extract field names, values and value types from array
    // and prepare placeholder string for prepared statements
    // according to method 'insert' or 'update'
    // ------------------------------------------------------
    protected function xtract_from_array($method, $array)
    {
      $prefix = '';

      foreach($array as $fieldname => $fieldvalue) {

        // insert components
        // -----------------
        if($method == 'insert') {
          $this->insert_fields .= $prefix . $fieldname;
          $this->insert_placeholders .= $prefix . '?';
          $this->insert_values[] = $fieldvalue;

          // value types string
          // ------------------
          if(is_string($fieldvalue)) { $this->insert_valtypes .= 's'; }
          elseif(is_int($fieldvalue)) { $this->insert_valtypes .= 'i'; }
          elseif(is_float($fieldvalue)) { $this->insert_valtypes .= 'd'; }
          else { $this->errormsg[] = 'Unknown data format for inserting: '.$fieldvalue; }
        }

        // update components
        // -----------------
        else {
          $this->update_placeholders .= $prefix . $fieldname . "= ?";
          $this->update_values[] = $fieldvalue;

          // value types string
          // ------------------
          if(is_string($fieldvalue)) { $this->update_valtypes .= 's'; }
          elseif(is_int($fieldvalue)) { $this->update_valtypes .= 'i'; }
          elseif(is_float($fieldvalue)) { $this->update_valtypes .= 'd'; }
          else { $this->errormsg[] = 'Unknown data format for updating: '.$fieldvalue;; }
        }

        $prefix = ', ';
      }
    }



    // -------------------------------------------------------------------



    // build a javascript object for prefilling forms
    // ----------------------------------------------
    public function set_prefill_data($array)
    {
      $prefill = '<script>';
      $prefill .= 'var prefillData = {';

      $prefix = '';

      foreach($array as $inputname => $inputvalue) {
        $prefill .= $prefix . "'" . $inputname . "':'" . $inputvalue . "'";
        $prefix = ', ';
      }

      $prefill .= '};';
      $prefill .= '</script>';

      $this->prefillData = $prefill;
    }
  }
}
?>
