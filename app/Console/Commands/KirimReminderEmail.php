<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class KirimReminderEmail extends Command
{
    protected $signature = 'reminder:kirim';
    protected $description = 'Kirim email dan WhatsApp pengingat berdasarkan end_date dan hari_sebelum dari item.id_master_reminder';

    public function handle()
    {
        $today = now()->toDateString();

        // Ambil semua item yang memiliki master_reminder
        $items = DB::table('document_item')->where('status_approve','approved')->whereNotNull('id_master_reminder')->get();

        foreach ($items as $item) {
            // Ambil master_reminder yang terkait dengan item
            $master = DB::table('document_master_reminders')->where('id', $item->id_master_reminder)->first();
            if (!$master) {
                $this->warn("Item ID {$item->id} tidak punya master_reminder yang valid.");
                continue;
            }

            // Ambil semua hari_sebelum dari reminders (berurutan dari besar ke kecil)
            $hariReminders = DB::table('document_reminders')
                ->where('id_master', $master->id)
                ->orderByDesc('hari_sebelum')
                ->pluck('hari_sebelum');

            // Cek setiap hari_sebelum
            foreach ($hariReminders as $hari) {
                $targetDate = now()->copy()->addDays($hari)->toDateString();

                // Jika end_date item cocok dengan targetDate, kirim email dan WhatsApp
                if (date('Y-m-d', strtotime($item->end_date)) === $targetDate) {
                    // Ambil email tujuan dari item_emails
                    $emails = DB::table('document_item_emails')->where('id_item', $item->id)->pluck('email');

                    foreach ($emails as $email) {
                        // Kirim Email
                        Mail::send('emails.reminder', [
                            'nama' => $item->nama,
                            'end_date' => $item->end_date
                        ], function ($message) use ($email, $item) {
                            $message->to($email)
                                    ->subject('Reminder Expired')
                                    ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                        });

                        $this->info("Email dikirim ke: {$email} untuk item {$item->nama}");
						$msx = "item dengan nama ".$item->nama." akan berakhir pada ".$item->end_date;
						DB::table('log_send_notification')->insert([
							'app' => 'document',
							'send_to' => $email,
							'message' => $msx,
							'status' => 'success',
							'created_at' => now()
						]);

                        // Cari nomor telepon dari tabel users berdasarkan email
                        $user = DB::table('users')->where('email', $email)->first();
                        if ($user && $user->telp_no) {
                            // Pastikan format nomor hanya angka
                            $nomor = preg_replace('/[^0-9]/', '', $user->telp_no);

                            // Ganti 0 awal jadi 62 jika perlu
                            if (strpos($nomor, '0') === 0) {
                                $nomor = '62' . substr($nomor, 1);
                            }

                            // Kirim WhatsApp via kirimi.id API
                            try {
								$message = "*Reminder* 🔔\n\n" .
										   "Nama item: *{$item->nama}*\n" .
										   "Akan berakhir pada: *{$item->end_date}* ⏰\n\n" .
										   "_Harap segera ditindaklanjuti._";


                                $response = Http::withHeaders([
                                    'Content-Type' => 'application/json',
                                ])->post('https://api.kirimi.id/v1/send-message', [
                                    'user_code' => 'KMX023725',
                                    'device_id' => 'D-32FAR',
                                    'receiver' => $nomor,
                                    'message' => $message,
                                    'secret' => 'bf0383e37648d8f9d36694b8f66be1af95108ec38d10246b20d1c48f90d6f044',
                                ]);

                                if ($response->successful()) {
                                    $this->info("WhatsApp dikirim ke: {$nomor}");
									DB::table('log_send_notification')->insert([
										'app' => 'document',
										'send_to' => $nomor,
										'message' => $msx,
										'status' => 'success',
										'created_at' => now()
									]);
                                } else {
                                    $this->error("Gagal kirim WhatsApp ke: {$nomor}. Response: " . $response->body());
									DB::table('log_send_notification')->insert([
										'app' => 'document',
										'send_to' => $nomor,
										'message' => $msx,
										'status' => 'failed',
										'created_at' => now()
									]);
                                }
                            } catch (\Exception $e) {
                                $this->error("Exception saat kirim WA ke {$nomor}: " . $e->getMessage());
									DB::table('log_send_notification')->insert([
										'app' => 'document',
										'send_to' => $nomor,
										'message' => $msx,
										'status' => 'exception',
										'created_at' => now()
									]);
                            }
                        } else {
                            $this->warn("Nomor telepon tidak ditemukan untuk email: {$email}");
                        }
                    }
                }
            }
        }

        $this->info('Selesai kirim reminder.');
    }
}
