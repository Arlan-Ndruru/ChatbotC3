<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class resetElearning extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {
        $question = Question::create("Apakah anda dapat mengakses Email UIN anda?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('Iya')->value('yes'),
                Button::create('Tidak')->value('netral'),
                Button::create('Batalkan')->value('no'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'yes')
                {
                    $this->say('Anda memilih :<b> Anda dapat mengakses Email anda</b>', ['parse_mode' => 'HTML']);
                    $this->say('Langkah Pertama, <i> Untuk mereset password Elearning. Kunjungi <a>https://elearning.uin-suska.ac.id/login/forgot_password.php</a></i>', ['parse_mode' => 'HTML']);

                    $attachment = new Image('https://live.staticflickr.com/65535/52988235129_3eec011dae_h.jpg');
                    $message = OutgoingMessage::create('Gambar halaman web untuk mereset password Elearning')
                    ->withAttachment($attachment);
                    $this->say($message);

                    $this->Solution();

                }
                elseif ($answer->getValue() === 'netral') {
                    $question = Question::create('Silahkan Ajukan Permasalahan Karena Anda ingin mereset password tetapi tidak dapat mengakses Email UIN. Ajukan?')
                        ->addButtons([
                            Button::create('Ya')->value('yes'),
                            Button::create('Batalkan')->value('no')
                        ]);

                        $this->ask($question, function (Answer $answer) {
                            if ($answer->getValue() === 'yes') {
                                $this->say('Anda memilih :<b> untuk mengajukan permasalahan</b>', ['parse_mode' => 'HTML']);
                                $this->askName();
                            }
                            else{
                                $this->Cancel();
                            }
                        });
                }
                else
                {
                    $this->Cancel();
                }
            }
        });
    }

    public function Solution()
    {
        $question = Question::create('Sudah kunjungi?')
		->addButtons([
			Button::create('Sudah')->value('yes'),
			Button::create('Batalkan')->value('no'),
		]);
        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === 'yes') {
                $this->say('Anda memilih :<b> Anda sudah melakukan langkah sebelumnya</b>', ['parse_mode' => 'HTML']);
                $this->say('Kedua, Lanjut Masukkan Nama Pengguna atau Alamat Surel/Email Anda pada tempat input yang ada pada halaman seperti gambar diatas atau pada link berikut <a>https://elearning.uin-suska.ac.id/login/forgot_password.php</a>, <b>Kemudian Klik Cari</b>', ['parse_mode' => 'HTML']);

                $this->say('Ketiga, Akan muncul peringatan bahwa surel sudah dikirim ke Email UIN anda untuk mereset password seperti gambar dibawah ini.', ['parse_mode' => 'HTML']);

                $attachment = new Image('https://live.staticflickr.com/65535/52988472135_24e16cea50_h.jpg');
                    $message = OutgoingMessage::create('Gambar Bahwa Surel Telah dikirim ke Email Anda untuk mereset password')
                    ->withAttachment($attachment);
                $this->say($message);
                $this->askReason2();
            }
            else{
                $this->Cancel();
            }
        });
    }

    public function askReason2()
    {
        $question = Question::create('Keempat, Cek apakah Anda mendapatkan Email Balasan?')
		->addButtons([
			Button::create('Dapat')->value('yes'),
			Button::create('Tidak')->value('netral'),
			Button::create('Batalkan')->value('no'),
		]);
        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === 'yes') {
                $this->say('Anda memilih :<b> Anda sudah mendapatkan Email balasan</b>', ['parse_mode' => 'HTML']);
                $this->say('Terakhir, buka surel dan lakukan reset password Elearning', ['parse_mode' => 'HTML']);
                $this->Closing();
            }
            elseif ($answer->getValue() === 'netral') {
                $this->say('Pastikan Email Balasan tidak ada juga di menu spam email anda', ['parse_mode' => 'HTML']);
                // $this->say('Tetap Tidak Mendapat Balasan? Silahkan Ajukan Permasalahan', ['parse_mode' => 'HTML']);
                $this->askReason3();
            }
            else{
                $this->say('Terima kasih, proses dibatalkan', ['parse_mode'=>'HTML']);
            }
        });
    }

    public function askReason3()
    {
        $question = Question::create('Tetap TIdak mendapat Email Balasan?')
		->addButtons([
			Button::create('Sudah Didapatkan')->value('yes'),
			Button::create('Belum')->value('no')
		]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === 'yes') {
                $this->say('Lanjut, ikuti instruksi dari balasan Email yang didapatkan untuk mereset password Iraise', ['parse_mode' => 'HTML']);
                $this->Closing();
            }
            else{
                $this->say('Silahkan Ajukan Permasalahan', ['parse_mode'=>'HTML']);
                $this->askName();
            }
        });
    }

    protected $Name;
    protected $NIM;
    protected $Jurusan;
    protected $Fakultas;
    protected $Permasalahan;

    public function askName()
    {
        $this->ask('Nama Lengkap Anda?', function(Answer $answer) {
            $this->Name = $answer->getText();
            $this->askNIM();
        });
    }

    public function askNIM()
    {
        $this->ask('NIM Anda?', function(Answer $answer) {
            $this->NIM = $answer->getText();
            $this->askJurusan();
        });
    }

    public function askJurusan()
    {
        $this->ask('Jurusan Anda?', function(Answer $answer) {
            $this->Jurusan = $answer->getText();
            $this->askFakultas();
        });
    }

    public function askFakultas()
    {
        $this->ask('Fakultas Anda?', function(Answer $answer) {
            $this->Fakultas = $answer->getText();
            $this->askDelete();
        });
    }

    public function askDelete()
    {
        $this->ask('Ajukan Permasalahan?', function(Answer $answer) {
            $this->Permasalahan = $answer->getText();
            $this->askKTM();
        });
    }

    public function askKTM()
    {
        $this->ask('Lampirkan Foto KTM anda?', function(Answer $answer) {
        $this->say('Nama : '.$this->Name.'
NIM : '.$this->NIM.'
Jurusan : '.$this->Jurusan.'
Fakultas : '.$this->Fakultas.'
Permasalahan : '.$this->Permasalahan);
        $this->say('Terima Kasih, Akan Diproses Secepatnya berdasarkan Data Tersebut.');
        $this->closing();
        });
    }

    public function closing()
    {
        $question = Question::create("Apakah Permasalahan Teratasi?")
            ->fallback('unable to ask question')
            ->callbackId('ask_reason2')
            ->addButtons([
                Button::create('Iya, Terima Kasih')->value('yes'),
                Button::create('Masih Menunggu Balasan')->value('no'),
            ]);

        return $this->ask($question, function (Answer $answer){
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'yes') {
                    $this->say('Permasalahan Teratasi. Senang Dapat Membantu :)');
                } else {
                    $this->say('Akan dibalas secepatnya');
                    $this->say('Atau Silahkan Datang ke Bagian C3 PTIPD UIN SUSKA RIAU dengan Membawa KTM Asli');
                }
            }
        });
    }

    public function Cancel()
    {

        $this->say('<b>Proses Dibatalkan</b>. <pre>Jika berubah pikiran, Ketik </pre> /Reset_Elearning <i>- untuk mengajukan Permasalahan Reset Password Elearning Mahasiswa</i>', ['parse_mode' => 'HTML']);
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
