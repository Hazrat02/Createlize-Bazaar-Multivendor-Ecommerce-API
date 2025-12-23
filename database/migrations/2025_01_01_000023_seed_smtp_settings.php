<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $value = [
            'mailer' => 'smtp',
            'host' => 'smtp-relay.brevo.com',
            'port' => 587,
            'username' => '946847001@smtp-brevo.com',
            'password' => 'gv2bnQ7rWV9NtBRO',
            'encryption' => 'tls',
            'from_address' => 'hazratbd80@gmail.com',
            'from_name' => 'Createlize',
            'template_subject' => 'Message from {{subject}}',
            'template_body' => '<p>Hi {{name}},</p><p>{{message}}</p><p>Thanks,<br/>Createlize</p>',
        ];

        $exists = DB::table('settings')->where('key', 'smtp')->exists();
        if (!$exists) {
            DB::table('settings')->insert([
                'group' => 'smtp',
                'key' => 'smtp',
                'value' => json_encode($value),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('settings')->where('key', 'smtp')->delete();
    }
};
