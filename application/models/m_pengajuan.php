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
	public function unique_no_surat($no_surat)
	{
		$query = $this->db->get_where('pengajuan', ['no_surat' => $no_surat]); 
		return $query->num_rows() === 0;
	}
	public function getOldInvoice($id_pengajuan)
    {
        $this->db->select('invoice');
        $this->db->from('pengajuan');
        $this->db->where('id_pengajuan', $id_pengajuan);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->invoice;
        }
    }
}

