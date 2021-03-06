<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu_admin extends CI_Controller
{
    
        
    function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_admin_model');
    }

    public function index()
    {
        if($this->session->userdata('id_position')!=NULL && $this->session->userdata('id_position') == 1){        
            $menu_admin = $this->Menu_admin_model->get_all();

            $data = array(
                'menu_admin_data' => $menu_admin
            );

            $this->template->load('template','menu_admin_list', $data);
        }
    }

    public function read($id) 
    {
        $row = $this->Menu_admin_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'name' => $row->name,
		'link' => $row->link,
		'icon' => $row->icon,
		'is_active' => $row->is_active,
		'is_parent' => $row->is_parent,
	    );
            $this->template->load('template','menu_admin_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('menu_admin'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('menu_admin/create_action'),
	    'id' => set_value('id'),
	    'name' => set_value('name'),
	    'link' => set_value('link'),
	    'icon' => set_value('icon'),
	    'is_active' => set_value('is_active'),
	    'is_parent' => set_value('is_parent'),
	);
        $this->template->load('template','menu_admin_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'name' => $this->input->post('name',TRUE),
		'link' => $this->input->post('link',TRUE),
		'icon' => $this->input->post('icon',TRUE),
		'is_active' => $this->input->post('is_active',TRUE),
		'is_parent' => $this->input->post('is_parent',TRUE),
	    );

            $this->Menu_admin_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('menu_admin'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Menu_admin_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('menu_admin/update_action'),
		'id' => set_value('id', $row->id),
		'name' => set_value('name', $row->name),
		'link' => set_value('link', $row->link),
		'icon' => set_value('icon', $row->icon),
		'is_active' => set_value('is_active', $row->is_active),
		'is_parent' => set_value('is_parent', $row->is_parent),
	    );
            $this->template->load('template','menu_admin_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('menu_admin'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'name' => $this->input->post('name',TRUE),
		'link' => $this->input->post('link',TRUE),
		'icon' => $this->input->post('icon',TRUE),
		'is_active' => $this->input->post('is_active',TRUE),
		'is_parent' => $this->input->post('is_parent',TRUE),
	    );

            $this->Menu_admin_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('menu_admin'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Menu_admin_model->get_by_id($id);

        if ($row) {
            $this->Menu_admin_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('menu_admin'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('menu_admin'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('name', 'name', 'trim|required');
	$this->form_validation->set_rules('link', 'link', 'trim|required');
	$this->form_validation->set_rules('icon', 'icon', 'trim|required');
	$this->form_validation->set_rules('is_active', 'is active', 'trim|required');
	$this->form_validation->set_rules('is_parent', 'is parent', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "menu_admin.xls";
        $judul = "menu_admin";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Name");
	xlsWriteLabel($tablehead, $kolomhead++, "Link");
	xlsWriteLabel($tablehead, $kolomhead++, "Icon");
	xlsWriteLabel($tablehead, $kolomhead++, "Is Active");
	xlsWriteLabel($tablehead, $kolomhead++, "Is Parent");

	foreach ($this->Menu_admin_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->name);
	    xlsWriteLabel($tablebody, $kolombody++, $data->link);
	    xlsWriteLabel($tablebody, $kolombody++, $data->icon);
	    xlsWriteNumber($tablebody, $kolombody++, $data->is_active);
	    xlsWriteNumber($tablebody, $kolombody++, $data->is_parent);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=menu_admin.doc");

        $data = array(
            'menu_admin_data' => $this->Menu_admin_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('menu_admin_doc',$data);
    }

    function pdf()
    {
        $data = array(
            'menu_admin_data' => $this->Menu_admin_model->get_all(),
            'start' => 0
        );
        
        ini_set('memory_limit', '32M');
        $html = $this->load->view('menu_admin_pdf', $data, true);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->WriteHTML($html);
        $pdf->Output('menu_admin.pdf', 'D'); 
    }

}

/* End of file Menu_admin.php */
/* Location: ./application/controllers/Menu_admin.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-10-22 00:47:45 */
/* http://harviacode.com */