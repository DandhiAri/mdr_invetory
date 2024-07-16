<?php 
    
    class M_jenis extends CI_Model{
        function tampil_data(){
        return $this->db->get('barang');
        }
        function tampil_jenis(){
            return $this->db->get('jenis');
        }
        function tampil_datajenis(){
        return $this->db->get('jenis');
        }
        function tampil_satuan(){
        return $this->db->get('satuan');
        }
        function tampil_datasatuan(){
        return $this->db->get('satuan');
        }
        function tambah_jenis_barang($data){
        return $this->db->insert($this->_table->$data);
        }


        function edit_data($id)
        {
            $query = $this->db->query("SELECT * FROM jenis WHERE id_jenis = '$id'");

            if ($query->num_rows() == 0) {
                $query = [];
            } else {
                $query = $query->row_array();
            }

            return $query;
        }

        public function ubah($data)
        {
            $this->db->set('nama_jenis', $data['nama_jenis']);
            //$this->db->set('nomor_seri', $data['nomor_seri']);
            $this->db->where('id_jenis', $data['id_jenis']);

            return $this->db->update('jenis');
        }

        public function hapus($id)
        {
            $this->db->where('id_jenis', $id);
            return $this->db->delete('jenis');
        }

}

