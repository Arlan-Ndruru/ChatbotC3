<?php

namespace App\Conversations;

use App\Conversations\FormatMessages;
use App\Conversations\FormatMessage;
use App\Conversations\resetEmailDosen;
use App\Conversations\resetEmailMahasiswa;
use App\Conversations\resetElearning;
use App\Conversations\ResetIraise;
use App\Conversations\helpDeskIraise;
use App\Conversations\helpDeskC3;
use App\Conversations\resetPresensia;
use App\Conversations\LateKRS;
use App\Conversations\SalahMatkul;
use App\Conversations\nimUKT;
use App\Conversations\helpDeskPMB;
use App\Conversations\helpDeskUKT;
use App\Conversations\MenuNavigasi;
use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class MenuNavigasi extends Conversation
{
    /**
     * First question
     */

    /**
     * Start the conversation
     */
    public function run()
    {
        $message = "Assalamu'alaikum, Selamat datang. Hai, Aku Robot PTIPD untuk memberikan layanan informasi untuk UIN SUSKA RIAU";
        // $this->say($message);
        $question = Question::create($message.'
        Apa yang ingin anda ajukan?')
        ->addButtons([
            Button::create('Format Pesan')->value('0'),
            Button::create('Reset Gmail Pegawai/Dosen')->value('1'),
            Button::create('Reset Mahasiswa Email')->value('2'),
            Button::create('Reset Elearning')->value('3'),
            Button::create('Reset Iraise')->value('4'),
            Button::create('Helpdesk Permasalahan Iraise')->value('5'),
            Button::create('Helpdesk Customer Care Center')->value('6'),
            Button::create('Reset Presensia')->value('7'),
            Button::create('Terkait KRS')->value('8'),
            Button::create('Terkait Mata Kuliah')->value('9'),
            Button::create('Terkait NIM_UKT')->value('10'),
            Button::create('Helpdesk Penerimaan MABA')->value('11'),
            Button::create('Helpdesk Keringanan UKT')->value('12'),
            Button::create('Lainnya')->value('13'),
        ]);
        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === '0')
            {
                $this->say('<b>Anda memilih Menu : Format Pesan </b>',['parse_mode' => 'HTML']);
                $this->bot->startConversation(new FormatMessages());
            }
            elseif ($answer->getValue() === '1') {
                $this->say('<b>Anda memilih Menu : Reset Akun Gmail Pegawai/Dosen </b>',['parse_mode' => 'HTML']);
                $this->bot->startConversation(new resetEmailDosen());
            }
            elseif ($answer->getValue() === '2') {
                $this->say('<b>Anda memilih Menu : Reset Akun Mahasiswa Email </b>',['parse_mode' => 'HTML']);
                $this->bot->startConversation(new resetEmailMahasiswa());
            }
            elseif ($answer->getValue() === '3') {
                $this->say('<b>Anda memilih Menu : Reset Akun Elearning </b>',['parse_mode' => 'HTML']);
                $this->bot->startConversation(new resetElearning());
            }
            elseif ($answer->getValue() === '4') {
                $this->say('<b>Anda memilih Menu : Reset Akun Iraise </b>',['parse_mode' => 'HTML']);
                $this->bot->startConversation(new ResetIraise());
            }
            elseif ($answer->getValue() === '5') {
                $this->say('<b>Anda memilih Menu : Helpdesk Permasalahan Iraise </b>',['parse_mode' => 'HTML']);
                $this->bot->startConversation(new helpDeskIraise());
            }
            elseif ($answer->getValue() === '6') {
                $this->say('<b>Anda memilih Menu : Helpdesk Customer Care Center </b>',['parse_mode' => 'HTML']);
                $this->bot->startConversation(new helpDeskC3());
            }
            elseif ($answer->getValue() === '7') {
                $this->say('<b>Anda memilih Menu : Reset Presensia </b>',['parse_mode' => 'HTML']);
                $this->bot->startConversation(new resetPresensia());
            }
            elseif ($answer->getValue() === '8') {
                $this->say('<b>Anda memilih Menu : Terkait KRS </b>',['parse_mode' => 'HTML']);
                $this->bot->startConversation(new LateKRS());
            }
            elseif ($answer->getValue() === '9') {
                $this->say('<b>Anda memilih Menu : Terkait Mata Kuliah </b>',['parse_mode' => 'HTML']);
                $this->bot->startConversation(new SalahMatkul());
            }
            elseif ($answer->getValue() === '10') {
                $this->say('<b>Anda memilih Menu : Terkait NIM pada UKT </b>',['parse_mode' => 'HTML']);
                $this->bot->startConversation(new nimUKT());
            }
            elseif ($answer->getValue() === '11') {
                $this->say('<b>Anda memilih Menu : Helpdesk Penerimaan MABA </b>',['parse_mode' => 'HTML']);
                $this->bot->startConversation(new helpDeskPMB());
            }
            elseif ($answer->getValue() === '12') {
                $this->say('<b>Anda memilih Menu : Helpdesk Keringanan UKT </b>',['parse_mode' => 'HTML']);
                $this->bot->startConversation(new helpDeskUKT());
            }
            elseif ($answer->getValue() === '13') {
                $this->say('<b>Anda memilih Menu : Lainnya </b>',['parse_mode' => 'HTML']);
                $this->bot->startConversation(new FormatMessages());
            }
            else
            {
                $this->say('<b>Tolong pilih sesuai menu yang tersedia</b>!',['parse_mode' => 'HTML']);
            }
        });

        // $this->say('Silahkan, menggunakan perintah yang tersedia untuk berinteraksi.');
        // $this->say('<b> /Start -<pre> Memulai </pre></b>', ['parse_mode' => 'HTML']);
        // $this->say('<b> /Format_Pesan -<pre> Melihat Format Pesan untuk menyampaikan Permasalahan</pre></b>', ['parse_mode' => 'HTML']);
        // $this->say('<b> /Reset_Gmail_PegawaiDosen -<pre> Reset Password Akun Gmail Pegawai atau Dosen </pre></b>', ['parse_mode' => 'HTML']);
        // $this->say('<b> /Reset_Mahasiswa_Email -<pre> Reset Password Akun Gmail Mahasiswa </pre></b>', ['parse_mode' => 'HTML']);
        // $this->say('<b> /Reset_Elearning -<pre> Reset Password Akun Elearning Mahasiswa </pre></b>', ['parse_mode' => 'HTML']);
        // $this->say('<b> /Reset_Iraise -<pre> Reset Password Akun Iraise Mahasiswa </pre></b>', ['parse_mode' => 'HTML']);
        // $this->say('<b> /Helpdesk_Permasalahan_Iraise -<pre> Mengajukan Permasalahan Terkait Iraise </pre></b>', ['parse_mode' => 'HTML']);
        // $this->say('<b> /Helpdesk_Customer_Care_Center -<pre> Mengajukan Permasalahan Terkait C3 </pre></b>', ['parse_mode' => 'HTML']);
        // $this->say('<b> /Reset_Presensia -<pre> Pengajuan Reset Presensia Pegawai </pre></b>', ['parse_mode' => 'HTML']);
        // $this->say('<b> /Telat_KRS -<pre> Terlambat mengisi KRS sesuai Jadwal </pre></b>', ['parse_mode' => 'HTML']);
        // $this->say('<b> /Salah_Matkul -<pre> Kesalahan Dalam Mengambil Mata Kuliah </pre></b>', ['parse_mode' => 'HTML']);
        // $this->say('<b> /NIM_NF_UKT -<pre> Pengajuan Permasalahan NIM/Kode Bayar saat membayar UKT </pre></b>', ['parse_mode' => 'HTML']);
        // $this->say('<b> /Helpdesk_PenerimaanMABA -<pre> Pengajuan Permasalahan Terkait Penerimaan Mahasiswa Baru</pre></b>', ['parse_mode' => 'HTML']);
        // $this->say('<b> /Helpdesk_Keringanan_UKT -<pre> Pengajuan Permasalahan Terkait Keringanan UKT</pre></b>', ['parse_mode' => 'HTML']);
        // $this->say('<b> /Lainnya -<pre> Pengajuan Permasalahan Umum Terkait Kampus</pre></b>', ['parse_mode' => 'HTML']);

    }
}
