<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKegiatanAslap extends Migration
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

            'id_sppg' => [

                'type'       => 'VARCHAR',
                'constraint' => 50,

            ],

            'tanggal' => [

                'type' => 'DATE',

            ],

            'judul_kegiatan' => [

                'type'       => 'VARCHAR',
                'constraint' => 255,

            ],

            'lokasi' => [

                'type'       => 'VARCHAR',
                'constraint' => 255,

            ],

            'deskripsi' => [

                'type' => 'TEXT',

            ],

            'created_by' => [

                'type'       => 'INT',
                'constraint' => 11,

            ],

            'created_at' => [

                'type' => 'DATETIME',
                'null' => true,

            ],

            'updated_at' => [

                'type' => 'DATETIME',
                'null' => true,

            ]

        ]);

        $this->forge->addKey('id', true);

        $this->forge->createTable(
            'kegiatan_aslap'
        );
    }

    public function down()
    {
        $this->forge->dropTable(
            'kegiatan_aslap'
        );
    }
}
