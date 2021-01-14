<?php
namespace App\Exports;

use App\Member;
use App\Models\Member as ModelsMember;
use Maatwebsite\Excel\Concerns\FromArray;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class MemberListExport implements FromArray, WithEvents
{
    use RegistersEventListeners;

    public function array(): array
    {   
        $jurisdictionid = Auth::user()->jurisdiction_id;
        $status1 = "Abandoned";
        $status2 = "Inactive";
        if($jurisdictionid == 0)
        {
            $member_data = DB::table('members')
            ->join('positions','positions.id','=','members.position_id')
         ->select(
            DB::raw('CONCAT("9","-",jurisdiction_id,"-",LPAD(chapter_id,3,0),"-",LPAD(members.id,5,0)) as id'),
             DB::raw('CONCAT(last_name, " ", first_name) as name'),
             DB::raw('preferred_name as goes_by'),
             DB::raw('home_phone as home_phone'),
             DB::raw('mobile_phone as mobile_phone'),
             DB::raw('email as email'),
             DB::raw('positions.position_name as position')
         )
         ->where(function ($cquery) use ($status1){
            $cquery->where('status', '<>', $status1);})
        ->where(function ($cquery) use ($status2){
            $cquery->where('status', '<>', $status2);})
         ->orderBy('position')
         ->get()->toArray();
        }
        elseif(Auth::user()->chapter_id == null)
        {
            $member_data = DB::table('members')
            ->join('positions','positions.id','=','members.position_id')
         ->select(
            DB::raw('CONCAT("9","-",jurisdiction_id,"-",LPAD(chapter_id,3,0),"-",LPAD(members.id,5,0)) as id'),
             DB::raw('CONCAT(last_name, " ", first_name) as name'),
             DB::raw('preferred_name as goes_by'),
             DB::raw('home_phone as home_phone'),
             DB::raw('mobile_phone as mobile_phone'),
             DB::raw('email as email'),
             DB::raw('positions.position_name as position')
         )
         ->where(function ($jquery) use ($jurisdictionid){
            $jquery->where('jurisdiction_id', '=', $jurisdictionid);})
            ->where(function ($cquery) use ($status1){
                $cquery->where('status', '<>', $status1);})
            ->where(function ($cquery) use ($status2){
                $cquery->where('status', '<>', $status2);})
            ->orderBy('position')
         ->get()->toArray();
        }
        else
        {
            $chapterid = Auth::user()->chapter_id;
            $member_data = DB::table('members')
            ->join('positions','positions.id','=','members.position_id')
         ->select(
            DB::raw('CONCAT("9","-",jurisdiction_id,"-",LPAD(chapter_id,3,0),"-",LPAD(members.id,5,0)) as id'),
             DB::raw('CONCAT(last_name, " ", first_name) as name'),
             DB::raw('preferred_name as goes_by'),
             DB::raw('home_phone as home_phone'),
             DB::raw('mobile_phone as mobile_phone'),
             DB::raw('email as email'),
             DB::raw('positions.position_name as position')
         )
         ->where(function ($jquery) use ($jurisdictionid){
            $jquery->where('jurisdiction_id', '=', $jurisdictionid);})
         ->where(function ($cquery) use ($chapterid){
            $cquery->where('chapter_id', '=', $chapterid);})
            ->where(function ($cquery) use ($status1){
                $cquery->where('status', '<>', $status1);})
            ->where(function ($cquery) use ($status2){
                $cquery->where('status', '<>', $status2);})
            ->orderBy('position')
         ->get()->toArray();
        }

        $member_array[] = array('ID', 'Name', 'Goes By','Home Phone','Cell Phone','Email','Position');
        foreach($member_data as $member)
        {
        $member_array[] = array(
            'ID'  => $member->id,
            'Name'  => $member->name,
            'Goes By'  => $member->goes_by,
            'Home Phone'  => $member->home_phone,
            'Cell Phone'  => $member->mobile_phone,
            'Email'  => $member->email,
            'Position' => $member->position
        );
        }
        return($member_array);
    }

    public function registerEvents(): array{
        return[
            AfterSheet::class => function(AfterSheet $event){

                    $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(15);
                    $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(25);
                    $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(20);
                    $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(30);
                    $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(30);
                    $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(40);
                    $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(25);
            }
        ];
    }
}