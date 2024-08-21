<?php
class M_pengajuan extends CI_Model
{
	public function getPengajuan($keyword=null, $limit, $start) {
        $this->db->select('pengajuan.*');
        $this->db->from('pengajuan');
		if ($keyword) {
			$this->db->or_like('pengajuan.id_pengajuan', $keyword);
		}
		$this->db->group_by('pengajuan.id_pengajuan');
        $this->db->limit($limit, $start); 
        $query = $this->db->get();
        return $query->result();
    }
}

