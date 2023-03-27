<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class PathologyQR extends MY_Controller
{

    public function __construct()
    {
        parent::__construct(); 
        
        // https://sourceforge.net/projects/phpqrcode/ | https://phpqrcode.sourceforge.net/examples/index.php?example=005
        require_once APPPATH . "/third_party/phpqrcode/qrlib.php";
            }

  
   public function printPatientReportDetail()
    {
         
        $patient_id            = $_GET['patient_id'];
        $print_details         = $this->printing_model->get('', 'pathology');
        $data['print_details'] = $print_details;
        $id                    = $this->input->post('id');
        $id                    = (isset($_GET['id']) ? $_GET['id'] : $id);
        $data['id']            = $id;
        $result                = $this->pathology_model->getPatientPathologyReportDetails($id);
        
        $data['result']        = $result; 
        $data['patient_id'] = $patient_id;
        $data['id']         = $id;
        if($result->patient_id == $patient_id){
        echo $page             = $this->load->view('admin/pathology/_printPatientReportDetail', $data, true);    
        }else{
            echo json_encode(['status'=>false, 'message'=> 'Invalid Report id or patient_id ']);
        }
    }

    public function getQRCode($data = 'NA'){
         
        $filename =   time() . ".png";
        $qr_code_image_path =   base_url() . 'uploads/qr-code/QR-'.$filename; // for get url
        $filename = FCPATH .'uploads\qr-code\QR-'.$filename; // for save dir url        
        $errorCorrectionLevel = 'L';
        $matrixPointSize = 6;
        QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);   
        return $qr_code_image_path;

    }

}