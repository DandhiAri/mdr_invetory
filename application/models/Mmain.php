<?php
class mMain  extends CI_Model
{

    // ++++++++++++++++++++++++++++++++++++++++ variable declaration

    function __construct()
    {
        parent::__construct();
    }


    function autoid($tbl0, $pk0, $defid, $defval, $defno)   
	// $tbl0: Nama tabel
    // $pk0: Nama kolom primary key
    // $defid: Prefix untuk ID (misalnya 'BRG' untuk barang)
    // $defval: Nilai default (format lengkap ID, misalnya 'BRG001')
    // $defno: Bagian angka dari ID default (misalnya '001')
    {
        if (isset($defno) && strlen($defno) > 0){
            $no = substr($defval, 0, strlen($defval) - strlen($defno));
		}else{
            $no = "";
		}
		
		$query = $this->db->query("SELECT $pk0 FROM $tbl0 WHERE $pk0 LIKE '$defid%' ORDER BY $pk0 DESC LIMIT 1");
    
		if ($query->num_rows() > 0) {
			$tempurut = $query->row()->$pk0;
			$pj = strlen($defval) - strlen($no);
			$no1 = intval(substr($tempurut, strlen($no))) + 1;
			$max_number = pow(10, strlen($defno)) - 1;
			if ($no1 > $max_number) {
				$pj++;
				$no1 = 1;
			}
			$id1 = $no . sprintf("%0" . $pj . "d", $no1);
		} else {
			$id1 = $defval;
		}

		return $id1;
	}

	public function getIdBarang($id) {
        return $this->db->get_where('barang', ['id_barang' => $id])->row_array();
    }

	function getDataPinjam($id)
    {
		$query = $this->db->query("SELECT b.nama_barang,
										dp.serial_code,
										dp.item_description,
										dp.qtty,
										dp.keterangan,
										dp.id_detail_pinjam
								FROM pinjam AS p
								LEFT JOIN detail_pinjam AS dp
									ON p.id_pinjam = dp.id_pinjam
								LEFT JOIN barang AS b
									ON dp.id_barang = b.id_barang
								WHERE p.id_pinjam = '$id'");
		
		if ($query->num_rows() == 0) {
			$query = [];
		} else {
			$query = $query->result_array();
		}
		
		return $query;
    }

    function getid($fval, $ftb, $fid) //fval = flag value, 
    {
        return self::qRead($ftb, "", "$fid='" . $fval . "'");
    }

    // ++++++++++++++++++++++++++++++++++++++++++ retrieve column name
    function qCol($tbq)
    {
        $fieldArr = null;
        $fields = $this->db->list_fields($tbq);

        foreach ($fields as $field) {
            $fieldArr[] = $field;
        }
        return $fieldArr;
    }


    // ++++++++++++++++++++++++++++++++++++++++++ Create insert query
    function qIns($tbq, $valq)
    {
		$this->db->insert($tbq, $valq);
    }

	public function getBarang($keyword = null, $limit = null, $start = null, $id = null, $with_position = false) {
        $this->db->select('barang.*, 
        jenis.nama_jenis, 
        satuan.nama_satuan, 
        SUM(detail_barang.qtty) AS detail_count');

		$this->db->from('barang');
		$this->db->join('jenis', 'barang.id_jenis = jenis.id_jenis');
		$this->db->join('satuan', 'barang.id_satuan = satuan.id_satuan');
		$this->db->join('detail_barang', 'barang.id_barang = detail_barang.id_barang', 'left');
		
		if ($with_position) {
			if ($keyword) {
				$this->db->join('(SELECT barang.id_barang FROM barang LEFT JOIN detail_barang ON barang.id_barang = detail_barang.id_barang WHERE detail_barang.serial_code LIKE "%'.$keyword.'%" OR barang.nama_barang LIKE "%'.$keyword.'%" GROUP BY barang.id_barang) as b2', 'b2.id_barang <= barang.id_barang', 'left');
			} else {
				$this->db->join('barang as b2', 'b2.id_barang <= barang.id_barang', 'left');
			}
			$this->db->select('COUNT(DISTINCT b2.id_barang) as position');
		}

		if ($keyword) {
			$this->db->group_start();
			$this->db->like('detail_barang.serial_code', $keyword);
			$this->db->or_like('detail_barang.id_barang', $keyword);
			$this->db->or_like('detail_barang.id_detail_barang', $keyword);
			$this->db->or_like('barang.nama_barang', $keyword);
			$this->db->or_like('jenis.nama_jenis', $keyword);
			$this->db->group_end();
		}

		$this->db->group_by('barang.id_barang');
		$this->db->order_by('barang.id_barang', 'ASC');

		if ($id !== null) {
			$this->db->having('barang.id_barang', $id);
		}

		if ($limit !== null && $start !== null) {
			$this->db->limit($limit, $start);
		}

		$query = $this->db->get();

		if ($id !== null) {
			$result = $query->row();
			return $result ? $result->position : 0;
		}

		return $query->result();
    }

	public function getData($type, $keyword = null, $limit = null, $start = null, $id = null, $with_position = false, $sort_order = 'asc') {
		$config = [
			'request' => [
				'main_table' => 'request',
				'detail_table' => 'detail_request',
				'id_field' => 'id_request',
				'name_field' => 'nama',
				'additional_like_field' => 'id_detail_barang'
			],
			'replace' => [
				'main_table' => 'ganti',
				'detail_table' => 'detail_ganti',
				'id_field' => 'id_replace',
				'name_field' => 'nama',
				'additional_like_field' => 'id_detail_barang'
			],
			'pinjam' => [
				'main_table' => 'pinjam',
				'detail_table' => 'detail_pinjam',
				'id_field' => 'id_pinjam',
				'name_field' => 'nama_peminjam',
				'additional_like_field' => 'id_detail_barang'
			]
		];
	
		if (!isset($config[$type])) {
			return false;
		}
	
		$conf = $config[$type];

		$this->db->select($conf['main_table'] . '.*');
		$this->db->from($conf['main_table']);
		$this->db->join($conf['detail_table'], $conf['main_table'] . '.' . $conf['id_field'] . ' = ' . $conf['detail_table'] . '.' . $conf['id_field'], 'left');
		if ($with_position) {
			if ($keyword) {
				$this->db->join('(
					SELECT ' . $conf['id_field'] . ' 
					FROM ' . $conf['main_table'] . ' 
					LEFT JOIN ' . $conf['detail_table'] . ' ON ' . $conf['main_table'] . '.' . $conf['id_field'] . ' = ' . $conf['detail_table'] . '.' . $conf['id_field'] . 
					' WHERE ' . $conf['detail_table'] . '.serial_code LIKE "%' . $keyword . '%" 
					OR ' . $conf['main_table'] . '.' . $conf['name_field'] . ' LIKE "%' . $keyword . '%" ' . 
					(isset($conf['additional_like_field']) ? 'OR ' . $conf['detail_table'] . '.' . $conf['additional_like_field'] . ' LIKE "%' . $keyword . '%" ' : '') . 
					'GROUP BY ' . $conf['id_field'] . 
				') as b2', 'b2.' . $conf['id_field'] . ' <= ' . $conf['main_table'] . '.' . $conf['id_field'], 'left');
			} else {
				$this->db->join($conf['main_table'] . ' as b2', 'b2.' . $conf['id_field'] . ' <= ' . $conf['main_table'] . '.' . $conf['id_field'], 'left');
			}
			$this->db->select('COUNT(DISTINCT b2.' . $conf['id_field'] . ') as position');
		}

		if ($keyword) {
			$this->db->group_start();
			$this->db->like($conf['detail_table'] . '.serial_code', $keyword);
			$this->db->or_like($conf['main_table'] . '.' . $conf['name_field'], $keyword);
			if ($conf['additional_like_field']) {
				$this->db->or_like($conf['detail_table'] . '.' . $conf['additional_like_field'], $keyword);
			}
			$this->db->group_end();
		}
		$this->db->order_by($conf['id_field'], $sort_order);
		$this->db->group_by($conf['main_table'] . '.' . $conf['id_field'] . ', ' . $conf['detail_table'] . '.' . $conf['id_field']);
		$this->db->order_by($conf['main_table'] . '.' . $conf['id_field'], 'ASC');
	
		if ($limit !== null && $start !== null) {
			$this->db->limit($limit, $start);
		}
	
		$query = $this->db->get();

		if ($id !== null && $with_position) {
			$result = $query->row();
			return $result ? $result->position : 0;
		}
	
		return $query->result();
	}
	public function get_serial_codes($id_barang) {
        
        $this->db->select('serial_code, id_detail_barang, qtty, status');
        $this->db->from('detail_barang');
        $this->db->where('id_barang', $id_barang);
        $query = $this->db->get();
       
        if ($query->num_rows() > 0) {
            return $query->result_array(); 
        } else {
            return []; 
        }
    }
    // ++++++++++++++++++++++++++++++++++++++++++ Create delete query

    function qDel($tbq, $idq, $valq) //Delete query declaration
    {
        if (is_array($idq)) {
            foreach ($idq as $i => $id)
                $this->db->where($id, $valq[$i]);
        } else
            $this->db->where($idq, $valq);

        $this->db->delete($tbq);
    }
	
	 public function delDetail($id)
	{
		$this->db->where('id_detail_pinjam', $id);
		return $this->db->delete('detail_pinjam');
	} 

    // ++++++++++++++++++++++++++++++++++++++++++ Create Update query
    function qUpd($tbq, $idq, $idflag, $valq)
    {
        $tes = self::qCol($tbq);
        $i = 0;
        foreach ($tes as $row) {
            $savVal[$row] = $valq[$i];
            $i++;
        }

        if (is_array($idq)) {
            for ($i = 0; $i < count($idq); $i++) {
                $this->db->where($idq[$i], $idflag[$i]);
            }
        } else {

            $this->db->where($idq, $idflag);
        }

        $this->db->update($tbq, $savVal);
    }

    // ++++++++++++++++++++++++++++++++++++++++++ Create Update query
    function qUpdpart($tbq, $idq, $idflag, $valid, $valq)
    {
        //echo implode(" ",$valid);
        $i = 0;
        foreach ($valid as $row) {
            $savVal[$row] = $valq[$i];
            $i++;
            //echo $savVal[$row];
        }

        if (is_array($idq)) {
            for ($i = 0; $i < count($idq); $i++) {
                $this->db->where($idq[$i], $idflag[$i]);
            }
        } else {

            $this->db->where($idq, $idflag);
        }
        $this->db->update($tbq, $savVal);
    }
    // ++++++++++++++++++++++++++++++++++++++++++ Create Update query
    function qUpdpartin($tbq, $idq, $idflag, $valid, $valq)
    {
        //echo implode(" ",$valid);
        $i = 0;
        //echo "UPDATE ".$tbq." SET ";
        foreach ($valid as $row) {
            //echo $row." = ".$valq[$i];
            $savVal[$row] = $valq[$i];
            $i++;
            //echo $savVal[$row];
        }

        $this->db->where_in($idq, $idflag, FALSE);
        $this->db->update($tbq, $savVal);
        //echo " WHERE ".$idq." in ".$idflag;
        //echo $this->db->last_query();
    }

    // ++++++++++++++++++++++++++++++++++++++++++ Create read query
    function qRead($tbq, $sel = "", $valflag = "")
    {

        if ($sel == "")
            $sel = "*";


        if (strlen($valflag) > 0)
            $valflag = "where " . $valflag;

        $sqlq = sprintf("select %s from %s %s", $sel, $tbq, $valflag);

        $query = $this->db->query($sqlq);
        return $query;
    }
	
}
