<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReminderTicketLoan extends Command{
    protected $signature = 'reminder:loan';

    public function handle(){
        date_default_timezone_set('Asia/Bangkok');

        $ticketLoans = DB::table('helpdesk_tickets')
            ->where('helpdesk_tickets.status','closed')
            ->where('is_loan',1)
            ->join('users AS usr', 'usr.id', '=', 'helpdesk_tickets.assigned_user_id')
            ->join('users AS general_user','general_user.id','=','helpdesk_tickets.user_id')
            ->join('document_master_reminders AS dmc','dmc.id','helpdesk_tickets.template_reminder')
            ->select('helpdesk_tickets.id',
                'helpdesk_tickets.title',
                'dmc.id AS reminder_id',
                'dmc.nama AS template_name',
                'helpdesk_tickets.created_at',
                'helpdesk_tickets.duration_loan',
                'helpdesk_tickets.status_loan',
                'usr.name AS agent_name',
                'general_user.name AS user_name',
                'usr.email AS agent_email',
                'general_user.email AS user_email')
            ->get();

        if ($ticketLoans->isNotEmpty()) {
            foreach ($ticketLoans as $ticket) {
                $urls = route('helpdesk.ticketing.thread', ['id' => $ticket->id]);
                $reminders = DB::table('document_reminders')
                    ->select('hari_sebelum')
                    ->where('id_master', $ticket->reminder_id)
                    ->orderBy('hari_sebelum', 'DESC')
                    ->get();

                //Cek apakah peminjaman sudah melewati bataas waktu
                $dueDateParse    = Carbon::parse($ticket->created_at)
                    ->addDays($ticket->duration_loan)
                    ->toDateString();

                if ($ticket->status_loan == 1) {
                    //Jika pengembalian sudah terlambat
                    if (now()->toDateString()  > $dueDateParse) {
                        $diffDays = Carbon::parse($dueDateParse)->diffInDays(date('Y-m-d'));
                        $content = "Peminjaman untuk ticket " . $ticket->id . " tersisa " . $diffDays . " hari lagi";
                    } else {

                        foreach ($reminders as $index2) { 
                            //Jika harian
                            if ($ticket->template_name == 'Harian') {
                                $addDays = Carbon::parse($ticket->created_at)
                                    ->addDays($index2->hari_sebelum)
                                    ->toDateString();
                                if ($addDays == $dueDateParse || $dueDateParse >= $addDays ) {
                                    $diffDays = Carbon::parse($dueDateParse)->diffInDays(date('Y-m-d'));
                                    break;
                                }
                            }
                            //Jika Standar & Bulanan
                            else if($ticket->template_name == 'Standar' || $ticket->template_name == 'Template Bulanan'){
                                $addDays = Carbon::parse($ticket->created_at)
                                    ->addDays($index2->hari_sebelum)
                                    ->toDateString();

                                if($addDays == $dueDateParse ){
                                    $diffDays = Carbon::parse($dueDateParse)->diffInDays(date('Y-m-d'));
                                    break;
                                }
                            }                           
                        }

                        $content = "Peminjaman untuk ticket " . $ticket->id . " tersisa " . $diffDays . " hari lagi";
                        Mail::send('emails.helpdesk', [
                            'receiver'  => $ticket->agent_name,
                            'subject'   => $ticket->title,
                            'date'      => $ticket->created_at,
                            'content'   => $content,
                            'urls'      => $urls
                        ], function ($message) use ($ticket) {
                            $message->to([$ticket->user_email, $ticket->agent_email])
                                ->subject($ticket->title)
                                ->from(env('MAIL_FROM_ADDRESS'), 'Reminder Helpdesk');;
                        });
                    }
                }
            }
        }
        

        $this->info('Selesai kirim reminder.');
    }

}