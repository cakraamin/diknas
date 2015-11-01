<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Program extends CI_Controller 
{

  function __construct()
  {
    parent::__construct();

    $this->load->model('mmaster','',TRUE);
    $this->load->library(array('page','SimpleLoginSecure','arey'));

    $this->load->library('acl',$this->session->userdata('user_id'));

    if(!$this->session->userdata('logged_in')) 
    {
      redirect('home');
    }
  }

  function index()
  {
    redirect('program/daftar');    
  }

  function daftar($short_by='id_school',$short_order='desc',$page=0)
  {
    $per_page = 10;
    $skule = $this->session->userdata('id_school');
    $total_page = $this->mmaster->getNumJur($skule);
    $url = 'masters/sekolah/'.$short_by.'/'.$short_order.'/';

    $query = $this->mmaster->getSkul($kec,$id,$per_page,$page,$short_by,$short_order);

    if(count($query) == 0 && $page != 0)
    {
      redirect('masters/sekolah/'.$short_by.'/'.$short_order.'/'.($page - $per_page));   
    }  

    $data = array(
      'kueri'     => $query,
      'page'      => $page,
      'paging'    => $this->page->getPagination($total_page,$per_page,$url,$uri=5),
      'main'      => 'schools',
      'sekolah'   => 'select',
      'sort_by'     => $short_by,
      'sort_order'  => $short_order,      
      'page'      => $page,
      'id'      => $id,
      'nama'      => $nama,
      'kecamatan'   => $this->mmaster->getSelekKec(),
      'kec'     => $kec,
      'total_page'  => $total_page
    );

    $this->load->view('template',$data);
  }

  function tambah_sekolah($id,$nama)

  {

    $data = array(        

      'main'      => 'formSekolah',

      'ket'     => 'Form Master Sekolah',

      'jenis'     => 'Tambah',

      'sekolah'   => 'select',

      'link'      => 'simpan_sekolah/'.$id.'/'.$nama,

      'jenjang'   => $this->arey->getJenjangId($id),

      'id'      => $id,

      'nama'      => $nama,

      'kecamatan'   => $this->mmaster->getSelekKec()

    );

      

    $this->load->view('template',$data);

  }      

  function edit_sekolah($ids,$nama,$id)

  {

    if($id == "")

    {

      $this->message->set('notice','Maaf parameter salah');

      redirect('masters/sekolah/<?=$ids?>/<?=$nama?>');

    }



    $data = array(      

      'main'      => 'formSekolah',

      'ket'     => 'Form Master Sekolah',

      'jenis'     => 'Edit',

      'master'    => 'select',

      'link'      => 'update_sekolah/'.$ids.'/'.$nama.'/'.$id,

      'kueri'     => $this->mmaster->editSekolah($id),

      'jenjang'   => $this->arey->getJenjang(),

      'nama'      => $nama,

      'id'      => $ids,

      'kecamatan'   => $this->mmaster->getSelekKec()

    );

      

    $this->load->view('template',$data);

  }

  function edit_propinsi($id)

  {

    if($id == "")

    {

      $this->message->set('notice','Maaf parameter salah');

      redirect('masters/propinsi');

    }



    $data = array(      

      'main'      => 'formPropinsi',

      'ket'     => 'Form Master Propinsi',

      'jenis'     => 'Edit',

      'master'    => 'select',

      'link'      => 'update_propinsi/'.$id,

      'kueri'     => $this->mmaster->editPropinsi($id)

    );

      

    $this->load->view('template',$data);

  }

  function simpan_sekolah($id,$nama)

  {

    if($this->mmaster->cekNpsn() > 0)

    {

      $this->message->set('notice','NSPN atau Nama Sekolah Tidak boleh sama');  

      redirect('masters/sekolah/'.$id.'/'.$nama);

    }



    $this->mmaster->addSekolah();



    if($this->db->affected_rows() > 0)

    {

      $this->message->set('succes','Sekolah berhasil dibuat');

    }

    else

    {

      $this->message->set('notice','Sekolah gagal dibuat');

    }



    redirect('masters/sekolah/'.$id.'/'.$nama);

  }


  function update_sekolah($ids,$nama,$id)

  {

    if($this->mmaster->cekNpsns($id))

    {

      $this->message->set('notice','Maaf NPSN tidak boleh sama');

      redirect('sekolah');  

    }

  

    if($id == "")

    {

      $this->message->set('notice','Maaf parameter salah');

      redirect('masters/sekolah/'.$ids.'/'.$nama);

    }



    $this->mmaster->updateSekolah($id);



    if($this->db->affected_rows() > 0)

    {

      $this->message->set('succes','Data sekolah berhasil diupdate');

    }

    else

    {

      $this->message->set('notice','Data sekolah gagal diupdate');

    }

    redirect('masters/sekolah/'.$ids.'/'.$nama);

  }

  function hapus_sekolah($ids,$nama,$id)

  {

    if($id == "")

    {

      $this->message->set('notice','Maaf parameter salah');

      redirect('masters/sekolah/'.$ids.'/'.$nama);

    }



    if($this->mmaster->deleteSchool($id))

    {

      $this->message->set('succes','Data sekolah berhasil dihapus');

    }

    else

    {

      $this->message->set('notice','Data sekolah gagal dihapus');

    }

    redirect('masters/sekolah/'.$ids.'/'.$nama);

  }

  function all_sekolah($id,$nama)

  {   

    $cek = $this->input->post('check');

    if(!is_array($cek))

    {

      $kec = $this->input->post('kecamatan',TRUE);

      redirect('masters/sekolah/'.$id.'/'.$nama.'/'.$kec);      
    }

    foreach($cek as $dt_cek)

    {

      $this->mmaster->deleteSchool($dt_cek);

    }

    $this->message->set('succes','Data sekolah berhasil dihapus');

    redirect('masters/sekolah/'.$id.'/'.$nama);

  }
}