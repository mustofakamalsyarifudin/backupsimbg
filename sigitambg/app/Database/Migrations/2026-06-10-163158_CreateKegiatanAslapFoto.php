<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKegiatanAslapFoto extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [

                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,

            ],

            'kegiatan_id' => [

                'type'       => 'INT',
                'constraint' => 11,

            ],

            'foto' => [

                'type'       => 'VARCHAR',
                'constraint' => 255,

            ],

            'created_at' => [

                'type' => 'DATETIME',
                'null' => true,

            ]

        ]);

        $this->forge->addKey('id', true);

        $this->forge->createTable(
            'kegiatan_aslap_foto'
        );
    }

    public function down()
    {
        $this->forge->dropTable(
            'kegiatan_aslap_foto'
        );
    }
}
