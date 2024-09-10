<?php
class mMain  extends CI_Model
{

    // ++++++++++++++++++++++++++++++++++++++++ variable declaration

    function __construct()
    {
        parent::__construct();
    }


    function autoid($tbl0, $pk0, $defid, $defval, $defno) //tbl0=table name, pk0=flag pk, defid=
    {
        if (isset($defno) && strlen($defno) > 0)
            $no = substr($defval, 0, strlen($defval) - strlen($defno));
        else
            $no = "";

        $id1 = 0;
        $query = $this->db->query("SELECT $pk0 FROM $tbl0 where $pk0 like '" . $defid . "%' order by $pk0 desc LIMIT 1 ");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $tempurut = $row->$pk0;
            }
            $pj = strlen($defval) - strlen($no);
            $no1 = substr($tempurut, strlen($no), strlen($defno)) + 1;
            $id1 = $no . sprintf("%0" . $pj . "s", $no1);
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

	public function getBarang($keyword=null, $limit, $start) {
        $this->db->select('barang.*, 
			jenis.nama_jenis, 
			satuan.nama_satuan, 
			SUM(detail_barang.qtty) AS detail_count,
			SUM(CASE WHEN detail_barang.status = "Stored" THEN 1 ELSE 0 END) AS stored_count'
		);
        $this->db->from('barang');
        $this->db->join('jenis', 'barang.id_jenis = jenis.id_jenis');
        $this->db->join('satuan', 'barang.id_satuan = satuan.id_satuan');	
		$this->db->join('detail_barang', 'barang.id_barang = detail_barang.id_barang', 'left');
		if ($keyword) {
			$this->db->like('detail_barang.serial_code', $keyword);
			$this->db->or_like('detail_barang.id_barang', $keyword);
			$this->db->or_like('detail_barang.id_detail_barang', $keyword);
			$this->db->or_like('barang.nama_barang', $keyword);
			$this->db->or_like('jenis.nama_jenis', $keyword);
		}
		$this->db->group_by('barang.id_barang, detail_barang.id_barang');
		$this->db->order_by('id_barang', 'ASC');
        $this->db->limit($limit, $start); 
        $query = $this->db->get();
        return $query->result();
    }

	public function getRequest($keyword=null, $limit, $start) {
        $this->db->select('request.*');
        $this->db->from('request');
		$this->db->join('detail_request', 'request.id_request = detail_request.id_request', 'left');
		if ($keyword) {
			$this->db->like('detail_request.serial_code', $keyword);
			$this->db->or_like('detail_request.id_detail_barang', $keyword);
			$this->db->or_like('request.nama', $keyword);
		}
		$this->db->group_by('request.id_request, detail_request.id_request');
        $this->db->limit($limit, $start); 
        $query = $this->db->get();
        return $query->result();
    }

	public function getReplace($keyword=null, $limit, $start) {
        $this->db->select('ganti.*');
        $this->db->from('ganti');
		$this->db->join('detail_ganti', 'ganti.id_replace = detail_ganti.id_replace', 'left');
		if ($keyword) {
			$this->db->like('detail_ganti.serial_code', $keyword);
			$this->db->or_like('ganti.nama', $keyword);
		}
		$this->db->group_by('ganti.id_replace, detail_ganti.id_replace');
        $this->db->limit($limit, $start); 
        $query = $this->db->get();
        return $query->result();
    }
	public function getDetailReplace($id, $limit, $start) {
        $this->db->select('detail_ganti.*');
        $this->db->from('detail_ganti');
        $this->db->where('id_replace', $id);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }
	public function getPinjam($keyword=null, $limit, $start) {
        $this->db->select('pinjam.*');
        $this->db->from('pinjam');
		$this->db->join('detail_pinjam', 'pinjam.id_pinjam = detail_pinjam.id_pinjam', 'left');
		if ($keyword) {
			$this->db->like('detail_pinjam.serial_code', $keyword);
			$this->db->or_like('pinjam.nama', $keyword);
		}
		$this->db->group_by('pinjam.id_pinjam, detail_pinjam.id_pinjam');
        $this->db->limit($limit, $start); 
        $query = $this->db->get();
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
