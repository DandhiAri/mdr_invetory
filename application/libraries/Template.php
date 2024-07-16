<?php

class Template
{
    var $template_data = [];

    function set($name, $value)
    {
        $this->template_data[$name] = $value;
    }

    function load($template = '', $view = '', $view_data = [], $return = false)
    {
        $this->CI = &get_instance();
        $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
        return $this->CI->load->view($template, $this->template_data, $return);
    }

    function count_pinjam() {
        $this->CI->load->m_data();
        return $this->CI->tampil()->num_rows();
    }

    function count_request() {
        $this->CI->load->model->m_data();
        return $this->CI->m_data->tampil_datarequest()->num_rows();
    }

    function count_replace() {
        $this->CI->load->m_data('replace');
        return $this->CI->replace->tampil()->num_rows();
    }

    function count_barang() {
        $this->CI->load->model->m_data();
        return $this->CI->model->tampil_data()->num_rows();
    }
}
