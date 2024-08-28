<?php
class M_pengajuan extends CI_Model
{
	public function getPengajuan($keyword=null, $limit, $start) {
        $this->db->select('pengajuan.*');
        $this->db->from('pengajuan');
		if ($keyword) {
			$this->db->like('pengajuan.tgl_pengajuan', $keyword);
			$this->db->or_like('pengajuan.id_pengajuan', $keyword);
		}
		$this->db->group_by('pengajuan.id_pengajuan');
        $this->db->limit($limit, $start); 
        $query = $this->db->get();
        return $query->result();
    }
	public function hapus($id)
    {
        $this->db->where('id_pengajuan', $id);
        return $this->db->delete('pengajuan');
    }
}

