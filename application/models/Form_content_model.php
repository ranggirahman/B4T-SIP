<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Form_content_model extends CI_Model
{

    public $table = 'form_content';
    public $id = 'id_form_content';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_form_content', $q);
	$this->db->or_like('id_form', $q);
	$this->db->or_like('id_items_detail', $q);
	$this->db->or_like('id_supplier', $q);
	$this->db->or_like('quantity', $q);
	$this->db->or_like('status_acc', $q);
	$this->db->or_like('unit', $q);
	$this->db->or_like('quantity_origin', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_form_content', $q);
	$this->db->or_like('id_form', $q);
	$this->db->or_like('id_items_detail', $q);
	$this->db->or_like('id_supplier', $q);
	$this->db->or_like('quantity', $q);
	$this->db->or_like('status_acc', $q);
	$this->db->or_like('unit', $q);
	$this->db->or_like('quantity_origin', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

     function get_by_form($id)
    {
        $this->db->where('id_form', $id);
        return $this->db->get($this->table)->result();
    }

    function get_all_detail()
    {
        return $this->db->query('select * from form a, items_detail b, items_category c, user_akun d, form_content e where a.id_user = d.id_user and a.id_form = e.id_form and b.id_category = c.id_category and b.id_items_detail = e.id_items_detail')->result();
    }


    function get_all_detail_by_form($id)
    {
        return $this->db->query('select * from form a, items_detail b, items_category c, user_akun d, form_content e where a.id_user = d.id_user and a.id_form = e.id_form and b.id_category = c.id_category and b.id_items_detail = e.id_items_detail and e.id_form = '.$id)->result();
    }

    function get_all_detail_by_form_pengadaan($id)
    {
        return $this->db->query('select * from form a, items_detail b, items_category c, user_akun d, form_content e where a.id_user = d.id_user and a.id_form = e.id_form and b.id_category = c.id_category and b.id_items_detail = e.id_item_by_pengadaan and e.id_form = '.$id)->result();
    }

    function get_all_detail_by_form_only_acc($id)
    {
        return $this->db->query('select * from form a, items_detail b, items_category c, user_akun d, form_content e where a.id_user = d.id_user and a.id_form = e.id_form and b.id_category = c.id_category and b.id_items_detail = e.id_items_detail and e.status_acc=1 and e.id_form = '.$id)->result();
    }

    function get_all_detail_by_form_pengadaan_only_acc($id)
    {
        return $this->db->query('select * from form a, items_detail b, items_category c, user_akun d, form_content e where a.id_user = d.id_user and a.id_form = e.id_form and b.id_category = c.id_category and b.id_items_detail = e.id_item_by_pengadaan and e.status_acc=1 and e.id_form = '.$id)->result();
    }

    function get_all_detail_by_form_acc($id)
    {
        return $this->db->query('select * from form a, items_detail b, items_category c, user_akun d, form_content e where a.id_user = d.id_user and a.id_form = e.id_form and b.id_category = c.id_category and b.id_items_detail = e.id_items_detail and e.status_acc=1 and e.id_form = '.$id)->result();
    }

    function get_by_item_quantity_form($id,$qty,$form)
    {
        $this->db->where('id_items_detail', $id);
        $this->db->where('quantity', $qty);
        $this->db->where('id_form', $form);
        return $this->db->count_all_results($this->table);
    }

    function get_by_item_form($id,$form)
    {
        $this->db->where('id_items_detail', $id);
        $this->db->where('id_form', $form);
        return $this->db->count_all_results($this->table);
    }
    // update data
    function update_by_form($id, $data)
    {
        $this->db->where('id_form', $id);
        $this->db->update($this->table, $data);
    }

    // delete by form
    function delete_by_form($id)
    {
        $this->db->where('id_form', $id);
        $this->db->delete($this->table);
    }

}

