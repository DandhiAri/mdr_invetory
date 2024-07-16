<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Commonfunction
{
	
	/*	
		====================================================== Variable Declaration =========================================================
	*/	
	protected $CI;
	var $frm;
	
    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct()
    {
        // Assign the CodeIgniter super-object
    
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->library('session');
		$this->CI->load->database();
		
		// $this->CI->load->library('FPDF','','fnpdf');
		// $this->CI->load->library('PHPExcel','','excel');
		
    }
	
	
	public function addAlert($user,$rem,$link)
	{
		
		//save to database
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		
		//$this->CI->Mmain->qIns("tb_alert",Array(0,$user,$rem,$link,0));
	}
	
	public function stopAlert($id)
	{
	
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		//$this->CI->Mmain->qUpdpart("tb_alert","id_alert",$id,Array("stat_alert"),Array(1));
		
	}


	public function checkAccess($accUser,$idFrm)
	{
		//check user access	
		//init modal
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		$isAll = $this->CI->Mmain->qRead(
										"tb_accfrm AS a INNER JOIN tb_frm AS b ON a.code_frm = b.code_frm 
										WHERE a.id_acc ='".$accUser."' AND b.id_frm='".$idFrm."'",
										"a.is_add as isadd,a.is_edt as isedt,a.is_del as isdel,a.is_spec1 as acc1,a.is_spec2 as acc2","");
	
		return $isAll->num_rows() > 0 ? $isAll->row() : null ;
	}
	
	public function sendAlert($userList,$alertList,$alertTitle,$alertLink)
	{
		//check user access	
		//init modal
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		$retVal="";
		
		return $retVal;
	}
	
	public function uploadFile($files,$defaultFiles="")
	{
		$retVal = $defaultFiles;
		if(!empty($files))
		{
			$flName=$files['name'];
			$flTmp=$files['tmp_name'];
			move_uploaded_file($flTmp,"assets/images/picNews/".$flName);
			$retVal=$flName;
		}
		
		return $retVal;
	}
	
	public function getheader()
	{	
	
			$this->CI->load->database();
			$this->CI->load->model('Mmain');
			//get website setting
			
			$output['setting']=$this->CI->Mmain->qRead(
											"tb_setting",
											"","");
											
			$output['comments']=$this->CI->Mmain->qRead(
										"
										tb_comment AS a INNER JOIN 
										tb_events AS b ON a.id_events = b.id_events 
										WHERE a.stat_comment =0 ",
										"
										a.id_comment as id,
										b.title_events as tit,
										a.date_comment as date,
										a.time_comment as time,
										a.nm_comment as nm,
										a.content_comment as content,
										a.email_comment as email,
										a.stat_comment as st
										
										","");
	/*
			$output['events']=$this->CI->Mmain->qRead(
										"
										tb_events AS a INNER JOIN 
										tb_emp AS b ON a.code_user = b.code_user
										WHERE a.stat_events =0 ",
										"
										a.id_events as id,
										a.title_events as tit,
										a.date_events as date,
										a.summary_events as content,
										a.pic_events as pic,
										b.nm_emp as nm,
										a.stat_events as st
										","");
										*/
		
				
			$surveyData=$this->CI->Mmain->qRead(
										"
									tb_sur s 
										WHERE NOW() >= s.dt0_sur AND s.dt1_sur > NOW()
										AND ( s.type_rmd_sur='Daily')
										AND 
											CASE 
												WHEN s.par_sur='Selected Participant' THEN s.id_sur IN (SELECT id_sur FROM tb_surmem WHERE code_user = '".$this->CI->session->userdata("codeUser")."' GROUP BY id_sur ) 
											END 
										AND NOT s.id_sur in (select id_sur from tb_surres WHERE code_user = '".$this->CI->session->userdata("codeUser")."' AND DATE_FORMAT(dt_surres,'%Y-%m-%d') = CURDATE() )
										",
										"
										s.id_sur,
										s.nm_sur,
										s.desc_sur
										
										","");
										
			if($surveyData->num_rows() > 0 )
			{
				$surveyID = $surveyData->row()->id_sur;
				// ACTIVITIES
				$tableQuery="
									tb_surq a 
									
									WHERE a.id_sur = '".$surveyID."'
									ORDER BY a.order_surq
									";
				$fieldQuery="
									a.id_surq as id, 
									a.nm_surq as nm,
									a.type_surq as type,
									''  as isi,
									a.required_surq,
									a.placeholder_surq,
									a.maxlength_surq
									";
									
				$renderTemp=$this->CI->Mmain->qRead($tableQuery,$fieldQuery,"");
				$surveyFormTxt=null;
				$surveyTableHeader = null;
				foreach($renderTemp->result() as $i => $row)
				{
						$surveyTableHeader[$i] = $row->nm;
						$isi = $row->isi;
						$tmp=null;
						//$surveyFormTxt[$i] = "<input type='hidden' name='txtID[]' value='".$row->id."'>";
					
						switch($row->type)
						{
							case "Input/Text" : 	$tmp = "<input type='text' class='form-control'  autocomplete='off' name='".$row->id."' ".($row->maxlength_surq<>0?" maxlength='".$row->maxlength_surq."' ":"")." placeholder='".$row->placeholder_surq."' value='".$isi."' ".$row->required_surq.">";
											break;
											
							case "Input/Number" : 	$tmp = "<input type='number' class='form-control'  autocomplete='off' name='".$row->id."'  placeholder='".$row->placeholder_surq."' value='".$isi."'  ".$row->required_surq.">";
											break;
											
							case "Input/Date" : 	$tmp = "<input type='text' class='form-control dtp'  autocomplete='off' name='".$row->id."'  placeholder='".$row->placeholder_surq."' value='".$isi."'  ".$row->required_surq.">";
											break;
											
							case "Input/Email" : 	$tmp = "<input type='email' class='form-control'  autocomplete='off' name='".$row->id."'  maxlength='".$row->maxlength_surq."' placeholder='".$row->placeholder_surq."'  value='".$isi."'  ".$row->required_surq.">";
											break;
											
							case "Essay" : 			$tmp = "<textarea class='form-control'  autocomplete='off' name='".$row->id."'>".$isi."</textarea>";
											break;
							case "Multiple Choices" : $tmp = $this::createCbofromdb("tb_surqsub WHERE id_surq = '".$row->id."' ORDER BY order_surqsub","nm_surqsub as id,nm_surqsub as nm","",$isi,$row->required_surq,$row->id,$row->placeholder_surq); 
											break;
											
											
							case "Input/File" : 	$tmp = "
														<input type='hidden' name='txt[]' value='".$isi."'>
														<br>".($isi<>"" ? "<a target='_blank' href='".base_url()."assets/documents/".$isi."'>Open file</a>": "")."
														<input type='file' accept='image/*,application/pdf' class='form-control fileupload'  name='txtImg".$row->id."'  ".$row->required_surq.">"; 
											break;
						}
						
						$surveyFormTxt[$i] = $tmp;
						
						
					
				}
				
					
				$output['surveyTableHeader']=	$surveyTableHeader;
				$output['surveyFormTxt']=$surveyFormTxt;
				
				$output['survey'] = $surveyData;
			}
			
	
	
		$isadmin="";
		$isAll = $this->CI->Mmain->qRead(
										"tb_accfrm AS a INNER JOIN tb_frm AS b ON a.code_frm = b.code_frm
										WHERE a.id_acc ='".$this->CI->session->userdata['accUser']."' AND a.code_frm='FR017' ",
										"a.is_add as isadd,a.is_edt as isedt,a.is_del as isdel,a.is_spec1 as acc1,a.is_spec2 as acc2","");
		
		$access=$isAll->row();
		//echo count($access);
		//$output['isall']=$access->isadd;
		$isAdmin="";
		if($access->acc1<>1)
			
			$isAdmin=" AND (d.appr1_lobgroup = '".$this->CI->session->userdata("codeUser")."' OR d.appr2_lobgroup = '".$this->CI->session->userdata("codeUser")."')";
		
			$output['alert']=$this->CI->Mmain->qRead("	tb_lob a 
														INNER JOIN tb_emp b ON b.code_user = a.code_user
														INNER JOIN tb_user u ON b.code_user = u.code_user
														INNER JOIN tb_detlobgroup c ON c.code_user = a.code_user
														INNER JOIN tb_lobgroup d ON d.id_lobgroup = c.id_lobgroup
														INNER JOIN tb_lobtype e ON e.id_lobtype = a.id_lobtype
														WHERE a.stat_lob=0 AND  YEAR(a.date0_lob) = YEAR(CURDATE())
														".$isAdmin."
														GROUP BY e.desc_lobtype
														",
														"
														a.id_lob AS id,
														COUNT(e.desc_lobtype) AS rem,
														CONCAT('Vacation?type=',e.desc_lobtype) AS link,
														e.desc_lobtype AS nm,
														'mdr-logo.png' AS ava,
														a.date0_lob AS dt
														","");
										
			$output['ses']=$this->CI->session->all_userdata();
			$output['frmList']=$this->CI->session->userdata('frmList');
			$output['frmHead']=$this->CI->session->userdata('frmHead');
			$output['currentMenu'] = $this->CI->uri->segment(1);
			$this->CI->load->view('adm_header',$output);
		
		
	}
	
	public function getfooter()
	{	
	
		$output['setting']=$this->CI->Mmain->qRead(
											"tb_setting",
											"","");
											
		$this->CI->session->unset_userdata('successNotification');
		
		$this->CI->load->view('adm_footer',$output);	
		
		
	}
	public function loadView($viewPage, $output)
	{
		//render view
		$this::getheader();
		$this->CI->load->view($viewPage, $output);
		$this::getfooter();
	}
	
	public function getFormGroup($idacc)
	{
		//init modal
		$this->CI->load->database();
		$this->CI->load->model('Mmain');		
		$qemp=$this->CI->Mmain->qRead("	tb_frm AS a 
										INNER JOIN tb_frmgroup AS b ON a.id_frmgroup = b.id_frmgroup 
										INNER JOIN tb_accfrm AS c ON a.code_frm = c.code_frm
										WHERE c.id_acc='".$idacc."' AND a.stat_frm=1 ORDER BY b.nm_frmgroup,a.sort_order,a.desc_frm ",
										"a.code_frm as code,a.id_frm as id,a.desc_frm as descs,b.nm_frmgroup as groupnm,b.icon_frmgroup as ico,b.iconcolor_frmgroup as iclr,a.is_shortcut as iss",
										"");
										
		return $qemp;
	}
	
	
	public function getFormGroupHeader($idacc)
	{
		//init modal
		$this->CI->load->database();
		$this->CI->load->model('Mmain');												
										
		$qemp=$this->CI->Mmain->qRead("	tb_frm AS a 
										INNER JOIN tb_frmgroup AS b ON a.id_frmgroup = b.id_frmgroup 
										INNER JOIN tb_accfrm AS c ON a.code_frm = c.code_frm
										WHERE c.id_acc='".$idacc."' AND a.stat_frm=1  GROUP BY b.nm_frmgroup ORDER BY b.nm_frmgroup,a.sort_order,a.desc_frm ",
										"b.nm_frmgroup as groupnm,b.icon_frmgroup as ico,b.iconcolor_frmgroup as iclr",
										"");
		return $qemp;
	}
	// combobox
	public function createCbofromDbAll($cboTb,$cboSel,$cboWhere,$cboDef,$isdis="",$nmdef="txt[]")
	{
		//init modal
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		$qemp=$this->CI->Mmain->qRead($cboTb,$cboSel,$cboWhere);
		$cboemp="<select name=$nmdef class='form-control select2' multiple='multiple'   $isdis data-placeholder='Select data' style='width: 100%'>";
			$cboemp.="<option  value=''>All</option>";
		foreach($qemp->result() as $row)
		{
			$isdef="";
			if(is_array($cboDef))
			{
				foreach($cboDef as $dt)
				if($row->nm==$dt || $row->id==$dt)		
					$isdef="selected";
			}
			else
			if($row->nm==$cboDef || $row->id==$cboDef)	
				$isdef="selected";
			$cboemp.="<option value='".$row->id."' $isdef>".$row->nm."</option>";
		}
		$cboemp.="</select>";
		return $cboemp;
	}
	
    // combobox
	public function createCbofromDb($cboTb,$cboSel,$cboWhere,$cboDef,$IDs="",$nmdef="txt[]",$placeholder="Select Data",$clsName="",$cboAdd=null)
	{
		//init modal
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		$qemp=$this->CI->Mmain->qRead($cboTb,$cboSel,$cboWhere);
		$cboemp="<select name=$nmdef class='form-control $clsName' placeholder='".$placeholder."'  $IDs style='width: 100%'>";

		if($placeholder=="" || $placeholder <> "no")
		{
			if($placeholder == "")
			$placeholder="Pilih Data";
		
			$opt="";
			if($cboAdd <> null)
			{
				foreach($cboAdd as $i => $add)
				$opt .= " data-".$add."='Pilih Data' ";
			}
			$cboemp.="	<option  data-opt='Pilih Data' $opt value=''  selected>".$placeholder."</option>";
		}
			
		foreach($qemp->result() as $row)
		{
			
			$opt = isset($row->opt) ? " data-opt='".$row->opt."' " : "";
			if($cboAdd <> null)
			{
				foreach($cboAdd as $i => $add)
					$opt .= " data-".$add."='".$row->$add."' ";
			}
			
			$isdef="";
			if($row->nm === $cboDef || $row->id === $cboDef)	
				$isdef="selected";
			$cboemp.="<option value='".$row->id."' $opt $isdef>".$row->nm."</option>";
		}
		$cboemp.="</select>";
		return $cboemp;
	}
	
	public function createCbofromDbsingle($cboTb,$cboSel,$cboWhere,$cboDef,$IDs="",$nmdef="txt[]", $addclass="")
	{
		//init modal
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		$qemp=$this->CI->Mmain->qRead($cboTb,$cboSel,$cboWhere);
		$cboemp="<select name=$nmdef class='form-control $addclass' $IDs style='width: 100%'>";
		foreach($qemp->result() as $row)
		{
			$isdef="";
			if($row->nm === $cboDef)	
				$isdef="selected";
			$cboemp.="<option value='".$row->id."' $isdef>".$row->nm."</option>";
		}
		$cboemp.="</select>";
		return $cboemp;
	}
	
	public function createCbo($cboid,$cboval,$cboDef,$IDs="",$nmdef="txt[]"	,$cls="",$placeholder="Select Data",$cboAdd=null)
	{
		
			
		//init modal
		$cboemp="<select name=$nmdef class='form-control $cls' $IDs placeholder='Select data' style='width: 100%'>";
		
		if($placeholder=="" || $placeholder <> "no")
		{
			if($placeholder == "")
			$placeholder="Select Data";
		
			$opt="";
			if($cboAdd <> null)
			{
				foreach($cboAdd as $i => $add)
				$opt .= " data-".$add."='Pilih Data' ";
			}
			$cboemp.="	<option  data-opt='Pilih Data' $opt value=''  selected>".$placeholder."</option>";
		}
		
		for($i=0;$i<count($cboid);$i++)
		{
			$isdef=( $cboid[$i] == $cboDef || $cboval[$i] == $cboDef ? "selected" : "");	
			$cboemp.="<option value='".$cboid[$i]."' $isdef >".$cboval[$i]."</option>";
		}
		$cboemp.="</select>";
		return $cboemp;
	}
	
	public function createCboAll($cboid,$cboval,$cboDef,$IDs="",$nmdef="txt[]")
	{
		//init modal
		$cboemp="<select name=$nmdef class='form-control select2' multiple='multiple' data-placeholder='Select data' style='width: 100%'>";
			$cboemp.="<option value=''>All</option>";
		for($i=0;$i<count($cboid);$i++)
		{
			$isdef="";
			if(is_array($cboDef))
			{
				foreach($cboDef as $dt)
					if($cboval[$i] == $dt || $cboid[$i] == $dt)		
					$isdef="selected";
			}
			else
			if($cboval[$i] == $cboDef || $cboid[$i] == $cboDef)	
				$isdef="selected";
			$cboemp.="<option value='".$cboid[$i]."' $isdef >".$cboval[$i]."</option>";
		}
		$cboemp.="</select>";
		return $cboemp;
	}
	
	
	public function createMulCbofromDb2($cboTb,$cboSel,$cboWhere,$cboDef,$IDs="",$nmdef="txt[]")
	{
			//init modal
			$this->CI->load->database();
			$this->CI->load->model('Mmain');
			$qemp=$this->CI->Mmain->qRead($cboTb,$cboSel,$cboWhere);
			$cboemp="<select name=$nmdef class='form-control '  $IDs multiple=multiple  style='width: 100%'>";
			foreach($qemp->result() as $row)
			{
					$isdef="";
			if(is_array($cboDef))
			{
				foreach($cboDef as $dt)
					if($cboval[$i] == $dt || $cboid[$i] == $dt)		
					$isdef="selected";
			}
			else
				if($row->nm == $cboDef || $row->id == $cboDef)	
					$isdef="selected='selected'";
				
				$cboemp.="<option value='".$row->id."' $isdef  >".$row->nm."</option>";
			}
			$cboemp.="</select>";
		return $cboemp;
	}

	public function createMulCbofromDb($cboTb,$cboSel,$cboWhere,$cboDef,$IDs="",$nmdef="txt[]")
	{
			//init modal
			$this->CI->load->database();
			$this->CI->load->model('Mmain');
			$qemp=$this->CI->Mmain->qRead($cboTb,$cboSel,$cboWhere);
			$cboemp="<select name=$nmdef class='form-control select2'  $IDs multiple=multiple  style='width: 100%'>";
			foreach($qemp->result() as $row)
			{
					$isdef="";
			if(is_array($cboDef))
			{
				foreach($cboDef as $dt)
					if($row->id == $dt || $row->nm == $dt)		
					$isdef="selected";
			}
			else
				if($row->nm == $cboDef || $row->id == $cboDef)	
					$isdef="selected='selected'";
				
				$cboemp.="<option value='".$row->id."' $isdef  >".$row->nm."</option>";
			}
			$cboemp.="</select>";
		return $cboemp;
	}
	
	
	
	public function createCbofromDb2($cboTb,$cboSel,$cboWhere,$cboDef,$isdis="",$cboNm="txt[]")
	{
			//init modal
			$this->CI->load->database();
			$this->CI->load->model('Mmain');
			$qemp=$this->CI->Mmain->qRead($cboTb,$cboSel,$cboWhere);
			$cboemp="<select name=$cboNm class='form-control select2'  $isdis  style='width: 100%'>";
			foreach($qemp->result() as $row)
			{
				$isdef="";
				if(is_array($cboDef))
				{
					foreach($cboDef as $dt)
						if($cboval[$i] == $dt || $cboid[$i] == $dt)		
						$isdef="selected";
				}
				else
					if($row->nm == $cboDef || $row->id == $cboDef)	
						$isdef="selected='selected'";
					
					$cboemp.="<option value='".$row->id."' $isdef  >".$row->nm."</option>";
			}
			$cboemp.="</select>";
		return $cboemp;
	}
		
	
	public function createRadio($cboid,$cboval,$count,$cboDef)
	{
			//init modal
			$cboemp=" 
                   ";
			for($i=0;$i<count($cboid);$i++)
			{
				$chk="";
				if($cboDef == $cboid[$i])
				$chk="checked"	;
				$cboemp.=" <label><input type='radio' name=txt[$count] class='flat-red' value='".$cboid[$i]."' $chk>&nbsp;$cboval[$i]</label>";
			}
			
			$cboemp.="";
		return $cboemp;
	}
	
	public function createRadiofromDb($cboTb,$cboSel,$count,$cboDef)
	{
		//init modal
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		$qemp=$this->CI->Mmain->qRead($cboTb,$cboSel,"");
		
		$cboemp="";
		foreach($qemp->result() as $row)
		{
			$chk=$row->nm === $cboDef || $row->id === $cboDef ? "checked" : ""	;
			$cboemp.=" <label><input type='radio' name=txt[$count] class='flat-red' value='".$row->id."' ".$chk.">&nbsp;".$row->nm."</label>&nbsp;";
		}
		return $cboemp <> "" ? "<br>".$cboemp : "";
	}
	
	public function createCheckToggle($cboid,$cboval,$cboDef,$cboClass="")
	{
		
			$cboemp=" 
			<br>
			<label>
			<input type='checkbox' class='$cboClass' name='txt[]' ".($cboDef == $cboid[0] ? "checked"	: "")." data-bootstrap-switch data-offstyle='danger' data-onstyle='success' data-on='".$cboval[0]."' data-off='".$cboval[1]."' data-handle-width='30' >
			</label>
			";
			
			
			$cboemp.="";
		return $cboemp;
	}
	
	public function addViewCount($formName)
	{
			//init modal
			$this->CI->load->database();
			$this->CI->load->model('Mmain');
			$visitorIp=$_SERVER['REMOTE_ADDR'];
			$saveVal=Array(
							"",
							date("Y-m-d h:i:s"),
							$visitorIp,
							$formName
							);
			$this->CI->Mmain->qIns("tb_viewcount",$saveVal);
	}
	
	public function getVacationLeft($codeUser,$year="")
	{
		//init modal
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
			
		if($year=="")
			$year=date("Y");
			//$year="2021";
		
		
		
		//get permit count by permit category
		$yearListQuery=$this->CI->Mmain->qRead("		tb_lob a 
												
												 GROUP BY SUBSTR(a.date0_lob,1,4) 
												 ORDER BY SUBSTR(a.date0_lob,1,4) 
										",
										"		SUBSTR(a.date0_lob,1,4) as year,
												COUNT(a.id_lobtype) as tot
										","");
	
		
		$nowyear=$year;
		$kuota=12;
		
		$curUsage[0][0]=0;
		$lastUsage=0;
		$iy=0;
		$sisa=0;
		foreach($yearListQuery->result() as $y)
		{
			$year=$y->year;
			if($year<=$nowyear)
			{
				$lastyear=$year-1;
				
				
				//$this->viewFormTableHeader[2]=$lastyear;
					$this->tableQuery="
							tb_emp u 
						";
						
				//last year report
				$this->tableQuery.="
									LEFT OUTER JOIN
								 (
									SELECT 
										code_user, SUM(dur_lob) AS tot
									FROM            
										tb_lob b INNER JOIN tb_lobtype c ON b.id_lobtype =c.id_lobtype
									WHERE        
										(substr(date0_lob, 1, 4) = '".$lastyear."') AND c.type_lobtype=2 AND b.stat_lob = 1
									GROUP BY code_user) ly ON u.code_user = ly.code_user 
									";
				$this->fieldQuery="	 
							u.nm_emp, 
							u.title_emp,
							CASE WHEN ly.tot is null THEN 0 ELSE ly.tot END AS lastyear, 
							CASE WHEN b1.tot is null THEN 0 ELSE b1.tot END AS jan, 
							CASE WHEN b2.tot is null THEN 0 ELSE b2.tot END AS feb, 
							CASE WHEN b3.tot is null THEN 0 ELSE b3.tot END AS mar, 
							CASE WHEN b4.tot is null THEN 0 ELSE b4.tot END AS apr, 
							CASE WHEN b5.tot is null THEN 0 ELSE b5.tot END AS may, 
							CASE WHEN b6.tot is null THEN 0 ELSE b6.tot END AS jun,
							CASE WHEN b7.tot is null THEN 0 ELSE b7.tot END AS jul,
							CASE WHEN b8.tot is null THEN 0 ELSE b8.tot END AS aug,
							CASE WHEN b9.tot is null THEN 0 ELSE b9.tot END AS sep,
							CASE WHEN b10.tot is null THEN 0 ELSE b10.tot END AS okt,
							CASE WHEN b11.tot is null THEN 0 ELSE b11.tot END AS nov,
							CASE WHEN b12.tot is null THEN 0 ELSE b12.tot END AS des,
							0 AS tot,
							0 AS bal,
							u.code_user as id
							
							";
				
				//current year report
				for($i=1;$i<=12;$i++)
				{
					$curdate=$year."-".sprintf("%02d",$i);
					$this->tableQuery.="
										LEFT OUTER JOIN
									 (
										SELECT 
											code_user, SUM(dur_lob) AS tot
										FROM            
											tb_lob b INNER JOIN tb_lobtype c ON b.id_lobtype =c.id_lobtype
										WHERE        
											(substr(date0_lob, 1, 7) = '".$curdate."') AND c.type_lobtype=2 AND b.stat_lob = 1
										GROUP BY code_user) b".$i." ON u.code_user = b".$i.".code_user 
										";
				}
			
				//$this->tableQuery.=" WHERE u.code_user='".$codeUser."' ";
				$this->tableQuery.=" WHERE u.code_user='".$codeUser."' ";
				$renderTemp=$this->CI->Mmain->qRead($this->tableQuery,$this->fieldQuery,"");
				
				$i2=0;
				foreach($renderTemp->result() as $row)
				{	
					$row->tot=$row->jan+$row->feb+$row->mar+$row->apr+$row->may+$row->jun+$row->jul+$row->aug+$row->sep+$row->okt+$row->nov+$row->des;
					
					
					$janmar=$row->jan+$row->feb+$row->mar;
					$aprdes=$row->apr+$row->may+$row->jun+$row->jul+$row->aug+$row->sep+$row->okt+$row->nov+$row->des;
					
					$bal=0;
					if($iy>0)
						$bal=$curUsage[$iy-1][$i2];
				
					if($bal>$janmar)
					{
						$janmar=0;
						$sisa=$kuota-($janmar+$aprdes);
					}
					else
					{
						
						$sisa=$kuota-($janmar-$bal+$aprdes);
					}
					
					$curUsage[$iy][$i2]=$sisa;
					$row->lastyear=$bal;
					$row->bal=$sisa;
					
					
					//$row->nm_emp.=" ".$kurang;
					
					$i2++;
				}
				$iy++;
			}
		}
		
			return $sisa;
	}
	

//check file extension
	public function checkExtension($filename,$folderName,$viewLink,$id="")
	{
		$retVal="";
		
		$ext=strtolower(substr($filename,strlen($filename)-3,3));
					
		if($ext=="pdf")
			$retVal="<a target='_blank' href='".base_url().$folderName.$filename."' >".$filename."</a>";
		else
		if($ext=="jpg" || $ext=="png" || $ext=="bmp" || $ext=="gif" || strtolower(substr($filename,strlen($filename)-4,4))=="jpeg")
		{
			//$retVal="<a data-toggle='tooltip' title='Open File ".$filename."' href='".base_url().$viewLink."/printPDF/".$id."/".$filename."' target='_blank'><img src='".base_url().$folderName.$filename."' width='200px'></a>";
			$retVal="<a data-toggle='tooltip' title='Open File ".$filename."' href='".base_url().$folderName.$filename."' target='_blank'><img src='".base_url().$folderName.$filename."' width='200px'></a>";
			
		}
		else
		if($ext=="mkv" || $ext=="mp4" || $ext=="flv" || $ext=="bmp" || $ext=="mov" )
			$retVal="<a target='_blank' href='".base_url().$folderName.$filename."' title='Putar ".$filename."' class='fa fa-film fa-2x' >&nbsp;</a>";
		else
		if($ext=="xls" || strtolower(substr($filename,strlen($filename)-4,4))=="xlsx"  )
			$retVal="<a target='_blank' href='".base_url().$folderName.$filename."' title='Buka ".$filename."'  >".$filename."</a>";
		else
			$retVal="<a target='_blank' href='".base_url().$folderName.$filename."' title='Buka ".$filename."' >".$filename."</a>";
		
		return $retVal;
	}
	
	public function converttoOrderedItem($id,$ord,$link,$jum)
	{
		
		$tempOrder="";
		if($ord == 1 )
		$tempOrder = "<a class='btn btn-default btn-flat btn-xs' disabled><i class='fa fa-chevron-up fa-xs'></i></a>&nbsp;&nbsp;";
		else
		$tempOrder = "<a href='".$link.$id."/".$ord."/up'  class='btn btn-success btn-flat btn-xs'><i class='fa fa-chevron-up fa-xs'></i></a>&nbsp;&nbsp;";
		
		$tempOrder .= $ord ;
					
					
		if($ord == $jum )
		$tempOrder .= "&nbsp;&nbsp;<a href='#' class='btn btn-default btn-flat btn-xs' disabled><i class='fa fa-chevron-down fa-xs'></i></a>" ;
		else
		$tempOrder .= "&nbsp;&nbsp;<a href='".$link.$id."/".$ord."/down' class='btn btn-danger btn-flat btn-xs'><i class='fa fa-chevron-down fa-xs'></i></a>" ;
				
		return $tempOrder;
	}
	
	public function filtering(){
		
	}
	
	
	//export to PDF
	public function exporttoPDF($pdfHeader,$pdfTitle,$widthArr,$renderTemp)
	{
		
		$pdf = $this->CI->fnpdf;
		$pdf->AddPage("L","Legal");
		
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,7,'Laporan '.$pdfTitle,0,1,'C');
		$pdf->Ln();
		if($renderTemp->num_rows()>0)
		{
			$height=5;
			$width=25;
					
		//$pdf->Image(base_url()."assets/images/logo.png",12,5,20);
		//$pdf->Image(base_url()."assets/images/approved.png",140,30,-200);
		
		//header
		
		//sub header
		
		$pdf->SetFont('Arial','',6);
		
		//echo count($pdfHeader);
		$i=0;
		foreach($pdfHeader as $label)
		{
			
			if($i<count($pdfHeader))
			{
				$nextLine=0;
				if($i==count($pdfHeader)-1)
					$nextLine=1;
				$pdf->Cell($widthArr[$i],$height,$label,1,$nextLine,'C');
			}
			$i++;
			
		}
		foreach($renderTemp->result() as $row)
		{
			
				$i=0;
				foreach($row as $label)
				{
					if($i<count($pdfHeader))
					{
						$nextLine=0;
						if($i==count($pdfHeader)-1)
							$nextLine=1;
						$pdf->Cell($widthArr[$i],$height,$label,1,$nextLine,'C');
					}
					$i++;
				}
			
		}
		
			
		}
		else
		{
			
				$pdf->Cell(0,0,"No data",1,0,'C');
		}
		
		$pdf->Output("I");
	}

	//export to Excel
	public function exporttoExcel($excelHeader,$excelTitle,$widthArr,$renderTemp)
	{
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$rowArr=Array(
						"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
						"AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ",
						"BA","BB","BC","BD","BE","BF","BG","BH","BI","BJ","BK","BL","BM","BN","BO","BP","BQ","BR","BS","BT","BU","BV","BW","BX","BY","BZ",
						"CA","CB","CC","CD","CE","CF","CG","CH","CI","CJ","CK","CL","CM","CN","CO","CP","CQ","CR","CS","CT","CU","CV","CW","CX","CY","CZ",
						"DA","DB","DC","DD","DE","DF","DG","DH","DI","DJ","DK","DL","DM","DN","DO","DP","DQ","DR","DS","DT","DU","DV","DW","DX","DY","DZ"
					);
		$isExist=0;
		
		if(is_array($renderTemp))
		{
			$isExist=1;
			
		}
		else
		if($renderTemp->num_rows()>0)
		{
			$isExist=2;
		}
		if($isExist>0)
		{
			//echo $renderTemp->num_rows();		
			
			$objPHPExcel->getActiveSheet()->setCellValue($rowArr[0].'1', $excelTitle);
			$i=0;
			foreach($excelHeader as $label)
			{
							
				$objPHPExcel->getActiveSheet()->setCellValue($rowArr[$i].'3', $label);
				
				$objPHPExcel->getActiveSheet()->getColumnDimension($rowArr[$i])->setAutoSize(true);
				$i++;
			}
			
			$excelRow=4;
			if($isExist==2)
			foreach($renderTemp->result() as $row)
			{
				//if($excelRow<=600)
				//{
					$i=0;
					foreach($row as $label)
					{
						if($i<count($excelHeader))
						{
							$objPHPExcel->getActiveSheet()->setCellValue($rowArr[$i].$excelRow, $label);
						}
						$i++;
					}
					
					$excelRow++;
				//}
			}
			else
			if($isExist==1)
			foreach($renderTemp as $row)
			{
				//if($excelRow<=600)
				//{
					$i=0;
					foreach($row as $label)
					{
						if($i<count($excelHeader))
						{
							$objPHPExcel->getActiveSheet()->setCellValue($rowArr[$i].$excelRow, $label);
						}
						$i++;
					}
					
					$excelRow++;
				//}
			}
			
			
			$styleArray = array(
			'alignment' => array(
                'horizontal' =>  PHPExcel_Style_Alignment::HORIZONTAL_CENTER ,
                'vertical' =>  PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			  'borders' => array(
				'allborders' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			  )
			);
			$batas=$excelRow;
			$objPHPExcel->getActiveSheet()->getStyle('A3:'.$rowArr[$i-1].$batas)->applyFromArray($styleArray);
			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle($excelTitle);


	
			
		}
		else
		{
			
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "No data");
		}
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		//header('Content-Type: application/pdf');
		header('Content-Disposition: attachment;filename="'.$excelTitle."_".Date("Y-m-d").'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		
		//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
		$objWriter->save('php://output');
		
	}
	
	public function countAll($tableQuery, $fieldQuery, $ordQuery)
	{
		
		//save to database
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		
		$renderTemp=$this->CI->Mmain->qRead($tableQuery, $fieldQuery,"");
		return $renderTemp->num_rows();
	}
	
	
	public function generateDTOption($formAccess, $option)
	{
		$dtTemp = "";
		$dtTemp .= (isset($option->detLink)) 	? 	"<a data-toggle='tooltip' target='_blank' title='Show Detail' href='". site_url()."". $option->detLink."/". $option->id."'><i class='fa fa-search fa-fw  text-gold'></i></a>" : '' ;
		$dtTemp .= (isset($formAccess->isedt) && $formAccess->isedt==1 && !isset($option->noedit)) ? "<a class='editModal' data-id='".$option->id."' title='Edit Data' href='" . site_url(). (!isset($option->editLink) ? $option->saveLink : $option->editLink )."/". $option->id."'><i class='fa fa-cog fa-fw '></i></a>" : "";
		$dtTemp .= (isset($formAccess->isdel) && $formAccess->isdel==1 && !isset($option->nodelete)) ? "<a data-toggle='modal' data-target='#confirm-delete' title='Delete Data' href='#' name='". $option->id."' class='deleteBtn'><i class='fa fa-trash fa-fw '></i></a>" : "" ;
		$dtTemp .= (isset($option->isOwner) && $option->isOwner == 1) ? 	"<a data-toggle='modal' data-target='#confirm-checkpoint' title='Input Checkpoint' href='#' name='" . site_url()."Ongoingtrip/SimpanCheckpoint/". $option->id."' class='checkPointBtn'><i class='fas fa-tachometer-alt fa-fw fa-lg text-gold'></i></a>" : "" ;
		$dtTemp .= (isset($option->printLink)) 	? 	"<a  title='Print Data' href='" . site_url() . $option->printLink . "/" . $option->id."'  class='printBtn' target='_blank'><i class='fa fa-print fa-fw text-gold'></i></a>" : "" ;
		return $dtTemp;
		
	}
	
}

?>