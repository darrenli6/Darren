<?php
/*  auth darren
 *  database link class
 *  
 */
 
class DB {
	//pdo class
	private $_pdo = null;
	
	static private $_instance = null;
	
	//common static method get instance
	static protected function getInstance() {
		if (!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	//private clone
	private function __clone() {}
	
	//private contruct
	private function __construct() {
		try {
			$this->_pdo = new PDO(DB_DNS, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES '.DB_CHARSET));
			$this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			exit($e->getMessage());
		}
	}
	
	//add
	protected function add($_tables, Array $_addData) {
		$_addFields = array();
		$_addValues = array();
		foreach ($_addData as $_key=>$_value) {
			$_addFields[] = $_key;
			$_addValues[] = $_value;
		}
		$_addFields = implode(',', $_addFields);
		$_addValues = implode("','", $_addValues);
		$_sql = "INSERT INTO $_tables[0] ($_addFields) VALUES ('$_addValues')";
		return $this->execute($_sql)->rowCount();
	}
	
	//update
	protected function update($_tables, Array $_param, Array $_updateData) {
		$_where = $_setData = '';
		foreach ($_param as $_key=>$_value) {
			$_where .= $_value.' AND ';
		}
		$_where = 'WHERE '.substr($_where, 0, -4);
		foreach ($_updateData as $_key=>$_value) {
			if (Validate::isArray($_value)) {
				$_setData .= "$_key=$_value[0],";
			} else {
				$_setData .= "$_key='$_value',";
			}
		}
		$_setData = substr($_setData, 0, -1);
		$_sql = "UPDATE $_tables[0] SET $_setData $_where";
		return $this->execute($_sql)->rowCount();
	}
	
	//verify one data
	protected function isOne($_tables, Array $_param) {
		$_where = '';
		foreach ($_param as $_key=>$_value) {
			$_where .=$_value.' AND ';
		}
		$_where = 'WHERE '.substr($_where, 0, -4);
		$_sql = "SELECT id FROM $_tables[0] $_where LIMIT 1";
		return $this->execute($_sql)->rowCount();
	}
	
	//delete
	protected function delete($_tables, Array $_param) {
		$_where = '';
		foreach ($_param as $_key=>$_value) {
			$_where .= $_value.' AND ';
		}
		$_where = 'WHERE '.substr($_where, 0, -4);
		$_sql = "DELETE FROM $_tables[0] $_where LIMIT 1";
		return $this->execute($_sql)->rowCount();
	}
	
	//query 
	protected function select($_tables, Array $_fileld, Array $_param = array()) {
		$_limit = $_order = $_where = $_like = '';
		if (Validate::isArray($_param) && !Validate::isNullArray($_param)) {
			$_limit = isset($_param['limit']) ? 'LIMIT '.$_param['limit'] : '';
			$_order = isset($_param['order']) ? 'ORDER BY '.$_param['order'] : '';
			if (isset($_param['where'])) {
				foreach ($_param['where'] as $_key=>$_value) {
					$_where .= $_value.' AND ';
				}
				$_where = 'WHERE '.substr($_where, 0, -4);
			}
			if (isset($_param['like'])) {
				foreach ($_param['like'] as $_key=>$_value) {
					$_like = "WHERE $_key LIKE '%$_value%'";
				}
			}
		}
		$_selectFields = implode(',', $_fileld);
		$_table = isset($_tables[1]) ? $_tables[0].','.$_tables[1] : $_tables[0];
		$_sql = "SELECT $_selectFields FROM $_table $_where $_like $_order $_limit";
		$_stmt = $this->execute($_sql);
		$_result = array();
		while (!!$_objs = $_stmt->fetchObject()) {
			$_result[] = $_objs;
		}
		return Tool::setHtmlString($_result);
	}
	
	//total record
	protected function total($_tables, Array $_param = array()) {
		$_where = '';
		if (isset($_param['where'])) {
			foreach ($_param['where'] as $_key=>$_value) {
				$_where .= $_value.' AND ';
			}
			$_where = 'WHERE '.substr($_where, 0, -4);
		}
		$_sql = "SELECT COUNT(*) as count FROM $_tables[0] $_where";
		$_stmt = $this->execute($_sql);
		return $_stmt->fetchObject()->count;
	}
	
	//get next id of data
	protected function nextId($_tables) {
		$_sql = "SHOW TABLE STATUS LIKE '$_tables[0]'";
		$_stmt = $this->execute($_sql);
		return $_stmt->fetchObject()->Auto_increment;
	}

	//execute sql
	private function execute($_sql) {
		try {
			$_stmt = $this->_pdo->prepare($_sql);
			$_stmt->execute();
		} catch (PDOException  $e) {
			exit('SQL语句：'.$_sql.'<br />错误信息：'.$e->getMessage());
		}
		return $_stmt;
	}
}
?>