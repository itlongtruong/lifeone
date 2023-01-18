<?php

namespace App\Http\Controllers;

use Auth; //use thư viện auths
use DB;
use view;
use Cookie;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use DateTime;
use URL;
class PrintController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function print_list(Request $request)
    {
        $request->session()->put('data_print_list', $request->data);
    }
    public function show(Request $request)
    {
        if($request->session()->has('data_search_list_print')){
            $datas = $request->session()->get('data_search_list_print');
        }
        $request->session()->forget('data_search_list_print');
        return view('print',compact('datas'));
    }
    private function getSQLHACYU($lists_id){
        $query = DB::table('T_HACYU')
        ->select(
        'T_HACYU.HACYU_ID',
        'T_HACYU.IRAI_DAY',
        DB::raw("(SELECT KBNMSAI_NAME FROM M_KBN_WEB WHERE M_KBN_WEB.KBNMSAI_CD = T_HACYU.IRAI_CD AND M_KBN_WEB.KBN_CD = '00' AND M_KBN_WEB.DEL_FLG = 0 LIMIT 1) AS IRAI_CD_NAME"),
        DB::raw("(SELECT KBNMSAI_BIKO FROM M_KBN_WEB WHERE M_KBN_WEB.KBNMSAI_CD = T_HACYU.IRAI_CD AND M_KBN_WEB.KBN_CD = '00' AND M_KBN_WEB.DEL_FLG = 0 LIMIT 1) AS IRAI_COLOR"),      
        DB::raw("(SELECT KBNMSAI_NAME FROM M_KBN_WEB WHERE M_KBN_WEB.KBNMSAI_CD = T_HACYU.STS_CD AND M_KBN_WEB.KBN_CD = T_HACYU.IRAI_CD AND M_KBN_WEB.DEL_FLG = 0 LIMIT 1) AS STS_CD_NAME"),       
        'T_HACYU.HACYUSAKI_NAME',
        'T_HACYU.TAIO_CD',       
        DB::raw("(SELECT TANT_NAME FROM M_TANT_WEB WHERE M_TANT_WEB.TANT_CD = T_HACYU.TAIO_TANT_CD AND M_TANT_WEB.DEL_FLG = 0 LIMIT 1) AS TAIO_TANT_NAME"),
        'T_HACYU.CO_NAME',
        'T_HACYU.CO_POSTNO',
        'T_HACYU.CO_ADDRESS',
        'T_HACYU.CO_TELNO',
        'T_HACYU.CO_FAX',
        'T_HACYU.CO_TANT_NAME',
        'T_HACYU.NONYUSAKI_POSTNO',
        'T_HACYU.NONYUSAKI_NAME',
        'T_HACYU.NONYUSAKI_ADDRESS',
        'T_HACYU.NONYUSAKI_TELNO',
        'T_HACYU.NONYUSAKI_TANT_NAME',
        'T_HACYU.KENMEI',
        'T_HACYU.IRAI_YMD_NAME',
        'T_HACYU.IRAI_YMD',
        'T_HACYU.MESSAGE',
        'T_HACYU.COMMENT1',
        'T_HACYU.COMMENT2',
        'T_HACYU.HAISO_SYBET_CD',
        'T_HACYU.IRAI_CD',
        'T_HACYU.HAISOGYOSYA1',
        'T_HACYU.DENPYONO1',
        'T_HACYU.HAISOGYOSYA2',
        'T_HACYU.DENPYONO2',        
        'T_HACYU.RENRAKUSAKI2',
        'T_HACYU.HAISOGYOSYA_MULTI_FLG',
        'T_HACYU.HAISOGYOSYA3_1_LABEL',
        'T_HACYU.HAISOGYOSYA3_2_LABEL',
        'T_HACYU.HAISOGYOSYA3_1',
        'T_HACYU.DENPYONO3_1',
        'T_HACYU.HAISOGYOSYA3_2',
        'T_HACYU.DENPYONO3_2',
        'T_HACYU.DRIVER_NAME',
        'T_HACYU.RENRAKUSAKI4',
        'T_HACYU.NO_DENPYO_FLG',
        'T_HACYU.BIKO', 
        'T_HACYU.SYOKEI',
        'T_HACYU.SORYO',
        'T_HACYU.SYOHIZEI',
        'T_HACYU.SUM',
        'T_HACYU.NEBIKI_SUM',
        'T_HACYU.PDF_PATH',
        'T_HACYU.EXCEL_PATH',
        'T_HACYU.STS_CD',
        'T_HACYU.SAITAN_NOKI',
        'T_HACYU.KARIOSAE_LIMIT_YMD',
        'T_HACYU.HAISO_HUKA_YOBI',
        'T_HACYU.WEEKDAY_SITEI_RYOKIN',
        'T_HACYU.KARIOSAE_LIMIT_YMD_VSBL_FLG',
        'T_HACYU.CANCEL_IRAI_FLG',
        'T_HACYU.KINGAK_KAKNIN_ANS_CD',
        'T_HACYU.KINGAK_KAKNIN_VSBL_FLG'
        )
        ->leftJoin('T_HACYUMSAI','T_HACYUMSAI.HACYU_ID','=','T_HACYU.HACYU_ID')
        ->where(['T_HACYU.DEL_FLG'=> 0,'T_HACYU.VISIVLE_FLG'=>1])
        ->whereIn('T_HACYU.HACYU_ID', $lists_id)
        ->GROUPBY('T_HACYU.HACYU_ID');

        if(session()->has('sort_list')){
            $items_sort = session()->get('items_sort');
            foreach ($items_sort as $value) {
                if(session()->has($value)){
                    $asc = session()->get($value.'_asc');
                    if ($value == 'MAKER'){
                        $query->orderBy('T_HACYUMSAI.'.$value, empty($asc) ? 'asc' : $asc);
                    }else{
                        $query->orderBy('T_HACYU.'.$value, empty($asc) ? 'asc' : $asc);
                    }
                }
            }
        }else{
            $field_sort             =  session()->get('field_sort');
            $query_sort             =  session()->get('query_sort');
            $query->orderBy($field_sort, $query_sort);
        }

        $query->orderBy('T_HACYUMSAI.HACYUMSAI_ID', 'asc');
        $query->orderBy('T_HACYU.HACYU_ID', 'asc');

        return $query;
    }


    private function getOneSQLHACYU($id){
        $query = DB::table('T_HACYU')
        ->select(
        'T_HACYU.HACYU_ID',
        'T_HACYU.IRAI_DAY',
        'T_HACYU.STS_CD',
        'T_HACYU.HACYU_SYBET_CD',
        'T_HACYU.CO_ADDRESS',
        'T_HACYU.CO_TELNO',
        'T_HACYU.CO_FAX',
        'T_HACYU.CO_TANT_NAME',
        'T_HACYU.NONYUSAKI_POSTNO',
        'T_HACYU.NONYUSAKI_NAME',
        'T_HACYU.NONYUSAKI_ADDRESS',
        'T_HACYU.NONYUSAKI_TELNO',
        'T_HACYU.NONYUSAKI_TANT_NAME',
        'T_HACYU.KENMEI',
        'T_HACYU.IRAI_YMD_NAME',
        'T_HACYU.IRAI_YMD',
        'T_HACYU.MESSAGE',
        'T_HACYU.COMMENT1',
        'T_HACYU.COMMENT2',
        'T_HACYU.HAISO_SYBET_CD',
        'T_HACYU.IRAI_CD',
        'T_HACYU.HAISOGYOSYA1',
        'T_HACYU.DENPYONO1',
        'T_HACYU.HAISOGYOSYA2',
        'T_HACYU.DENPYONO2',        
        'T_HACYU.RENRAKUSAKI2',
        'T_HACYU.HAISOGYOSYA_MULTI_FLG',
        'T_HACYU.HAISOGYOSYA3_1_LABEL',
        'T_HACYU.HAISOGYOSYA3_2_LABEL',
        'T_HACYU.HAISOGYOSYA3_1',
        'T_HACYU.DENPYONO3_1',
        'T_HACYU.HAISOGYOSYA3_2',
        'T_HACYU.DENPYONO3_2',
        'T_HACYU.DRIVER_NAME',
        'T_HACYU.RENRAKUSAKI4',
        'T_HACYU.NO_DENPYO_FLG',
        'T_HACYU.BIKO', 
        'T_HACYU.SYOKEI',
        'T_HACYU.SORYO',
        'T_HACYU.SYOHIZEI',
        'T_HACYU.SUM',
        'T_HACYU.NEBIKI_SUM',
        'T_HACYU.PDF_PATH',
        'T_HACYU.EXCEL_PATH',
        'T_HACYU.TAIO_CD',
        'T_HACYU.KINGAK_KAKNIN_ANS_CD',
        'T_HACYU.KINGAK_KAKNIN_VSBL_FLG',
        'T_HACYU.SAITAN_NOKI',
        'T_HACYU.KARIOSAE_LIMIT_YMD',
        'T_HACYU.HAISO_HUKA_YOBI',
        'T_HACYU.WEEKDAY_SITEI_RYOKIN',
        'T_HACYU.CANCEL_IRAI_FLG'
        )
        ->where(['T_HACYU.DEL_FLG'=> 0,'T_HACYU.VISIVLE_FLG'=>1])
        ->where('T_HACYU.HACYU_ID', '=', (string)$id);

        $data = $query->first();
        return $data;
    }

    private function getDataOneHACYUMSAI($id, $id_detail, $no = 1){
        $query = DB::table('T_HACYUMSAI')
        ->select(
        'T_HACYUMSAI.HACYUMSAI_ID',
        'T_HACYUMSAI.SPLIT_NO',
        'T_HACYUMSAI.CTGORY',
        'T_HACYUMSAI.MAKER',
        'T_HACYUMSAI.HINBAN',
        'T_HACYUMSAI.TANKA',
        'T_HACYUMSAI.ZEINUKI_TANKA',
        'T_HACYUMSAI.SURYO',
        'T_HACYUMSAI.KINGAK',
        'T_HACYUMSAI.SIKIRI_RATE',
        'T_HACYUMSAI.NEBIKI_TANKA',
        'T_HACYUMSAI.NEBIKI_GAK',
        'T_HACYUMSAI.NEBIKI_YM',
        'T_HACYUMSAI.NOHIN_KIBO_YMD',
        'T_HACYUMSAI.BIKO',
        'T_HACYUMSAI.KAITO_NOKI_CD',
        'T_HACYUMSAI.KAITO_NOKI',
        'T_HACYUMSAI.NOHIN_YMD',
        'T_HACYUMSAI.NYUKA_ID',
        'T_HACYUMSAI.NOKIMITEI_ANS_CD',
        'T_HACYUMSAI.CANCEL_KAHI_ANS_CD',
        'T_HACYUMSAI.CANCEL_SU'
        )
        ->where(['T_HACYUMSAI.DEL_FLG'=> 0])
        ->where('T_HACYUMSAI.HACYU_ID', '=', (string)$id)
        ->where('T_HACYUMSAI.HACYUMSAI_ID', '=', (string)$id_detail);
        if ($no > 0){
          $query->where('T_HACYUMSAI.SPLIT_NO', '=', (string)$no);
        }
        $query->orderBy("T_HACYUMSAI.SPLIT_NO" , "ASC");
        return $query->first();
    }    


    private function getDataHACYUMSAI($id){
        $query = DB::table('T_HACYUMSAI')
        ->select(
        'T_HACYUMSAI.HACYUMSAI_ID',
        'T_HACYUMSAI.SPLIT_NO',
        'T_HACYUMSAI.CTGORY',
        'T_HACYUMSAI.MAKER',
        'T_HACYUMSAI.HINBAN',
        'T_HACYUMSAI.TANKA',
        'T_HACYUMSAI.ZEINUKI_TANKA',
        'T_HACYUMSAI.SURYO',
        'T_HACYUMSAI.KINGAK',
        'T_HACYUMSAI.SIKIRI_RATE',
        'T_HACYUMSAI.NEBIKI_TANKA',
        'T_HACYUMSAI.NEBIKI_GAK',
        'T_HACYUMSAI.NEBIKI_YM',
        'T_HACYUMSAI.NOHIN_KIBO_YMD',
        'T_HACYUMSAI.BIKO',
        'T_HACYUMSAI.KAITO_NOKI_CD',
        'T_HACYUMSAI.KAITO_NOKI',
        'T_HACYUMSAI.NOHIN_YMD',
        'T_HACYUMSAI.NYUKA_ID',
        'T_HACYUMSAI.NOKIMITEI_ANS_CD',
        'T_HACYUMSAI.CANCEL_KAHI_ANS_CD',
        'T_HACYUMSAI.CANCEL_SU'
        )
        ->where(['T_HACYUMSAI.DEL_FLG'=> 0])
        ->where('T_HACYUMSAI.HACYU_ID', '=', (string)$id)
        ->orderBy('T_HACYUMSAI.HACYUMSAI_ID', 'asc')
        ->orderBy('T_HACYUMSAI.SPLIT_NO', 'asc');
        return $query->get();
    }

    private function getMaxSPLITNO($id){
        $query = DB::table('T_HACYUMSAI')
        ->select(
        DB::raw("MAX(T_HACYUMSAI.SPLIT_NO) AS SPLIT_NO")   
        )
        ->where(['T_HACYUMSAI.DEL_FLG'=> 0])
        ->where('T_HACYUMSAI.HACYUMSAI_ID', '=', (string)$id)
        ->groupBy('T_HACYUMSAI.HACYUMSAI_ID');

        $rs = $query->first();
        $no = 0;
        if (!empty($rs)){
            $no  = (int)$rs->SPLIT_NO;
        }
        return $no;
    }    

    private function getDataFILE($id){
        $query = DB::table('T_FILE')
        ->select(
        'T_FILE.ID',
        'T_FILE.FILE_NAME',
        'T_FILE.FILE_PATH',
        'M_TANT_WEB.HACYUSAKI_CD',
        'M_TANT_WEB.TANT_NAME'
        )
        ->join('M_TANT_WEB', 'M_TANT_WEB.TANT_CD', '=', 'T_FILE.TANT_CD' )
        ->where(['T_FILE.DEL_FLG'=> 0])
        ->where('T_FILE.HACYU_ID', '=', (string)$id);


        return $query->get();
    }

    private function getDriverInfo(){
        $query = DB::table('M_KBN_WEB')
        ->select(
        'M_KBN_WEB.KBNMSAI_CD',
        'M_KBN_WEB.KBNMSAI_NAME'
        )
        ->where(['M_KBN_WEB.DEL_FLG'=> 0])
        ->where('M_KBN_WEB.KBN_CD', '05');
        $data =  $query->get();
        $arr = array();
        foreach ($data as $value) { 
           $arr[] = $value->KBNMSAI_NAME;          
        }
        return $arr;
    }

    private function getHolidays(){
        $query = DB::table('M_HOLIDAY_WEB')
        ->select(
        'M_HOLIDAY_WEB.HOLIDAY'
        );
        $data =  $query->get();
        $arr = array();
        foreach ($data as $value) { 
           $arr[] = $value->HOLIDAY;
        }
        return $arr;
    }
    private function deliveryCompany(){
        // 配送業者
        $query = DB::table('M_KBN_WEB')
        ->where('KBN_CD','05')
        ->where('DEL_FLG', 0);

        $delivery_company = $query->get(); 
        return $delivery_company;
    }

    private function cancelList($is_array = false){
        // キャンセル可否　回答選択欄 
        $query = DB::table('M_KBN_WEB')
        ->where('KBN_CD','06')
        ->where('DEL_FLG', 0);
        $data = $query->get();
        if($is_array){
            $unDecidedArray = array();
            foreach ($data as $decide) {
                $unDecidedArray[$decide->KBNMSAI_CD] = $decide->KBNMSAI_CD.' '.$decide->KBNMSAI_NAME;
            }
            $data = $unDecidedArray;
        }        
        return $data;
    }

    private function unDecidedList($is_array = false){
        // 納期未定の場合 
        $query = DB::table('M_KBN_WEB')
        ->where('KBN_CD','07')
        ->where('DEL_FLG', 0);
        $data = $query->get();
        if($is_array){
            $unDecidedArray = array();
            foreach ($data as $decide) {
                $unDecidedArray[$decide->KBNMSAI_CD] = $decide->KBNMSAI_CD.' '.$decide->KBNMSAI_NAME;
            }
            $data = $unDecidedArray;
        }
        return $data;
    }

    private function amountInfoList(){
        // 金額確認 
        $query = DB::table('M_KBN_WEB')
        ->where('KBN_CD','08')
        ->where('DEL_FLG', 0);

        $data = $query->get(); 
        return $data;
    }

    private function dueDateCode($isKBNMSAI_BIKO = false){
        // 回答納期コード
        $query = DB::table('M_KBN_WEB')
        ->where('KBN_CD','09')
        ->where('DEL_FLG', 0);
        $data = $query->get(); 
        if($isKBNMSAI_BIKO){
            $rs = array();
            foreach ($data as $decide) {
                $rs[$decide->KBNMSAI_CD] = !empty($decide->KBNMSAI_BIKO) ? (int) $decide->KBNMSAI_BIKO : 0;
            }
            $data = $rs;
        }
        return $data;
    }

    private function dueDate11Code($isKBNMSAI_BIKO = false){
        // 回答納期コード
        $query = DB::table('M_KBN_WEB')
        ->where('KBN_CD','12')
        ->where('DEL_FLG', 0);
        $data = $query->get(); 
        if($isKBNMSAI_BIKO){
            $rs = array();
            foreach ($data as $decide) {
                $rs[$decide->KBNMSAI_CD] = !empty($decide->KBNMSAI_BIKO) ? (int) $decide->KBNMSAI_BIKO : 0;
            }
            $data = $rs;
        }
        return $data;
    }

    private function unDeliveryDate(){
        // 配送不可曜日
        $query = DB::table('M_KBN_WEB')
        ->where('KBN_CD','10')
        ->where('DEL_FLG', 0);

        $unDeliveryDate = $query->get(); 
        return $unDeliveryDate;
    }

    private function statusLeadTimeList(){
        // 配送不可曜日
        $query = DB::table('M_KBN_WEB')
        ->where('KBN_CD','11')
        ->where('DEL_FLG', 0);

        $statusList = $query->get(); 
        return $statusList;
    }

    private function displayData($list_id){
        $user = Auth::user();
        $sourceName = $user->TANT_NAME;
        $isUserLifeOne = true;
        if($user->HACYUSAKI_CD != ''){
            $isUserLifeOne = false;
        }       
        $deliveryCompany = $this->deliveryCompany();
        $dueDateCode = $this->dueDateCode();
        $dueDateCode11 = $this->dueDate11Code();
        $cancelList = $this->cancelList();
        $unDecidedList = $this->unDecidedList();
        $amountInfoList = $this->amountInfoList();

        $data = array();
        $query = $this->getSQLHACYU($list_id);
        $data = $query->get();
        foreach($data as &$item){
            $detail = $this->getDataHACYUMSAI($item->HACYU_ID);
            $item->HACYUMSAI = $detail;
            $item->FILE = $this->getDataFILE($item->HACYU_ID);
        }
        $hasSTS01Load = false;  
        if(session()->has('hasSTS01')){
            $hasSTS01Load = true;
            session()->forget('hasSTS01');
        }
        $driverList = $this->getDriverInfo();
        $holidays = $this->getHolidays();
        return compact('deliveryCompany', 'data', 'sourceName', 'isUserLifeOne' ,'hasSTS01Load', 'driverList','holidays', 'dueDateCode', 'cancelList', 'unDecidedList', 'amountInfoList', 'dueDateCode11'); 
    }

    public function search_print($id)
    {
         $item = $this->displayData(array($id));
         return view('detail', $item); 
    }
    public function post_search_print(Request $request)
    {
        if(session()->has('data_list_checkbox')){
            if( empty(session()->get('data_list_checkbox')) )
                return redirect()->route('list');
        }
     
        $field_sort         =  $request->session()->get('field_sort');
        $query_sort         =  $request->session()->get('query_sort');
        $data = array();
        if(session()->has('data_list_checkbox')){
            $check_box = session()->get('data_list_checkbox');
        } 
        $lists_checkboxID = array();
        $check_box_list = $request->check_box_list;
        foreach($check_box_list as $key => $value){
            $lists_checkboxID[] = substr($value,0,strpos($value,'-'));
        }
        switch ($request->submit) {
            case 'submit_export':
                $request->session()->put('list_csv',$lists_checkboxID);
                $this->__updateStatus($lists_checkboxID);
                return redirect()->route('export');
                break;
            case 'submit_print_pdf':
            case 'submit_print_excel':
                $this->__updateStatus($lists_checkboxID);
                return redirect()->route('list');
                break;
            case 'submit_detail': 
                $item = $this->displayData($lists_checkboxID);
                return view('detail', $item); 
                break;
            default:
                break;
        }
    }

    public function get_search_print()
    {
        if(session()->has('data_list_checkbox')){
            if( empty(session()->get('data_list_checkbox')) )
                return redirect()->route('list');
        }
        $data               = [];
        $lists_checkboxID   = [];
        if(session()->has('data_list_checkbox')){
            $data = session()->get('data_list_checkbox');
        }
        
        foreach($data as $key => $value){
            $lists_checkboxID[] = substr($value,0,strpos($value,'-'));
        }
        $item = $this->displayData($lists_checkboxID);
        return view('detail', $item); 
    }    

    private function __updateStatus($listID){
        if(Auth::user()->HACYUSAKI_CD != ''){
            DB::table('T_HACYU')
           ->whereIn('HACYU_ID',$listID)
           ->where('STS_CD', '01')
           ->update(['STS_CD' => '02']);
        }        
    }

    public function postUpdate(Request $request){  
        $date = New \DateTime();  
        $date = $date->format('Y-m-d H:i:s');
        $data = $request->data;
        $user = Auth::user();
        $HACYU_ID = '0';
        $hasSTS01 = false;

        $arrDENPYO = array(0 => 'チェックなし',  1 =>'チェックあり');


        if (isset($request->submit) && $request->submit == 'delete_file'){
            foreach($data as $key => $value){
                $delete_files = '';
                $HACYU_ID = $key;
                if (!empty($value['FILE_DELETE'])){
                    $delete_files = $value['FILE_DELETE'];
                    
                }
                if ($delete_files !== ''){
                    $arrFiles = explode(',', $delete_files);

                    $query = DB::table('T_FILE')
                    ->select(
                    'T_FILE.FILE_NAME',
                    'T_FILE.HACYU_ID'
                    )
                    ->where(['T_FILE.DEL_FLG'=> 0])
                    ->whereIn('ID',$arrFiles);
                    $listFiles =  $query->get();
                    foreach ($listFiles as $itemFile) { 
                        $pathFile = public_path().'/uploads/'.$itemFile->HACYU_ID.'/'.$itemFile->FILE_NAME;
                        \File::delete($pathFile);
                    }


                    $TFILE = array();
                    $TFILE['DEL_FLG'] = 1;
                    $TFILE['UPD_TANTCD'] = $user->TANT_CD;
                    $TFILE['UPD_YMD'] = $date;
                    DB::table('T_FILE')
                    ->whereIn('ID',$arrFiles)
                    ->update($TFILE);
                }
            }           
        }elseif(isset($request->submit) && $request->submit == 'submit_export'){
            $lists_checkboxID = array();
            foreach($data as $key => $value){
                $lists_checkboxID[] = $key;
            }
            $request->session()->put('list_csv',$lists_checkboxID);
            $this->__updateStatus($lists_checkboxID);
            return redirect()->route('export');
        }elseif(isset($request->submit) && ($request->submit == 'submit_print_pdf' || $request->submit == 'submit_print_excel' || $request->submit == 'order_sale')){
            $lists_checkboxID = array();
            foreach($data as $key => $value){
                $HACYU_ID = $key;
                $lists_checkboxID[] = $key;
            }            
            $this->__updateStatus($lists_checkboxID);
            if ($request->submit == 'order_sale'){
               return redirect()->route('list');
            }            
        }else{
            $holidays = $this->getHolidays();
            $cancelList = $this->cancelList(true);
            $unDecidedList = $this->unDecidedList(true);
            foreach($data as $key => $value){
                $HACYU_ID = $key;
                $HACYU = $value;
                $details = array();
                $dataUpdate = array();
                $driverChange = false;
                if (isset($value['DETAIL'])){
                   $details = $value['DETAIL'];
                   unset($HACYU['DETAIL']);
                }
                
                $files = array();
                if (isset($value['FILE'])){
                    $files = $value['FILE'];
                    unset($HACYU['FILE']);
                }

                unset($HACYU['FILE_DELETE']);

                if (isset($HACYU['NO_DENPYO_FLG']) && $HACYU['NO_DENPYO_FLG'] == 'on'){
                    $HACYU['NO_DENPYO_FLG'] = 1;
                }else{
                    $HACYU['NO_DENPYO_FLG'] = 0;
                }
                $text_yobi = '';
                if (isset($HACYU['HAISO_HUKA_YOBI'])){
                    $text_yobi .= implode('・', $HACYU['HAISO_HUKA_YOBI']).'曜日';
                }
                if (isset($HACYU['HAISO_HUKA_YOBI_HOLIDAY'])){
                    $text_yobi .= '　祝日';
                    unset($HACYU['HAISO_HUKA_YOBI_HOLIDAY']);
                }
                $HACYU['HAISO_HUKA_YOBI'] = $text_yobi;

                $oldData = $this->getOneSQLHACYU($HACYU_ID);
                $IRAI_CD = $oldData->IRAI_CD;
                $HAISO_SYBET_CD = $oldData->HAISO_SYBET_CD;
                $CANCEL_IRAI_FLG = $oldData->CANCEL_IRAI_FLG;

                $arrDateNoHin = array();
                $isUpdate = false;

                if($user->HACYUSAKI_CD != ''){
                    if (isset($value['TAIO_CD1'])){
                       unset($HACYU['TAIO_CD1']);
                    }
                    if (isset($value['TAIO_CD2'])){
                       unset($HACYU['TAIO_CD2']);
                    }
                    if (isset($value['COMMENT1'])){
                       unset($HACYU['COMMENT1']);
                    }
                    $comment2 = '';
                    $comment2Private = empty($oldData->COMMENT2) ? '' : $oldData->COMMENT2;
                    $isChangeComment = false;
                    
                    $order   = array("\r\n", "\n", "\r","【","】"); 
                    $text1 = str_replace($order, "", trim($HACYU['COMMENT2'])); 
                    $text2 = str_replace($order, "", trim($oldData->COMMENT2)); 

                    if(empty(trim($HACYU['COMMENT2']))){
                        $comment2Private = '';
                    }elseif ($text1 != $text2){
                        $comment2Private = '【'.date('Y/m/d H:i').'】' . $HACYU['COMMENT2'];
                        $isChangeComment = true;
                    }
                    $oddDetailFisrt = '';
                    $arrDays = array('01' => 3, '02' => 7, '03' => 10, '04' => 14, '05' => 21, '06' => 30, '07' => 60, '08' => 90, '09' => 180);
                    if($IRAI_CD == '11'){
                        $arrDays = $this->dueDate11Code(true);
                    }elseif($IRAI_CD == '01'){
                        $arrDays = $this->dueDateCode(true);
                    }
                    foreach($details as $k => $v){
                        $HACYUMSAI = $v;
                        $arrData = explode('-', $k);
                        $HACYUMSAI_ID = $arrData[0];
                        $HACYUMSAI['SPLIT_NO'] = $arrData[1];
                        $days = 0;
                        if(($IRAI_CD == '01' || $IRAI_CD == '11') && !empty($HACYUMSAI['KAITO_NOKI_CD'])){
                            $days = isset($arrDays[$HACYUMSAI['KAITO_NOKI_CD']]) ? $arrDays[$HACYUMSAI['KAITO_NOKI_CD']] : 0;
                            $days = $days + 1;
                            if ($HAISO_SYBET_CD == '04'){
                                $days = $days + 2;
                            }elseif ($HAISO_SYBET_CD == '03'){
                                $days = $days + 1;
                            }
                            $kaito_noki = date('Y-m-d');
                            for ($i=1; $i <= $days; $i++) { 
                                $kaito_noki = date('Y-m-d', strtotime("+1 day", strtotime($kaito_noki)));
                                $kaito_noki = $this->checkHolidays($kaito_noki, $holidays);
                            }
                            $HACYUMSAI['KAITO_NOKI'] = $kaito_noki;
                        }

                        if($IRAI_CD == '02'){
                            $HACYUMSAI['KAITO_NOKI'] = $HACYU['SAITAN_NOKI'];
                        }

                        $oddDetail = $this->getDataOneHACYUMSAI($HACYU_ID, $HACYUMSAI_ID, $HACYUMSAI['SPLIT_NO']);

                        if (isset($HACYUMSAI['SURYO']) && $HACYUMSAI['SURYO'] == ''){
                            $HACYUMSAI['SURYO'] = 0;
                        }
                        if (isset($HACYUMSAI['KAITO_NOKI']) && $HACYUMSAI['KAITO_NOKI'] != ''){
                            $HACYUMSAI['KAITO_NOKI'] = str_replace('/', '-', $HACYUMSAI['KAITO_NOKI']);
                            $arrDateNoHin[] = $HACYUMSAI['KAITO_NOKI'];
                        }

                        if (isset($HACYUMSAI['NOHIN_YMD']) && $HACYUMSAI['NOHIN_YMD'] != ''){
                            $HACYUMSAI['NOHIN_YMD'] = str_replace('/', '-', $HACYUMSAI['NOHIN_YMD']);
                            $arrDateNoHin[] = $HACYUMSAI['NOHIN_YMD'];
                        }
                        
                        $dataUpdateDetail = array();

                        if (!empty($oddDetail)){

                            $HACYUMSAI['SURYO'] = isset($HACYUMSAI['SURYO']) ? $HACYUMSAI['SURYO'] : $oddDetail->SURYO; 

                            if ($HACYUMSAI['SURYO'] != $oddDetail->SURYO){
                                $dataUpdateDetail['UPD_TANTCD'] = $user->TANT_CD;
                                $dataUpdateDetail['UPD_YMD'] = $date; 
                            }

                            $dataUpdateDetail['SURYO'] = $HACYUMSAI['SURYO'];
                            $dataUpdateDetail['KINGAK'] = $HACYUMSAI['SURYO'] * $oddDetail->ZEINUKI_TANKA;
                            $dataUpdateDetail['NEBIKI_GAK'] = $HACYUMSAI['SURYO'] * $oddDetail->NEBIKI_TANKA;
                            if(empty($HACYUMSAI['KAITO_NOKI'])){
                                $dataUpdateDetail['KAITO_NOKI'] = null;
                            }elseif(!empty($HACYUMSAI['KAITO_NOKI']) && $oddDetail->KAITO_NOKI != $HACYUMSAI['KAITO_NOKI']){
                                $dataUpdateDetail['KAITO_NOKI'] = $HACYUMSAI['KAITO_NOKI'];
                            }
                            if($IRAI_CD == '01' || $IRAI_CD == '11'){
                                if(empty($HACYUMSAI['KAITO_NOKI_CD'])){
                                    $dataUpdateDetail['KAITO_NOKI_CD'] = null;
                                }elseif(!empty($HACYUMSAI['KAITO_NOKI_CD']) && $oddDetail->KAITO_NOKI_CD != $HACYUMSAI['KAITO_NOKI_CD']){
                                    $dataUpdateDetail['KAITO_NOKI_CD'] = $HACYUMSAI['KAITO_NOKI_CD'];
                                }
                            }

                            $nokimiteiAnsCdOld = '';
                            $nokimiteiAnsCdNew = '';
                            $cancelKahiAnsCdOld = '';
                            $cancelKahiAnsCdNew = '';

                            if($IRAI_CD == '03'){
                                if(empty($HACYUMSAI['NOKIMITEI_ANS_CD'])){
                                    $dataUpdateDetail['NOKIMITEI_ANS_CD'] = null;
                                }elseif(!empty($HACYUMSAI['NOKIMITEI_ANS_CD']) && $oddDetail->NOKIMITEI_ANS_CD != $HACYUMSAI['NOKIMITEI_ANS_CD']){
                                    $dataUpdateDetail['NOKIMITEI_ANS_CD'] = $HACYUMSAI['NOKIMITEI_ANS_CD'];
                                }

                                if(!empty($oddDetail->NOKIMITEI_ANS_CD)){
                                    $nokimiteiAnsCdOld = $unDecidedList[$oddDetail->NOKIMITEI_ANS_CD];
                                }
                                if(!empty($HACYUMSAI['NOKIMITEI_ANS_CD'])){
                                    $nokimiteiAnsCdNew = $unDecidedList[$HACYUMSAI['NOKIMITEI_ANS_CD']];
                                }

                                if($CANCEL_IRAI_FLG == 1){
                                    if(empty($HACYUMSAI['CANCEL_KAHI_ANS_CD'])){
                                        $dataUpdateDetail['CANCEL_KAHI_ANS_CD'] = null;
                                    }elseif(!empty($HACYUMSAI['CANCEL_KAHI_ANS_CD']) && $oddDetail->CANCEL_KAHI_ANS_CD != $HACYUMSAI['CANCEL_KAHI_ANS_CD']){
                                        $dataUpdateDetail['CANCEL_KAHI_ANS_CD'] = $HACYUMSAI['CANCEL_KAHI_ANS_CD'];
                                    }

                                    if(!empty($oddDetail->CANCEL_KAHI_ANS_CD)){
                                        $cancelKahiAnsCdOld = $cancelList[$oddDetail->CANCEL_KAHI_ANS_CD];
                                    }
                                    if(!empty($HACYUMSAI['CANCEL_KAHI_ANS_CD'])){
                                        $cancelKahiAnsCdNew = $cancelList[$HACYUMSAI['CANCEL_KAHI_ANS_CD']];
                                    }
                                }
                            }

                            if(empty($HACYUMSAI['NOHIN_YMD'])){
                                $dataUpdateDetail['NOHIN_YMD'] = null;
                            }elseif(!empty($HACYUMSAI['NOHIN_YMD']) && $oddDetail->NOHIN_YMD != $HACYUMSAI['NOHIN_YMD']){
                                $dataUpdateDetail['NOHIN_YMD'] = $HACYUMSAI['NOHIN_YMD'];
                            }

                            $dateNoHinChange = '';
                            $dateNoHinOld = '';
                            if(empty($HACYUMSAI['KAITO_NOKI'])){
                                $dateNoHinChange = '';
                                $dateNoHinOld = str_replace('-', '/', $oddDetail->KAITO_NOKI);
                            }elseif(!empty($HACYUMSAI['KAITO_NOKI']) && $oddDetail->KAITO_NOKI != $HACYUMSAI['KAITO_NOKI']){
                                $dateNoHinChange = str_replace('-', '/', $HACYUMSAI['KAITO_NOKI']);
                                $dateNoHinOld = str_replace('-', '/', $oddDetail->KAITO_NOKI);
                            }

                            if(empty($HACYUMSAI['NOHIN_YMD']) && $dateNoHinChange == ''){
                                $dateNoHinChange = '';
                                $dateNoHinOld = str_replace('-', '/', $oddDetail->NOHIN_YMD);
                            }elseif(!empty($HACYUMSAI['NOHIN_YMD']) && $oddDetail->NOHIN_YMD != $HACYUMSAI['NOHIN_YMD']){
                                $dateNoHinChange = str_replace('-', '/', $HACYUMSAI['NOHIN_YMD']);
                                $dateNoHinOld = str_replace('-', '/', $oddDetail->NOHIN_YMD);
                            }

                            if (!empty($dateNoHinChange) || (empty($HACYUMSAI['KAITO_NOKI']) && !empty($oddDetail->KAITO_NOKI)) || (empty($HACYUMSAI['NOHIN_YMD'])&& !empty($oddDetail->NOHIN_YMD)) || ($nokimiteiAnsCdNew != $nokimiteiAnsCdOld) || ($nokimiteiAnsCdNew != $nokimiteiAnsCdOld) || ($cancelKahiAnsCdOld != $cancelKahiAnsCdNew)){
                                if (!empty($comment2)){
                                    $comment2 .= PHP_EOL;
                                }
                                $changeDate = false;
                                if(!empty($dateNoHinOld)){
                                    $pre_text = $oddDetail->HINBAN.'('.$HACYUMSAI['SURYO'].'):';
                                    $comment2 .= '【'.date('Y/m/d H:i').'　'.$pre_text.$dateNoHinOld.' → '.$pre_text.$dateNoHinChange.'】';
                                    $changeDate = true;
                                }

                                $changeNokimite = false;
                                if($nokimiteiAnsCdNew != $nokimiteiAnsCdOld){
                                    if ($changeDate){
                                        $comment2 .= PHP_EOL;
                                    }
                                    $pre_text = $oddDetail->HINBAN.'('.$HACYUMSAI['SURYO'].'):';
                                    $comment2 .= '【'.date('Y/m/d H:i').'　'.$pre_text.$nokimiteiAnsCdOld.' → '.$pre_text.$nokimiteiAnsCdNew.'】';
                                    $changeNokimite = true;
                                }
  
                                $changeCancelKahi = false;
                                if($cancelKahiAnsCdOld != $cancelKahiAnsCdNew){
                                    if ($changeDate || $changeNokimite){
                                        $comment2 .= PHP_EOL;
                                    }
                                    $pre_text = $oddDetail->HINBAN.'('.$HACYUMSAI['SURYO'].'):';
                                    $comment2 .= '【'.date('Y/m/d H:i').'　'.$pre_text.$cancelKahiAnsCdOld.' → '.$pre_text.$cancelKahiAnsCdNew.'】';
                                    $changeCancelKahi = true;
                                }
                                $dataUpdateDetail['UPD_TANTCD'] = $user->TANT_CD;
                                $dataUpdateDetail['UPD_YMD'] = $date;  
                                $isUpdate = true;
                            }

                            if (!empty($dataUpdateDetail)){
                                DB::table('T_HACYUMSAI')
                                ->where('HACYU_ID',(string)$HACYU_ID)
                                ->where('HACYUMSAI_ID',$HACYUMSAI_ID)
                                ->where('SPLIT_NO',$HACYUMSAI['SPLIT_NO'])
                                ->update($dataUpdateDetail);
                            }
                        }else{
                            $oddDetailFisrt = $this->getDataOneHACYUMSAI($HACYU_ID, $HACYUMSAI_ID, 0);
                            $dataUpdateDetailNew = array();
                            $dataUpdateDetailNew['HACYU_ID'] = $HACYU_ID;
                            $dataUpdateDetailNew['HACYUMSAI_ID'] = $HACYUMSAI_ID;
                            $dataUpdateDetailNew['SPLIT_NO'] = $HACYUMSAI['SPLIT_NO'];
                            $dataUpdateDetailNew['CTGORY'] = $oddDetailFisrt->CTGORY;
                            $dataUpdateDetailNew['MAKER'] = $oddDetailFisrt->MAKER;
                            $dataUpdateDetailNew['HINBAN'] = $oddDetailFisrt->HINBAN;
                            $dataUpdateDetailNew['TANKA'] = $oddDetailFisrt->TANKA;
                            $dataUpdateDetailNew['ZEINUKI_TANKA'] = $oddDetailFisrt->ZEINUKI_TANKA;
                            $dataUpdateDetailNew['SIKIRI_RATE'] = $oddDetailFisrt->SIKIRI_RATE;
                            $dataUpdateDetailNew['NEBIKI_TANKA'] = $oddDetailFisrt->NEBIKI_TANKA;
                            $dataUpdateDetailNew['NEBIKI_YM'] = $oddDetailFisrt->NEBIKI_YM;
                            $dataUpdateDetailNew['NOHIN_KIBO_YMD'] = $oddDetailFisrt->NOHIN_KIBO_YMD;
                            $dataUpdateDetailNew['BIKO'] = $oddDetailFisrt->BIKO;
                            $dataUpdateDetailNew['MOTO_NYUKA_ID'] = $oddDetailFisrt->NYUKA_ID;
                            $dataUpdateDetailNew['DEL_FLG'] = 0;
                            $dataUpdateDetailNew['ADD_TANTCD'] = $user->TANT_CD;
                            $dataUpdateDetailNew['ADD_YMD'] = $date; 
                            $dataUpdateDetailNew['UPD_TANTCD'] = $user->TANT_CD;
                            $dataUpdateDetailNew['UPD_YMD'] = $date; 

                            if(empty($HACYUMSAI['KAITO_NOKI'])){
                                $dataUpdateDetailNew['KAITO_NOKI'] = null;
                            }else{
                                $dataUpdateDetailNew['KAITO_NOKI'] = $HACYUMSAI['KAITO_NOKI'];
                            }

                            if(empty($HACYUMSAI['NOHIN_YMD'])){
                                $dataUpdateDetailNew['NOHIN_YMD'] = null;
                            }else{
                                $dataUpdateDetailNew['NOHIN_YMD'] = $HACYUMSAI['NOHIN_YMD'];
                            }

                            $new_suryo = $HACYUMSAI['SURYO'];
                            $dataUpdateDetailNew['SURYO'] = $new_suryo;
                            $dataUpdateDetailNew['KINGAK'] = $new_suryo * $oddDetailFisrt->ZEINUKI_TANKA;
                            $dataUpdateDetailNew['NEBIKI_GAK'] = $new_suryo * $oddDetailFisrt->NEBIKI_TANKA;
                            DB::table('T_HACYUMSAI')->insert($dataUpdateDetailNew);
                        }
                    }

                    $arrItemChange = array('HAISOGYOSYA1', 'DENPYONO1','HAISOGYOSYA2', 'DENPYONO2', 'RENRAKUSAKI2', 'HAISOGYOSYA3_1', 'DENPYONO3_1', 'HAISOGYOSYA3_2', 'DENPYONO3_2' , 'DRIVER_NAME', 'RENRAKUSAKI4', 'NO_DENPYO_FLG', 'BIKO', 'KINGAK_KAKNIN_ANS_CD');
                    $dataChange = array();
                    $canChange = true;
                    if ($oldData->HAISO_SYBET_CD == '04' && $oldData->IRAI_CD == '03' ){
                        foreach ($arrItemChange as $itemChange) {
                            if ($oldData->HAISOGYOSYA_MULTI_FLG == 0){
                                if (in_array($itemChange, array('HAISOGYOSYA3_1', 'DENPYONO3_1', 'HAISOGYOSYA3_2', 'DENPYONO3_2'))){
                                    $canChange = false;
                                }
                                else{
                                    $canChange = true;
                                }
                            }
                            if ($canChange){
                                if (isset($HACYU[$itemChange]) && $HACYU[$itemChange]  != $oldData->$itemChange ){
                                    if (!empty($oldData->$itemChange) && $itemChange !== 'NO_DENPYO_FLG'){
                                        $dataChange[] = $oldData->$itemChange.' → '.$HACYU[$itemChange];
                                    }elseif ($itemChange === 'NO_DENPYO_FLG'){
                                        $dataChange[] =  $arrDENPYO[ ($oldData->$itemChange == '') ? 0: $oldData->$itemChange].' → '. $arrDENPYO[$HACYU[$itemChange]]; 
                                    }
                                    if ($itemChange !== 'BIKO'){
                                       $driverChange = true;
                                    }
                                    $isUpdate = true;
                                }
                            }
                        }
                    }

                    $arrItemChange3 = array('SAITAN_NOKI', 'HAISO_HUKA_YOBI', 'KARIOSAE_LIMIT_YMD');
                    if ($oldData->IRAI_CD == '02' ){
                        foreach ($arrItemChange3 as $itemChange) {
                            if(isset($HACYU[$itemChange]) && $itemChange != 'HAISO_HUKA_YOBI'){
                                if(!empty($oldData->$itemChange)){
                                    $oldData->$itemChange = date('Y/m/d', strtotime($oldData->$itemChange));
                                }
                            }
                            if (isset($HACYU[$itemChange]) && $HACYU[$itemChange] != $oldData->$itemChange ){
                                $dataChange[] = $oldData->$itemChange.' → '.$HACYU[$itemChange];
                                $isUpdate = true;
                            }
                        }
                    }

                    if(!empty($dataChange)){
                        if (!empty($comment2)){
                            $comment2 .= PHP_EOL;
                        }
                        $comment2 .= '【'.date('Y/m/d H:i').'　'.implode(', ', $dataChange).'】'; 
                        $isUpdate = true; 
                    } 

                    if (!empty($comment2)){
                        $comment2 .= PHP_EOL;
                    }
                    $comment2 .= $comment2Private;

                    $HACYU['COMMENT2'] = $comment2;
                    $dataUpdate = $HACYU;
                    $dataUpdate['HAC_ANS_YMD'] = $date;
                }else{
                    $dataUpdate = array();
                    $TAIO_CD = '';
                    if (isset($HACYU['TAIO_CD1']) && $HACYU['TAIO_CD1'] == 'on'){
                        $TAIO_CD = '01';
                    }
                    if (isset($HACYU['TAIO_CD2']) && $HACYU['TAIO_CD2'] == 'on'){
                        $TAIO_CD = '02';
                    }
                    if ($TAIO_CD != $oldData->TAIO_CD){
                        $dataUpdate['TAIO_CD'] = $TAIO_CD;
                        $dataUpdate['TAIO_TANT_CD'] = $TAIO_CD == '' ? '' : $user->TANT_CD;
                        $isUpdate = true;
                    }
                    if (empty($HACYU['COMMENT1'])){
                        $dataUpdate['COMMENT1']  = '';
                    }elseif (trim($HACYU['COMMENT1']) != trim($oldData->COMMENT1)){
                        $dataUpdate['COMMENT1'] = '【'.date('Y/m/d H:i').' '.$user->TANT_NAME.'】' . $HACYU['COMMENT1']; 
                        $dataUpdate['LIF_AND_YMD'] = $date;
                    }
                }
                $countNoHin = 0;
                if (!empty($dataUpdate)){
                    if($user->HACYUSAKI_CD != ''){
                        if (!empty($arrDateNoHin)){
                            $countNoHin = count($arrDateNoHin);
                        }

                        if (in_array($oldData->STS_CD, array('01', '02', '03', '04'))){
                            if ($countNoHin == count($details)){
                                if ($oldData->IRAI_CD == '01' || $oldData->IRAI_CD == '11' || $oldData->IRAI_CD == '02'){
                                    $dataUpdate['STS_CD'] = '05';
                                }elseif ($oldData->IRAI_CD == '03'){
                                    if ($oldData->HAISO_SYBET_CD == '04'){
                                        $dataUpdate['STS_CD'] = '06';
                                    }else{
                                        $dataUpdate['STS_CD'] = '10';
                                    }
                                }
                            }elseif ($countNoHin == 0){
                                $dataUpdate['STS_CD'] = '02';
                            }else{
                                $dataUpdate['STS_CD'] = '03';
                            }
                        
                        }elseif($oldData->STS_CD == '06' && $driverChange){
                            $dataUpdate['STS_CD'] = '07';
                        }
                    }
                    if($IRAI_CD == '03'){
                        if($oldData->STS_CD == '06' && $oldData->KINGAK_KAKNIN_VSBL_FLG == '1'){
                            $dataUpdate['STS_CD'] = '07';
                        }elseif(($oldData->STS_CD == '06' && $oldData->KINGAK_KAKNIN_VSBL_FLG == '0') || ($oldData->STS_CD == '07' && $oldData->HAISO_SYBET_CD == '04' && $oldData->KINGAK_KAKNIN_VSBL_FLG == '1' && $HACYU['KINGAK_KAKNIN_ANS_CD'] != '')){
                            $dataUpdate['STS_CD'] = '10';
                        }
                    }

                    if ($isUpdate){
                        $dataUpdate['UPD_TANTCD'] = $user->TANT_CD;
                        $dataUpdate['UPD_YMD'] = $date;
                    }
                    
                    DB::table('T_HACYU')->where('HACYU_ID',(string)$HACYU_ID)->update($dataUpdate);
                }

                if (((!empty($dataUpdate['STS_CD']) && $dataUpdate['STS_CD'] == '01') || empty($dataUpdate['STS_CD'])) && $oldData->STS_CD == '01'){
                    $hasSTS01 = true;
                }

                if (isset($value['FILE'])){
                    $a = count($this->getDataFILE($HACYU_ID)) + 1;
                    foreach($files as $key => $item){
                        //Start of Upload Files
                        $fileName = time().'_' . $item->getClientOriginalName();
                        $path = public_path().'/uploads/'.$HACYU_ID;
                        $item->move($path, $fileName);
                        DB::table('T_FILE')->insert([
                            'HACYU_ID' => (string)$HACYU_ID,
                            'JYUNJO' => $a,
                            'FILE_NAME' => $fileName,
                            'FILE_PATH' => URL::to('/').'/uploads/'.$HACYU_ID.'/'.$fileName,
                            'TANT_CD' => $user->TANT_CD,
                            'UPD_TANTCD' => $user->TANT_CD,
                            'UPD_YMD' => $date
                        ]);
                        $a++;
                    }  
                }
            }
        }

        if (isset($request->submit) && $request->submit == 'submit_back_list' && !$hasSTS01){
            return redirect()->route('list');
        }else{
            if($hasSTS01 && $request->submit == 'submit_back_list'){
              $request->session()->put('hasSTS01',1);  
            }            
            if (count($data) > 1){
                return redirect()->route('get_search_print');
            }else{
                return redirect()->route('search_print', array('id' => $HACYU_ID));
            } 
        }
    }

    private function checkHolidays($kaito_noki, $holidays){
        if(in_array($kaito_noki, $holidays)){
            $kaito_noki = date('Y-m-d', strtotime("+1 day", strtotime($kaito_noki)));
            $kaito_noki = $this->checkHolidays($kaito_noki, $holidays);
        }
        return $kaito_noki;
    }
}