<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaguSnapshotToBahanBaku extends Migration
{
    public function up()
    {
        $this->forge->addColumn('bahan_baku', [
            'pagu_tanggal' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'tanggal',
            ],
            'pagu_porsi_kecil' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'after' => 'pagu_tanggal',
            ],
            'pagu_porsi_besar' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'after' => 'pagu_porsi_kecil',
            ],
            'pagu_tarif_kecil' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'after' => 'pagu_porsi_besar',
            ],
            'pagu_tarif_besar' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'after' => 'pagu_tarif_kecil',
            ],
            'pagu_total' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'after' => 'pagu_tarif_besar',
            ],
            'pagu_selisih' => [
                'type' => 'DECIMAL',
                'constraint' => '18,2',
                'null' => true,
                'after' => 'pagu_total',
            ],
            'pagu_snapshot_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'pagu_selisih',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('bahan_baku', [
            'pagu_tanggal',
            'pagu_porsi_kecil',
            'pagu_porsi_besar',
            'pagu_tarif_kecil',
            'pagu_tarif_besar',
            'pagu_total',
            'pagu_selisih',
            'pagu_snapshot_at',
        ]);
    }
}
