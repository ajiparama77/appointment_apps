<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class ReminderHelpdesk extends Command{
    protected $signature = 'helpdesk:sent';

    public function handle(){
        date_default_timezone_set('Asia/Bangkok');
        $ticketsProcessed = DB::table('helpdesk_tickets')
            ->join('helpdesk_priorities', 'helpdesk_priorities.id', '=', 'helpdesk_tickets.priority_id')
            ->join('users', 'users.id', '=', 'helpdesk_tickets.assigned_user_id')
            ->select(
                'helpdesk_tickets.id',
                'helpdesk_tickets.title',
                'helpdesk_priorities.sla_duration',
                'helpdesk_tickets.created_at',
                'users.id AS user_id',
                'users.name AS agent_name',
                'users.email',
                'telp_no'
            )
            ->where('helpdesk_tickets.status', 'open')
            ->orWhere('helpdesk_tickets.status', 'in_progress')
            ->orderBy('helpdesk_priorities.sla_duration', 'DESC')
            ->get();

        foreach ($ticketsProcessed as $index) {
            $urls = route('helpdesk.ticketing.thread', ['id' => $index->id]);
            $sla_ticket = duration_left_tickets($index->id);
            //Jika tiket belum terlambat
            if (!$sla_ticket['is_overdued']) {
                $dueDateTicket = $sla_ticket['due_date'];
                $diffDays = Carbon::parse($dueDateTicket)->diffInDays(date('Y-m-d'));
                $content = "Ticket tersisa " . $diffDays . " hari lagi, harap segera diproses & diselesaikan, terimakasih";

                Mail::send('emails.helpdesk', [
                    'receiver'  => $index->agent_name,
                    'subject'   => $index->title,
                    'date'      => $index->created_at,
                    'content'   => $content,
                    'urls'      => $urls
                ], function ($message) use ($index) {
                    $message->to($index->email)
                        ->subject($index->title)
                        ->from(env('MAIL_FROM_ADDRESS'), 'Reminder Helpdesk');;
                });
            }
            //Jika ticket sudah terlambat
            else {
                //Kirim notif sudah terlambat
                Mail::send('emails.helpdesk', [
                    'receiver'  => $index->agent_name,
                    'subject'   => $index->title,
                    'date'      => $index->created_at,
                    'content'   => 'Ticket sudah melewati jatuh tempo, harap segera diproses & diselesaikan, terimakasih',
                    'urls'      => $urls
                ], function ($message) use ($index) {
                    $message->to($index->email)
                        ->subject($index->title)
                        ->from(env('MAIL_FROM_ADDRESS'), 'Reminder Helpdesk');;
                });
            }
        }

        $this->info('Selesai kirim reminder.');
    }
}